<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Currencies;
use App\Http\Resources\CurrencyResource;
use App\Models\Currency;

/**
 * Class CurrencyController
 *
 * @package App\Http\Controllers\Api
 */
class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Currencies
     */
    public function index()
    {
        return new Currencies(Currency::all());
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return CurrencyResource
     */
    public function show($id)
    {
        return new CurrencyResource(Currency::findOrFail($id));
    }


}
