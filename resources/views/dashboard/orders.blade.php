@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header text-white bg-danger">
                My Orders
             </div>
            <div class="card-body">

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Products</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $key => $order)
                            @if($order->user_id == Auth::user()->_id)
                                <tr>
                                    <th scope="row">{{$key + 1}}</th>
                                    <td>
                                        @foreach (json_decode($order->cart) as $cart)
                                            {{$cart->name}} ,
                                        @endforeach
                                    </td>
                                    <td>{{($order->process != '') ?  $order->process : 'Working....'}}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
