@can('View Marketing Pegawai Dashboard')
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h4>Dashboard Staff Marketing</h4>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-3">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-caret-square-o-right"></i>
                                </div>
                                <div class="count">{{ $turlap }}</div>

                                <h4>Turlap</h4>
                                {{-- <p>Total Tiktok Video</p> --}}
                            </div>
                        </div>
                        <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-3">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-plus-square"></i>
                                </div>
                                <div class="count">{{ $leads }}</div>

                                <h4>Leads</h4>
                                {{-- <p>Total Feed Instagram</p> --}}
                            </div>
                        </div>
                        <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-3">
                            <div class="tile-stats">
                                <div class="icon"><i class="fa fa-play-circle"></i>
                                </div>
                                <div class="count">{{ $brand }}</div>

                                <h4>Brand</h4>
                                {{-- <p>Total Story Instagram</p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
@endcan