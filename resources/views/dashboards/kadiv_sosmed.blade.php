@can('View Sosmed Kadiv Dashboard')
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <h4>Dashboard</h4>
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
                                            <a href="{{ route('detail.project', $item->id) }}" class="btn btn-sm btn-info">View</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="row">
                            <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-3">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fa fa-caret-square-o-right"></i>
                                    </div>
                                    <div class="count">{{ $tiktok_video }}</div>

                                    <h4>Tiktok Video</h4>
                                    {{-- <p>Total Tiktok Video</p> --}}
                                </div>
                            </div>
                            <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-3">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fa fa-plus-square"></i>
                                    </div>
                                    <div class="count">{{ $feed_instagram }}</div>

                                    <h4>Feed Instagram</h4>
                                    {{-- <p>Total Feed Instagram</p> --}}
                                </div>
                            </div>
                            <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-3">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fa fa-play-circle"></i>
                                    </div>
                                    <div class="count">{{ $story_instagram }}</div>

                                    <h4>Story Instagram</h4>
                                    {{-- <p>Total Story Instagram</p> --}}
                                </div>
                            </div>
                            <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-3">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fa fa-plus-square-o"></i>
                                    </div>
                                    <div class="count">{{ $total_project_all }}</div>

                                    <h4>Total Project</h4>
                                    {{-- <p>Total Project Baru</p> --}}
                                </div>
                            </div>
                            <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-3">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fa fa-refresh"></i>
                                    </div>
                                    <div class="count">{{ $project_ongoing }}</div>

                                    <h4>Project Ongoing</h4>
                                    {{-- <p>Total Project Ongoing</p> --}}
                                </div>
                            </div>
                            <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-3">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fa fa-check-square-o"></i>
                                    </div>
                                    <div class="count">{{ $project_completed }}</div>

                                    <h4>Project Completed</h4>
                                    {{-- <p>Total Project Completed</p> --}}
                                </div>
                            </div>
                            <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-3">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fa fa-user-plus"></i>
                                    </div>
                                    <div class="count">{{ $new_tiktok_follower }}</div>

                                    <h4>New Tiktok Follower</h4>
                                    {{-- <p>Total New Tiktok Follower</p> --}}
                                </div>
                            </div>
                            <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-3">
                                <div class="tile-stats">
                                    <div class="icon"><i class="fa fa-instagram"></i>
                                    </div>
                                    <div class="count">{{ $new_ig_follower }}</div>

                                    <h4>New Instagram Follower</h4>
                                    {{-- <p>Total New Instagram Follower</p> --}}
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