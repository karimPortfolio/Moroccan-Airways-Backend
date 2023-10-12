<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserReservation;
use App\Models\Flight;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        return $users;
    }


    public function store(Request $request)
    {
        $checkUserExistens = User::where('email' , $request->email)->first();
        if (empty($checkUserExistens) )
        {
                $passwordHashed = Hash::make($request->password);
                $insert = new User();
                $insert->name = $request->name;
                $insert->email = $request->email;
                $insert->password = $passwordHashed;
                $insert->save();
                return response()->json(['message'=>'Your Account successfuly created','user_name' =>$request->name , 'user_email' => $request->email ]);
        }
        else
        {
            return response()->json(['message'=>'This account has already been taken']);
        }
    }


    public function show(Request $request)
    {
        $user = User::where('email' , $request->email)->first();
        $password = $request->password;
        if (!$user || !Hash::check($password, $user->password))
        {
            return response()->json(['message'=>'Email or password not matched']);
        }else{
            return response()->json(['message'=>'Loged successfuly','user'=>$user]);
        }
    }

    public function userReservations($id)
    {
        $user_reservations = DB::select("SELECT DISTINCT user_reservations.* , flights.from , flights.to , flights.dateDepart ,
         flights.HourDepart , flights.airport FROM users , flights , user_reservations
        WHERE user_reservations.user_id = $id AND user_reservations.flight_id = flights.id");
        //return response()->json(['reservation'=>$user_reservation , 'flight'=>$flights]);
        return response()->json(['reservation'=>$user_reservations]);

    }



    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
