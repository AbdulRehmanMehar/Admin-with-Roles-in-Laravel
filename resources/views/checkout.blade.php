@extends('layouts.app')

@section('content')  
        <div class="container">
            <div class="card">
                <div class="card-header text-white bg-danger display-5">Amount: ₦{{Cart::total()}}
                <a class="btn btn-primary float-right" href="{{route('pay')}}">Pay</a>
                </div>
                    <div class="card-body">
                        <div class="row">
                           <table class="table">
                                @foreach(Cart::content() as $products)
                                <tbody>
                                    <tr>
                                        <td class="">{{$products->name}} | x{{$products->qty}} | (₦{{$products->price}})</td>
                                    </tr>
                                </tbody>
                                @endforeach                                       
                            </table>                    
                    </div>
                </div>
            </div>
        </div>

@endsection