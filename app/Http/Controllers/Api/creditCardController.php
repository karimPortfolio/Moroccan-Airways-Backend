<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\creditCard;

class creditCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $creditCards = creditCard::all();
        return $creditCards;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $creditCard = creditCard::where('cardNumber' , $request->cardNumber)->get();
        if (count($creditCard) == 0)
        {
            return response()->json(['message'=>'Card Not Valide']);
        }else{
            if ($creditCard[0]->cvvNumber == $request->cvvNumber && $creditCard[0]->name == $request->name && $creditCard[0]->expireDate == $request->expireDate)
            {
                return response()->json(['message'=>'Card Valide']);
            }else{
                return response()->json(['message'=>'Card Not Valide']);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
