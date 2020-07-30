<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('api');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home')->with(['api_auth' => 'login']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getshippinglinelist()
    {
        return view('shipsgo.getshippingline')->with(['api_auth' => 'login']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getcontainerlist()
    {
        return view('shipsgo.getcontainerlist')->with(['api_auth' => 'login']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function postcontainerlist()
    {
        return view('shipsgo.postcontainerlist')->with(['api_auth' => 'login']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function postcustomcontainerlist()
    {
        return view('shipsgo.postcustomcontainerlist')->with(['api_auth' => 'login']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function postcontainerbllist()
    {
        return view('shipsgo.postcontainerbllist')->with(['api_auth' => 'login']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function postcustomcontainerbllist()
    {
        return view('shipsgo.postcustomcontainerbllist')->with(['api_auth' => 'login']);
    }
}
