@extends('layouts.app')

@section('title', 'Member')

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
                    <div class="breadcrumb-item"><a href="#">Discount</a></div>
                    <div class="breadcrumb-item">Member Discount</div>
                </div>
            </div>
            <div class="section-body">
                @include('layouts.alert')

                <h2 class="section-title">All Member Discount</h2>
                <p class="section-lead">
                    You can manage all member discount, such as editing, deleting and more.
                </p>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="float-right">
                                        <form method="GET" action="{{ route('discount-member.index') }}">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Search"
                                                    name="name">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="section-header-button">
                                        <a href="{{ route('discount-member.create') }}"><button class="btn btn-primary"><i
                                                    class="fas fa-plus"></i> Add New</button></a>
                                    </div>
                                </div>
                                <div class="clearfix mb-3"></div>
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>Tier</th>
                                            <th>Discount</th>
                                            <th class="text-center">Default</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        @foreach ($members as $member)
                                            <tr>
                                                <td>{{ $member->tier }}</td>
                                                <td>
                                                    @if ($member->discount <= 100)
                                                        <div class="text-success"><strong>{{ $member->discount }}%</strong>
                                                        </div>
                                                    @else
                                                        <div class="text-warning"><strong>Rp.
                                                                {{ number_format($member->discount, 0, ',', '.') }}</strong>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($member->set_default)
                                                        <button class="btn btn-sm btn-secondary">Default</button>
                                                    @else
                                                        <a href="{{ route('discount-member.setDefault', $member->id) }}"
                                                            class="btn btn-sm btn-warning">
                                                            Set Default
                                                        </a>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('discount-member.edit', $member->id) }}"
                                                        class="btn btn-sm btn-info btn-icon">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
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
