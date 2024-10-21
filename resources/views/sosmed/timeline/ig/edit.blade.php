@extends('layouts.app', ['pageTitle' => 'Edit Timeline Instagram'])

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
@if($errors->any())
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
                <h2>Edit Timeline Instagram</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form method="POST" action="{{ route('timelineInstagram.update', $timelineInstagram->kd_timelineig) }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $timelineInstagram->tanggal }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jenis_project">Jenis Project</label>
                                <select name="jenis_project" id="jenis_project" class="form-control select2">
                                    <option value="">--Pilih Jenis Project--</option>
                                    <option value="FEED" {{ (old('jenis_project', $timelineInstagram->jenis_project)=='FEED' ) ? 'selected' : '' }}>FEED</option>
                                    <option value="STORY" {{ (old('jenis_project', $timelineInstagram->jenis_project)=='STORY' ) ? 'selected' : '' }}>STORY</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control select2">
                                    <option value="">--Pilih Status--</option>
                                    <option value="On Going" {{ (old('status', $timelineInstagram->status)=='On Going' ) ? 'selected' : '' }}>On Going</option>
                                    <option value="Desain" {{ (old('status', $timelineInstagram->status)=='Desain' ) ? 'selected' : '' }}>Desain</option>
                                    <option value="Editing Revisi" {{ (old('status', $timelineInstagram->status)=='Editing Revisi' ) ? 'selected' : '' }}>Editing Revisi</option>
                                    <option value="Approve" {{ (old('status', $timelineInstagram->status)=='Approve' ) ? 'selected' : '' }}>Approve</option>
                                    <option value="Upload" {{ (old('status', $timelineInstagram->status)=='Upload' ) ? 'selected' : '' }}>Upload</option>
                                    <option value="Syuting Done" {{ (old('status', $timelineInstagram->status)=='Syuting Done' ) ? 'selected' : '' }}>Syuting Done</option>
                                    <option value="Storyboard" {{ (old('status', $timelineInstagram->status)=='Storyboard' ) ? 'selected' : '' }}>Storyboard</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="format">Format</label>
                                <select name="format" id="format" class="form-control select2">
                                    <option value="Single Image" {{ (old('format', $timelineInstagram->format)=='Single Image' ) ? 'selected' : '' }}>Single Image</option>
                                    <option value="Carrousel" {{ (old('format', $timelineInstagram->format)=='Carrousel' ) ? 'selected' : '' }}>Carrousel</option>
                                    <option value="Reels" {{ (old('format', $timelineInstagram->format)=='Reels' ) ? 'selected' : '' }}>Reels</option>
                                    <option value="Video" {{ (old('format', $timelineInstagram->format)=='Video' ) ? 'selected' : '' }}>Video</option>
                                    <option value="Video & Image" {{ (old('format', $timelineInstagram->format)=='Video & Image' ) ? 'selected' : '' }}>Video & Image</option>
                                    <option value="Motion Graphic" {{ (old('format', $timelineInstagram->format)=='Motion Graphic' ) ? 'selected' : '' }}>Motion Graphic</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jenis_konten">Jenis Konten</label>
                                <select name="jenis_konten" id="jenis_konten" class="form-control select2">
                                    <option value="">--Pilih Jenis Konten--</option>
                                    <option value="Educate" {{ (old('jenis_konten', $timelineInstagram->jenis_konten)=='Educate' ) ? 'selected' : '' }}>Educate</option>
                                    <option value="Inspire" {{ (old('jenis_konten', $timelineInstagram->jenis_konten)=='Inspire' ) ? 'selected' : '' }}>Inspire</option>
                                    <option value="Entertain" {{ (old('jenis_konten', $timelineInstagram->jenis_konten)=='Entertain' ) ? 'selected' : '' }}>Entertain</option>
                                    <option value="Convience" {{ (old('jenis_konten', $timelineInstagram->jenis_konten)=='Convience' ) ? 'selected' : '' }}>Convience</option>
                                    <option value="Testimonial" {{ (old('jenis_konten', $timelineInstagram->jenis_konten)=='Testimonial' ) ? 'selected' : '' }}>Testimonial</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="produk">Produk</label>
                                <select name="produk" id="produk" class="form-control select2">
                                    <option value="">--Pilih Produk--</option>
                                    @foreach ($products as $product)
                                    <option value="{{ $product->nama_product }}" {{ (old('produk', $timelineInstagram->produk) == $product->nama_product) ? 'selected' : '' }}>{{ $product->nama_product }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="head_term">Head Term</label>
                                <input type="text" class="form-control" id="head_term" name="head_term" value="{{ old('head_term', $timelineInstagram->head_term) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="core_topic">Core Topic</label>
                                <input type="text" class="form-control" id="core_topic" name="core_topic" value="{{ old('core_topic', $timelineInstagram->core_topic) }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="subtopic">Subtopic</label>
                                <input type="text" class="form-control" id="subtopic" name="subtopic" value="{{ old('subtopic', $timelineInstagram->subtopic) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="copywriting">Copywriting</label>
                                <input type="text" class="form-control" id="copywriting" name="copywriting" value="{{ old('copywriting', $timelineInstagram->copywriting) }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="notes">Notes</label>
                                <input type="text" class="form-control" id="notes" name="notes" value="{{ old('notes', $timelineInstagram->notes) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="refrensi">Refrensi</label>
                                <input type="text" class="form-control" id="refrensi" name="refrensi" value="{{ old('refrensi', $timelineInstagram->refrensi) }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pics">Pics</label>
                                <select name="pics[]" id="pics" class="form-control select2" multiple>
                                    @foreach ($pics as $pic)
                                    <option value="{{ $pic->id }}" {{ in_array($pic->id, old('pics', $timelineInstagram->pics->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $pic->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" style="margin-top: 25px;">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('timelineInstagram.index') }}" class="btn btn-secondary">Batal</a>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            allowClear: true,
        });
    });
</script>
@endpush
