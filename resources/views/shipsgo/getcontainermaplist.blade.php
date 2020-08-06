@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> {{ _('Get Container Map Information API') }} </div>

                <div class="card-body">
                    <form id="getcontainerinfomap_form" name="getcontainerinfomap_form">
                        <div class="form-group row required">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ _('ShipsGo Auth Code') }}</label>
                            <div class="col-md-6">
                                <input id="authcode" type="text" class="form-control " name="authcode" value="" required="" autofocus="">
                            </div>
                        </div>
                        <div class="form-group row required">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ _('ShipsGo Request ID') }}</label>
                            <div class="col-md-6">
                                <input id="requestId" type="text" class="form-control " name="requestId" value="" required="" autofocus="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mapPoint" class="col-md-4 col-form-label text-md-right"> {{ _('MapPoint') }} </label>
                            <div class="col-md-6">
                                <!-- Verticle radio button replace class with .form-check -->
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" name="mapPoint" value="true" checked>
                                    <label class="form-check-label">True</label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" name="mapPoint" value="false">
                                    <label class="form-check-label">False</label>
                                </div>
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
                <div class='shipsgo_map d-none' id='shipsgo_map_frame'>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/shipsgo/get_containermap_info.js') }}" defer></script>
@endsection