@extends('layouts.app')

@section('title', 'Products')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Manage Product</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Manage Product</a></div>
                    <div class="breadcrumb-item">All Products</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <form method="GET" action="{{ route('manage-product.index') }}" class="form-inline">
                                        <!-- Filter by Name -->
                                        <div class="input-group mr-2">
                                            <input type="text" name="name" class="form-control"
                                                value="{{ request('name') }}" placeholder="Search by name">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    
                                        <!-- Filter by Category -->
                                        <select name="category_id" class="form-control mr-2">
                                            <option value="">All Categories</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    
                                        <!-- Filter by Branch -->
                                        <select name="branch_id" class="form-control mr-2">
                                            <option value="">All Branches</option>
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}"
                                                    {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                                    {{ $branch->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    
                                        <!-- Submit button -->
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </form>
                                    

                                    {{-- <div class="section-header-button">
                                        <a href="{{ route('product.create') }}"><button class="btn btn-primary"><i
                                                    class="fas fa-plus"></i> Add New</button></a>
                                    </div> --}}
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>

                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Stock</th>
                                            <th>Branch</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        @foreach ($products as $product)
                                            <tr>

                                                <td>{{ $product->product->name }}
                                                </td>
                                                <td>
                                                    {{ $product->product->category }}
                                                </td>
                                                <td>{{ 'Rp ' . number_format($product->product->price, 0, ',', '.') }}</td>
                                                <td>
                                                    @if ($product->stock <= 5)
                                                        <span class="text-danger">{{ $product->stock }}</span>
                                                    @else
                                                        {{ $product->stock }}
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $product->branch->name }}
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a href='{{ route('manage-product.request', $product->id) }}'
                                                            class="btn btn-sm btn-info btn-icon">
                                                            Request New Stock
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{-- {{ $products->withQueryString()->links() }} --}}
                                </div>
                            </div>
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
