@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <p>
                        <a class='btn btn-primary btn-sm' id='get_ship_line' name='get_ship_line' href="{{ url('getshippinglinelist') }}">GetShippingLineList</a>
                        &nbsp;
                        <a class='btn btn-primary btn-sm' id='get_container_info' name='get_container_info' href="{{ url('getcontainerlist') }}"> Container Info</a>
                        &nbsp;
                        <a class='btn btn-primary btn-sm' id='post_container_info' name='post_container_info' href="{{ url('postcontainerlist') }}"> Post Container Info</a>
                        &nbsp;
                        <a class='btn btn-primary btn-sm' id='post_customcontainer_info' name='post_customcontainer_info' href="{{ url('postcustomcontainerlist') }}"> Post Custom Container Info</a>
                        &nbsp;
                    </p>
                    <p>
                        <a class='btn btn-primary btn-sm' id='post_container_info_bi' name='post_container_info_bi' href="{{ url('postcontainerbllist') }}"> Post Container Info With BL</a>
                        &nbsp;
                        <a class='btn btn-primary btn-sm' id='post_customcontainer_info_bi' name='post_customcontainer_info_bi' href="{{ url('postcustomcontainerbllist') }}"> Post Custom Container Info With BI</a>
                        &nbsp;
                        <a class='btn btn-primary btn-sm' id='get_containermap_info' name='get_containermap_info' href="{{ url('containerinfomap') }}"> Container Map Info</a>
                    </p>
                </div>

                <div class="card-body">

                </div>

            </div>
        </div>
    </div>
</div>
@endsection