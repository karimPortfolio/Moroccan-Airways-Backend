<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserReservation;
use App\Models\Flight;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = UserReservation::all();
        return $reservations;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $add_reser = new UserReservation();
        $add_reser->title  = $request->title;
        $add_reser->name  = $request->name;
        $add_reser->nationality  = $request->nationality;
        $add_reser->passport  = $request->passport;
        $add_reser->countryResidence  = $request->countryResidence;
        $add_reser->email  = $request->email;
        $add_reser->mobile  = $request->mobile;
        $add_reser->passengersAdultes  = $request->passengersAdultes;
        $add_reser->passengersChilds  = $request->passengersChilds;
        $add_reser->class  = $request->class;
        $add_reser->extras  = $request->extras;
        $add_reser->user_id  = $request->user_id;
        $add_reser->flight_id  = $request->flight_id;
        $add_reser->save();
        return response()->json(['message'=>'Reservation success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $reservation = UserReservation::where('email' , $request->email)->get();
        if (count($reservation) !== 0)
        {
            $flights = array();
            for ($i = 0 ; $i < count($reservation) ; $i++)
            {
                $flight =Flight::where('id' , $reservation[$i]->flight_id)->get();
                $todays_date = date('Y-m-d');
                array_push($flights , $flight);
            }
            for ($i = 0;$i < count($flights); $i++)
            {
                if ($reservation[$i]->name == $request->name)
                {
                   return response()->json(['message'=>'Reservation success' , 'reservation'=>$reservation , 'flight'=>$flights]);
                }else{
                     return response()->json(['message'=>'No Reservation Found For This User']);
                }
            }
            //return $flights;
        }else{
            return response()->json(['message'=>'No Reservation Found For This User']);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        UserReservation::where("id" , $id)->delete();
        return response()->json(['message'=>'Reservation deleted with success']);
    }
}
