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
        'from' => 'required|string|size:3',
        'to' => 'required|string|size:3',
        'amount' => 'required|numeric|min:0',
    ]);

    $from = Currency::where('code', strtoupper($request->from))->firstOrFail();
    $to = Currency::where('code', strtoupper($request->to))->firstOrFail();

    $pair = Pair::where('devise_from_id', $from->id)
                ->where('devise_to_id', $to->id)
                ->firstOrFail();

    $pair->increment('conversion_count');

    $converted = $request->amount * $pair->rate;

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
