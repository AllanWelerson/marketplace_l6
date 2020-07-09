@extends('layouts.app')

@section('content')
    <h1>Criar Loja</h1>
    <form action="{{route('admin.products.store')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="">Nome Produto</label>
            <input type="text" name="name" class="form-control">
        </div>

        <div class="form-group">
            <label for="">Descrição</label>
            <input type="text" name="description" class="form-control">
        </div>

        <div class="form-group">
            <label for="">Conteúdo</label>
            <textarea name="body" rows="10" cols="30" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label for="">Preço</label>
            <input type="text" name="price" class="form-control" >
        </div>


        <div class="form-group">
            <label for="">Slug</label>
            <input type="text" name="slug" class="form-control">
        </div>
        <div class="form-group">
            <label for="">Lojas</label>
            <select type="text" name="store" class="form-control">
                @foreach($stores as $store)
                    <option value="{{$store->id}}">{{$store->name}}</option>
                @endforeach
            </select>
        </div>

        <div>
            <button class="btn-success btn-lg" type="submit">Criar Produto</button>
        </div>

    </form>
@endsection
