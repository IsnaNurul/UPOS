@extends('layouts.app')

@section('title', 'Edit Product')

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
                    <a href="{{ route('product.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                </div>
                <h1>Edit Product</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('product.index') }}">Product</a></div>
                    <div class="breadcrumb-item">Edit</div>
                </div>
            </div>

            <div class="section-body">
                <div class="col col-md-6">
                    <div class="card">
                        <form action="{{ route('product.update', $product) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <div class="row">
                                    <!-- Name Input -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Product Name</label>
                                            <input autofocus type="text" id="name"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{ old('name', $product->name) }}">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Category Selection -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category-select">Category</label>
                                            <select id="category-select"
                                                class="form-control select2 @error('category_id') is-invalid @enderror"
                                                name="category_id">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <button type="button" class="btn btn-link p-0 mt-1" data-toggle="modal"
                                                data-target="#addCategoryModal">+ Add New Category</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Price Input -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="price">Price</label>
                                            <input type="number" id="price"
                                                class="form-control @error('price') is-invalid @enderror" name="price"
                                                value="{{ old('price', $product->price) }}">
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Stock Input -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="stock">Stock</label>
                                            <input type="number" id="stock"
                                                class="form-control @error('stock') is-invalid @enderror" name="stock"
                                                value="{{ old('stock', $product->stock) }}">
                                            @error('stock')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Photo Product Input -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="image">Photo Product</label>
                                            <input type="file" id="image"
                                                class="form-control @error('image') is-invalid @enderror" name="image"
                                                accept="image/*" onchange="previewImage(event)">

                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Image Preview Section (Side-by-Side) -->
                                <div class="col-md-4">
                                    <div id="image-preview-container" class="p-3" style="border: 1px solid #ddd;">
                                        <img id="image-preview" src="{{ asset('storage/public\products/' . $product->image) }}"
                                            alt="Product Image" class="img-fluid" style="width: 100%; max-width: 200px;">
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- Modal for Adding New Category -->
        <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="addCategoryForm">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="newCategoryName">Category Name</label>
                                <input type="text" class="form-control" id="newCategoryName" name="newCategoryName"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="saveCategoryButton">Save
                                Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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

        function previewImage(event) {
            const imagePreview = document.getElementById('image-preview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                }

                reader.readAsDataURL(file);
            }
        }

        $(document).ready(function() {
            // Initialize Select2 for category selection
            $('#category-select').select2();

            // Handle new category save
            $('#saveCategoryButton').click(function() {
                const newCategoryName = $('#newCategoryName').val();
                if (newCategoryName) {
                    $.ajax({
                        url: "{{ route('categories.store') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            name: newCategoryName
                        },
                        success: function(response) {
                            $('#addCategoryModal').modal('hide');
                            $('#addCategoryForm')[0].reset();
                            const newOption = new Option(response.name, response.id, true,
                                true);
                            $('#category-select').append(newOption).trigger('change');
                        },
                        error: function(error) {
                            if (error.status === 422) {
                                alert(
                                    "This category name already exists. Please choose a different name."
                                );
                            } else {
                                alert("There was an error adding the category.");
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush
