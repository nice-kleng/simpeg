@extends('layouts.app', ['pageTitle' => 'Data Jawaban Mitra'])

@section('button-action')
    <a href="{{ route('crm.jadwalKunjungan.index') }}" class="btn btn-secondary btn-sm pull-right">Kembali</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Data Jawaban Mitra - {{ $jadwal->mitra->nama }}</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="jawaban-mitra-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pertanyaan</th>
                                    <th>Jawaban</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Jawaban -->
    <div class="modal fade" id="editJawabanModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Jawaban</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editJawabanForm">
                    <div class="modal-body">
                        <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">
                        <input type="hidden" name="pertanyaan_id" id="pertanyaan_id">
                        <div class="form-group">
                            <label>Pertanyaan</label>
                            <p id="pertanyaanText"></p>
                        </div>
                        <div class="form-group">
                            <label>Jawaban</label>
                            <textarea class="form-control" name="jawaban" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#jawaban-mitra-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('crm.jadwalKunjungan.jawabanMitra', $jadwal->id) }}",
                    type: 'GET',
                    error: function(xhr, error, thrown) {
                        console.log('Error:', error);
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'pertanyaan',
                        name: 'pertanyaan'
                    },
                    {
                        data: 'jawaban',
                        name: 'jawaban'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $(document).on('click', '.edit-jawaban', function() {
                $('#pertanyaan_id').val($(this).data('id'));
                $('#pertanyaanText').text($(this).data('pertanyaan'));
                $('textarea[name="jawaban"]').val($(this).data('jawaban'));
                $('.modal-title').text($(this).data('jawaban') ? 'Edit Jawaban' : 'Tambah Jawaban');
                $('#editJawabanModal').modal('show');
            });

            $('#editJawabanForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('crm.jadwalKunjungan.updateJawaban') }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#editJawabanModal').modal('hide');
                        table.ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: xhr.responseJSON.message
                        });
                    }
                });
            });
        });
    </script>
@endpush
