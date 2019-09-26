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
          $user_id = User::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'address' => $request->address,
          ]);
          if($user_id){
             booking::create([
                'user_id'        => $user_id->id,
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
  public function cancel_booking(Request $request){
    $status = 100;
      try {
          // validate code
          $validator = Validator::make($request->all(), [
              'user_id'        => 'required|numeric',
              'reference_code' => 'required|exists:bookings,reference_code'
            ]);
          if ($validator->fails()) {
              return \Response::json(['status' => false, 'errors' => $validator->errors() ],406);
          }  
          // end validation 
          if(booking::where(['user_id' => $request->user_id,'reference_code' => $request->reference_code])->get()->count() == 1){
            if(booking::where(['reference_code' => $request->reference_code])->update([
                'status' => 'cancel'
             ])){
                return \Response::json(['status' => true],200);              
            }
         }
         return \Response::json(['status' => false ],406);
      } catch (Exception $e) {
          $status =   $e->getMessage();
      }
      return $status;
  }
  public function list_booking(Request $request){
      $status = 100;
      try {
             return \Response::json(['status' => true, 'response' => booking::join('users','users.id', '=' , 'bookings.user_id')->join('car_types','car_types.id', '=' , 'bookings.car_type_id')->get(['bookings.id as id','users.name as name','car_types.name as car_type','bookings.status','bookings.reference_code','bookings.created_at','bookings.updated_at'])],200);              
      } catch (Exception $e) {
          $status =   $e->getMessage();
      }
      return $status; 
  }
  public function accept_booking(Request $request){
    $status = 100;
      try {
          // validate code
          $validator = Validator::make($request->all(), [
              'user_id'        => 'required|numeric',
              'reference_code' => 'required|exists:bookings,reference_code'
            ]);
          if ($validator->fails()) {
              return \Response::json(['status' => false, 'errors' => $validator->errors() ],406);
          }  
          // end validation 
          if(booking::where(['user_id' => $request->user_id,'reference_code' => $request->reference_code])->get()->count() == 1){
            if(booking::where(['reference_code' => $request->reference_code])->update([
                'status' => 'accepted'
             ])){
                return \Response::json(['status' => true],200);              
            }
         }
         return \Response::json(['status' => false ],406);
      } catch (Exception $e) {
          $status =   $e->getMessage();
      }
      return $status;
  }
}
