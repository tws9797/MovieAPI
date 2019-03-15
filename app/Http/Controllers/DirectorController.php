<?php

namespace App\Http\Controllers;

use App\Model\Director;
use Illuminate\Http\Request;
use App\Http\Requests\DirectorRequest;
use App\Http\Resources\Director\DirectorResource;
use App\Http\Resources\Director\DirectorCollection;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DirectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->input('name');

        $directors = Director::with('movies')
          ->when($name, function($query) use($name){
              return $query->where('name', 'like', "%$name%");
          })
          ->paginate(10);

        return new DirectorCollection($directors);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DirectorRequest $request)
    {
        try{
          $director = new Director;
          $director->fill($request->all());

          $director->saveOrFail();

          return response()->json([
            'id' => $director->id,
            'created_at' => $director->created_at
          ], 201);
        }
        catch(QueryException $ex){
          return response()->json([
            'message' => $ex->getMessage()
          ], 500);
        }
        catch(\Exception $ex){
          return response()->json([
            'message' => $ex->getMessage()
          ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Director  $director
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      try{
        $director = Director::with('movies')->find($id);

        if(!$director) throw new ModelNotFoundException;

        return new DirectorResource($director);
      }
      catch(ModelNotFoundException $ex){
        return response()->json([
          'message' => $ex->getMessage()
        ], 404);
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Director  $director
     * @return \Illuminate\Http\Response
     */
    public function edit(Director $director)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Director  $director
     * @return \Illuminate\Http\Response
     */
    public function update(DirectorRequest $request, $id)
    {
        try{
          $director = Director::find($id);

          if(!$director) throw new ModelNotFoundException;

          $director->fill($request->all());

          $director->saveOrFail();

          return response()->json(null, 204);
        }
        catch(ModelNotFoundException $ex){
          return response()->json([
              'message' => $ex->getMessage(),
          ], 404);
        }
        catch(QueryException $ex){
          return response()->json([
              'message' => $ex->getMessage(),
          ], 500);
        }
        catch(\Exception $ex){
          return response()->json([
              'message' => $ex->getMessage(),
          ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Director  $director
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
          $director = Director::find($id);

          if(!$director) throw new ModelNotFoundException;

          $director->delete();

          return response()->json(null, 204);
        }
        catch(ModelNotFoundException $ex){
          return response()->json([
              'message' => $ex->getMessage(),
          ], 404);
        }
    }
}
