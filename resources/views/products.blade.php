@extends('layouts.app')

@section('content')  
        <div class="container">
            <div class="card">
                <div class="card-header text-white bg-danger">Mercy Stores</div>
                    <div class="card-body">
                        <div class="row">
                        @foreach($products as $product)
                            <div class="card col-lg-4" style="width: 11rem; height: 30rem;">
                                <img class="card-img-top" src="{{asset($product->image)}}" alt="" height="60%">
                                <div class="card-body">
                                    <h5 class="card-title">{{$product->name}} - ₦{{$product->price}}</h5>
                                    
                                    <p class="card-text">{{$product->description}}</p>
                                    <form action="{{route('cart.add')}}" method="post">
                                        {{csrf_field()}}
                                        QUANTIY: <input type="number" name="qty" min="1" max="5" value="1">
                                        <input type="hidden" value="{{$product->id}}" name="product_id">
                                        <button  class="btn btn-primary" type="submit">Add to Cart</button>
                                    </form>
                                    
                                </div>
                            </div>
                        @endforeach    
                    </div>
                </div>
            </div>
        </div>

@endsection