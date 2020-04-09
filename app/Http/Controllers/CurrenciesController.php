<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use App\Currencies;


class CurrenciesController extends Controller
{
      /**
     * @var
     */
    protected $user;


    /**
     * TransactionsController constructor.
     */
    public function __construct()
    {

    }


    /**
 * @return mixed
 */
public function index()
{
    //$currencies = $this->user->currencies()->get(['id','country','symbol','name','code'])->toArray();

    $currencies = Currencies::all();
    return $currencies;
}

public function show()
{
    try{
        $this->user = JWTAuth::parseToken()->authenticate();

     } catch(Exception $error){

    }

    $currencies = $this->user->currencies()->get();
    return $currencies;
}





}
