@extends('layouts.app')

@section('title', 'Campaigns')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush


@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Discount</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Discounts</a></div>
                    <div class="breadcrumb-item">Transaction Discount</div>
                </div>
            </div>

            <div class="section-body">
                @include('layouts.alert')

                <h2 class="section-title">All Transaction Discount</h2>
                <p class="section-lead">
                    You can manage all transaction discount, such as editing, deleting and more.
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card mb-0">
                            <div class="card-body">
                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a class="nav-link {{ $status == 'all' ? 'active' : '' }}"
                                            href="{{ route('transaction-discount.index', ['status' => 'all']) }}">
                                            All <span class="badge badge-white">{{ $countAll }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $status == 'active' ? 'active' : '' }}"
                                            href="{{ route('transaction-discount.index', ['status' => 'active']) }}">
                                            Active <span class="badge badge-primary">{{ $countActive }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $status == 'unactive' ? 'active' : '' }}"
                                            href="{{ route('transaction-discount.index', ['status' => 'unactive']) }}">
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
                                        <form method="GET" action="{{ route('transaction-discount.index') }}">
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
                                        <a href="{{ route('transaction-discount.create') }}"><button
                                                class="btn btn-primary"><i class="fas fa-plus"></i> Add New</button></a>
                                    </div>
                                </div>
                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>Title</th>
                                            <th>Discount</th>
                                            <th>Minimum Transaction</th>
                                            <th>Expired</th>
                                            <th>Status</th>
                                        </tr>
                                        @foreach ($discounts as $discount)
                                            <tr>
                                                <td><strong>{{ $discount->name }}</strong>
                                                    <div class="">
                                                        <a href="{{ route('transaction-discount.edit', $discount->id) }}"
                                                            data-toggle="tooltip" title="Edit Discount">Edit</a>
                                                        <div class="bullet"></div>

                                                        @php
                                                            // Cek apakah discount telah melewati tanggal expired
                                                            $isExpired = \Carbon\Carbon::now()->greaterThan(
                                                                $discount->end_date,
                                                            );
                                                        @endphp

                                                        @if ($discount->status)
                                                            <a href="{{ route('transaction-discount.toggleStatus', $discount->id) }}"
                                                                class="text-danger" data-toggle="tooltip"
                                                                title="Update Status Discount">InActive</a>
                                                        @else
                                                            <!-- Jika tidak aktif dan belum expired, tampilkan opsi Active -->
                                                            @if (!$isExpired)
                                                                <a href="{{ route('transaction-discount.toggleStatus', $discount->id) }}"
                                                                    class="text-success" data-toggle="tooltip"
                                                                    title="Update Status Discount">Active</a>
                                                            @else
                                                                <!-- Jika expired, tampilkan teks tanpa tautan -->
                                                                <span class="text-muted">Active</span>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="">
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
                                                <td>
                                                    <div class=""><strong>Rp.
                                                            {{ number_format($discount->minimum_transaction, 0, ',', '.') }}</strong>
                                                    </div>
                                                </td>
                                                @if (!$isExpired)
                                                    <td>{{ $discount->end_date }}</td>
                                                @else
                                                    <td class="text-danger">{{ $discount->end_date }}</td>
                                                @endif
                                                <td>
                                                    @if ($discount->status)
                                                        <div class="badge badge-primary">Active</div>
                                                    @else
                                                        <div class="badge badge-danger">Inactive</div>
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
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
