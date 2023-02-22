<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MovementController extends Controller
{
    public function index(Request $request){
        return response()->json(["movements" => Movement::where('user_id',auth()->user()->id)->get()],200);
    }

    public function create(Request $request){
        $request->validate([
            'value' => 'required|numeric',
            'date' => 'required|date',
            'category_id' => ['required',Rule::exists('categories','id')],
        ]);

        $movement = new Movement();
        $movement->value = $request->value;
        $movement->date = $request->date;
        $movement->note = $request->note;
        $movement->category_id = $request->category_id;
        $movement->user_id = auth()->user()->id;

        try {
            $movement->save();
        }catch (\Exception $exception){
            return response()->json(["movement" => null,"error" => $exception->getMessage()],500);
        }

        return response()->json(["movement" => $movement->refresh()],201);
    }

    public function delete(Request $request){

        $movement = Movement::findOrFail($request->id);

        if ($movement->user_id === auth()->user()->id){
            $movement->delete();
        }else{
           return response()->json(["message" => "Forbidden"],401);
        }

        return response()->json(["message" => "Movement deleted"],204);
    }

}
