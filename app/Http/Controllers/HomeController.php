<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function index(Request $request)
    {
        $query = GalleryImage::where('user_id', Auth::user()->id);

        if($request->category){
            $query->where('category', $request->category);
        }

        if($request->sort == 'oldest'){
            $query->orderBy('created_at', 'ASC');
        }elseif($request->sort == 'latest') {
            $query->orderBy('created_at', 'DESC');
        }

        $data['images'] = $query->paginate(4);

        return view('home', [
            'data' => $data
        ]);
    }

}
