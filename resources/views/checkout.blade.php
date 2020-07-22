@extends('layouts.front')

@section('stylesheets')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.csss">
@endsection

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12 msg"></div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Dados para Pagamento</h2>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="">Nome no Cartão </label>
                            <input type="text" class="form-control" name="card_name" id="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="">Número do Cartão <span class="brand"></span> </label>
                            <input type="text" class="form-control" name="card_number" id="">
                            <input type="hidden" name="card_brand">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="">Mês de Expiração</label>
                            <input type="text" class="form-control" name="card_month">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="">Ano de Expiração</label>
                            <input type="text" class="form-control" name="card_year">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5 form-group">
                            <label for="">Código de segurança</label>
                            <input type="text" class="form-control" name="card_cvv">
                        </div>

                        <div class="col-md-12 installments form-group"></div>
                    </div>

                    <button class="btn btn-success btn-lg processCheckout">Efetuar Pagamento</button>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        const sessionId = '{{session()->get('pagseguro_session_code')}}';

        const urlThanks = '{{route('checkout.thanks')}}';
        const urlProccess = '{{route('checkout.proccess')}}';
        const amountTransaction = '{{$total}}';
        const csrf = '{{csrf_token()}}';

        PagSeguroDirectPayment.setSessionId(sessionId);
    </script>
    <script src="{{asset('js/pagseguro_functions.js')}}"></script>
    <script src="{{asset('js/pagseguro_events.js')}}"></script>

@endsection
