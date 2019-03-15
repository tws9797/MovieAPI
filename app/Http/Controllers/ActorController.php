<?php

namespace App\Http\Controllers;

use App\Model\Actor;
use Illuminate\Http\Request;
use App\Http\Resources\Actor\ActorResource;
use App\Http\Resources\Actor\ActorCollection;

class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return new ActorCollection(Actor::paginate(5));
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
    public function store(Request $request)
    {
        $movie = Movie::create($request->all());

        return response()->json([
          'id' => $movie->id,
          'created_at' => $movie->created_at
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $actor = Actor::find($id);

        if(!$actor){
          return response()->json([
              'error' => 404,
              'message' => 'Not found'
          ], 404);
        }

        return new ActorResource($actor);
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
    public function update(Request $request, $id)
    {
        $actor = Actor::find($id);

        if(!$actor){
          return response()->json([
            'error' => 404,
            'message' => 'Not found'
          ]);
        }

        $actor->update($request->all());

        return response()->json(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $actor = Actor::find($id);

      if(!$actor){
        return response()->json([
          'error' => 404,
          'message' => 'Not found'
        ]);
      }

      $actor->delete();

      return response()->json(null, 204);
    }
}
