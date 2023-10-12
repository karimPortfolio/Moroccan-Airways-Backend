<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationsController extends Controller
{

    public function geUserNotifications($user_id)
    {
        $user = User::find($user_id);
        if ($user)
        {
            $notifications = $user->notifications;
            return response()->json($notifications);
        } else {
            return response()->json(["message" =>"No user found with this id"]);
        }

    }

    public function getUserNotificationsCount($user_id)
    {
        $user = User::find($user_id);
        if ($user)
        {
            $notifications = $user->notifications->where("isSeen" , "false")->count();
            return response()->json($notifications);
        } else {
            return response()->json(["message" =>"No user found with this id"]);
        }
    }


    public function addNotification(Request $request)
    {
        $validator = $request->validate([
              "user_id" => "required | exists:users,id",
              "content" => "required | string",
              "title" => "required | string | max:100",
              "isSeen" => "required | string"
        ]);

        if ($validator)
        {
            Notification::create([
                "user_id" => $request->user_id,
                "content" => $request->content,
                "title" => $request->title,
                "isSeen" => $request->isSeen,
            ]);
            return response()->json(["message" => "Notification created with success"]);
        } else {
            return response()->json(["message" => "Something went wrong when creating notification!"]);
        }
    }


    public function changeNotificationStatus($user_id)
    {
        $matchedNotifications = Notification::where("isSeen" , "false")->where("user_id" , $user_id)->get();
         if ($matchedNotifications)
         {
             foreach ($matchedNotifications as $notify)
             {
                $notify->update([
                    "isSeen" => "true",
                 ]);
             }

             return response()->json(["message" => "Notification seen status has been changed"]);
         }
         return response()->json(["message" => "Something went wrong on changing seen status"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
