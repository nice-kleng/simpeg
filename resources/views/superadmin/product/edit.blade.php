@extends('layouts.app', ['pageTitle' => 'Edit Product'])

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10 col-sm-10">
        <div class="x_panel">
            <div class="x_title">
                <h2>Edit Data Product</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form action="{{ route('product.update', $product->kd_product) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="kd_product">Kode Product</label>
                        <input type="text" class="form-control" id="kd_product" name="kd_product" value="{{ $product->kd_product }}" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_product">Nama Product</label>
                        <input type="text" class="form-control" id="nama_product" name="nama_product" value="{{ $product->nama_product }}" required>
                    </div>
                    <div class="form-group">
                        <label for="stock">Stock</label>
                        <input type="number" class="form-control" id="stock" name="stock" value="{{ $product->stock }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('product.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-1"></div>
</div>
@endsection

