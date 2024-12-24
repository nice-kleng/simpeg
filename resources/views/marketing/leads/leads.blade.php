@extends('layouts.app', ['pageTitle' => 'Data Leads'])

@section('button-action')
    <a href="javascript:void(0)" data-toggle="modal" data-target="#sumberMarketingModal" class="btn btn-primary btn-sm pull-right">Input Sumber</a>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Data Sumber Leads</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-nowrap" id="leads-table" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Sumber</th>
                                <th>Jumlah Data</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sumberMarketings as $sumberMarketing)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><a href="{{ route('leads.detailLeadsByArea', $sumberMarketing->id) }}"><span class="badge badge-{{ ['primary', 'success', 'info', 'warning', 'danger'][$loop->index % 5] }}">{{ $sumberMarketing->nama_sumber_marketing }}</span></a></td>
                                    <td>{{ $sumberMarketing->marketings_count }}</td>
                                    <td>
                                        <a href="javascript:void(0)" data-id="{{ $sumberMarketing->id }}" class="btn btn-primary btn-sm btn-edit"><i class="fa fa-edit"></i></a>
                                        <a href="javascript:void(0)" data-url="{{ route('sumberMarketing.destroy', $sumberMarketing->id) }}" onclick="deleteData(this)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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

<!-- modal tambah sumber -->
<div class="modal fade" id="sumberMarketingModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sumberMarketingModalLabel">Tambah Sumber</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('sumberMarketing.store') }}" method="POST" id="sumberMarketingForm">
                    @csrf
                    <div class="form-group">
                        <label for="nama_sumber_marketing">Sumber</label>
                        <input type="text" name="nama_sumber_marketing" id="nama_sumber_marketing" class="form-control">
                        <input type="hidden" name="label" value="Leads">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
        $('#leads-table').DataTable();

        $('#leads-table').on('click', '.btn-edit', function () {
            const id = $(this).data('id');
            
            $.ajax({
                type: "get",
                url: "{{ route('sumberMarketing.edit', ':id') }}".replace(':id', id),
                dataType: "json",
                success: function (response) {
                    $('#sumberMarketingModalLabel').text('Edit Sumber');
                    $('#nama_sumber_marketing').val(response.nama_sumber_marketing);
                    $('#sumberMarketingModal').modal('show');
                    $('#sumberMarketingForm').append('<input type="hidden" name="_method" value="PUT">');
                    $('#sumberMarketingForm').attr('action', "{{ route('sumberMarketing.update', ':id') }}".replace(':id', id));
                }
            });
        });

        $('#sumberMarketingModal').on('hidden.bs.modal', function () {
            $('#sumberMarketingForm')[0].reset();
            $('#sumberMarketingForm').attr("action", "{{ route('sumberMarketing.store') }}");
            $('#sumberMarketingForm').find('input[name="_method"]').remove();
        });
    </script>
@endpush
