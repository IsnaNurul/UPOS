@extends('layouts.app')

@section('title', 'Order Detail')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Order Detail</h1>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Orders</a></div>
                    <div class="breadcrumb-item">Order Detail</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <h5>Order #{{ $order->id }}</h5>
                <p><strong>Date : </strong>{{ \Carbon\Carbon::parse($order->transactionTime)->format('d F Y') }}</p>
                <p class="section-lead">
                <div></div>
                <div></div>
                </p>

                <div class="row mt-4">
                    <div class="col col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="text-primary">List Products</h6>
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total Price</th>
                                        </tr>
                                        @php
                                            $subtotal = 0; // Initialize subtotal
                                        @endphp
                                        @foreach ($orderItems as $item)
                                            <tr>
                                                <td>
                                                    <img src="{{ asset('/storage/public/products/' . $item->product->image) }}" alt="{{ $item->product->name }}" style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                                                    {{ $item->product->name }}
                                                </td>
                                                <td>
                                                    Rp. {{ number_format($item->price, 0, ',', '.') }}
                                                </td>
                                                <td>
                                                    {{ $item->quantity }}
                                                </td>
                                                @php
                                                    $total_price = $item->price * $item->quantity;
                                                    $subtotal += $total_price; // Accumulate total price in subtotal
                                                @endphp
                                                <td>
                                                    Rp. {{ number_format($total_price, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <!-- Subtotal Row -->
                                        <tr>
                                            <td colspan="3" class="text-right font-weight-bold">Subtotal:</td>
                                            <td class="font-weight-bold">Rp. {{ number_format($subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h4>Summary</h4>
                                <div class="d-flex justify-content-between">
                                    <p>Subtotal :</p>
                                    <p>Rp. {{ number_format($order->subTotal, '0', ',', '.') }}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p>Tax :</p>
                                    <p>Rp. {{ number_format($order->totalPajak, '0', ',', '.') }}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p>Service Fee :</p>
                                    <p>Rp. {{ number_format($order->serviceFee, '0', ',', '.') }}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p>Discount Member :</p>
                                    <p class="text-danger">- Rp. {{ number_format($order->memberDiscount, '0', ',', '.') }}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p>Voucher :</p>
                                    <p class="text-danger">- Rp. {{ number_format($order->voucherDiscount, '0', ',', '.') }}</p>
                                </div>
                    
                                <!-- Divider line above total -->
                                <hr class="my-3">
                    
                                <!-- Total with larger font size -->
                                <div class="d-flex justify-content-between">
                                    <p class="font-weight-bold" style="font-size: 1.2rem;">Total :</p>
                                    <p class="font-weight-bold" style="font-size: 1.2rem;">Rp. {{ number_format($order->totalPrice) }}</p>
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
