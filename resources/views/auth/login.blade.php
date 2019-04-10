@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div>
                <div class="card">
                    <div class="card-header">Default Users</div>
                    <div class="card-body" style="height: calc(100vh - 150px); overflow-y: auto">
                        <table class="table">
                            <tr>
                                <th colspan="5" class="text-center">Default Users</th>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Role</th>
                                <th colspan="2">Description</th>
                            </tr>
                            <tr>
                                <td>ordermanager1@app.com</td>
                                <td>admin</td>
                                <td>Order Manager</td>
                                <td>Handles orders when a client makes it.</td>
                            </tr>
                            <tr>
                                <td>ordermanager2@app.com</td>
                                <td>admin</td>
                                <td>Order Manager</td>
                                <td>Handles orders when a client makes it.</td>
                            </tr>
                            <tr>
                                <td>ordermanager3@app.com</td>
                                <td>admin</td>
                                <td>Order Manager</td>
                                <td>Handles orders when a client makes it.</td>
                            </tr>
                            <tr>
                                <td>shippingmanager1@app.com</td>
                                <td>admin</td>
                                <td>Shipping Manager</td>
                                <td>Further processes the order when processed by Order Manager.</td>
                            </tr>
                            <tr>
                                <td>shippingmanager2@app.com</td>
                                <td>admin</td>
                                <td>Shipping Manager</td>
                                <td>Further processes the order when processed by Order Manager.</td>
                            </tr>
                            <tr>
                                <td>shippingmanager3@app.com</td>
                                <td>admin</td>
                                <td>Shipping Manager</td>
                                <td>Further processes the order when processed by Order Manager.</td>
                            </tr>
                            <tr>
                                <td>deliverymanager1@app.com</td>
                                <td>admin</td>
                                <td>Delivery Manager</td>
                                <td>Delivers the order when processed by Shipping Manager.</td>
                            </tr>
                            <tr>
                                <td>deliverymanager2@app.com</td>
                                <td>admin</td>
                                <td>Delivery Manager</td>
                                <td>Delivers the order when processed by Shipping Manager.</td>
                            </tr>
                            <tr>
                                <td>deliverymanager3@app.com</td>
                                <td>admin</td>
                                <td>Delivery Manager</td>
                                <td>Delivers the order when processed by Shipping Manager.</td>
                            </tr>
                            <tr>
                                <td>customer@app.com</td>
                                <td>customer</td>
                                <td>-</td>
                                <td>Standard Customer that makes or tracks the order.</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
{{--
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
--}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
