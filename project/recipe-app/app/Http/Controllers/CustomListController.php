<?php

namespace App\Http\Controllers;

use App\Models\CustomList;
use App\Models\ListEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomListController extends Controller
{
    public function store(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'user_id' => 'required',
            'list_name' => 'required' 
        ]);

        CustomList::create($input);
        return back();
    }

    public function getAll()
    {
        if(Auth::user())
        {
            $id = Auth::user()->id;
            $lists = CustomList::where('user_id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            
            return response($lists, 200); 
        } else
        {
            return response()->json([
                "message" => "Found no lists"
            ], 404);
        }
    }

    public function getByID($id)
    {
        if(Auth::user())
        {
            $list = CustomList::where('id', $id)->first();
            $recipes = ListEntry::select()->where('customlist_id', $id)->get();

            return response($recipes, 200);
        } else
        {
            return response()->json([
                "message" => "List not found"
            ], 404);
        }
    }



    public function update(Request $request, $id)
    {   
        if(CustomList::where('id', $id)->exist())
        {
            $list = CustomList::find($id);
            $list->listName = is_null($request->listName) ? $list->listName : $request->listName;
            $list->recipeID = is_null($request->recipeID) ? $list->recipeID : $request->recipeID;
            $list->save();

            return response()->json([
                "message" => "The list has been updated"], 200);
            
        } else 
        {
            return response()->json([
                "message" => "List not found"
            ], 404);
        }
    }

    public function destroy($id)
    {
        if(Auth::user() && CustomList::where('id', $id)->exists())
        {
            $list = CustomList::find($id);
            $list->delete();

            return response()->json([
                "message" => "List deleted"
            ], 202);
        } else
        {
            return response()->json([
                "message" => "List not found"
            ], 404);
        }
    }
}
