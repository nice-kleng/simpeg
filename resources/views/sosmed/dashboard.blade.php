@extends('layouts.app', ['pageTitle' => 'Dashboard'])

@section('content')

@can('View Sosmed Kadiv Dashboard')
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Dashboard</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-md-5">
                        <h3>Project</h3>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table-project">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Staff</th>
                                        <th>Project</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pegawai as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <a href="" class="btn btn-sm btn-info">View</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="row">
                            <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fa fa-caret-square-o-right"></i>
                                    </div>
                                    <div class="count">{{ $tiktok_video }}</div>

                                    <h3>Tiktok Video</h3>
                                    <p>Total Tiktok Video</p>
                                </div>
                            </div>
                            <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fa fa-caret-square-o-right"></i>
                                    </div>
                                    <div class="count">{{ $feed_instagram }}</div>

                                    <h3>Feed Instagram</h3>
                                    <p>Total Feed Instagram</p>
                                </div>
                            </div>
                            <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fa fa-caret-square-o-right"></i>
                                    </div>
                                    <div class="count">{{ $story_instagram }}</div>

                                    <h3>Story Instagram</h3>
                                    <p>Total Story Instagram</p>
                                </div>
                            </div>
                            <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fa fa-caret-square-o-right"></i>
                                    </div>
                                    <div class="count">{{ $project_new }}</div>

                                    <h3>Project Baru</h3>
                                    <p>Total Project Baru</p>
                                </div>
                            </div>
                            <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fa fa-caret-square-o-right"></i>
                                    </div>
                                    <div class="count">{{ $project_ongoing }}</div>

                                    <h3>Project Ongoing</h3>
                                    <p>Total Project Ongoing</p>
                                </div>
                            </div>
                            <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fa fa-caret-square-o-right"></i>
                                    </div>
                                    <div class="count">{{ $project_completed }}</div>

                                    <h3>Project Completed</h3>
                                    <p>Total Project Completed</p>
                                </div>
                            </div>
                            <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fa fa-caret-square-o-right"></i>
                                    </div>
                                    <div class="count">{{ $new_tiktok_follower }}</div>

                                    <h3>New Tiktok Follower</h3>
                                    <p>Total New Tiktok Follower</p>
                                </div>
                            </div>
                            <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fa fa-caret-square-o-right"></i>
                                    </div>
                                    <div class="count">{{ $new_ig_follower }}</div>

                                    <h3>New Instagram Follower</h3>
                                    <p>Total New Instagram Follower</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endcan

@can('View Sosmed Pegawai Dashboard')

@endcan

@endsection