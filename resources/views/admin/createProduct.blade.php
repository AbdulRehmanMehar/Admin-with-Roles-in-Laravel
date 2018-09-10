@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header text-white bg-danger">
                <a href="{{route('admin.home')}}" style="color: #f9f9f9;"><b>&larr;</b></a> &nbsp;
                Create Products
             </div>
            <!-- must enctype when submiting form with file -->
            <div class="card-body">
            <form action="{{route('admin.products.store')}}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}

                    <div class="form-group">
                        <label for="name">Name</label>
                         <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" >
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                            <input id="price" type="number" class="form-control" name="price" value="{{ old('price') }}" >
                    </div>

                    <div class="form-group">
                        <label for="image">Image</label>
                            <input id="image" type="file" class="form-control" name="image" >
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                            <textarea name="description" id="description" cols="30" rows="5" class="form-control">{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <div class="text-center">
                            <button class="form-control btn btn-success " type="submit">
                                Add Product
                            </button>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
@endsection
