<script src="https://unpkg.com/react@17/umd/react.production.min.js"></script>
<script src="https://unpkg.com/react-dom@17/umd/react-dom.production.min.js"></script>
@extends('pages.layouts.admin')
<script src="{{ asset(mix('js/components/Cart.js')) }}"></script>
@section('title', 'Open POS')
@section('content')
    <div id="cart"></div>
@endsection