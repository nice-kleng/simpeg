@extends('layouts.app', ['pageTitle' => 'Data Mitra'])

@section('button-action')
    <a href="{{ route('mitra.create') }}" class="btn btn-primary btn-sm pull-right">Tambah Data</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Data Mitra</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-nowrap" id="mitra-table" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Gabung</th>
                                    <th>Kode Mitra</th>
                                    <th>Nama Lengkap</th>
                                    <th>Status Mitra</th>
                                    <th>Kota/Wilayah</th>
                                    <th>Facebook</th>
                                    <th>Instagram</th>
                                    <th>Marketplace</th>
                                    <th>No Hp</th>
                                    <th>Upline</th>
                                    <th>Downline</th>
                                    <th>Bulan</th>
                                    <th>Note 1</th>
                                    <th>Note 2</th>
                                    <th>Status Mitra</th>
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
            var table = $('#mitra-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('mitra.index') }}",
                    type: 'GET',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'kode',
                        name: 'kode'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'status_mitra',
                        name: 'status_mitra'
                    },
                    {
                        data: 'kota_wilayah',
                        name: 'kota_wilayah'
                    },
                    {
                        data: 'fb',
                        name: 'fb'
                    },
                    {
                        data: 'ig',
                        name: 'ig'
                    },
                    {
                        data: 'marketplace',
                        name: 'marketplace'
                    },
                    {
                        data: 'no_hp',
                        name: 'no_hp'
                    },
                    {
                        data: 'upline',
                        name: 'upline'
                    },
                    {
                        data: 'downline',
                        name: 'downline'
                    },
                    {
                        data: 'bulan',
                        name: 'bulan'
                    },
                    {
                        data: 'note_1',
                        name: 'note_1'
                    },
                    {
                        data: 'note_2',
                        name: 'note_2'
                    },
                    {
                        data: 'status_mitra',
                        name: 'status_mitra'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });
        });
    </script>
@endpush
