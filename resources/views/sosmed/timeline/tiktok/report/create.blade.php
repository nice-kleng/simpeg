@extends('layouts.app', ['pageTitle' => 'Report TikTok'])

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
                <h2>Report TikTok {{ $kd_timeline_tiktok }}</h2>
                <a href="{{ route('timelineTikTok.index') }}" class="btn btn-secondary pull-right">Kembali</a>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form id="report-form" action="{{ route('timelineTikTok.reportStore') }}" method="POST">
                    @csrf
                    <div id="wizard" class="form_wizard wizard_horizontal">
                        <ul class="wizard_steps">
                            <li><a href="#step-1"><span class="step_no">1</span><span class="step_descr">Statistik Engagement</span></a></li>
                            <li><a href="#step-2"><span class="step_no">2</span><span class="step_descr">Demografi</span></a></li>
                            <li><a href="#step-3"><span class="step_no">3</span><span class="step_descr">Statistik Lanjutan</span></a></li>
                        </ul>
                        <div id="step-1">
                            <h2 class="StepTitle">Step 1: Statistik Engagement</h2>
                            <div class="form-group">
                                <label for="views">Views</label>
                                <input type="hidden" name="kd_timeline_tiktok" value="{{ $kd_timeline_tiktok }}">
                                <input type="number" class="form-control" id="views" name="views" value="{{ old('views') }}">
                            </div>
                            <div class="form-group">
                                <label for="like">Like</label>
                                <input type="number" class="form-control" id="like" name="like" value="{{ old('like') }}">
                            </div>
                            <div class="form-group">
                                <label for="comment">Comment</label>
                                <input type="number" class="form-control" id="comment" name="comment" value="{{ old('comment') }}">
                            </div>
                            <div class="form-group">
                                <label for="share">Share</label>
                                <input type="number" class="form-control" id="share" name="share" value="{{ old('share') }}">
                            </div>
                            <div class="form-group">
                                <label for="save">Save</label>
                                <input type="number" class="form-control" id="save" name="save" value="{{ old('save') }}">
                            </div>
                        </div>

                        <div id="step-2">
                            <h2 class="StepTitle">Step 4: Demografi</h2>
                            <div class="form-group">
                                <label for="usia_18_24">Usia 18-24</label>
                                <input type="number" class="form-control" id="usia_18_24" name="usia_18_24" value="{{ old('usia_18_24') }}">
                            </div>
                            <div class="form-group">
                                <label for="usia_25_34">Usia 25-34</label>
                                <input type="number" class="form-control" id="usia_25_34" name="usia_25_34" value="{{ old('usia_25_34') }}">
                            </div>
                            <div class="form-group">
                                <label for="usia_35_44">Usia 35-44</label>
                                <input type="number" class="form-control" id="usia_35_44" name="usia_35_44" value="{{ old('usia_35_44') }}">
                            </div>
                            <div class="form-group">
                                <label for="usia_45_54">Usia 45-54</label>
                                <input type="number" class="form-control" id="usia_45_54" name="usia_45_54" value="{{ old('usia_45_54') }}">
                            </div>
                            <div class="form-group">
                                <label for="gender_pria">Gender Pria (%)</label>
                                <input type="number" class="form-control" id="gender_pria" name="gender_pria" value="{{ old('gender_pria') }}">
                            </div>
                            <div class="form-group">
                                <label for="gender_wanita">Gender Wanita (%)</label>
                                <input type="number" class="form-control" id="gender_wanita" name="gender_wanita" value="{{ old('gender_wanita') }}">
                            </div>
                        </div>

                        <div id="step-3">
                            <h2 class="StepTitle">Step 5: Statistik Lanjutan</h2>
                            <div class="form-group">
                                <label for="total_pemutaran">Total Pemutaran</label>
                                <input type="number" class="form-control" id="total_pemutaran" name="total_pemutaran" value="{{ old('total_pemutaran') }}">
                            </div>
                            <div class="form-group">
                                <label for="rata_menonton">Rata-rata Menonton</label>
                                <input type="number" step="0.01" class="form-control" id="rata_menonton" name="rata_menonton" value="{{ old('rata_menonton') }}">
                            </div>
                            <div class="form-group">
                                <label for="view_utuh">View Utuh</label>
                                <input type="number" class="form-control" id="view_utuh" name="view_utuh" value="{{ old('view_utuh') }}">
                            </div>
                            <div class="form-group">
                                <label for="pengikut_baru">Pengikut Baru</label>
                                <input type="number" class="form-control" id="pengikut_baru" name="pengikut_baru" value="{{ old('pengikut_baru') }}">
                            </div>
                            <div class="form-group">
                                <label for="link_konten">Link Konten</label>
                                <input type="url" class="form-control" id="link_konten" name="link_konten" value="{{ old('link_konten') }}">
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
<script>
    $(document).ready(function() {
        $('#wizard').smartWizard();
        $('.select2').select2({
            allowClear: true,
        });
    });
</script>
@endpush