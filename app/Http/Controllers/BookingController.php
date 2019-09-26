<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingValidation;

use Exception;
use Validator;

use App\User;
use App\booking;

class BookingController extends Controller
{
  public function create_booking(BookingValidation $request){
      $status = 100;
        try {
         $query = user::where(['email' => $request->email])->get(); 
        if($query->count() == 1){
            $user_id = $query->first()->id; 
          }else{
            $user_id = User::create([
              'name'    => $request->name,
              'email'   => $request->email,
              'address' => $request->address,
            ]);
            $user_id = $user_id->id;
          }
          if($user_id){
             booking::create([
                'user_id'        => $user_id,
                'car_type_id'    => $request->car_type,
                'status'         => 'pending',
                'reference_code' => str_shuffle($request->name).strtotime(\Carbon\Carbon::now())
             ]);
            return 200;
          }
        } catch (Exception $e) {
            $status =   $e->getMessage();
        }

        return $status;
  }
}
