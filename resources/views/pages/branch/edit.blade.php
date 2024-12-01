@extends('layouts.app')

@section('title', 'Edit Branch')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-back">
                    <a href="{{ route('branch.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                </div>
                <h1>Edit Branch</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col col-md-6 col-lg-6">
                        <div class="card">
                            <form action="{{ route('branch.update', $branch->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Branch Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $branch->name) }}" autofocus>
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>PIC</label>
                                        <input type="text" class="form-control @error('pic') is-invalid @enderror" name="pic" value="{{ old('pic', $branch->pic) }}">
                                        @error('pic')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $branch->phone) }}">
                                        @error('phone')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" rows="5">{{ old('alamat', $branch->alamat) }}</textarea>
                                        @error('alamat')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
