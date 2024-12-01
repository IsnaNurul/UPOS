@extends('layouts.app')

@section('title', 'Receipt Settings')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">

            <div class="section-header">
                <h1>Settings</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Settings</a></div>
                    <div class="breadcrumb-item">Receipt</div>
                </div>
            </div>

            @include('layouts.alert')

            <div class="section-body">
                <div id="output-status"></div>
                <div class="row d-flex justify-content-center">
                    <div class="col-md-8">
                        <form action="{{ route('setting-receipt.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf <!-- Jangan lupa tambahkan CSRF token -->

                            <div class="card" id="settings-card">
                                <div class="card-header">
                                    <h4>Receipt Settings</h4>
                                </div>

                                <div class="card-body">
                                    <div class="form-group row align-items-center">
                                        <label for="bussines-name"
                                            class="form-control-label col-sm-2 text-md-right">Bussines Name</label>
                                        <div class="col-sm-7 col-md-10">
                                            <input type="text" name="business_name"
                                                value="{{ old('business_name', $profile->business_name ?? '') }}"
                                                class="form-control" id="bussines-name">
                                            @error('bussines_name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label for="header-text"
                                            class="form-control-label col-sm-2 text-md-right">Header</label>
                                        <div class="col-sm-7 col-md-10">
                                            <input type="text" name="header_text"
                                                value="{{ old('header_text', $profile->header_text ?? '') }}"
                                                class="form-control" id="header-text">
                                            @error('header_text')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label for="footer-text"
                                            class="form-control-label col-sm-2 text-md-right">Footer</label>
                                        <div class="col-sm-7 col-md-10">
                                            <input type="text" name="footer_text"
                                                value="{{ old('footer_text', $profile->footer_text ?? '') }}"
                                                class="form-control" id="footer-text">
                                            @error('footer_text')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row align-items-center">
                                        <label for="site-logo"
                                            class="form-control-label col-sm-2 text-md-right">Logo</label>
                                        <div class="col-sm-7 col-md-10">
                                            <div class="custom-file">
                                                <input type="file" name="logo" class="custom-file-input"
                                                    id="site-logo">
                                                <label class="custom-file-label" for="site-logo">Choose File</label>
                                            </div>
                                            <div class="form-text text-muted">The image must have a maximum size of 1MB
                                            </div>
                                            @error('site_logo')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    @if (isset($profile->logo))
                                        <div class="form-group row">
                                            <label class="form-control-label col-sm-2 text-md-right">Current Logo</label>
                                            <div class="col-sm-7 col-md-10">
                                                <img src="{{ asset('storage/public\logo/' . $profile->logo) }}" alt="" class="img-thumbnail" width="100">
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="card-footer bg-whitesmoke text-md-right">
                                    <button class="btn btn-primary" id="save-btn">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
