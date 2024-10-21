@extends('layouts.app', ['pageTitle' => 'Detail Project'])

@section('content')

<div class="row mb-5">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h4>Project Timeline Instagram</h4>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-nowrap" id="timeline-ig-table" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Timeline</th>
                                <th>Tanggal</th>
                                <th>Jenis Project</th>
                                <th>Status</th>
                                <th>Format</th>
                                <th>Jenis Konten</th>
                                <th>Produk</th>
                                <th>Head Term</th>
                                <th>Core Topic</th>
                                <th>Subtopic</th>
                                <th>Copywriting</th>
                                <th>Notes</th>
                                <th>Refrensi</th>
                                <th>Pics</th>
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

<div class="row mb-5">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h4>Project Timeline TikTok</h4>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped text-nowrap table-bordered" id="timeline-tiktok-table" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Tipe Konten</th>
                                <th>Jenis Konten</th>
                                <th>Produk</th>
                                <th>Hook Konten</th>
                                <th>Copywriting</th>
                                <th>Jam Upload</th>
                                <th>Pics</th>
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

<div class="row mb-5">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h4>Project TikTok Live</h4>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped text-nowrap table-bordered" id="report-tiktok-live-table" width="100%">
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
    $(document).ready(function () {
        $('#timeline-ig-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('detail.project', $user->id) }}",
                data: { table: 'timeline_ig' }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'kd_timelineig', name: 'kd_timelineig' },
                { data: 'tanggal', name: 'tanggal' },
                { data: 'jenis_project', name: 'jenis_project' },
                { data: 'status', name: 'status' },
                { data: 'format', name: 'format' },
                { data: 'jenis_konten', name: 'jenis_konten' },
                { data: 'produk', name: 'produk' },
                { data: 'head_term', name: 'head_term' },
                { data: 'core_topic', name: 'core_topic' },
                { data: 'subtopic', name: 'subtopic' },
                { data: 'copywriting', name: 'copywriting' },
                { data: 'notes', name: 'notes' },
                { data: 'refrensi', name: 'refrensi' },
                { data: 'pics', name: 'pics' },
            ]
        });

        $('#timeline-tiktok-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('detail.project', $user->id) }}",
                data: { table: 'timeline_tiktok' }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'tanggal', name: 'tanggal' },
                { data: 'tipe_konten', name: 'tipe_konten' },
                { data: 'jenis_konten', name: 'jenis_konten' },
                { data: 'produk', name: 'produk' },
                { data: 'hook_konten', name: 'hook_konten' },
                { data: 'copywriting', name: 'copywriting' },
                { data: 'jam_upload', name: 'jam_upload' },
                { data: 'pics', name: 'pics' },
            ]
        });

        $('#report-tiktok-live-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('detail.project', $user->id) }}",
                data: { table: 'tiktok_live' }
            },
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
            ]
        });
    });
</script>
@endpush