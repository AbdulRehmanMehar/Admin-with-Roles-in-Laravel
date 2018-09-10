@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Add Product</h5>
                <p class="card-text">Go ahead and add a product.</p>
                <a href="{{route('admin.products.create')}}" class="btn btn-primary" style="float: right;">Go</a>
              </div>
            </div>

            <div class="card mt-4">
              <div class="card-body">
                <h5 class="card-title">Manage {{Auth::user()->role}}</h5>
                <p class="card-text">Go ahead and manage {{Auth::user()->role}}.</p>
                <a href="{{route('admin.orders.manage')}}" class="btn btn-primary" style="float: right;">Go</a>
              </div>
            </div>

        </div>
    </div>
</div>
@endsection
