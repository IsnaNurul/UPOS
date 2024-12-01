@extends('layouts.app')

@section('title', 'Add Kasir')

@push('style')
    <style>
        .pin-input {
            width: 50px;
            text-align: center;
            font-size: 1.5rem;
            border: 2px solid #007bff;
            border-radius: 5px;
        }
        .pin-input:focus {
            border-color: #0056b3;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
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
            <h1>Add Kasir</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <form action="{{ route('kasir.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>PIN POS</label>
                                    <div class="d-flex">
                                        <input type="text" class="form-control pin-input @error('pin') is-invalid @enderror" name="pin[]" maxlength="1" pattern="\d" required>
                                        <input type="text" class="form-control pin-input @error('pin') is-invalid @enderror" name="pin[]" maxlength="1" pattern="\d" required>
                                        <input type="text" class="form-control pin-input @error('pin') is-invalid @enderror" name="pin[]" maxlength="1" pattern="\d" required>
                                        <input type="text" class="form-control pin-input @error('pin') is-invalid @enderror" name="pin[]" maxlength="1" pattern="\d" required>
                                    </div>
                                    @error('pin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Branch</label>
                                    <div id="branch-selection">
                                        @foreach($branches as $branch)
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input branch-checkbox" id="branch{{ $branch->id }}" name="branch_id" value="{{ $branch->id }}">
                                                <label class="form-check-label" for="branch{{ $branch->id }}">{{ $branch->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('branch_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">Submit</button>
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
        document.addEventListener('DOMContentLoaded', function () {
            const pinInputs = document.querySelectorAll('.pin-input');

            pinInputs.forEach((input, index) => {
                input.addEventListener('input', function () {
                    if (input.value.length === 1 && index < pinInputs.length - 1) {
                        pinInputs[index + 1].focus();
                    }
                });

                input.addEventListener('keydown', function (e) {
                    if (e.key === 'Backspace' && index > 0 && input.value === '') {
                        pinInputs[index - 1].focus();
                    }
                });
            });

            // Ensure only one branch checkbox is selected at a time
            const branchCheckboxes = document.querySelectorAll('.branch-checkbox');
            branchCheckboxes.forEach((checkbox) => {
                checkbox.addEventListener('change', function () {
                    if (this.checked) {
                        branchCheckboxes.forEach((cb) => {
                            if (cb !== this) cb.checked = false;
                        });
                    }
                });
            });
        });
    </script>
@endpush
