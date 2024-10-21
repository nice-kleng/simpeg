@extends('layouts.app', ['pageTitle' => 'Timeline TikTok'])

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    /* .select2-container.is-invalid + error{
        border: 1px solid #dc2626;
    } */
    .select2-container.is-invalid + .error-message {
       display: block;
       margin-top: 0.25rem;
   }
</style>

@endpush

@section('button-action')
<a href="javascript:void(0)" data-toggle="modal" data-target="#addTimelineTikTokModal"
    class="btn btn-primary btn-sm pull-right">Tambah Data</a>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Data Timeline TikTok</h2>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#exportReportModal" class="btn btn-success btn-sm pull-right">Export Report</a>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered dt-responsive nowrap" width="100%"
                        id="timeline-tiktok-table">
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
                                <th>Report</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="addTimelineTikTokModal" tabindex="-1" role="dialog"
    aria-labelledby="addTimelineTikTokModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTimelineTikTokModalLabel">Tambah Data Timeline TikTok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" id="form-add-timeline-tiktok">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal"
                                    value="{{ old('tanggal') }}">
                            </div>
                            <div class="form-group">
                                <label for="tipe_konten">Tipe Konten</label>
                                <select class="form-control" id="tipe_konten" name="tipe_konten">
                                    <option value="">--Pilih Tipe Konten--</option>
                                    <option value="Reels" {{ old('tipe_konten')=='Reels' ? 'selected' : '' }}>Reels
                                    </option>
                                    <option value="Other" {{ old('tipe_konten')=='Other' ? 'selected' : '' }}>Other
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="jenis_konten">Jenis Konten</label>
                                <select name="jenis_konten" id="jenis_konten" class="form-control">
                                    <option value="">--Pilih Jenis Konten--</option>
                                    <option value="Educate" {{ old('jenis_konten')=='Educate' ? 'selected' : '' }}>
                                        Educate
                                    </option>
                                    <option value="Inspire" {{ old('jenis_konten')=='Inspire' ? 'selected' : '' }}>
                                        Inspire
                                    </option>
                                    <option value="Entertain" {{ old('jenis_konten')=='Entertain' ? 'selected' : '' }}>
                                        Entertain
                                    </option>
                                    <option value="Convience" {{ old('jenis_konten')=='Convience' ? 'selected' : '' }}>
                                        Convience
                                    </option>
                                    <option value="Testimonial" {{ old('jenis_konten')=='Testimonial' ? 'selected' : ''
                                        }}>
                                        Testimonial</option>
                                    <option value="Commercial" {{ old('jenis_konten')=='Commercial' ? 'selected' : ''
                                        }}>
                                        Commercial</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="produk">Produk</label>
                                <select name="produk" id="produk" class="form-control select2" style="width: 100%;">
                                    <option value="">--Pilih Produk--</option>
                                    @foreach ($products as $product)
                                    <option value="{{ $product->nama_product }}" {{ (old('produk')==$product->
                                        nama_product) ?
                                        'selected' : '' }}>{{ $product->nama_product }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hook_konten">Hook Konten</label>
                                <input type="text" class="form-control" id="hook_konten" name="hook_konten"
                                    value="{{ old('hook_konten') }}">
                            </div>
                            <div class="form-group">
                                <label for="copywriting">Copywriting</label>
                                <input type="text" class="form-control" id="copywriting" name="copywriting"
                                    value="{{ old('copywriting') }}">
                            </div>
                            <div class="form-group">
                                <label for="jam_upload">Jam Upload</label>
                                <input type="time" class="form-control" id="jam_upload" name="jam_upload"
                                    value="{{ old('jam_upload') }}">
                            </div>
                            <div class="form-group">
                                <label for="pics">Pics</label>
                                <select name="pics[]" id="pics" class="form-control select2" style="width: 100%;"
                                    multiple>
                                    @foreach ($users as $pic)
                                    <option value="{{ $pic->id }}" {{ (old('pics')==$pic->id) ? 'selected' : '' }}>{{
                                        $pic->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Data -->
<div class="modal fade" id="editTimelineTikTokModal" tabindex="-1" role="dialog"
    aria-labelledby="editTimelineTikTokModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTimelineTikTokModalLabel">Edit Data Timeline TikTok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" id="form-edit-timeline-tiktok">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal"
                                    value="{{ old('tanggal') }}">
                            </div>
                            <div class="form-group">
                                <label for="tipe_konten">Tipe Konten</label>
                                <select class="form-control" id="tipe_konten" name="tipe_konten">
                                    <option value="">--Pilih Tipe Konten--</option>
                                    <option value="Reels" {{ old('tipe_konten')=='Reels' ? 'selected' : '' }}>Reels
                                    </option>
                                    <option value="Other" {{ old('tipe_konten')=='Other' ? 'selected' : '' }}>Other
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="jenis_konten">Jenis Konten</label>
                                <select name="jenis_konten" id="jenis_konten" class="form-control">
                                    <option value="">--Pilih Jenis Konten--</option>
                                    <option value="Educate" {{ old('jenis_konten')=='Educate' ? 'selected' : '' }}>
                                        Educate
                                    </option>
                                    <option value="Inspire" {{ old('jenis_konten')=='Inspire' ? 'selected' : '' }}>
                                        Inspire
                                    </option>
                                    <option value="Entertain" {{ old('jenis_konten')=='Entertain' ? 'selected' : '' }}>
                                        Entertain
                                    </option>
                                    <option value="Convience" {{ old('jenis_konten')=='Convience' ? 'selected' : '' }}>
                                        Convience
                                    </option>
                                    <option value="Testimonial" {{ old('jenis_konten')=='Testimonial' ? 'selected' : ''
                                        }}>
                                        Testimonial</option>
                                    <option value="Commercial" {{ old('jenis_konten')=='Commercial' ? 'selected' : ''
                                        }}>
                                        Commercial</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="produk">Produk</label>
                                <select name="produk" id="produk" class="form-control select2" style="width: 100%;">
                                    <option value="">--Pilih Produk--</option>
                                    @foreach ($products as $product)
                                    <option value="{{ $product->nama_product }}" {{ (old('produk')==$product->
                                        nama_product) ?
                                        'selected' : '' }}>{{ $product->nama_product }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hook_konten">Hook Konten</label>
                                <input type="text" class="form-control" id="hook_konten" name="hook_konten"
                                    value="{{ old('hook_konten') }}">
                            </div>
                            <div class="form-group">
                                <label for="copywriting">Copywriting</label>
                                <input type="text" class="form-control" id="copywriting" name="copywriting"
                                    value="{{ old('copywriting') }}">
                            </div>
                            <div class="form-group">
                                <label for="jam_upload">Jam Upload</label>
                                <input type="time" class="form-control" id="jam_upload" name="jam_upload"
                                    value="{{ old('jam_upload') }}">
                            </div>
                            <div class="form-group">
                                <label for="pics">Pics</label>
                                <select name="pics[]" id="pics" class="form-control select2" style="width: 100%;"
                                    multiple>
                                    @foreach ($users as $pic)
                                    <option value="{{ $pic->id }}" {{ (old('pics')==$pic->id) ? 'selected' : '' }}>{{
                                        $pic->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal View Report -->
<div class="modal fade" id="detailReportModal" tabindex="-1" role="dialog" aria-labelledby="detailReportModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailReportModalLabel">Detail Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered dt-responsive text-nowrap" width="100%" id="report-table">
                        <thead>
                            <tr>
                                <th>Tanggal Report</th>
                                <th>Link Konten</th>
                                <th>Views</th>
                                <th>Like</th>
                                <th>Comment</th>
                                <th>Share</th>
                                <th>Save</th>
                                <th>Usia 18-24</th>
                                <th>Usia 25-34</th>
                                <th>Usia 35-44</th>
                                <th>Usia 45-54</th>
                                <th>Gender M</th>
                                <th>Gender F</th>
                                <th>Total Pemutaran</th>
                                <th>Rata-rata Menonton</th>
                                <th>View Utuh</th>
                                <th>Pengikut Baru</th>
                            </tr>
                        </thead>
                        <tbody id="report-body">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Export Report -->
<div class="modal fade" id="exportReportModal" tabindex="-1" role="dialog" aria-labelledby="exportReportModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportReportModalLabel">Export Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('timelineTikTok.exportReport') }}" method="POST" id="form-export-report">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tanggal_awal">Tanggal Awal</label>
                        <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" value="{{ old('tanggal_awal') }}">
                    </div>
                    <div class="form-group">
                        <label for="tanggal_akhir">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="{{ old('tanggal_akhir') }}">
                    </div>
                    <div class="form-group">
                        <label for="tipe_konten">Tipe Konten</label>
                        <select name="tipe_konten" id="tipe_konten" class="form-control">
                            <option value="">--Pilih Tipe Konten--</option>
                            <option value="Reels">Reels</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Export</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    function addTimelineTikTok() {
        $.ajax({
            type: "POST",
            url: "{{ route('timelineTikTok.store') }}",
            data: $('#form-add-timeline-tiktok').serialize(),
            dataType: "json",
            success: function (response) {
                $('#addTimelineTikTokModal').modal('hide');
                $('#timeline-tiktok-table').DataTable().ajax.reload();
                $('#form-add-timeline-tiktok')[0].reset();
                new PNotify({
                    title: 'Berhasil',
                    text: response.success,
                    type: 'success',
                    styling: 'bootstrap3',
                });
            },
            error: function (xhr, status, error) {
                handleAjaxError(xhr);
            }
        });
        return false;
    }

    function editTimelineTikTok(kd_timeline_tiktok) {
        $.ajax({
            type: "GET",
            url: "{{ route('timelineTikTok.edit', ':timelineTiktok') }}".replace(':timelineTiktok', kd_timeline_tiktok),
            dataType: "json",
            success: function (response) {
                $('#editTimelineTikTokModal').modal('show');
                $('#form-edit-timeline-tiktok')[0].reset();
                $('#form-edit-timeline-tiktok').attr('action', "{{ route('timelineTikTok.update', ':timelineTiktok') }}".replace(':timelineTiktok', kd_timeline_tiktok));
                
                // Isi form dengan data yang diterima
                $('#form-edit-timeline-tiktok #tanggal').val(response.tanggal);
                $('#form-edit-timeline-tiktok #tipe_konten').val(response.tipe_konten);
                $('#form-edit-timeline-tiktok #jenis_konten').val(response.jenis_konten);
                $('#form-edit-timeline-tiktok #produk').val(response.produk).trigger('change');
                $('#form-edit-timeline-tiktok #hook_konten').val(response.hook_konten);
                $('#form-edit-timeline-tiktok #copywriting').val(response.copywriting);
                $('#form-edit-timeline-tiktok #jam_upload').val(response.jam_upload);
                $('#form-edit-timeline-tiktok #pics').val(response.pics).trigger('change');
            },
            error: function (xhr, status, error) {
                handleAjaxError(xhr);
            }
        });
        return false;
    }

    function updateTimelineTikTok() {
        var form = $('#form-edit-timeline-tiktok');
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: form.serialize(),
            dataType: "json",
            success: function (response) {
                $('#editTimelineTikTokModal').modal('hide');
                $('#timeline-tiktok-table').DataTable().ajax.reload();
                new PNotify({
                    title: 'Berhasil',
                    text: response.success,
                    type: 'success',
                    styling: 'bootstrap3',
                });
            },
            error: function (xhr, status, error) {
                handleAjaxError(xhr);
            }
        });
        return false;
    }

    function deleteTimelineTikTok(kd_timeline_tiktok) {
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            $.ajax({
                type: "DELETE",
                url: "{{ route('timelineTikTok.destroy', ':timelineTiktok') }}".replace(':timelineTiktok', kd_timeline_tiktok),
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $('#timeline-tiktok-table').DataTable().ajax.reload();
                    new PNotify({
                        title: 'Berhasil',
                        text: response.success,
                        type: 'success',
                        styling: 'bootstrap3',
                    });
                },
                error: function (xhr, status, error) {
                    handleAjaxError(xhr);
                }
            });
        }
        return false;
    }

    function handleAjaxError(xhr) {
        if (xhr.status === 422) {
            var errors = xhr.responseJSON.errors;
            $('.error-message').remove();
            $.each(errors, function (key, value) {
                var $element = $('#' + key);
                if (key === 'pics' || key === 'produk') {
                    $element.next('.select2-container').after('<span class="error-message text-danger">' + value[0] + '</span>');
                } else {
                    $element.after('<span class="error-message text-danger">' + value[0] + '</span>');
                }
                if ($element.hasClass('select2-hidden-accessible')) {
                    $element.next('.select2-container').addClass('is-invalid');
                }
            });
        } else {
            new PNotify({
                title: 'Error',
                text: 'Terjadi kesalahan. Silakan coba lagi.',
                type: 'error',
                styling: 'bootstrap3',
            });
        }
    }

    function detailReport(kd_timeline_tiktok) {
        $.ajax({
            type: "GET",
            url: "{{ route('timelineTikTok.detailReport', ':timelineTiktok') }}".replace(':timelineTiktok', kd_timeline_tiktok),
            dataType: "json",
            success: function (response) {
                $('#detailReportModal').modal('show');
                $('#report-body').empty();
                // $.each(response, function (key, value) {
                    var row = '<tr>' +
                        '<td>' + moment(response.created_at).locale('id').format('DD MMMM YYYY HH:mm:ss') + '</td>' +
                        '<td>' + response.link_konten + '</td>' +
                        '<td>' + response.views + '</td>' +
                        '<td>' + response.like + '</td>' +
                        '<td>' + response.comment + '</td>' +
                        '<td>' + response.share + '</td>' +
                        '<td>' + response.save + '</td>' +
                        '<td>' + response.usia_18_24 + '</td>' +
                        '<td>' + response.usia_25_34 + '</td>' +
                        '<td>' + response.usia_35_44 + '</td>' +
                        '<td>' + response.usia_45_54 + '</td>' +
                        '<td>' + response.gender_pria + '</td>' +
                        '<td>' + response.gender_wanita + '</td>' +
                        '<td>' + response.total_pemutaran + '</td>' +
                        '<td>' + response.rata_menonton + '</td>' +
                        '<td>' + response.view_utuh + '</td>' +
                        '<td>' + response.pengikut_baru + '</td>' +
                        '</tr>';
                    $('#report-body').append(row);
                // });
            },
            error: function (xhr, status, error) {
                handleAjaxError(xhr);
            }
        });
    }

    function deleteReport(kd_timeline_tiktok) {
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            $.ajax({
                type: "DELETE",
                url: "{{ route('timelineTikTok.destroyReport', ':timelineTiktok') }}".replace(':timelineTiktok', kd_timeline_tiktok),
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $('#detailReportModal').modal('hide');
                    $('#timeline-tiktok-table').DataTable().ajax.reload();
                    new PNotify({
                        title: 'Berhasil',
                        text: response.success,
                        type: 'success',
                        styling: 'bootstrap3',
                    });
                },
                error: function (xhr, status, error) {
                    handleAjaxError(xhr);
                }
            });
        }
        return false;
    }
    

    $(function() {
        $('.select2').select2({
            allowClear: true,
        });
        var table = $('#timeline-tiktok-table').DataTable({
            processing: true,
            serverSide: false,
            responsive: true,
            ajax: {
                url: '{{ route('timelineTikTok.index') }}',
                type: 'GET',
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
                { data: 'report', name: 'report', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        $('#form-add-timeline-tiktok').on('submit', function(e) {
            e.preventDefault();
            addTimelineTikTok();
        });

        $('#form-edit-timeline-tiktok').on('submit', function(e) {
            e.preventDefault();
            updateTimelineTikTok();
        });
    });
</script>
@endpush
