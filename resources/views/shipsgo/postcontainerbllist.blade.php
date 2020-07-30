@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> {{ _('Post Container Information With BL API') }} </div>

                <div class="card-body">
                    <form id="postcontainerinfobl_form" name="postcontainerinfobl_form">
                        <div class="form-group row required">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ _('ShipsGo Auth Code') }}</label>
                            <div class="col-md-6">
                                <input id="authcode" type="text" class="form-control " name="authcode" value="" required="" autofocus="">
                            </div>
                        </div>
                        <div class="form-group row required">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ _('ShipsGo Container Number') }}</label>
                            <div class="col-md-6">
                                <input id="containerNumber" type="text" class="form-control " name="containerNumber" value="" required="" autofocus="">
                            </div>
                        </div>

                        <div class="form-group row required">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ _('ShipsGo Shipping Line') }}</label>
                            <div class="col-md-6">
                                <input id="shippingLine" type="text" class="form-control " name="shippingLine" value="" required="" autofocus="">
                            </div>
                        </div>

                        <div class="form-group row required">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ _('ShipsGo Container Count') }}</label>
                            <div class="col-md-6">
                                <input id="containersCount" type="number" class="form-control " name="containersCount" value="" required="" autofocus="" min="0">
                            </div>
                        </div>

                        <div class="form-group row required">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ _('ShipsGo BL Container Ref') }}</label>
                            <div class="col-md-6">
                                <input id="blContainersRef" type="text" class="form-control " name="blContainersRef" value="" required="" autofocus="">
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
<script src="{{ asset('js/shipsgo/post_container_info_bl.js') }}" defer></script>
@endsection