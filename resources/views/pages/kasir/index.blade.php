@extends('layouts.app')

@section('title', 'kasirs')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Kasirs</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Kasirs</a></div>
                    <div class="breadcrumb-item">All kasirs</div>
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
                                    <form method="GET" action="{{ route('kasir.index') }}" class="form-inline">
                                        <!-- Filter by Name -->
                                        <div class="input-group mr-2">
                                            <input type="text" name="name" class="form-control"
                                                value="{{ request('name') }}" placeholder="Search by name">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
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

                                    <div class="section-header-button">
                                        <a href="{{ route('kasir.create') }}"><button class="btn btn-primary"><i
                                                    class="fas fa-plus"></i> Add New</button></a>
                                    </div>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>

                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Branch</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        @foreach ($kasirs as $kasir)
                                            <tr>

                                                <td>{{ $kasir->name }}
                                                </td>
                                                <td>
                                                    {{ $kasir->phone }}
                                                </td>
                                                <td>{{ $kasir->branch->name ?? 'N/A' }}</td> <!-- Display branch name -->
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a href='{{ route('kasir.edit', $kasir->id) }}'
                                                            class="btn btn-sm btn-info btn-icon">
                                                            <i class="fas fa-edit"></i>
                                                            Edit
                                                        </a>

                                                        <form action="{{ route('kasir.destroy', $kasir->id) }}"
                                                            method="POST" class="ml-2">
                                                            <input type="hidden" name="_method" value="DELETE" />
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}" />
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                                <i class="fas fa-times"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach


                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $kasirs->withQueryString()->links() }}
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

    <script>
        $(document).ready(function() {
            $('.selectric').selectric();
        });
    </script>
@endpush
