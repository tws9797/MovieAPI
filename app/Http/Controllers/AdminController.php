<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Bouncer;
use App\User;

class AdminController extends Controller
{
    public function assign(Request $request){
      $user = User::find($request->user_id);
      Bouncer::assign('admin')->to($user);
      Bouncer::retract('member')->from($user);
      return response()->json([
        'message' => 'The roles have been assigned successfully',
      ], 201);
    }

    public function retract(Request $request){
      $user = User::find($request->user_id);
      Bouncer::assign('member')->to($user);
      Bouncer::retract('admin')->from($user);
      return response()->json([
        'message' => 'The roles have been retracted successfully',
      ], 201);
    }
}
