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
    <style>
        .modal-backdrop {
            z-index: 1040 !important;
        }

        .modal-content {
            z-index: 1050 !important;
        }

        #image-preview {
            max-width: 200px;
            max-height: 200px;
            border: 2px solid #ddd;
            padding: 5px;
            border-radius: 8px;
            display: none;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-back">
                    <a href="{{ route('product.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                </div>
                <h1>Add Product</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('product.index') }}">Product</a></div>
                    <div class="breadcrumb-item">Create</div>
                </div>
            </div>

            <div class="section-body">
                <!-- Card Form -->
                <div class="col col-md-6">
                    <div class="card">
                        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="card-body">
                                <div class="row">
                                    <!-- Name Input -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Product Name</label>
                                            <input autofocus type="text" id="name"
                                                class="form-control @error('name') is-invalid @enderror" name="name">
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
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                                                class="form-control @error('price') is-invalid @enderror" name="price">
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Stock Input -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="stock">Stock</label>
                                            <input type="number" id="stock"
                                                class="form-control @error('stock') is-invalid @enderror" name="stock">
                                            @error('stock')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Unit Input -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="stock">Unit</label>
                                            <select name="unit" class="form-control" id="">
                                                <option value="pcs">pcs</option>
                                                <option value="kg">kg</option>
                                                <option value="g">g</option>
                                            </select>
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
                                                class="form-control @error('image') is-invalid @enderror" name="image">
                                            <div class="mt-2">
                                                <!-- Preview Image -->
                                                <img id="image-preview" src="#" alt="Preview Image" class="img-fluid"
                                                    style="display: none;">
                                            </div>
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Branch Selection -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="branches">Select Branches</label>
                                            <div class="form-check">
                                                @foreach ($branches as $branch)
                                                <input class="form-check-input" type="checkbox" name="branches[]" value="{{ $branch->id }}" id="branch-{{ $branch->id }}">
                                                <label class="form-check-label" for="branch-{{ $branch->id }}">{{ $branch->name }}</label><br>
                                                @endforeach
                                            </div>
                                            @error('branches')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">Submit</button>
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
    <!-- Include Select2 CSS and JS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Event listener untuk input file
            $('#image').change(function(event) {
                var file = event.target.files[0]; // Ambil file yang dipilih
                var reader = new FileReader();

                reader.onload = function(e) {
                    // Setelah file selesai dibaca, tampilkan preview gambar
                    $('#image-preview').attr('src', e.target.result).show();
                };

                if (file) {
                    reader.readAsDataURL(file); // Baca file sebagai URL
                }
            });
        });

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
                            // Close the modal
                            $('#addCategoryModal').modal('hide');
                            // Append the new category to the select input
                            $('#category-select').append(new Option(response.name, response.id)).trigger('change');
                        }
                    });
                }
            });
        });
    </script>
@endpush
