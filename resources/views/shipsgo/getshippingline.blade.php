@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> {{ _('Get Shipping Line List API') }} </div>

                <div class="card-body">
                    <form id="getshippinglinelist_form" name="getshippinglinelist_form">
                        <div class="form-group row required">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ _('ShipGo Auth Code') }}</label>
                            <div class="col-md-6">
                                <input id="authcode" type="text" class="form-control " name="authcode" value="" required="" autocomplete="name" autofocus="">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ _('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/shipsgo/get_shipping_list.js') }}" defer></script>
@endsection