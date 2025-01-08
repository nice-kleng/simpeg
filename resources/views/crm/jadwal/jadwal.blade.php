@extends('layouts.app', ['pageTitle' => 'Jadwal Kunjungan'])

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
                        <table class="table table-bordered" id="jadwal-table">
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
                    <form action="" method="POST" id="pertanyaanForm">
                        @csrf
                        <div class="form-group">
                            <input type="date" name="tanggal" id="tanggal" class="form-control">
                        </div>
                        <div class="form-group">
                            <select name="mitra_id" id="mitra_id" class="form-control" required>
                                <option value="">-- Pilih Mitra --</option>
                                @foreach ($mitras as $mitra)
                                    <option value="{{ $mitra->id }}">{{ $mitra->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">PIC</label>
                            <select name="pic" id="pic" class="form-control" required multiple>
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
