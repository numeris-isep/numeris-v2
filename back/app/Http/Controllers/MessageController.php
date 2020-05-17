<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MessageRequest;
use App\Models\Message;
use App\Http\Resources\MessageResource;
use Illuminate\Http\JsonResponse;

class MessageController extends Controller
{
    public function index()
    {
        return response()->json(MessageResource::collection(Message::all()));
    }

    public function store(MessageRequest $request)
    {
        $message = Message::create(
            $request->only(['title','content'])
        );

        return response()->json(MessageResource::make($message), JsonResponse::HTTP_CREATED);
    }

    public function update(MessageRequest $request,$message_id)
    {
        $message = Message::findOrFail($message_id);
        $message->update($request->only(['title','content']));

        return response()->json(MessageResource::make($message), JsonResponse::HTTP_CREATED);
    }


    public function destroy($message_id)
    {
        $message = Message::findOrFail($message_id);
        $message->delete();

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
