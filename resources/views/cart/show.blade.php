@extends('layouts.app')

@push('scripts')
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <script>
        $('form#updateCart input[type=number]').on('change', function() {
            $(this).closest('form').submit();
        });
    </script>
@endpush

@push('styles')
    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            opacity: 1;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card-body">
                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                        {{ \Illuminate\Support\Facades\Session::forget('message')  }}
                    @endif
                    @if ($errors)
                        @foreach($errors as $error)
                            <div class="alert alert-warning" role="alert">
                                <p>{{ $error }}</p>
                            </div>
                        @endforeach
                    @endif
                    @include('partials/cart')

                    <div class="com-md-12 mt-1">
                        <a href="{{ route('checkout.show') }}" class="btn btn-success btn-block">
                            Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
