@extends('layouts.app')

@section('title', 'Campaigns')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <style>
        /* Center modal content */
        .modal-dialog-centered {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Discount</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Discounts</a></div>
                    <div class="breadcrumb-item">Voucher Discount</div>
                </div>
            </div>

            <div class="section-body">
                @include('layouts.alert')

                <h2 class="section-title">All Voucher Discount</h2>
                <p class="section-lead">
                    You can manage all voucher discount, such as editing, deleting and more.
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card mb-0">
                            <div class="card-body">
                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a class="nav-link {{ $status == 'all' ? 'active' : '' }}"
                                            href="{{ route('voucher-discount.index', ['status' => 'all']) }}">
                                            All <span class="badge badge-white">{{ $countAll }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $status == 'active' ? 'active' : '' }}"
                                            href="{{ route('voucher-discount.index', ['status' => 'active']) }}">
                                            Active <span class="badge badge-primary">{{ $countActive }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $status == 'unactive' ? 'active' : '' }}"
                                            href="{{ route('voucher-discount.index', ['status' => 'unactive']) }}">
                                            InActive <span class="badge badge-danger">{{ $countUnactive }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="float-right">
                                        <form method="GET" action="{{ route('voucher-discount.index') }}">
                                            <div class="input-group">
                                                <input type="text" name="name" class="form-control"
                                                    placeholder="Search">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="section-header-button">
                                        <a href="{{ route('voucher-discount.create') }}"><button class="btn btn-primary"><i
                                                    class="fas fa-plus"></i> Add New</button></a>
                                    </div>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>Title</th>
                                            <th>Unique Code</th>
                                            <th>Discount</th>
                                            <th>Minimum Transaction</th>
                                            <th>Expired</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($discounts as $discount)
                                            <tr>
                                                <td><strong>{{ $discount->name }}</strong>
                                                    @php
                                                        $isExpired = \Carbon\Carbon::now()->greaterThan(
                                                            $discount->end_date,
                                                        );
                                                    @endphp
                                                </td>
                                                <td>{{ $discount->unique_code }}</td>
                                                <td>
                                                    @if ($discount->discount <= 100)
                                                        <div class="text-success">
                                                            <strong>{{ $discount->discount }}%</strong>
                                                        </div>
                                                    @else
                                                        <div class="text-warning"><strong>Rp.
                                                                {{ number_format($discount->discount, 0, ',', '.') }}</strong>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td><strong>Rp.
                                                        {{ number_format($discount->minimum_transaction, 0, ',', '.') }}</strong>
                                                </td>
                                                <td class="{{ $isExpired ? 'text-danger' : '' }}">
                                                    {{ $discount->end_date }}</td>
                                                <td>
                                                    <div
                                                        class="badge {{ $discount->status ? 'badge-primary' : 'badge-danger' }}">
                                                        {{ $discount->status ? 'Active' : 'Inactive' }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="{{ route('voucher-discount.edit', $discount->id) }}"
                                                        class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @if ($discount->image)
                                                        <button class="btn btn-sm btn-info" data-toggle="modal"
                                                            data-target="#imageModal"
                                                            onclick="showImage('{{ asset('storage/public/vouchers/' . $discount->image) }}')"
                                                            title="View Voucher Image">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    @else
                                                        <span class="badge badge-danger">No Image</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $discounts->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <!-- Modal for Image Display -->
        <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Voucher Image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img id="modalImage" src="" alt="Voucher Image" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>

    <script>
        function showImage(imageUrl) {
            document.getElementById('modalImage').src = imageUrl;
        }
    </script>
@endpush
