@extends('layouts.app', ['pageTitle' => 'Data Brand'])

@section('content')

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
                                <th>Area</th>
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
                            </tr>
                            <tbody>
                        </thead>
                            @foreach ($marketings as $marketing)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $marketing->sumberMarketing->nama_sumber_marketing }}</td>
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
                                {{-- <td>
                                    <a href="javascript:void(0)" data-id="{{ $marketing->id }}"
                                        class="btn btn-primary btn-sm btn-edit">Edit</a>
                                    <a href="javascript:void(0)" data-url="{{ route('turlap.destroy', $marketing->id) }}"
                                        onclick="deleteData(this)" class="btn btn-danger btn-sm btn-delete">Hapus</a>
                                    <a href="{{ route('turlap.followUp', $marketing->id) }}" class="btn btn-info btn-sm btn-followup">Follow Up</a>
                                </td> --}}
                            </tr>
                            @endforeach
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
    $(document).ready(function() {
        $('#turlap-table').DataTable();
    });
</script>
@endpush
