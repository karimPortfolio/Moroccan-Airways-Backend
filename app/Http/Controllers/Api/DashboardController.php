<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function numberBooks($user_id)
    {
        $numBooks = UserReservation::where("user_id" , $user_id)->count();
        return response()->json($numBooks);
    }

    public function moneySpending($user_id)
    {
        $numBooks = UserReservation::where("user_id" , $user_id)->count();
        if ($numBooks > 0)
        {
            $moneyPremuimSpend = DB::select("SELECT SUM(flights.pricePremuim) AS total_premuim FROM flights , user_reservations WHERE flights.id = user_reservations.flight_id AND user_reservations.class = 'Premium' AND user_reservations.user_id = $user_id");
            if ($moneyPremuimSpend[0]->total_premuim == NULL)
            {
                $moneyPremuimSpend[0]->total_premuim = 0;
            }
            $moneyEconomySpend = DB::select("SELECT SUM(flights.pricePremuim) AS total_economy FROM flights , user_reservations WHERE flights.id = user_reservations.flight_id AND user_reservations.class = 'Economy' AND user_reservations.user_id = $user_id");
            if ($moneyEconomySpend[0]->total_economy == NULL)
            {
                $moneyEconomySpend[0]->total_economy = 0;
            }
            $totalExtras = DB::select("SELECT SUM(extras) AS total_extras FROM user_reservations WHERE user_id = 40");
            if ($totalExtras[0]->total_extras == NULL)
            {
                $totalExtras[0]->total_extras = 0;
            }
            $totalSpends = intval($moneyEconomySpend[0]->total_economy) + intval($moneyPremuimSpend[0]->total_premuim) + intval($totalExtras[0]->total_extras);
            return response()->json($totalSpends);
        }

        return response()->json(0);

    }

}
