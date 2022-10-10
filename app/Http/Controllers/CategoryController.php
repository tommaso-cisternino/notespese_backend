<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request){
        return response()->json(["categories" => Category::where('user_id',auth()->user()->id)->get()],200);
    }

    public function create(Request $request){
        $request->validate([
            'name' => 'string|required',
            'color' => 'required',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->color = $request->color;
        $category->user_id = auth()->user()->id;

        try {
            $category->save();
        }catch (\Exception $exception){
            return response()->json(["category" => null,"error" => $exception->getMessage()],500);
        }

        return response()->json(["category" => $category],201);
    }
}
