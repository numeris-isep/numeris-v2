<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MessageRequest;
use App\Http\Requests\UpdateMessageActivationRequest;
use App\Models\Message;
use App\Http\Resources\MessageResource;
use Illuminate\Http\JsonResponse;

class MessageController extends Controller
{
    public function index()
    {
        $this->authorize('index', Message::class);

        return response()->json(MessageResource::collection(Message::all()));
    }

    public function current()
    {
        $this->authorize('current', Message::class);

        return response()->json(MessageResource::make(Message::active()->first()));
    }

    public function store(MessageRequest $request)
    {
        $this->authorize('store', Message::class);
        $message = Message::create(array_merge(
            $request->only(['title', 'content', 'link']),
            ['is_active' => false]
        ));

        return response()->json(MessageResource::make($message), JsonResponse::HTTP_CREATED);
    }

    public function update(MessageRequest $request,$message_id)
    {
        $message = Message::findOrFail($message_id);
        $this->authorize('update', $message);
        $message->update($request->only(['title', 'content', 'link']));

        return response()->json(MessageResource::make($message), JsonResponse::HTTP_CREATED);
    }

    public function updateActivated(UpdateMessageActivationRequest $request, $message_id)
    {
        $message = Message::findOrFail($message_id);
        $this->authorize('updateActivated', $message);

        Message::active()->update(['is_active' => false]);
        $message->update(['is_active' => $request['is_active']]);

        return response()->json(MessageResource::make($message), JsonResponse::HTTP_CREATED);
    }


    public function destroy($message_id)
    {
        $message = Message::findOrFail($message_id);
        $this->authorize('destroy', $message);
        $message->delete();

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
