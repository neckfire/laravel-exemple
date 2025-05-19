<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        $this->authorize('viewAny', Dish::class);

        return view('home', ['dishes'=>Dish::with(['owner', 'likedBy'])->paginate(5)]);
    }
}
