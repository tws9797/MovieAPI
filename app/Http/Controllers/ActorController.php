<?php

namespace App\Http\Controllers;

use App\Model\Actor;
use Illuminate\Http\Request;
use App\Http\Requests\ActorRequest;
use App\Http\Resources\Actor\ActorResource;
use App\Http\Resources\Actor\ActorCollection;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $name = $request->input('name');

      $actors = Actor::with('movies')
        ->when($name, function($query) use($name){
          return $query->where('name', 'like', "%$name%");
        })
        ->paginate(10);

      return new ActorCollection($actors);
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
    public function store(ActorRequest $request)
    {
        try{
          $actor = new Actor;
          $actor->fill($request->all());

          $actor->saveOrFail();

          $actor->movies()->sync($request->movies);

          return response()->json([
            'id' => $actor->id,
            'created_at' => $actor->created_at
          ], 201);
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
     * Display the specified resource.
     *
     * @param  \App\Model\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
          $actor = Actor::with('movies')->find($id);

          if(!$actor) throw new ModelNotFoundException;

          return new ActorResource($actor);
        }
        catch(ModelNotFoundException $ex){
          return response()->json([
            'message' => $ex->getMessage(),
          ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function edit(Actor $actor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function update(ActorRequest $request, $id)
    {
        try{
          $actor = Actor::find($id);

          if(!$actor) throw new ModelNotFoundException;

          $actor->fill($request->all());

          $actor->saveOrFail();

          return response()->json(null, 204);
        }
        catch(ModelNotFoundException $ex) {
            return response()->json([
                'message' => $ex->getMessage(),
            ], 404);
        }
        catch(QueryException $ex) {
            return response()->json([
                'message' => $ex->getMessage(),
            ], 500);
        }
        catch(\Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      try{
        $actor = Actor::find($id);

        if(!$actor) throw new ModelNotFoundException;

        $actor->delete();

        return response()->json(null, 204);
      }
      catch(ModelNotFoundException $ex){
        return response()->json([
            'message' => $ex->getMessage(),
        ], 404);
      }
    }
}
