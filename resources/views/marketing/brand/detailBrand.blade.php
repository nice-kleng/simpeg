@extends('layouts.app', ['pageTitle' => 'Data Brand ' . $sumberMarketing->nama_sumber_marketing])

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('button-action')
    <a href="{{ route('brand.index') }}" class="btn btn-secondary btn-sm pull-right ml-2">Kembali</a>
    <a href="javascript:void(0)" data-toggle="modal" data-target="#brandModal"
        class="btn btn-primary btn-sm pull-right">Input Brand</a>
@endsection

@section('content')
@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Data Brand</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-nowrap" id="brand-table" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Rating</th>
                                <th>Alamat</th>
                                <th>No HP</th>
                                <th>Brand</th>
                                <th>Pic</th>
                                <th>Pic Sign</th>
                                <th>Maps</th>
                                <th>Tanggal</th>
                                <th>Status Follow Up</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sumberMarketing->marketings as $marketing)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $marketing->nama }}</td>
                                <td>{{ $marketing->rating }}</td>
                                <td>{{ $marketing->alamat }}</td>
                                <td>{{ $marketing->no_hp }}</td>
                                <td>{{ $marketing->brand }}</td>
                                <td>{{ $marketing->pics->pluck('name')->implode(', ') }}</td>
                                <td>{{ $marketing->picSign->pluck('name')->implode(', ') }}</td>
                                <td>{{ $marketing->maps }}</td>
                                <td>{{ \Carbon\Carbon::parse($marketing->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                                <td>
                                    @php
                                        $lastFollowUp = $marketing->followUp->last();
                                        $status = $lastFollowUp ? $lastFollowUp->getRawOriginal('status') : null;
                                        $badgeColor = '';
                                        $badgeText = 'Not Started';
                                        
                                        if ($status === '1') {
                                            $badgeColor = 'primary';
                                            $badgeText = 'Follow Up';
                                        } elseif ($status === '2') {
                                            $badgeColor = 'danger'; 
                                            $badgeText = 'Ditolak';
                                        } elseif ($status === '3') {
                                            $badgeColor = 'success';
                                            $badgeText = 'Join';
                                        } else {
                                            $badgeColor = 'secondary';
                                        }
                                    @endphp
                                    <span class="badge badge-{{ $badgeColor }}">
                                        {{ $badgeText }}
                                    </span>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" data-id="{{ $marketing->id }}"
                                        class="btn btn-primary btn-sm btn-edit">Edit</a>
                                    <a href="javascript:void(0)" data-url="{{ route('brand.destroy', $marketing->id) }}"
                                        onclick="deleteData(this)" class="btn btn-danger btn-sm btn-delete">Hapus</a>
                                    <a href="{{ route('brand.followUp', $marketing->id) }}" class="btn btn-info btn-sm btn-followup">Follow Up</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal tambah turlap -->
<div class="modal fade" id="brandModal">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="brandModalLabel">Tambah Brand</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('brand.store') }}" method="POST" id="brandForm">
                    <div id="mtd"></div>
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="maps">Maps</label>
                                <input type="text" name="maps" id="maps" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <input type="text" name="alamat" id="alamat" class="form-control">
                                <input type="hidden" name="sumber_marketing_id" value="{{ $sumberMarketing->id }}">
                                <input type="hidden" name="label" value="Brand">
                            </div>
                            <div class="form-group">
                                <label for="no_hp">No HP</label>
                                <input type="text" name="no_hp" id="no_hp" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="brand">Brand</label>
                                <input type="text" name="brand" id="brand" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="rating">Rating</label>
                                <select name="rating" id="rating" class="form-control">
                                    <option value="0">Not Rated</option>
                                    <option value="1">Minat & Mampu</option>
                                    <option value="2">Minat Tidak Mampu</option>
                                    <option value="3">Tidak Minat Mampu</option>
                                    <option value="4">Tidak Minat Tidak Mampu</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="status_prospek">Status Prospek</label>
                                <select name="status_prospek" id="status_prospek" class="form-control">
                                    <option value="Not Status">Not Status</option>
                                    <option value="Prospek">Prospek</option>
                                    <option value="Non Prospek">Non Prospek</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="pics">PIC</label>
                                <select name="pics[]" id="pics" class="form-control select2" style="width: 100%" multiple>
                                    @foreach ($pegawai as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="picSign">PIC Sign</label>
                                <select name="picSign[]" id="picSign" class="form-control select2" style="width: 100%" multiple>
                                    @foreach ($pegawai as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
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
        $('#brand-table').DataTable();

        $('.select2').select2({
            allowClear: true,
        });

        // $('#turlapModal').on('show.bs.modal', function(event) {
        //     var button = $(event.relatedTarget);
        //     var id = button.data('id');

        //     if (id) {
        //         $('#turlapModalLabel').text('Edit Turlap');
        //     } else {
        //         $('#turlapModalLabel').text('Tambah Turlap');
        //     }

        //     $.ajax({
        //         url: "{{ route('turlap.edit', ':id') }}".replace(':id', id),
        //         type: 'GET',
        //         success: function(response) {
        //             console.log(response);
        //         }
        //     });
        // });

        $('#brand-table').on('click', '.btn-edit', function() {
            var id = $(this).data('id');

            $.ajax({
                url: "{{ route('brand.edit', ':id') }}".replace(':id', id),
                type: 'GET',
                success: function(response) {
                    console.log(response);

                    $('#brandModalLabel').text('Edit Brand');
                    $('#nama').val(response.nama);
                    $('#maps').val(response.maps);
                    $('#alamat').val(response.alamat);
                    $('#no_hp').val(response.no_hp);
                    $('#brand').val(response.brand);
                    $('#rating').val(response.rating_raw);
                    $('#tanggal').val(response.tanggal);
                    $('#status_prospek').val(response.status_prospek);
                    $('#pics').val(response.pics).trigger('change');
                    $('#picSign').val(response.picSign).trigger('change');
                    $('#brandModal').modal('show');

                    $('#mtd').html('<input type="hidden" name="_method" value="PUT">');
                    $('#brandForm').attr('action', "{{ route('brand.update', ':id') }}".replace(':id', id));
                }
            });
        });

        $('#turlapModal').on('hidden.bs.modal', function() {
            $('#brandForm')[0].reset();
            $('#brandForm').attr('action', "{{ route('brand.store') }}");
            $('#mtd').html('');
        });
    });
</script>
@endpush