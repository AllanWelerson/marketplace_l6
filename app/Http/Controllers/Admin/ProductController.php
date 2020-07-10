<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Product;
use App\Store;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userStore = auth()->user()->store;
        $products = $userStore->products()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all(['id','name']);

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $data = $request->all();

        $store = auth()->user()->store;
        $product = $store->products()->create($data);
        $product->categories()->sync($data['categories']);

        if($request->hasFile('photos')) {
            $images = $this->imageUpload($request, 'image');

            $product->photos()->createMany($images);
        }

        flash('Produto criado com sucesso!')->success();
        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($product)
    {
        $product = $this->product->findOrFail($product);
        $categories = Category::all(['id','name']);

        return view('admin.products.edit', compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $product)
    {
        $data = $request->all();

        $product = $this->product->find($product);
        $product->update($data);
        $product->categories()->sync($data['categories']);

        if($request->hasFile('photos')) {
            $images = $this->imageUpload($request, 'image');

            $product->photos()->createMany($images);
        }

        flash('Produto atualizado com sucesso!')->success();
        return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($product)
    {

        $product = $this->product->find($product);
        $product->delete();

        flash('Produto removido com sucesso!')->success();
        return redirect()->route('admin.products.index');
    }

    private function imageUpload(Request $request, $imageColumn) {

        $images = $request->file('photos');
        $uploadedImages = [];

        foreach ($images as $image) {
            $uploadedImages[] = [$imageColumn => $image->store('products','public')];
        }

        return $uploadedImages;
    }
}
