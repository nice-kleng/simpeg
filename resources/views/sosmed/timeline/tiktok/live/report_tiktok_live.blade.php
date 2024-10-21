@extends('layouts.app', ['pageTitle' => 'Report TikTok Live'])

@section('button-action')
<a href="{{ route('reportTikTokLive.create') }}" class="btn btn-primary btn-sm pull-right">Tambah Data</a>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Data Report TikTok Live</h2>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#exportModal"
                    class="btn btn-success btn-sm pull-right">Export</a>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped nowrap table-bordered" id="report-tiktok-live-table" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Tanggal</th>
                                <th>Judul</th>
                                <th>Waktu Mulai</th>
                                <th>Durasi</th>
                                <th>Total Tayangan</th>
                                <th>Penonton Unik</th>
                                <th>Rata-Rata Menonton</th>
                                <th>Jumlah Penonton Teratas</th>
                                <th>Pengikut</th>
                                <th>Penonton Lainnya</th>
                                <th>Pengikut Baru</th>
                                <th>Penonton Berkomentar</th>
                                <th>Suka</th>
                                <th>Berbagi</th>
                                <th>Pics</th>
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


<!-- Export Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Export Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('reportTikTokLive.export') }}" method="POST">
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
        var table = $('#report-tiktok-live-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('reportTikTokLive.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'kd_report_tiktok_live', name: 'kd_report_tiktok_live'},
                {data: 'tanggal', name: 'tanggal'},
                {data: 'judul', name: 'judul'},
                {data: 'waktu_mulai', name: 'waktu_mulai'},
                {data: 'durasi', name: 'durasi'},
                {data: 'total_tayangan', name: 'total_tayangan'},
                {data: 'penonton_unik', name: 'penonton_unik'},
                {data: 'rata_menonton', name: 'rata_menonton'},
                {data: 'jumlah_penonton_teratas', name: 'jumlah_penonton_teratas'},
                {data: 'pengikut', name: 'pengikut'},
                {data: 'penonton_lainnya', name: 'penonton_lainnya'},
                {data: 'pengikut_baru', name: 'pengikut_baru'},
                {data: 'penonton_berkomentar', name: 'penonton_berkomentar'},
                {data: 'suka', name: 'suka'},
                {data: 'berbagi', name: 'berbagi'},
                {data: 'pics', name: 'pics'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    });
</script>
@endpush