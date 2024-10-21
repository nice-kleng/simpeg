@extends('layouts.app', ['pageTitle' => 'Edit Data Pegawai'])

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Edit Data Pegawai</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form action="{{ route('pegawai.update', $pegawai->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ $pegawai->nama }}" required>
                    </div>
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" value="{{ $pegawai->nik }}" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $pegawai->akun->email }}" required>
                    </div>
                    <div class="form-group">
                        <label for="wa">No. HP</label>
                        <input type="text" class="form-control" id="wa" name="wa" value="{{ $pegawai->wa }}" required>
                    </div>
                    <div class="form-group">
                        <label for="ttl">Tempat, Tanggal Lahir</label>
                        <input type="text" class="form-control" id="ttl" name="ttl" value="{{ $pegawai->ttl }}" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" required>{{ $pegawai->alamat }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="jenkel">Jenis Kelamin</label>
                        <select class="form-control" id="jenkel" name="jenkel" required>
                            <option value="Laki-laki" {{ $pegawai->jenkel == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ $pegawai->jenkel == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jabatan_id">Jabatan</label>
                        <select class="form-control" id="jabatan_id" name="jabatan_id" required>
                            @foreach($jabatan as $jabatan)
                                <option value="{{ $jabatan->id }}" {{ $pegawai->jabatan_id == $jabatan->id ? 'selected' : '' }}>{{ $jabatan->nama_jabatan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto</label>
                        <input type="file" class="form-control" id="foto" name="foto">
                        @if($pegawai->foto)
                            <img src="{{ asset('storage/' . $pegawai->foto) }}" width="100">
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
