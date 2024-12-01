@extends('layouts.app')

@section('title', 'Orders')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <style>
        .table tbody tr:hover {
            background-color: #f1f1f1; /* Ubah warna background saat hover */
            cursor: pointer; /* Mengubah kursor menjadi pointer */
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Orders</h1>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Orders</a></div>
                    <div class="breadcrumb-item">All Orders</div>
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

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Date</th>
                                                <th>Kasir</th>
                                                <th>Total Price</th>
                                                <th>Total Item</th>
                                                <th class="text-center">Payment Method</th>
                                                {{-- <th class="text-center">Detail Order</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr onclick="window.location='{{ route('order.show', $order->id) }}'"
                                                    style="cursor: pointer;">
                                                    <td>
                                                        <strong>#{{ $order->id }}</strong>
                                                    </td>
                                                    <td>
                                                        {{ \Carbon\Carbon::parse($order->transactionTime)->format('d F Y') }}
                                                    </td>
                                                    <td>
                                                        {{ $order->namaKasir }}
    
                                                    </td>
                                                    <td>
                                                        Rp. {{ number_format($order->totalPrice, '0', ',', '.') }}
                                                    </td>
                                                    <td>
                                                        {{ $order->totalQuantity }}
                                                    </td>
                                                    <td class="text-center">
                                                        <span
                                                            class="
                                                            @if ($order->paymentMethod === 'cash') badge badge-success 
                                                            @else badge badge-primary @endif">
                                                            {{ ucfirst($order->paymentMethod) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $orders->withQueryString()->links() }}
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
