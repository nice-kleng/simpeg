@extends('layouts.app', ['pageTitle' => 'Timeline Instagram'])

@section('button-action')
    <a href="{{ route('timelineInstagram.create') }}" class="btn btn-primary btn-sm pull-right">Tambah Data</a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Data Timeline Instagram</h2>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#reportModal" class="btn btn-success btn-sm pull-right"><i class="fa fa-file-excel-o"></i> Export</a>
                <div class="clearfix"></div>
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
                                <th>Report</th>
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

<!-- Modal for Export Report -->
<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportModalLabel">Export Report Timeline Instagram</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('timelineInstagram.exportExcel') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="start_date">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis">Jenis Konten</label>
                        <select class="form-control" id="jenis" name="jenis">
                            <option value="">--Jenis Project--</option>
                            <option value="FEED">FEED</option>
                            <option value="STORY">STORY</option>    
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Export</button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        var table = $('#timeline-ig-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('timelineInstagram.index') }}",
                type: 'GET',
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
                { data: 'report', name: 'report' },
                { data: 'action', name: 'action' },
            ]
        });
    });
</script>
@endpush
