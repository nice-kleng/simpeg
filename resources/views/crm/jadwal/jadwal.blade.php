@extends('layouts.app', ['pageTitle' => 'Jadwal Kunjungan'])

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('button-action')
    <a href="javascript:void(0)" data-toggle="modal" data-target="#jadwalModal" class="btn btn-primary btn-sm pull-right"><i
            class="fa fa-plus"></i></a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Data Jadwal Kunjungan</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap" id="jadwal-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Hari dan Tanggal</th>
                                    <th>Bulan</th>
                                    <th>Nama</th>
                                    <th>Pic</th>
                                    <th>Alamat</th>
                                    <th>Status</th>
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
    <div class="modal fade" id="jadwalModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pertanyaanModalLabel">Buat Jadwal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="jadwalForm">
                        @csrf
                        <div class="form-group">
                            <input type="date" name="tanggal" id="tanggal" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="mitra_id">Mitra</label>
                            <input type="hidden" name="id" id="jadwal_id">
                            <select name="mitra_id" id="mitra_id" class="form-control select2" style="width: 100%;"
                                required>
                                <option value="">-- Pilih Mitra --</option>
                                @foreach ($mitras as $mitra)
                                    <option value="{{ $mitra->id }}">{{ $mitra->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">PIC</label>
                            <select name="pic[]" id="pic" class="form-control select2" style="width: 100%;" required
                                multiple>
                                <option value="">-- Pilih Pic --</option>
                                @foreach ($pics as $pic)
                                    <option value="{{ $pic->id }}">{{ $pic->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                allowClear: true,
            });

            var table = $('#jadwal-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('crm.jadwalKunjungan.index') }}",
                    data: function(d) {
                        d.search = $('input[type="search"]').val();
                        // Convert month name to number if needed
                        if (d.search) {
                            var monthNames = ["January", "February", "March", "April", "May", "June",
                                "July", "August", "September", "October", "November", "December"
                            ];
                            var monthIndex = monthNames.findIndex(month =>
                                month.toLowerCase().includes(d.search.toLowerCase())
                            );
                            if (monthIndex !== -1) {
                                d.month = (monthIndex + 1).toString().padStart(2, '0');
                            }
                        }
                    },
                    error: function(xhr, error, thrown) {
                        console.log('Error:', error);
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'bulan',
                        name: 'bulan'
                    },
                    {
                        data: 'mitra',
                        name: 'mitra'
                    },
                    {
                        data: 'pic',
                        name: 'pic'
                    },
                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#jadwalForm').on('submit', function(e) {
                e.preventDefault();
                var jadwal_id = $('#jadwal_id').val();

                var url = jadwal_id ?
                    "{{ route('crm.jadwalKunjungan.update', ':id') }}".replace(':id', jadwal_id) :
                    "{{ route('crm.jadwalKunjungan.store') }}";
                var type = jadwal_id ? "PUT" : "POST";

                var formData = new FormData(this);

                if (type === "PUT") {
                    formData.append('_method', 'PUT');
                }

                $.ajax({
                    url: url,
                    type: 'POST', // Always use POST, let Laravel handle the method override
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $('#jadwalModal').modal('hide');
                        Swal.fire('Success', data.success, 'success');
                        table.draw();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMessage = '';
                            for (let key in errors) {
                                errorMessage += errors[key][0] + '\n';
                            }
                            Swal.fire('Error', errorMessage, 'error');
                        } else {
                            Swal.fire('Error', 'Terjadi kesalahan server', 'error');
                        }
                    }
                });
            });

            $(document).on('click', '.edit', function() {
                let id = $(this).data('id');

                $.ajax({
                    type: "get",
                    url: "{{ route('crm.jadwalKunjungan.edit', ':id') }}".replace(':id', id),
                    dataType: "json",
                    success: function(response) {
                        if (response.status === 'success') {
                            let data = response.data;
                            $('#jadwalModal').modal('show');
                            $('#jadwal_id').val(data.id);
                            $('#tanggal').val(data.tanggal);
                            $('#mitra_id').val(data.mitra_id).trigger('change');

                            // Make sure pic data exists and is an array
                            if (data.pic && Array.isArray(data.pic)) {
                                let picIds = data.pic.map(item => item.id);
                                $('#pic').val(picIds).trigger('change');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengambil data');
                    }
                });
            });

            $('#jadwalModal').on('hidden.bs.modal', function() {
                $(this).find('form').trigger('reset');
                $('#jadwal_id').val('');
                $('#mitra_id').val(null).trigger('change');
                $('#pic').val(null).trigger('change');
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
                            url: "{{ route('crm.jadwalKunjungan.destroy', ':id') }}"
                                .replace(
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
        });
    </script>
@endpush
