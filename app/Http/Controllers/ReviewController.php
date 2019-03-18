<?php

namespace App\Http\Controllers;

use App\Model\Review;
use Illuminate\Http\Request;
use App\Http\Resources\Review\ReviewResource;
use App\Http\Resources\Review\ReviewCollection;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $star = $request->input('star');
      $plot = $request->input('plot');

      $reviews = Review::when($star, function($query) use($star){
        return $query->where('star', $star);
      })->when($plot, function($query) use($plot){
        return $query->where('plot', 'like', "%$plot%");
      })->paginate(10);

      return new ReviewCollection($reviews);
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
    public function store(ReviewRequest $request)
    {
        try{
          $review = new Review;
          $request['user_id'] = $request->user()->id;
          $review->fill([$request->all()]);
          $review->saveOrFail();

          return response()->json([
            'id' => $review->id,
            'created_at' => $review->created_at
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
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      try{
        $review = Review::findOrFail($id);
        if(!$review) throw ModelNotFoundException;

        return new ReviewResource($review);
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
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(ReviewRequest $request, $id)
    {
        try{
          $review = Review::findOrFail($id);
          if(!$review) return ModelNotFoundException;
          else if($request->user()->id !== $review->user_id){
            return response()->json(['error' => 'You can only edit your own review.'], 403);
          }

          $review->fill($request->all());
          $review->saveOrFail();
          return response()->json(null, 204);
        }
        catch(ModelNotFoundException $ex){
          return response()->json([
            'message' => $ex->getMessage()
          ]);
        }
        catch(QueryException $ex){
          return response()->json([
            'message' => $ex->getMessage()
          ]);
        }
        catch(\Exception $ex){
          return response()->json([
            'message' => $ex->getMessage()
          ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
      try{
        $review = Review::findOrFail($id);
        if(!$review) return ModelNotFoundException;
        else if($request->user()->id !== $review->user_id){
          return response()->json(['error' => 'You can only edit your own review.'], 403);
        }

        $review->delete();
        return response()->json(null, 204);
      }
      catch(ModelNotFoundException $ex){
        return response()->json([
          'message' => $ex->getMessage()
        ]);
      }
    }
}
