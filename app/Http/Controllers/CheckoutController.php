<?php

namespace App\Http\Controllers;

use App\Payment\PagSeguro\CreditCard;
use App\Store;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {

        //        var_dump(session()->get('pagseguro_session_code'));


        if(!auth()->check()){
            return redirect()->route('login');
        }

        if(!session()->has('cart')) return redirect()->route('home');

        $this->makePagSeguroSession();

        $cartItems = array_map(function($line){
            return $line['amount'] * $line['price'];
        },session()->get('cart'));

        $total = array_sum($cartItems);

        return view('checkout', ['total' => $total]);
    }

    public function proccess(Request $request)
    {
        try {
            $dataPost = $request->all();
            $user = auth()->user();
            $reference = 'XPTO';

            $cartItems = session()->get('cart');
            $stores = array_unique(array_column($cartItems, 'store_id'));

            $creditCardPayment = new CreditCard($cartItems, $user, $dataPost, $reference);

            $result = $creditCardPayment->doPayment();

            $userOrder = [
                'pagseguro_code'  => $result->getCode(),
                'pagseguro_status' => $result->getStatus(),
                'items' => serialize($cartItems),
                'store_id' => 42,
                'reference' => $reference,
            ];

            $userOrder = $user->orders()->create($userOrder);


            $userOrder->stores()->sync($stores);

            // notificar loja de noto pedido
            $store = (new Store())->notifyStoreOwners($stores);

            session()->forget('cart');
            session()->forget('pagseguro_session_code');

            return response()->json([
                'data' => [
                    'status' => true,
                    'message' => 'Pedido criado com sucesso',
                    'order' => $reference,
                ]
            ]);
        }catch(\Exception $e){
            $message = env('APP_DEBUG') ? $e->getMessage() : 'Erro ao processar pedido';

            return response()->json([
                'data' => [
                    'status' => false,
                    'message' => $message,
                ]
            ], 401);
        }
    }

    public function thanks()
    {
        return view('thanks');
    }

    private function makePagSeguroSession()
    {
        if(!session()->has('pagseguro_session_code')){
            $sessionCode = \PagSeguro\Services\Session::create(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );

            return session()->put('pagseguro_session_code', $sessionCode->getResult());
        }

    }

}
