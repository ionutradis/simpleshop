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
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @include('partials/cart')
                    <form method="POST" action="{{ route('checkout.confirm') }}">
                        @csrf
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <h5><span class="glyphicon glyphicon-user"></span> Billing & shipping address</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="firstname">Firstname</label>
                                            <input type="text" class="form-control" name="firstname" id="firstname" value="{{ old('firstname') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="lastname">Lastname</label>
                                            <input type="text" class="form-control" name="lastname" id="lastname" value="{{ old('lastname') }}">
                                        </div>
                                    </div>
                                </div><!-- /.row -->
                                <div class="row">
                                    <div class="col-sm-6 col-sm-4">
                                        <div class="form-group">
                                            <label for="street">Street</label>
                                            <input type="text" class="form-control" name="street" id="street" value="{{ old('street') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label for="streetnr">Number</label>
                                            <input type="text" class="form-control" name="street_number" id="streetnr" value="{{ old('street_number') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label for="zip">Postcode</label>
                                            <input type="text" class="form-control" name="postcode" id="postcode" value="{{ old('postcode') }}">
                                        </div>
                                    </div>
                                </div>
                                <!-- /.row -->

                                <div class="row">

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="country_code">Country</label>
                                            <select name="country_code" class="form-control" id="country">
                                                <option value="romania" @if(old('country') === 'romania') selected @endif>Romania</option>
                                                <option value="netherlands" @if(old('country') === 'netherlands') selected @endif>Netherlands</option>
                                                <option value="uk" @if(old('country') === 'uk') selected @endif>United Kingdom</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="telephone">Telephone</label>
                                            <input type="text" class="form-control" name="telephone" id="telephone" value="{{ old('telephone') }}">
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="voucher">Voucher code</label>
                                            <input type="text" class="form-control" id="voucher" name="voucher" value="{{ old('voucher') }}">
                                        </div>
                                        <div class="form-group">
                                            <p><b>Your coupons</b></p>
                                            @foreach($coupons as $coupon)
                                                {{ $coupon->name }} - <i style="color: green; font-weight: bolder;">{{ $coupon->code }}</i>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="com-md-12 mt-1">
                            <button type="submit" class="btn btn-success btn-block">
                                Place Order
                            </button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
@endsection
