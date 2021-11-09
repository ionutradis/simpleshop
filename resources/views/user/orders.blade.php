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
                <div class="card">
                    <div class="card-header">{{ __('My Orders') }}</div>

                    <div class="card-body">
                        @if (session('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                            {{ \Illuminate\Support\Facades\Session::forget('message')  }}
                        @endif

                            <div class="col-md-12">
                                <div class="table-responsive">


                                    <table id="mytable" class="table table-bordred table-striped">

                                        <thead>

                                        <th><input type="checkbox" id="checkall" /></th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Address</th>
                                        <th>Total</th>
                                        <th>Edit</th>

                                        <th>Delete</th>
                                        </thead>
                                        <tbody>

                                            @forelse($orders as $order)
                                                <tr>
                                                    <td><input type="checkbox" class="checkthis" /></td>
                                                    <td>{{ $order->firstname }}</td>
                                                    <td>{{ $order->lastname }}</td>
                                                    <td>{{ $order->street }} {{ $order->street_nr }}</td>
                                                    <td>${{ $order->total }}</td>
                                                    <td><p data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit" ><span class="glyphicon glyphicon-pencil"></span></button></p></td>
                                                    <td><p data-placement="top" data-toggle="tooltip" title="Delete"><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete" ><span class="glyphicon glyphicon-trash"></span></button></p></td>
                                                </tr>
                                            @empty
                                                <div class="alert alert-warning" role="alert">
                                                    No items in your cart
                                                </div>
                                            @endforelse
                                        </tbody>

                                    </table>

                                    <div class="clearfix"></div>
                                    {{ $orders->links() }}

                                </div>

                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
