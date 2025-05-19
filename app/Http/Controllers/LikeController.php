<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function storeOrDelete(Request $request)
    {
        $validatedData = $request->validate([
            'dish_id' => 'required',
        ]);

        $like = Like::where('user_id', Auth::id())
            ->where('dish_id', $validatedData['dish_id'])
            ->first();

        if ($like) {
            $like->delete();
        } else {
            $like = new Like();
            $like->user_id = Auth::id();
            $like->dish_id = $validatedData['dish_id'];
            $like->save();
        }

        return redirect('/');
    }
}
