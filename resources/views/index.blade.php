@extends('layouts.management.app')
@section('content')
    <style>
        .tabloid-card-fixed {
            width: 300px;
            min-width: 300px;
            max-width: 300px;
        }
    </style>
    <div class="card">
        <h5 class="card-header">List Tabloid</h5>
        {{-- <div class="row justify-content-end">
            <div class="col-sm-15 ml-4">
                <a href="{{ url('management/banner/create') }}" class="btn btn-sm btn-primary m-3">
                    Add data
                </a>
            </div>
        </div> --}}
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-4 tabloid-card-fixed">
                    <form action="{{ url('/tabloids') }}" method="POST" id="form-common">
                        <button type="submit" class="text-decoration-none btn p-0 w-100 h-100"
                            style="background: none; border: none;">
                            <div class="card h-100 shadow-sm d-flex align-items-center justify-content-center"
                                style="min-height: 400px;">
                                <div class="text-center">
                                    <div class="mb-3">
                                        <span class="display-4 text-primary">
                                            <i class="fas fa-plus-circle"></i>
                                        </span>
                                    </div>
                                    <h6 class="card-title mb-0 text-primary">Buat Baru Tabloid</h6>
                                </div>
                            </div>
                        </button>
                    </form>
                </div>
                @foreach ($tabloids as $tabloid)
                    <div class="col-md-3 mb-4">
                        <div class="card h-100 shadow-sm">
                            {{-- <img src="{{ asset('storage/' . $tabloid->cover_image) }}" class="card-img-top" alt="{{ $tabloid->title }}" style="height: 250px; object-fit: cover;"> --}}
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title">{{ $tabloid->title }}</h6>
                                <p class="card-text text-muted mb-2" style="font-size: 0.9rem;">
                                    {{ Str::limit($tabloid->description, 60) }}</p>
                                <a href="{{ route('tabloid.edit', $tabloid->id) }}"
                                    class="btn btn-sm btn-primary mt-auto">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endsection
