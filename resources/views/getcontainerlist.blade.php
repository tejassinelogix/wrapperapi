@extends('layouts.app')
@include('layouts.modal_messages')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> Get Container Information API </div>

                <div class="card-body">
                    <form id="getcontainerinfo_form" name="getcontainerinfo_form">
                        <div class="form-group row required">
                            <label for="name" class="col-md-4 col-form-label text-md-right">ShipsGo Auth Code</label>
                            <div class="col-md-6">
                                <input id="authcode" type="text" class="form-control " name="authcode" value="" required="" autofocus="">
                            </div>
                        </div>
                        <div class="form-group row required">
                            <label for="name" class="col-md-4 col-form-label text-md-right">ShipsGo Request ID</label>
                            <div class="col-md-6">
                                <input id="requestId" type="text" class="form-control " name="requestId" value="" required="" autofocus="">
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