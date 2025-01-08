@extends('layouts.app', ['pageTitle' => 'Setup User Permission'])

@section('button-action')
    <a href="{{ route('pegawai.index') }}" class="btn btn-secondary btn-sm pull-right">Kembali</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Setup User Permission</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="{{ route('pegawai.storePermission', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            @foreach ($permissions as $group => $items)
                                <h3>{{ Str::ucfirst($group) }}</h3>
                                @foreach ($items->chunk(4) as $chunk)
                                    <div class="row">
                                        @foreach ($chunk as $permission)
                                            <div class="col-md-3">
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        {{ $user->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
