@extends('layouts.app', ['pageTitle' => 'Data Pertanyaan'])

@section('button-action')
    <a href="javascript:void(0)" data-toggle="modal" data-target="#pertanyaanModal" class="btn btn-primary btn-sm pull-right"><i
            class="fa fa-plus"></i></a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Data Area Turlap</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="pertanyaan-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pertanyaan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal pertanyaan -->
    <div class="modal fade" id="pertanyaanModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pertanyaanModalLabel">Tambah Pertanyaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('crm.pertanyaan.store') }}" method="POST" id="pertanyaanForm">
                        @csrf
                        <input type="hidden" name="id" id="pertanyaan_id">
                        <div class="form-group">
                            <label for="pertanyaan">Pertanyaan</label>
                            <textarea name="pertanyaan" id="pertanyaan" class="form-control" cols="30" rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let table = $('#pertanyaan-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('crm.pertanyaan.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'pertanyaan',
                        name: 'pertanyaan'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('#pertanyaanForm').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                let id = $('#pertanyaan_id').val();
                let url = id ? "{{ route('crm.pertanyaan.update', ':pertanyaan') }}".replace(':pertanyaan',
                    id) : "{{ route('crm.pertanyaan.store') }}";
                let method = id ? 'PUT' : 'POST';

                $.ajax({
                    type: method,
                    url: url,
                    data: formData,
                    success: function(response) {
                        $('#pertanyaanModal').modal('hide');
                        $('#pertanyaanForm').trigger('reset');
                        $('#pertanyaan_id').val('');
                        table.ajax.reload();
                        Swal.fire('Success', response.success, 'success');
                    },
                    error: function(response) {
                        let errors = response.responseJSON.errors;
                        let errorMessage = '';
                        $.each(errors, function(key, value) {
                            errorMessage += value[0] + '\n';
                        });
                        Swal.fire('Error', errorMessage, 'error');
                    }
                });
            });

            $('body').on('click', '.edit', function() {
                let id = $(this).data('id');
                $.get("{{ route('crm.pertanyaan.edit', ':id') }}".replace(':id', id),
                    function(data) {
                        $('#pertanyaanModalLabel').text('Edit Pertanyaan');
                        $('#saveBtn').text('Update');
                        $('#pertanyaanModal').modal('show');
                        $('#pertanyaan_id').val(data.id);
                        $('#pertanyaan').val(data.pertanyaan);
                    }).fail(function(response) {
                    console.log(response);
                });
            });

            $('body').on('click', '.delete', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: "{{ route('crm.pertanyaan.destroy', ':id') }}".replace(
                                ':id', id),
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                table.ajax.reload();
                                Swal.fire('Deleted!', response.success, 'success');
                            },
                            error: function(response) {
                                Swal.fire('Error', 'Failed to delete data', 'error');
                            }
                        });
                    }
                });
            });

            // Reset form when modal is closed
            $('#pertanyaanModal').on('hidden.bs.modal', function() {
                $('#pertanyaanForm').trigger('reset');
                $('#pertanyaan_id').val('');
                $('#pertanyaanModalLabel').text('Tambah Pertanyaan');
                $('#saveBtn').text('Save');
            });
        });
    </script>
@endpush
