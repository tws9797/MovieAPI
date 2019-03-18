<?php
namespace App\Http\Controllers;
use App\Model\Review;
use App\Model\Movie;
use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\Review\ReviewResource;
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
      })->get();
      return ReviewResource::collection($reviews);
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
    public function store(ReviewRequest $request, Movie $movie)
    {
        try{
          $review = new Review;
          $review->fill(array_merge($request->all(), ['user_id' => $request->user()->id]));
          $movie->reviews()->save($review);
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
    public function show($movieId, $id)
    {
      try{
        $reviewFound = Review::findOrFail($id);
        if(!$reviewFound) throw ModelNotFoundException;
        return new ReviewResource($reviewFound);
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
    public function update(ReviewRequest $request, $movieId, $id)
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
    public function destroy(Request $request, $movieId, $id)
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
