<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use JWTAuth;
use App\Categories;
class CategoriesController extends Controller
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
    $categories = $this->user->categories()->get();

    return $categories;
}

/**
 * @param Request $request
 * @return \Illuminate\Http\JsonResponse
 * @throws \Illuminate\Validation\ValidationException
 */
public function store(Request $request)
{

    $this->validate($request, [
        'name' => 'required',

    ]);

    $category = new Categories();
    $category->name = $request->name;

    if(!Categories::where('name', $category->name )->exists()){

    if ($this->user->categories()->save($category))
        return response()->json([
            'success' => true,
            'categorie' => $category
        ],200);


    else
        return response()->json([
            'success' => false,
            'message' => 'Sorry, task could not be added.'
        ], 500);
    }else{
        return response()->json([
            'success' => false,
            'message' => 'Sorry, already exist'
        ], 500);
    }

}

/**
 * @param Request $request
 * @param $id
 * @return \Illuminate\Http\JsonResponse
 */
public function update(Request $request, $id)
{
    $category = $this->user->categories()->find($id);

    if (!$category) {
        return response()->json([
            'success' => false,
            'message' => 'Sorry, category with id ' . $id . ' cannot be found.'
        ], 400);
    }

     $category->name = $request->name;
     $updated = $category->save();

    if ($updated) {
        return response()->json([
            'success' => true
        ],200);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Sorry, category could not be updated.'
        ], 500);
    }
}


/**
 * @param $id
 * @return \Illuminate\Http\JsonResponse
 */
public function destroy($id)
{
    $category = $this->user->categories()->find($id);

    if (!$category) {
        return response()->json([
            'success' => false,
            'message' => 'Sorry, category with id ' . $id . ' cannot be found.'
        ], 400);
    }

    if ($category->delete()) {
        return response()->json([
            'success' => true
        ],200);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'category could not be deleted.'
        ], 500);
    }
}




}
