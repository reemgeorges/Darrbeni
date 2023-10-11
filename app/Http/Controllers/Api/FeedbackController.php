<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    use JsonResponse;

    public function store(Request $request){
        $feedback=Feedback::create([
            'user_id'=>Auth::id(),
            'feedback_content'=>$request->feedback_content
        ]);
        return $this->successResponse('Created Feedback Successfully');
    }
}
