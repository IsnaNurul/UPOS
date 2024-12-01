@extends('layouts.app')

@section('title', 'Product Create')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-back">
                    <a href="{{ route('discount-product.index') }}"
                        class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                </div>
                <h1>Add Discount</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('product.index') }}">Discount</a></div>
                    <div class="breadcrumb-item">Create</div>
                </div>
            </div>

            <div class="section-body">

                <div class="card">
                    <form action="{{ route('discount-product.store') }}" method="POST">
                        @csrf

                        <div class="card-body">
                            <div class="form-group ">
                                <label>Product</label>
                                <select class="form-control selectric @error('product_id') is-invalid @enderror"
                                    name="product_id">
                                    <option value="">Select Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Discount Type</label>
                                <select class="form-control" id="discountType" name="discount_type">
                                    <option value="fixed">Fixed Number</option>
                                    <option value="percentage">Percentage</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label id="discountLabel">Discount (Fixed)</label>
                                <input type="number" class="form-control @error('discount') is-invalid @enderror"
                                    id="discountValue" name="discount" placeholder="Enter discount value">
                                @error('discount')
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
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('discountType').addEventListener('change', function() {
            var discountType = this.value;
            var discountLabel = document.getElementById('discountLabel');
            var discountValue = document.getElementById('discountValue');

            if (discountType === 'percentage') {
                discountLabel.textContent = 'Discount (%)';
                discountValue.placeholder = 'Enter discount in percentage';
            } else {
                discountLabel.textContent = 'Discount (Fixed)';
                discountValue.placeholder = 'Enter discount in fixed value';
            }
        });
    </script>
@endpush
