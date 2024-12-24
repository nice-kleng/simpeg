@extends('layouts.app', ['pageTitle' => 'Follow Up Brand'])

@section('button-action')
<a href="{{ route('brand.detailBrandByArea', $brand->sumber_marketing_id) }}" class="btn btn-secondary btn-sm pull-right ml-2">Kembali</a>
<a href="javascript:void(0)" data-toggle="modal" data-target="#followUpModal"
    class="btn btn-primary btn-sm pull-right">Input Follow Up</a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Follow Up Brand</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-nowrap" width="100%">
                        <tr>
                            <th>Nama : </th>
                            <td>{{ $brand->nama }}</td>
                        </tr>
                        <tr>
                            <th>Alamat : </th>
                            <td>{{ $brand->alamat }}</td>
                        </tr>
                        <tr>
                            <th>Maps : </th>
                            <td>{{ $brand->maps }}</td>
                        </tr>
                        <tr>
                            <th>Rating : </th>
                            <td>{{ $brand->rating }}</td>
                        </tr>
                        <tr>
                            <th>Status Prospek : </th>
                            <td>{{ $brand->status_prospek }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal : </th>
                            <td>{{ \Carbon\Carbon::parse($brand->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                        </tr>
                        <tr>
                            <th>Status Follow Up : </th>
                            <td>{{ $brand->followUp->last()->status ?? 'Not Started' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Follow Up Brand</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-nowrap" id="followUp-table" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th>Tanggal Masuk Leads</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($brand->followUp as $followUp)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $followUp->status }}</td>
                                <td>{{ $followUp->keterangan }}</td>
                                <td>{{ \Carbon\Carbon::parse($followUp->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                                <td>
                                    <a href="javascript:void(0)" data-id="{{ $followUp->id }}"
                                        class="btn btn-primary btn-sm btn-edit">Edit</a>
                                    <a href="javascript:void(0)" data-url="{{ route('turlap.followUpDestroy', $followUp->id) }}"
                                        onclick="deleteData(this)" class="btn btn-danger btn-sm btn-delete">Hapus</a>
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

<!-- modal add follow up turlap -->
<div class="modal fade" id="followUpModal" tabindex="-1" role="dialog" aria-labelledby="followUpModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="followUpModalLabel">Input Follow Up</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('brand.followUpStore', $brand->id) }}" method="POST" id="followUpForm">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1">Follow Up</option>
                            <option value="2">Ditolak</option>
                            <option value="3">Join</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <input type="text" name="keterangan" id="keterangan" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control">
                    </div>
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
        $('#followUp-table').DataTable();

        $('#followUp-table').on('click', '.btn-edit', function () {
            var id = $(this).data('id');
            
            $.ajax({
                type: "get",
                url: "{{ route('brand.followUpEdit', ':id') }}".replace(':id', id),
                data: {
                    id: id
                },
                dataType: "json",
                success: function (response) {                    
                    $('#followUpModalLabel').text('Edit Follow Up');
                    $('#status').val(response.status_raw).trigger('change');
                    $('#keterangan').val(response.keterangan);
                    $('#tanggal').val(response.tanggal);
                    $('#followUpModal').modal('show');

                    $('#followUpForm').append('<input type="hidden" name="_method" value="PUT">');
                    $('#followUpForm').attr('action', "{{ route('brand.followUpUpdate', ':id') }}".replace(':id', id));
                }
            });
        });

        $('#followUpModal').on('hidden.bs.modal', function() {
            $('#followUpForm')[0].reset();
            $('#followUpForm').attr('action', "{{ route('brand.followUpStore', $brand->id) }}");
            $('#followUpForm').find('input[name="_method"]').remove();
        });
    });
</script>
@endpush
