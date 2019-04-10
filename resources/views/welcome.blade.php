@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1>What does this application do?</h1>
        <p>This application is simple eCommerce application. Anyone can register or login and place an order. Then the order is processed in three setps:</p>
        <ul>
            <li>When customer places the Order, it is sent to <b>Order Manager</b> which processes it.</li>
            <li>Then Order is transfered to <b>Shipping Manager</b> which makes sure that the order is ready to be shipped.</li>
            <li>When the order is processed by Shipping Manager, it is transfered to <b>Delivery Manager</b> which delivers the order.</li>
        </ul>
        <h2>Constraints</h2>
        <p>Here are some constraints:</p>
        <ul>
            <li>We've 3 users of same role &amp; One user can handle 3 orders at a time.</li>
            <li>If no user is free and i.e an order is placed, it is set to be pending.</li>
            <li>When a user of that role (for which the order is pending) gets free, the order is assigned to that user.</li>
        </ul>
        <p>This application is built with laravel and mongodb but It doesn't use the Queue System of Laravel.</p>
    </div>

@endsection