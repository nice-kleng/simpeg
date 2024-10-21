@extends('layouts.app', ['pageTitle' => 'Edit Report Timeline Instagram'])


@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Edit Report Timeline Instagram</h2>
                <a href="{{ route('timelineInstagram.index') }}" class="btn btn-secondary pull-right">Kembali</a>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form id="report-form" action="{{ route('timelineInstagram.updateReport', $timelineInstagram) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div id="wizard" class="form_wizard wizard_horizontal">
                        <ul class="wizard_steps">
                            <li><a href="#step-1"><span class="step_no">1</span><span class="step_descr">Basic Info</span></a></li>
                            <li><a href="#step-2"><span class="step_no">2</span><span class="step_descr">Engagement</span></a></li>
                            <li><a href="#step-3"><span class="step_no">3</span><span class="step_descr">Audience</span></a></li>
                            <li><a href="#step-4"><span class="step_no">4</span><span class="step_descr">Discovery</span></a></li>
                            <li><a href="#step-5"><span class="step_no">5</span><span class="step_descr">Video & Link</span></a></li>
                        </ul>
                        
                        <div id="step-1">
                            <h2 class="StepTitle">Step 1: Basic Information</h2>
                            <div class="form-group">
                                <label for="jangkauan">Jangkauan</label>
                                <input type="hidden" name="timeline_instagram_kd" value="{{ $timelineInstagram }}">
                                <input type="text" class="form-control" id="jangkauan" name="jangkauan" value="{{ old('jangkauan', $report->jangkauan) }}">
                            </div>
                            <div class="form-group">
                                <label for="interaksi">Interaksi</label>
                                <input type="text" class="form-control" id="interaksi" name="interaksi" value="{{ old('interaksi', $report->interaksi) }}">
                            </div>
                            <div class="form-group">
                                <label for="aktivitas">Aktivitas</label>
                                <input type="text" class="form-control" id="aktivitas" name="aktivitas" value="{{ old('aktivitas', $report->aktivitas) }}">
                            </div>
                        </div>
                        
                        <div id="step-2">
                            <h2 class="StepTitle">Step 2: Engagement Metrics</h2>
                            <div class="form-group">
                                <label for="impresi">Impresi</label>
                                <input type="text" class="form-control" id="impresi" name="impresi" value="{{ old('impresi', $report->impresi) }}">
                            </div>
                            <div class="form-group">
                                <label for="like">Like</label>
                                <input type="number" class="form-control" id="like" name="like" value="{{ old('like', $report->like) }}">
                            </div>
                            <div class="form-group">
                                <label for="comment">Comment</label>
                                <input type="number" class="form-control" id="comment" name="comment" value="{{ old('comment', $report->comment) }}">
                            </div>
                            <div class="form-group">
                                <label for="share">Share</label>
                                <input type="number" class="form-control" id="share" name="share" value="{{ old('share', $report->share) }}">
                            </div>
                            <div class="form-group">
                                <label for="save">Save</label>
                                <input type="number" class="form-control" id="save" name="save" value="{{ old('save', $report->save) }}">
                            </div>
                        </div>

                        <div id="step-3">
                            <h2 class="StepTitle">Step 3: Audience Information</h2>
                            <div class="form-group">
                                <label for="pengikut">Pengikut</label>
                                <input type="number" class="form-control" id="pengikut" name="pengikut" value="{{ old('pengikut', $report->pengikut) }}">
                            </div>
                            <div class="form-group">
                                <label for="bukan_pengikut">Bukan Pengikut</label>
                                <input type="number" class="form-control" id="bukan_pengikut" name="bukan_pengikut" value="{{ old('bukan_pengikut', $report->bukan_pengikut) }}">
                            </div>
                            {{-- <div class="form-group">
                                <label for="pengikut_baru">Pengikut Baru</label>
                                <input type="number" class="form-control" id="pengikut_baru" name="pengikut_baru" value="{{ old('pengikut_baru', $report->pengikut_baru) }}">
                            </div> --}}
                        </div>

                        <div id="step-4">
                            <h2 class="StepTitle">Step 4: Content Discovery</h2>
                            <div class="form-group">
                                <label for="profile">Profile</label>
                                <input type="text" class="form-control" id="profile" name="profile" value="{{ old('profile', $report->profile) }}">
                            </div>
                            <div class="form-group">
                                <label for="beranda">Beranda</label>
                                <input type="text" class="form-control" id="beranda" name="beranda" value="{{ old('beranda', $report->beranda) }}">
                            </div>
                            <div class="form-group">
                                <label for="jelajahi">Jelajahi</label>
                                <input type="text" class="form-control" id="jelajahi" name="jelajahi" value="{{ old('jelajahi', $report->jelajahi) }}">
                            </div>
                            <div class="form-group">
                                <label for="lainnya">Lainnya</label>
                                <input type="text" class="form-control" id="lainnya" name="lainnya" value="{{ old('lainnya', $report->lainnya) }}">
                            </div>
                            <div class="form-group">
                                <label for="tagar">Tagar</label>
                                <input type="text" class="form-control" id="tagar" name="tagar" value="{{ old('tagar', $report->tagar) }}">
                            </div>
                        </div>

                        <div id="step-5">
                            <h2 class="StepTitle">Step 5: Video Metrics and Content Link</h2>
                            <div class="form-group">
                                <label for="jumlah_pemutaran">Jumlah Pemutaran</label>
                                <input type="text" class="form-control" id="jumlah_pemutaran" name="jumlah_pemutaran" value="{{ old('jumlah_pemutaran', $report->jumlah_pemutaran) }}">
                            </div>
                            <div class="form-group">
                                <label for="waktu_tonton">Waktu Tonton</label>
                                <input type="text" class="form-control" id="waktu_tonton" name="waktu_tonton" value="{{ old('waktu_tonton', $report->waktu_tonton) }}">
                            </div>
                            <div class="form-group">
                                <label for="rata">Rata-rata</label>
                                <input type="text" class="form-control" id="rata" name="rata" value="{{ old('rata', $report->rata) }}">
                            </div>
                            <div class="form-group">
                                <label for="link_konten">Link Konten</label>
                                <input type="url" class="form-control" id="link_konten" name="link_konten" value="{{ old('link_konten', $report->link_konten) }}">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js') }}"></script>

@endpush