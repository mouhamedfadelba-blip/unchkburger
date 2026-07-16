<?php

namespace App\Http\Controllers;

use App\Http\Requests\BurgerRequest;
use App\Models\Burger;

class BurgerController extends Controller
{
    public function index()
    {
        return Burger::with('category')->get();
    }

    public function store(BurgerRequest $request)
    {
        $burger = Burger::create($request->validated());

        return response()->json([
            'message' => 'Burger créé avec succès.',
            'data' => $burger
        ], 201);
    }

    public function show(Burger $burger)
    {
        return $burger->load('category');
    }

    public function update(BurgerRequest $request, Burger $burger)
    {
        $burger->update($request->validated());

        return response()->json([
            'message' => 'Burger modifié avec succès.',
            'data' => $burger
        ]);
    }

    public function destroy(Burger $burger)
    {
        $burger->delete();

        return response()->json([
            'message' => 'Burger supprimé avec succès.'
        ]);
    }
}