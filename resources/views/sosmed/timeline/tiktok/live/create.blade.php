@extends('layouts.app', ['pageTitle' => 'Tambah Report TikTok Live'])

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('button-action')
    <a href="{{ route('reportTikTokLive.index') }}" class="btn btn-primary btn-sm pull-right">Kembali</a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Form Report TikTok Live</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form action="{{ route('reportTikTokLive.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="judul">Judul</label>
                                <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="waktu_mulai">Waktu Mulai</label>
                                <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai" value="{{ old('waktu_mulai') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="durasi">Durasi</label>
                                <input type="text" class="form-control" id="durasi" name="durasi" value="{{ old('durasi') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="total_tayangan">Total Tayangan</label>
                                <input type="text" class="form-control" id="total_tayangan" name="total_tayangan" value="{{ old('total_tayangan') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="penonton_unik">Penonton Unik</label>
                                <input type="text" class="form-control" id="penonton_unik" name="penonton_unik" value="{{ old('penonton_unik') }}">
                            </div>
                            <div class="form-group">
                                <label for="rata_menonton">Rata-rata Menonton</label>
                                <input type="text" class="form-control" id="rata_menonton" name="rata_menonton" value="{{ old('rata_menonton') }}">
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jumlah_penonton_teratas">Jumlah Penonton Teratas</label>
                                <input type="text" class="form-control" id="jumlah_penonton_teratas" name="jumlah_penonton_teratas" value="{{ old('jumlah_penonton_teratas') }}">
                            </div>
                            <div class="form-group">
                                <label for="pengikut">Pengikut</label>
                                <input type="text" class="form-control" id="pengikut" name="pengikut" value="{{ old('pengikut') }}">
                            </div>
                            <div class="form-group">
                                <label for="penonton_lainnya">Penonton Lainnya</label>
                                <input type="text" class="form-control" id="penonton_lainnya" name="penonton_lainnya" value="{{ old('penonton_lainnya') }}">
                            </div>
                            <div class="form-group">
                                <label for="pengikut_baru">Pengikut Baru</label>
                                <input type="text" class="form-control" id="pengikut_baru" name="pengikut_baru" value="{{ old('pengikut_baru') }}">
                            </div>
                            <div class="form-group">
                                <label for="penonton_berkomentar">Penonton Berkomentar</label>
                                <input type="text" class="form-control" id="penonton_berkomentar" name="penonton_berkomentar" value="{{ old('penonton_berkomentar') }}">
                            </div>
                            <div class="form-group">
                                <label for="suka">Suka</label>
                                <input type="text" class="form-control" id="suka" name="suka" value="{{ old('suka') }}">
                            </div>
                            <div class="form-group">
                                <label for="berbagi">Berbagi</label>
                                <input type="text" class="form-control" id="berbagi" name="berbagi" value="{{ old('berbagi') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
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
        $('.select2').select2({
            allowClear: true,
        });
    });
</script>
@endpush
