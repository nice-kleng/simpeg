@extends('layouts.app', ['pageTitle' => 'Jabatan'])

@section('button-action')
    <a href="" class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#tambah-jabatan">Tambah Data</a>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Data Jabatan</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="jabatan-table" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Jabatan</th>
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

<!-- Modal Tambah Data -->
<div class="modal fade" id="tambah-jabatan">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambah-jabatan-label">Tambah Data Jabatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" onsubmit="saveData()">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_jabatan">Nama Jabatan</label>
                        <input type="text" class="form-control" id="nama_jabatan" name="nama_jabatan" required>
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
<div class="modal fade" id="edit-jabatan">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-jabatan-label">Edit Data Jabatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" id="form-edit-jabatan" onsubmit="updateData()">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_jabatan">Nama Jabatan</label>
                        <input type="text" class="form-control" id="nama_jabatane" name="nama_jabatan" required>
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


@endsection

@push('scripts')
<script>

    function saveData() {
        event.preventDefault();
        var nama_jabatan = $('#nama_jabatan').val();
        $.ajax({
            url: "{{ route('jabatan.store') }}",
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                nama_jabatan: nama_jabatan
            },
            success: function(response) {
                $('#tambah-jabatan').modal('hide');
                $('#jabatan-table').DataTable().ajax.reload();
                $('#nama_jabatan').val('');

                new PNotify({
                    title: response.title,
                    text: response.message,
                    type: response.type,
                    styling: 'bootstrap3',
                });
            },
            error: function(xhr) {
                alert('Error: ' + xhr.statusText);
            }
        });
    }

    function editData(id) {
        $('#edit-jabatan').modal('show');
        $.ajax({
            url: "{{ route('jabatan.edit', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function(response) {
                console.log(response);
                $('#nama_jabatane').val(response.nama_jabatan);
                $('#edit-jabatan-label').text('Edit Data Jabatan');
                $('#form-edit-jabatan').attr('action', "{{ route('jabatan.update', ':id') }}".replace(':id', id));
            },
            error: function(xhr) {
                alert('Error: ' + xhr.statusText);
            }
        });
    }

    function updateData(){
        event.preventDefault();
        var nama_jabatan = $('#nama_jabatane').val();
        $.ajax({
            url: $('#form-edit-jabatan').attr('action'),
            type: 'PUT',
            data: {
                _token: "{{ csrf_token() }}",
                nama_jabatan: nama_jabatan
            },
            success: function(response) {
                $('#edit-jabatan').modal('hide');
                $('#jabatan-table').DataTable().ajax.reload();
                $('#nama_jabatane').val('');

                new PNotify({
                    title: response.title,
                    text: response.message,
                    type: response.type,
                    styling: 'bootstrap3',
                });
            },
            error: function(xhr) {
                alert('Error: ' + xhr.statusText);
            }
        });
    }

    $(document).ready(function() {
        var table = $('#jabatan-table').DataTable({
            responsive: true,   
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('jabatan.index') }}",
                type: 'GET',
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'nama_jabatan', name: 'nama_jabatan' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush
