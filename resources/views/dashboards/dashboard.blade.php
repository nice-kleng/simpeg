@extends('layouts.app', ['pageTitle' => 'Dashboard'])

@section('content')

@php

    $dashboards = [
        'sosmed_kadiv' => [
            'permission' => 'View Sosmed Kadiv Dashboard',
            'view' => 'dashboards.kadiv_sosmed',
        ],
        'sosmed_staff' => [
            'permission' => 'View Sosmed Pegawai Dashboard',
            'view' => 'dashboards.staff_sosmed',
        ],
    ];

    $userDashboards = collect($dashboards)->filter(function ($dashboard) {
        return auth()->user()->can($dashboard['permission']);
    });

    // batasi hanya pada dashboard kadiv
    if (auth()->user()->hasRole('Super Admin')) {
        $userDashboards = $userDashboards->filter(function ($dashboard, $key) {
            return str_contains($key, 'kadiv');
        });
    }

@endphp

@foreach ($userDashboards as $key => $dashboard)
    @include($dashboard['view'])
@endforeach

@endsection