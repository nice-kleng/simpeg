@extends('layouts.app', ['pageTitle' => 'Tambah Data Mitra'])

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Form Mitra</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="{{ route('mitra.store') }}" method="POST" class="row">
                        @csrf
                        <div class="form-group col-md-6">
                            <label for="kode">Kode Mitra</label>
                            <input type="text" class="form-control" id="kode" name="kode" value="{{ old('kode') }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tanggal">Tanggal Gabung</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="status_mitra">Status Mitra</label>
                            <select name="status_mitra" id="status_mitra" class="form-control">
                                <option value="Reseller" {{ old('status_mitra') == 'Reseller' ? 'selected' : '' }}>Reseller</option>
                                <option value="Agen" {{ old('status_mitra') == 'Agen' ? 'selected' : '' }}>Agen</option>
                                <option value="Sub Distributor" {{ old('status_mitra') == 'Sub Distributor' ? 'selected' : '' }}>Sub Distributor</option>
                                <option value="Distributor" {{ old('status_mitra') == 'Distributor' ? 'selected' : '' }}>Distributor</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="kota_wilayah">Kota/Wilayah</label>
                            <input type="text" class="form-control" id="kota_wilayah" name="kota_wilayah" value="{{ old('kota_wilayah') }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="fb">Facebook</label>
                            <input type="text" class="form-control" id="fb" name="fb" value="{{ old('fb') }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="ig">Instagram</label>
                            <input type="text" class="form-control" id="ig" name="ig" value="{{ old('ig') }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="marketplace">Marketplace</label>
                            <input type="text" class="form-control" id="marketplace" name="marketplace" value="{{ old('marketplace') }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="no_hp">No Hp</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="upline">Upline</label>
                            <select name="upline" id="upline" class="form-control">
                                <option value="">Pilih Upline</option>
                                @foreach ($uplines as $upline)
                                    <option value="{{ $upline->id }}" {{ old('upline') == $upline->id ? 'selected' : '' }}>{{ $upline->nama . '|' . $upline->status_mitra }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="bulan">Bulan</label>
                            <select name="bulan" id="bulan" class="form-control">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ Carbon\Carbon::create()->month($i)->locale('id')->monthName }}" {{ old('bulan') == Carbon\Carbon::create()->month($i)->locale('id')->monthName ? 'selected' : '' }}>{{ Carbon\Carbon::create()->month($i)->locale('id')->monthName }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="note_1">Note 1</label>
                            <select name="note_1" id="note_1" class="form-control">
                                <option value="New Mitra">New Mitra</option>
                                <option value="Upgrade">Upgrade</option>
                                <option value="Downgrade">Downgrade</option>
                                <option value="Move">Move</option>
                                <option value="Blacklist">Blacklist</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="note_2">Note 2</label>
                            <input type="text" class="form-control" id="note_2" name="note_2" value="{{ old('note_2') }}" required>
                        </div>
                        <div class="form-group col-md-6" style="margin-top: 25px;">   
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('mitra.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
