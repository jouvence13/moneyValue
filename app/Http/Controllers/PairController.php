<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pair;
use App\Models\Currency;
use App\Http\Requests\StorePairRequest;
use App\Http\Requests\UpdatePairRequest;

class PairController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Pair::with(['deviseFrom', 'deviseTo'])->get();
    }

    public function show(Pair $pair)
    {
        return $pair->load(['deviseFrom', 'deviseTo']);
    }

    public function store(StorePairRequest $request)
    {
        return Pair::create($request->validated());
    }

    public function update(UpdatePairRequest $request, Pair $pair)
    {
        $pair->update($request->validated());
        return $pair;
    }

    public function destroy(Pair $pair)
    {
        $pair->delete();
        return response()->noContent();
    }
public function convert(Request $request)
{
    $request->validate([
        'pair_id' => 'required|exists:pairs,id',  // Vérifie que la paire existe
        'amount' => 'required|numeric|min:0',   //  Vérifie que le montant est numérique et >=0
    ]);

    //  Récupère la paire sélectionnée
    $pair = Pair::findOrFail($request->pair_id);

    //  Incrémente le compteur
    $pair->increment('conversion_count');

    //  Calcule la conversion (multiplie puis divise par 100)
    $converted = ($request->amount * $pair->rate) / 100;

    return response()->json([
        'converted_amount' => $converted,
        'rate' => $pair->rate,
    ]);
}




    public function currencies()
    {
        return Currency::all();
    }
}
