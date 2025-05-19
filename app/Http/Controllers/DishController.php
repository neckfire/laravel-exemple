<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Notifications\NewDish;
use App\Policies\DishPolicy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function home(): \Illuminate\Database\Eloquent\Collection
    {
        return Dish::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Dish::class);

        $validatedData = $request->validate([
            'name' => 'required|max:2048',
            'recipe' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $dish = new Dish([
            'name' => $validatedData['name'],
            'recipe' => $validatedData['recipe'],
        ]);

        $dish->owner()->associate(Auth::user());
        $dish->image = Storage::disk('public')->put('images', $request->file('image'));

        $dish->save();
        Auth::user()->notify(new NewDish($dish));
        return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->authorize('view', Dish::class);

        return Dish::all()->where('id', $id)->first();
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(Request $request, Dish $dish, DishPolicy $dishPolicy)
    {
        $this->authorize('update', $dish);

        $validatedData = $request->validate([
            'name' => 'required|string|max:2048',
            'recipe' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $dish->name = $validatedData['name'];
        $dish->recipe = $validatedData['recipe'];

        if ($dish->image !== "images/image.gif") {
            Storage::disk('public')->delete('images', $dish->image);
        }
        $dish->image = Storage::disk('public')->put('images', $request->file('image'));

        $dish->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete', Dish::class);

        $dish = Dish::findOrFail($id);

        if ($dish->image !== "images/image.gif") {
            Storage::disk('public')->delete('images', $dish->image);
        }

        $dish->delete();

        return redirect('/');
    }
}
