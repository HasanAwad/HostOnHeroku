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

/**
 * @param Request $request
 * @return \Illuminate\Http\JsonResponse
 * @throws \Illuminate\Validation\ValidationException
 */
public function store(Request $request)
{


    // $this->validate($request, [
    //     'code' => 'required',
    //     'country' => 'required',
    //     'name' => 'required',
    //     'symbol
    //     ' => 'required',



    // ]);

    $currencies = new Currencies();
    $currencies->code = $request->code;
    $currencies->country = $request->country;
    $currencies->name = $request->name;
    $currencies->symbol = $request->symbol;

    //if(!Categories::where('name', $category->name )->exists()){

    if ($currencies->save())
        return response()->json([
            'success' => true,
            'currencies' => $currencies
        ],200);


    else
        return response()->json([
            'success' => false,
            'message' => 'Sorry, task could not be added.'
        ], 500);
    // }else{
    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Sorry, already exist'
    //     ], 500);
    // }

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
