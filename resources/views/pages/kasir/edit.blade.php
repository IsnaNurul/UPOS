@extends('layouts.app')

@section('title', 'Edit Kasir')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">

    <style>
        .pin-input {
            width: 50px;
            text-align: center;
            font-size: 1.5rem;
            border: 2px solid #007bff; /* Thicker blue border */
            border-radius: 5px;
        }
        .pin-input:focus {
            border-color: #0056b3; /* Darker blue on focus */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Blue shadow on focus */
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-back">
                    <a href="{{ route('kasir.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                </div>
                <h1>Edit Kasir</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Kasir</a></div>
                    <div class="breadcrumb-item">Edit</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col- col-md-6">
                        <div class="card">
                            <form action="{{ route('kasir.update', $kasir) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text"
                                            class="form-control @error('name')
                                        is-invalid
                                    @enderror"
                                            name="name" value="{{ $kasir->name }}" autofocus>
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="number"
                                            class="form-control @error('phone')
                                        is-invalid
                                    @enderror"
                                            name="phone" value="{{ $kasir->phone }}">
                                        @error('phone')
                                            <div class="invalid-feedback">
                                                {{ $phone }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>PIN POS</label>
                                        <div class="d-flex">
                                            @php
                                                // Split the stored PIN into an array of characters
                                                $pinDigits = str_split($kasir->pin ?? '');
                                                
                                            @endphp
                                            <input type="text" class="form-control pin-input @error('pin') is-invalid @enderror" name="pin[]" maxlength="1" pattern="\d" required value="{{ $pinDigits[0] ?? '' }}">
                                            <input type="text" class="form-control pin-input @error('pin') is-invalid @enderror" name="pin[]" maxlength="1" pattern="\d" required value="{{ $pinDigits[1] ?? '' }}">
                                            <input type="text" class="form-control pin-input @error('pin') is-invalid @enderror" name="pin[]" maxlength="1" pattern="\d" required value="{{ $pinDigits[2] ?? '' }}">
                                            <input type="text" class="form-control pin-input @error('pin') is-invalid @enderror" name="pin[]" maxlength="1" pattern="\d" required value="{{ $pinDigits[3] ?? '' }}">
                                        </div>
                                        @error('pin')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>     
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary">Submit</button>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pinInputs = document.querySelectorAll('.pin-input');

            pinInputs.forEach((input, index) => {
                input.addEventListener('input', function() {
                    if (input.value.length === 1 && index < pinInputs.length - 1) {
                        pinInputs[index + 1].focus();
                    }
                });

                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && index > 0 && input.value === '') {
                        pinInputs[index - 1].focus();
                    }
                });
            });
        });
    </script>
@endpush

