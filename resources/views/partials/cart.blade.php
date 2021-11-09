<div class="panel panel-info mb-0">
    <div class="panel-heading">
        <div class="panel-title">
            <div class="row">
                <div class="col-xs-6">
                    <h5><span class="glyphicon glyphicon-shopping-cart"></span> Shopping Cart</h5>
                </div>
                <div class="col-xs-6">
{{--                    <a href="{{ route('catalog.show') }}" class="btn btn-primary btn-sm btn-block">--}}
{{--                        <span class="glyphicon glyphicon-share-alt"></span> Continue shopping--}}
{{--                    </a>--}}
                </div>
            </div>
        </div>
    </div>
    <div class="panel-body">
        @if($cart && !$cart->isEmpty())
            @foreach($cart as $cartItem)
                <div class="row">
                    <div class="col-xs-1"><img class="img-responsive" src="{{ $cartItem->product->image }}">
                    </div>
                    <div class="col-xs-6">
                        <h4 class="product-name"><strong>{{ $cartItem->product ? $cartItem->product->name : 'Unidentified' }}</strong></h4><h4><small></small></h4>
                    </div>
                    <div class="col-xs-5">
                        <div class="col-xs-6 text-right">
                            <h6><strong>${{ $cartItem->price }} <span class="text-muted">x</span></strong></h6>
                        </div>
                        <div class="col-xs-4">
                            <form method="POST" action="{{ route('cart.update', $cartItem) }}" id="updateCart">
                                @csrf
                                <input type="number" name="quantity" class="form-control input-sm" value="{{ $cartItem->quantity }}">
                            </form>
                        </div>
                        <div class="col-xs-2">

                            <form action="{{ route('cart.remove', $cartItem) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-link btn-xs">
                                    <span class="glyphicon glyphicon-trash"> </span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <hr>
            @endforeach
        @else
            <div class="alert alert-warning" role="alert">
                No items in your cart
            </div>
        @endif

    </div>
    <div class="panel-footer">
        <div class="row text-center">
            <div class="col-xs-12">
                <h4 class="text-right">Total <strong>${{ $total }}</strong></h4>
            </div>
        </div>
    </div>
</div>
