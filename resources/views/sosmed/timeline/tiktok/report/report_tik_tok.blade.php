@extends('layouts.app', ['pageTitle' => 'Report TikTok'])

@section('button-action')
    <a href="{{ route('reportTikTok.create') }}" class="btn btn-primary btn-sm pull-right">Tambah Data</a>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Data Report TikTok</h2>
                <a href="javascript:void(0)" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#exportModal">Export</a>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered dt-responsive nowrap" width="100%" id="report-tiktok-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Report</th>
                                <th>Tanggal</th>
                                <th>Tipe Konten</th>
                                <th>Jenis Konten</th>
                                <th>Produk</th>
                                <th>Hook Konten</th>
                                <th>Copywriting</th>
                                <th>Jam Upload</th>
                                <th>Views</th>
                                <th>Like</th>
                                <th>Comment</th>
                                <th>Share</th>
                                <th>Save</th>
                                <th>Usia 18-24</th>
                                <th>Usia 25-34</th>
                                <th>Usia 35-44</th>
                                <th>Usia 45-54</th>
                                <th>Gender Pria</th>
                                <th>Gender Wanita</th>
                                <th>Total Pemutaran</th>
                                <th>Rata-Rata Menonton</th>
                                <th>View Utuh</th>
                                <th>Pengikut Baru</th>
                                <th>Link Konten</th>
                                <th>Pics</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Export Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Export Data</h5>
            </div>
            <form action="{{ route('reportTikTok.export') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" name="start_date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" name="end_date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="tipe_konten">Tipe Konten</label>
                        <select name="tipe_konten" class="form-control">
                            <option value="">Pilih Tipe Konten</option>
                            <option value="video">Video</option>
                            <option value="Live">Live</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Export</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            var table = $('#report-tiktok-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url: "{{ route('reportTikTok.index') }}",
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                        {data: 'kd_report_tiktok', name: 'kd_report_tiktok'},
                        {data: 'tanggal', name: 'tanggal'},
                        {data: 'tipe_konten', name: 'tipe_konten'},
                        {data: 'jenis_konten', name: 'jenis_konten'},
                        {data: 'produk', name: 'produk'},
                        {data: 'hook_konten', name: 'hook_konten'},
                        {data: 'copywriting', name: 'copywriting'},
                        {data: 'jam_upload', name: 'jam_upload'},
                        {data: 'views', name: 'views'},
                        {data: 'like', name: 'like'},
                        {data: 'comment', name: 'comment'},
                        {data: 'share', name: 'share'},
                        {data: 'save', name: 'save'},
                        {data: 'usia_18_24', name: 'usia_18_24'},
                        {data: 'usia_25_34', name: 'usia_25_34'},
                        {data: 'usia_35_44', name: 'usia_35_44'},
                        {data: 'usia_45_54', name: 'usia_45_54'},
                        {data: 'gender_pria', name: 'gender_pria'},
                        {data: 'gender_wanita', name: 'gender_wanita'},
                        {data: 'total_pemutaran', name: 'total_pemutaran'},
                        {data: 'rata_menonton', name: 'rata_menonton'},
                        {data: 'view_utuh', name: 'view_utuh'},
                        {data: 'pengikut_baru', name: 'pengikut_baru'},
                        {data: 'link_konten', name: 'link_konten'},
                        {data: 'pics', name: 'pics'},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ],
                });
        });
    </script>
@endpush

