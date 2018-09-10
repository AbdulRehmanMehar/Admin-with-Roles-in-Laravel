@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(Auth::user()->isAdmin)
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Hey {{Auth::user()->name}}</h5>
                    <p class="card-text">Go to Admin Area to perform administrative tasks!</p>
                    <a href="{{route('admin.home')}}" class="btn btn-primary" style="float: right;">Go</a>
                  </div>
                </div>
            @endif
            <div class="card mt-4">
              <div class="card-body">
                <h5 class="card-title">My Orders</h5>
                <p class="card-text">Go ahead and check the status of your orders.</p>
                <a href="{{route('home.myorders')}}" class="btn btn-primary" style="float: right;">Go</a>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
