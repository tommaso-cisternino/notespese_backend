<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use Illuminate\Http\Request;

class MovementController extends Controller
{
    public function index(Request $request){
        return response()->json(["movements" => Movement::all()],200);
    }

    public function create(Request $request){
        $request->validate([
            'value' => 'numeric|required',
            'date' => 'string|required',
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

        return response()->json(["movement" => $movement],201);
    }}
