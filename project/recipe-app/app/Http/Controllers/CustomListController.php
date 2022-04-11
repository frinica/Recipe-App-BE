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
        $list = new CustomList;
        $list->list_name = $request->list_name;
        $list->user_id = $request->user_id;
        $list->save();

        return response()->json([
            "message" => "List has been created successfully"
        ], 201);
    }

    public function getAll()
    {   
        $id = Auth::user()->id;
        $lists = CustomList::where('user_id', $id)->get()->toJson(JSON_PRETTY_PRINT);
             
         return response($lists, 200); 
        }
    

    public function getByID($id)
    {
        if(CustomList::where('id', $id)->exists()) {
            $list = CustomList::where('id', $id)->get();
            /* return response($list, 200); */

            $recipes = ListEntry::select()->where('customlist_id', $id)->get();
            return response()->json([$list, $recipes], 200);
        
        } else {
            return response()->json([
                "message" => "List not found"
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {   
            $list = CustomList::find($id);
            $list->list_name = is_null($request->list_name) ? $list->list_name : $request->list_name;
            $list->save();

            $listEntry = new ListEntry;
            $listEntry->customlist_id = $id;
            $listEntry->recipe_id = $request->recipe_id;
            $listEntry->save();

            return response()->json([
                "message" => "The list has been updated"], 200);
        
    }

    public function destroy($id)
    {
        if(CustomList::where('id', $id)->exists())
        {
            $list = CustomList::find($id);
            $list->delete();

            $listEntry = ListEntry::where('customlist_id', $id);
            $listEntry->delete();

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
