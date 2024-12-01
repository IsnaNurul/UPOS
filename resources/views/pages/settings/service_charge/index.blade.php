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
                    <div class="breadcrumb-item">Tax</div>
                </div>
            </div>

            @include('layouts.alert')

            <div class="section-body">
                <div id="output-status"></div>
                <div class="row d-flex justify-content-center">
                    <div class="col-md-6">
                        <form action="{{ route('service-charge.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf <!-- Jangan lupa tambahkan CSRF token -->
                            <div class="card" id="settings-card">
                                <div class="card-header">
                                    <h4>Service Charge</h4>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label for="header-text"
                                        class="form-control-label col-sm-2 text-md-right">Value(%)</label>
                                    <div class="col-sm-7 col-md-10">
                                        <input type="number" name="value"
                                            value="{{ old('value', $service_charge->value ?? '') }}" class="form-control"
                                            id="header-text">
                                        @error('service_charge')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="card-footer bg-whitesmoke text-md-right">
                                    <button class="btn btn-primary" id="save-btn">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
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
