@extends('layouts.app', ['pageTitle' => 'Product'])

@section('button-action')
    <a href="{{ route('product.create') }}" class="btn btn-primary btn-sm pull-right">Tambah Data</a>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Data Product</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="product-table" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Product</th>
                                <th>Nama Product</th>
                                <th>Stock</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#product-table').DataTable({
                ajax: {
                    url: "{{ route('product.index') }}",
                    type: 'GET',
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'kd_product', name: 'kd_product' },
                    { data: 'nama_product', name: 'nama_product' },
                    { data: 'stock', name: 'stock' },
                    { data: 'action', name: 'action' }
                ]
            });
        });
    </script>
@endpush
