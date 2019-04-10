@extends('layouts.app')

@section('content')  
        <div class="container">
            <div class="card">
                <div class="card-header text-white bg-danger">My Cart - {{Cart::content()->count()}} Item(s)  <br>  TOTAL AMOUNT: ₦{{Cart::total()}}           
                    <a class="btn btn-secondary float-right" href="{{route('cart.checkout')}}">Checkout</a>
                </div>
                    <div class="card-body">
                        <div class="row">
                        
                        <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Price</th>
                                    <th scope="col"></th>
                                    </tr>
                                </thead>
                                 
                                @foreach(Cart::content() as $products)
                            
                                <tbody>
                                    <tr>
                                    <td>{{$products->name}}</td>
                                    <td><img src="{{asset($products->model->image)}}" alt="" height="90px"></td>
                                    <td><input type="number" name="qty" value="{{$products->qty}}" min="1" max="5" id=""></td>
                                    <td>{{$products->price}}</td>
                                    <td><a href="{{url('/cart/delete/'.$products->rowId)}} "><span class="text-danger">X</span></a></td>
                                    </tr>
                                </tbody>
                                @endforeach                               
                                   
                                
                        </table>

                           
                    </div>
                </div>
            </div>
        </div>

@endsection