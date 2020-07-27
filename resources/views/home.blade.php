@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><a class='btn btn-primary btn-sm' id='test_btn' name='test_btn' href="{{ url('getshippinglinelist') }}">GetShippingLineList</a></div>

                <div class="card-body">

                </div>

            </div>
        </div>
    </div>
</div>
@endsection