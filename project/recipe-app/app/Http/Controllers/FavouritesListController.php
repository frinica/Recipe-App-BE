<?php

namespace App\Http\Controllers;

use App\Models\FavouritesList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavouritesListController extends Controller
{
    public function store(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'user_id' => 'required',
            'list_name' => 'required' 
        ]);

        FavouritesList::create($input);
        return back();
    }

    public function update(Request $request, $id)
    {   
        $user = Auth::user()->id;
        $recipe = $request->recipe_id;
        
        $favouritesList = FavouritesList::find($id);
    }
}
