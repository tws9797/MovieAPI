<?php

namespace App\Http\Controllers;

use App\Model\Movie;
use Illuminate\Http\Request;
use App\Http\Resources\Movie\MovieResource;
use App\Http\Resources\Movie\MovieCollection;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->input('name');
        $year = $request->input('year');
        $director = $request->input('director');
        $actor = $request->input('actors');

        $movies = Movie::with(['actors', 'director'])
          ->whereHas('actors', function($query) use($actor){
            return $query->where('name', 'like', "%$actor%");
          })
          ->whereHas('director', function($query) use($director){
            return $query->where('name', 'like', "%$director%");
          })
          ->when($year, function($query) use($year){
            return $query->where('year', $year);
          })
          ->when($name, function($query) use($name){
            return $query->where('name', 'like', "%$name%");
          })
          ->orderBy('id', 'asc')
          ->paginate(10);

          return new MovieCollection($movies);
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
        try{
          $movie = new Movie;
          $movie->fill($request->all());
          $movie->saveOrFail();

          $movie->actors()->sync($request->actors);

          return response()->json([
            'id' => $movie->id,
            'created_at' => $movie->created_at
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
     * @param  \App\Model\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
          $movie = Movie::with(['actors', 'director'])->find($id);
          if(!$movie) throw new ModelNotFoundException;

          return new MovieResource($movie);
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
     * @param  \App\Model\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
          $movie = Movie::find($id);
          if(!$movie) throw new ModelNotFoundException;

          $movie->fill($request->all());

          $movie->saveOrFail();

          $movie->actors()->sync($request->actors);

          return response()->json(null, 204);
        }
        catch(ModelNotFoundException $ex){
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
     * @param  \App\Model\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      try{
        $movie = Movie::find($id);

        if(!$movie) throw new ModelNotFoundException;

        $movie->delete();

        return response()->json(null, 204);
      }
      catch(ModelNotFoundException $ex){
        return response()->json([
            'message' => $ex->getMessage(),
        ], 404);
      }
    }
}
