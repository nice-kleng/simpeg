<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
            {{-- @role('Super Admin')
            <li><a href="{{ route('superadmin.dashboard') }}"><i class="fa fa-home"></i> Home </a></li>
            @endrole --}}

            {{-- @role('Content Creator')
            <li><a href="{{ route('sosmed.dashboard') }}"><i class="fa fa-home"></i> Home </a></li>
            @endrole --}}

            <li><a href="{{ route('dashboard') }}"><i class="fa fa-home"></i> Home </a></li>
            <li><a><i class="fa fa-table"></i> Data Master <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                  <li><a href="{{ route('jabatan.index') }}">Jabatan</a></li>
                  <li><a href="{{ route('pegawai.index') }}">Pegawai</a></li>
                  <li><a href="{{ route('product.index') }}">Product</a></li>
                  <li><a href="{{ route('mitra.index') }}">Mitra</a></li>
                </ul>
            </li>

            <li><a><i class="fa fa-share-alt"></i> Sosmed <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                  <li><a href="{{ route('timelineInstagram.index') }}">Timeline Instagram</a></li>
                  <li><a href="{{ route('timelineTikTok.index') }}">Timeline TikTok</a></li>
                  {{-- <li><a href="{{ route('reportTikTok.index') }}">Report TikTok Konten</a></li> --}}
                  <li><a href="{{ route('reportTikTokLive.index') }}">Report TikTok Live</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>