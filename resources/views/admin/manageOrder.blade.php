@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header text-white bg-danger">
                <a href="{{route('admin.home')}}" style="color: #f9f9f9;"><b>&larr;</b></a> &nbsp;
                Manage Orders
             </div>
            <div class="card-body">

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Ordered By</th>
                            <th scope="col">Products</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $key => $order)
                            @php
                                $dynamicVar;
                                $process;
                                if(Auth::user()->role == 'order'){
                                    $dynamicVar = 'Confirm Order';
                                    $process = '';
                                }elseif(Auth::user()->role == 'shipping'){
                                    $dynamicVar = 'Confirm Shipment';
                                    $process = 'Order Confirmed';
                                }elseif(Auth::user()->role == 'delivery'){
                                    $dynamicVar = 'Confirm Delivery';
                                    $process = 'Product Shipped';
                                }
                            @endphp
                            @if($order->process == $process && $order->admin == Auth::user()->_id)
                                <tr>
                                    <td>
                                        @foreach($users as $user)
                                            @if($user->_id == $order->user_id)
                                                {{$user->email}}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach (json_decode($order->cart) as $cart)
                                            {{$cart->name}} ,
                                        @endforeach
                                    </td>
                                    <td>
                                        <span
                                            class="dynamic-span"
                                            order-id="{{$order->_id}}"
                                            user-role="{{Auth::user()->role}}"
                                            user-id="{{Auth::user()->id}}"
                                            style="cursor: pointer;"
                                            onclick="submitForm(this)"
                                        >{{$dynamicVar}}</span>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <form id="managementForm" action="{{route('admin.orders.complete')}}" method="post" style="display: none;">
        {{csrf_field()}}
        <input type="hidden" name="order_id" id="order-id">
        <input type="hidden" name="user_role" id="user-role">
        <input type="hidden" name="user_id" id="user-id">
    </form>

@endsection

@section('scripts')
    <script type="text/javascript">
        let submitForm = (el) => {
            document.querySelector('#managementForm #order-id').value = el.getAttribute('order-id');
            document.querySelector('#managementForm #user-role').value = el.getAttribute('user-role');
            document.querySelector('#managementForm #user-id').value = el.getAttribute('user-id');
            document.querySelector('#managementForm').submit();
        }
    </script>
@endsection
