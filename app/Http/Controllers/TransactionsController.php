<?php

namespace App\Http\Controllers;
use JWTAuth;
use Illuminate\Http\Request;
use App\Transactions;
use App\Categories;

class TransactionsController extends Controller
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
        try{
            $this->user = JWTAuth::parseToken()->authenticate();

         } catch(Exception $error){

        }
    }

    /**
 * @return mixed
 */
public function index()
{
    $transaction = $this->user->transactions()->get()->toArray();

    return response()->json([
        'success'   =>  true,
        'data'      =>  $transaction
    ], 200);

}



 /**
        * @param Request $request
        * @return \Illuminate\Http\JsonResponse
        * @throws \Illuminate\Validation\ValidationException
    */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'amount' => 'required' ,
            'type' => 'required'
        ]);
       //s dd($request->toArray());

        $transaction = new Transactions();
        $transaction->title = $request->title;
        $transaction->description = $request->description;
        $transaction->amount = $request->amount;
        $transaction->type =$request->type;
        $transaction->currencies_id = $request->currencies_id;
        $transaction->categories_id = $request->categories_id;
        $transaction->start_date = $request->start_date;
        $transaction->interval = $request->interval;

        if($transaction->type != 'goal' && $transaction->interval === null){
            $transaction->start_date = $request->start_date;
            $transaction->end_date = null;
            $transaction->interval = null;

        }
        elseif($transaction->type != 'goal' && $transaction->interval !=null ){
            $transaction->start_date = $request->start_date;
            $transaction->end_date = $request->end_date | null;
        }
        else{
            if($transaction->type === 'goal'){

            }
        }

        if ($this->user->transactions()->save($transaction))
            return response()->json([
                'success' => true,
                'transaction' => $transaction
            ],201);
        else
            return response()->json([
                'success' => false,
                'message' => 'Sorry, transaction could not be added.'
            ], 500);
    }




    /**
 * @param Request $request
 * @param $id
 * @return \Illuminate\Http\JsonResponse
 */
public function update(Request $request, $id)
{
    $transaction = $this->user->transactions()->find($id);

    if (!$transaction) {
        return response()->json([
            'success' => false,
            'message' => 'Sorry, transaction with id ' . $id . ' cannot be found.'
        ], 400);
    }

    $transaction->title = $request->title;
    $transaction->description = $request->description;
    $transaction->amount = $request->amount;
    $transaction->type =$request->type;
    $transaction->currencies_id = $request->currencies_id;
    $transaction->categories_id = $request->categories_id;
    $transaction->start_date = $request->start_date;
    $transaction->interval = $request->interval;

     $updated = $transaction->save();
     //dd($updated);

    if ($updated) {
        return response()->json([
            'success' => true
        ],200);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Sorry, transaction could not be updated.'
        ], 500);
    }
}



    /**
 * @param $id
 * @return \Illuminate\Http\JsonResponse
 */
public function destroy($id)
{
    $transaction = $this->user->transactions()->find($id);

    //dd($transaction);

    if (!$transaction) {
        return response()->json([
            'success' => false,
            'message' => 'Sorry, transaction with id ' . $id . ' cannot be found.'
        ], 400);
    }

    if ($transaction->delete()) {
        return response()->json([
            'success' => true
        ],200);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'transaction could not be deleted.'
        ], 500);
    }
}




}
