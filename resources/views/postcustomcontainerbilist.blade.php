@extends('layouts.app')
@include('layouts.modal_messages')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> Post Custom Container Form With BI API </div>

                <div class="card-body">
                    <form id="postcustomcontainerinfobi_form" name="postcustomcontainerinfobi_form">
                        <div class="form-group row required">
                            <label for="name" class="col-md-4 col-form-label text-md-right">ShipsGo Auth Code</label>
                            <div class="col-md-6">
                                <input id="authcode" type="text" class="form-control " name="authcode" value="" required="" autofocus="">
                            </div>
                        </div>
                        <div class="form-group row required">
                            <label for="name" class="col-md-4 col-form-label text-md-right">ShipsGo Container Number</label>
                            <div class="col-md-6">
                                <input id="containerNumber" type="text" class="form-control " name="containerNumber" value="" required="" autofocus="">
                            </div>
                        </div>

                        <div class="form-group row required">
                            <label for="name" class="col-md-4 col-form-label text-md-right">ShipsGo Shipping Line</label>
                            <div class="col-md-6">
                                <input id="shippingLine" type="text" class="form-control " name="shippingLine" value="" required="" autofocus="">
                            </div>
                        </div>

                        <div class="form-group row required">
                            <label for="name" class="col-md-4 col-form-label text-md-right">ShipsGo Email</label>
                            <div class="col-md-6">
                                <input id="emailAddress" type="email" class="form-control " name="emailAddress" value="" required="" autofocus="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">ShipsGo Reference Number</label>
                            <div class="col-md-6">
                                <input id="referenceNo" type="text" class="form-control " name="referenceNo" value="" autofocus="">
                            </div>
                        </div>

                        <div class="form-group row required">
                            <label for="name" class="col-md-4 col-form-label text-md-right">ShipsGo Container Count</label>
                            <div class="col-md-6">
                                <input id="containersCount" type="number" class="form-control " name="containersCount" value="" required="" autofocus="" min="0">
                            </div>
                        </div>

                        <div class="form-group row required">
                            <label for="name" class="col-md-4 col-form-label text-md-right">ShipsGo BI Container Ref</label>
                            <div class="col-md-6">
                                <input id="blContainersRef" type="text" class="form-control " name="blContainersRef" value="" required="" autofocus="">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection