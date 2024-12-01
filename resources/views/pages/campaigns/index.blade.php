@extends('layouts.app')

@section('title', 'Campaigns')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush


@section('main')
    <div class="main-content">
        <section class="section">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="section-header">
                <h1>Campaigns</h1>
                <div class="section-header-button">
                    <a href="{{ route('campaign.create') }}" class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Products</a></div>
                    <div class="breadcrumb-item">All Discount</div>
                </div>
            </div>
            <div class="section-body">
                <h2 class="section-title">Campaigns</h2>
                <p class="section-lead">
                    You can manage all Campaigns, such as editing, deleting and more.
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card mb-0">
                            <div class="card-body">
                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a class="nav-link {{ $status == 'all' ? 'active' : '' }}"
                                            href="{{ route('campaign.index', ['status' => 'all']) }}">
                                            All <span class="badge badge-white">{{ $countAll }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $status == 'active' ? 'active' : '' }}"
                                            href="{{ route('campaign.index', ['status' => 'active']) }}">
                                            Active <span class="badge badge-primary">{{ $countActive }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $status == 'unactive' ? 'active' : '' }}"
                                            href="{{ route('campaign.index', ['status' => 'unactive']) }}">
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
                            <div class="card-header">
                                <h4>All Campaigns</h4>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                    <form>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Discount</th>
                                                <th>Expired</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($campaigns as $campaign)
                                                <tr>
                                                    <td>{{ $campaign->name }}
                                                        <div class="">
                                                            <a href="#">Edit</a>
                                                            <div class="bullet"></div>

                                                            @php
                                                                // Cek apakah campaign telah melewati tanggal expired
                                                                $isExpired = \Carbon\Carbon::now()->greaterThan(
                                                                    $campaign->end_date,
                                                                );
                                                            @endphp

                                                            @if ($campaign->status)
                                                                <a href="{{ route('campaign.toggleStatus', $campaign->id) }}"
                                                                    class="text-danger">InActive</a>
                                                            @else
                                                                <!-- Jika tidak aktif dan belum expired, tampilkan opsi Active -->
                                                                @if (!$isExpired)
                                                                    <a href="{{ route('campaign.toggleStatus', $campaign->id) }}"
                                                                        class="text-success">Active</a>
                                                                @else
                                                                    <!-- Jika expired, tampilkan teks tanpa tautan -->
                                                                    <span class="text-muted">Active</span>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if ($campaign->discount < 100)
                                                            {{ $campaign->discount }}%
                                                        @else
                                                            Rp. {{ number_format($campaign->discount, 0, ',', '.') }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $campaign->end_date }}</td>
                                                    <td>
                                                        @if ($campaign->status)
                                                            <div class="badge badge-primary">Active</div>
                                                        @else
                                                            <div class="badge badge-danger">Inactive</div>
                                                        @endif
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="float-right">
                                    <nav>
                                        <ul class="pagination">
                                            <li class="page-item disabled">
                                                <a class="page-link" href="#" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                            </li>
                                            <li class="page-item active">
                                                <a class="page-link" href="#">1</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">2</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">3</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
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
