@extends('layouts.app')

@push('styles')
    <style>
        .card-img-overlay {
            z-index: -1;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Catalog') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="container">
                            <div class="row">
                            @foreach($products as $product)
                                <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                                <div class="card">
                                    <img class="card-img" src="{{ $product->image }}" style="max-height: 289px;" alt="Vans">
                                    <div class="card-img-overlay d-flex justify-content-end">
                                        <a href="#" class="card-link text-danger like">
                                            <i class="fas fa-heart"></i>
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title">{{$product->name}}</h4>
                                        <p class="card-text"></p>
                                        <div class="buy d-flex justify-content-between align-items-center">
                                            <div class="price text-success"><h5 class="mt-4">${{$product->price}}</h5></div>
                                            <form method="POST" action="{{ route('cartAdd', $product) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-danger mt-3"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
