@extends('layouts.app')

@section('title', 'Products')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <style>
        .tab-title {
            font-weight: bold;
            font-size: 0.8rem;
            margin-right: 5px;
        }

        /* Tab Styling */
        .nav-tabs {
            border-bottom: none;
            /* Remove bottom border line from tabs */
            margin-bottom: 15px;
            /* Space between tabs and card */
        }

        .nav-tabs .nav-link {
            display: flex;
            align-items: center;
            gap: 5px;
            border-radius: 5px;
            padding: 8px 15px;
            color: #333;
        }

        .nav-tabs .nav-link.active {
            background-color: #007bff;
            color: #fff !important;
            border-radius: 10px;
        }

        .nav-tabs .badge {
            font-size: 0.9rem;
        }

        .card {
            border-radius: 10px;
        }

        .card-body {
            padding-top: 0;
        }
    </style>
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
                <!-- Tabs Outside of Card -->
                <ul class="nav nav-tabs" id="productTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="request-tab" data-toggle="tab" href="#request" role="tab">
                            <span class="tab-title">Request</span>
                            <span class="badge badge-primary">{{ $productsRequest->count() }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="onDelivery-tab" data-toggle="tab" href="#onDelivery" role="tab">
                            <span class="tab-title">On Delivery</span>
                            <span class="badge badge-warning">{{ $productsOnDelivery->count() }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="done-tab" data-toggle="tab" href="#done" role="tab">
                            <span class="tab-title">Done</span>
                            <span class="badge badge-success">{{ $productsDone->count() }}</span>
                        </a>
                    </li>
                </ul>

                <!-- Card Content with Tabs -->
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content" id="productTabContent">
                            <!-- Request Tab -->
                            <div class="tab-pane fade show active" id="request" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>Tanggal Request</th>
                                            <th>Branch</th>
                                            <th>Product</th>
                                            <th>Stock All</th>
                                            <th>Stock Branch</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        @forelse ($productsRequest as $product)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($product->created_at)->format('d F Y') }}</td>
                                                <td>{{ $product->product_branch->branch->name }}</td>
                                                <td>
                                                    <!-- Display Product Image, Name, and Category in one cell, using Flexbox for horizontal layout -->
                                                    <div class="d-flex align-items-center">
                                                        <!-- Product Image -->
                                                        <img src="{{ asset('storage/public\products/' . $product->product_branch->product->image) }}"
                                                            alt="{{ $product->product_branch->product->name }}"
                                                            class="img-thumbnail"
                                                            style="width: 50px; height: 50px; margin-right: 10px;">

                                                        <!-- Product Name and Category beside the image -->
                                                        <div>
                                                            <div>
                                                                <strong>{{ $product->product_branch->product->name }}</strong>
                                                            </div>
                                                            <div class="text-muted">
                                                                {{ $product->product_branch->product->category }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($product->product_branch->product->stock <= 5)
                                                        <span
                                                            class="text-danger">{{ $product->product_branch->product->stock }}</span>
                                                    @else
                                                        {{ $product->product_branch->product->stock }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($product->last_stock <= 5)
                                                        <span class="text-danger">{{ $product->last_stock }}</span>
                                                    @else
                                                        {{ $product->last_stock }}
                                                    @endif
                                                </td>
                                                <td>{{ ucfirst($product->status) }}</td>
                                                <td class="text-center">
                                                    <!-- Restock Modal Trigger -->
                                                    <button class="btn btn-sm btn-success" data-toggle="modal"
                                                        data-target="#restockModal{{ $product->id }}">
                                                        Restock
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No products found.</td>
                                            </tr>
                                        @endforelse
                                    </table>
                                </div>
                            </div>

                            <!-- On Delivery Tab -->
                            <div class="tab-pane fade" id="onDelivery" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>Branch</th>
                                            <th>Product</th>
                                            <th>Last Stock</th>
                                            <th>Request Stock</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        @forelse ($productsOnDelivery as $product)
                                            <tr>
                                                <td>{{ $product->product_branch->branch->name }}</td>
                                                <td>
                                                    <!-- Display Product Image, Name, and Category in one cell, using Flexbox for horizontal layout -->
                                                    <div class="d-flex align-items-center">
                                                        <!-- Product Image -->
                                                        <img src="{{ asset('storage/public\products/' . $product->product_branch->product->image) }}"
                                                            alt="{{ $product->product_branch->product->name }}"
                                                            class="img-thumbnail"
                                                            style="width: 50px; height: 50px; margin-right: 10px;">

                                                        <!-- Product Name and Category beside the image -->
                                                        <div>
                                                            <div>
                                                                <strong>{{ $product->product_branch->product->name }}</strong>
                                                            </div>
                                                            <div class="text-muted">
                                                                {{ $product->product_branch->product->category }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($product->last_stock <= 5)
                                                        <span class="text-danger">{{ $product->last_stock }}</span>
                                                    @else
                                                        {{ $product->last_stock }}
                                                    @endif
                                                </td>
                                                <td>{{ $product->new_stock }}</td>
                                                <td>{{ ucfirst($product->status) }}</td>
                                                <td class="text-center">
                                                    <!-- Mark as Delivered Button -->
                                                    <a href="{{ route('restock.complete', $product->id) }}"
                                                        class="btn btn-sm btn-warning">
                                                        Mark as Delivered
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No products found.</td>
                                            </tr>
                                        @endforelse
                                    </table>
                                </div>
                            </div>

                            <!-- Done Tab -->
                            <div class="tab-pane fade" id="done" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>Branch</th>
                                            <th>Product</th>
                                            <th>Last Stock</th>
                                            <th>New Stock</th>
                                            <th>Status</th>

                                        </tr>
                                        @forelse ($productsDone as $product)
                                            <tr>
                                                <td>{{ $product->product_branch->branch->name }}</td>
                                                <td>
                                                    <!-- Display Product Image, Name, and Category in one cell, using Flexbox for horizontal layout -->
                                                    <div class="d-flex align-items-center">
                                                        <!-- Product Image -->
                                                        <img src="{{ asset('storage/public\products/' . $product->product_branch->product->image) }}"
                                                            alt="{{ $product->product_branch->product->name }}"
                                                            class="img-thumbnail"
                                                            style="width: 50px; height: 50px; margin-right: 10px;">

                                                        <!-- Product Name and Category beside the image -->
                                                        <div>
                                                            <div>
                                                                <strong>{{ $product->product_branch->product->name }}</strong>
                                                            </div>
                                                            <div class="text-muted">
                                                                {{ $product->product_branch->product->category }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($product->last_stock <= 5)
                                                        <span class="text-danger">{{ $product->last_stock }}</span>
                                                    @else
                                                        {{ $product->last_stock }}
                                                    @endif
                                                </td>
                                                <td>{{ $product->new_stock }}</td>
                                                <td>{{ ucfirst($product->status) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No products found.</td>
                                            </tr>
                                        @endforelse
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal for Updating Stock -->
        @foreach ($productsRequest as $product)
            <div class="modal fade" id="restockModal{{ $product->id }}" tabindex="-1" role="dialog"
                aria-labelledby="restockModalLabel{{ $product->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="restockModalLabel{{ $product->id }}">
                                Update Stock for
                                {{ $product->product_branch->product->name }}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('restock.request', $product->id) }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <!-- Display Current Stock -->
                                <div class="form-group">
                                    <label for="current_stock">Current Stock</label>
                                    <input type="text" id="current_stock" class="form-control"
                                        value="{{ $product->product_branch->product->stock }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="new_stock">Add New Stock</label>
                                    <input type="number" name="new_stock" id="new_stock" class="form-control" required
                                        min="1">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Request
                                    Stock</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
