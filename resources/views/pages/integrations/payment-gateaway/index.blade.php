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
                <h1>Integration</h1>
                <div class="section-header-button">
                    <a href="{{ route('payment-gateaway.create') }}" class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Discounts</a></div>
                    <div class="breadcrumb-item">Voucher Discount</div>
                </div>
            </div>

            <div class="section-body">
                @include('layouts.alert')

                <h2 class="section-title">All Payment Gateaway</h2>
                <p class="section-lead">
                    You can manage all payment gateaway, such as editing, deleting and more.
                </p>
                <div class="row mt-4">
                    @foreach ($payment_gateaway as $item)
                        <div class="col-md-4">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4>{{ $item->payment_gateaway_type->type }}</h4>
                                    <div class="card-header-action">
                                        @if ($item->status == 1)
                                            <button class="btn btn-primary">Active</button>
                                        @else
                                            <button class="btn btn-danger">InActive</button>
                                        @endif
                                        <div class="dropdown">
                                            <a href="#" data-toggle="dropdown"
                                                class="btn btn-warning dropdown-toggle">Options</a>
                                            <div class="dropdown-menu">
                                                <form action="{{ route('payment-gateaway.destroy', $item->id) }}" method="POST"
                                                    class="ml-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="{{ route('payment-gateaway.edit', $item->id) }}"
                                                        class="dropdown-item has-icon"><i class="far fa-edit"></i>
                                                        Edit</a>
                                                    <button class="dropdown-item has-icon text-danger" type="submit"><i
                                                            class="far fa-trash-alt"></i> Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chocolat-parent">
                                        <a href="{{ asset('storage/public\payment_gateaway/' . $item->payment_gateaway_type->image) }}"
                                            class="chocolat-image">
                                            <div data-crop-image="200">
                                                <img alt="image"
                                                    src="{{ asset('storage/public\payment_gateaway/' . $item->payment_gateaway_type->image) }}"
                                                    class="img-fluid">
                                            </div>
                                        </a>
                                        <div class="form-group">
                                            <label for="" class="form-label">API Key :</label>
                                            <p>{{ $item->api_key }}</p>
                                        </div>
                                        <a href="{{ route('payment-gateaway.toggleStatus', $item->id) }}"><button
                                                class="btn btn-primary w-100">Aktivasi</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
