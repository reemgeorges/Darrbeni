<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationRespurce;
use App\Models\Notification;
use Kutia\Larafirebase\Facades\Larafirebase;
use Ramsey\Uuid\Uuid;


class NotificationController extends Controller
{

    use JsonResponse;
    public function sendNotification(Request $request)
{
    $uuid = Uuid::uuid4()->toString();
    
    $request->validate([
        'title' => 'required',
        'message' => 'required'
    ]);

    Notification::create([
        'uuid' => $uuid,
        'title' => $request->title,
        'body' => $request->message
    ]);

    try {
        $fcmTokens = User::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();

        // Send the push notification
        Larafirebase::withTitle($request->title)
            ->withBody($request->message)
            ->sendMessage($fcmTokens);

        // Save the title and message to the database
        

        return $this->successResponse('Notification Sent Successfully!');
    } catch (\Exception $e) {
        report($e);
        return $this->errorResponse('Error, Something went wrong while sending the notification.');
    }
}

    public function updateToken(Request $request){

         
        try{
            $request->user()->update(['fcm_token'=>$request->token]);
            return response()->json([
                'success'=>true
            ]);
        }catch(\Exception $e){
            report($e);
            return response()->json([
                'success'=>false
            ],500);
        }
    }

    public function getnotifications(){
        $all=Notification::all();

        return $this->successResponse('all notifications',NotificationRespurce::collection($all));
    }
}
