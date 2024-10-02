<?php

namespace Appchat\Chat\Http\Controllers;

use Appchat\Chat\Http\Resources\ChatResource;
use Appchat\Chat\Http\Resources\MessageResource;
use Appchat\Chat\Http\Resources\UserResource;
use AppChat\Chat\Models\Chat;
use AppChat\Chat\Models\Message;
use AppChat\Chat\Models\Reaction;
use AppUser\User\Models\User;
use AppUser\User\Services\UserService;
use Illuminate\Http\Request;

class ChatController
{
    public function allUsers()
    {
        return UserResource::collection(User::all());
    }

    public function allChats()
    {
        $userId = UserService::getAuthenticatedUser()->id;

        return ChatResource::collection(Chat::where('user_one_id', $userId)
            ->orWhere('user_two_id', $userId)
            ->get());

    }

    public function openChat(Request $request)
    {
        $validated = $request->validate([
            'chat_id' => 'required|integer',
        ]);

        $user = UserService::getAuthenticatedUser();

        $chat = Chat::find($validated['chat_id']);

        if (!$chat || !$chat->userIsParticipant($user->id)) {
            return response()->json(['error' => 'Chat not found'], 404);
        }

        // Return the conversation using MessageResource
        return MessageResource::collection(
            Message::where('chat_id', $chat->id)
                ->whereNull('parent_message_id')
                ->with(['sender', 'reactions', 'replies'])
                ->get()
        );
    }

    public function create(Request $request)
    {

        $validated = $request->validate([
            'chat_name' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        $chat = new Chat();
        $chat->name = $request->input('chat_name');
        $chat->save();

        $chat->users()->attach($validated['user_id']);
        $chat->users()->attach(UserService::getAuthenticatedUser()->id);

        return response()->json('success');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'chat_id' => 'required|integer',
            'text' => 'nullable|string',
            'file' => 'nullable|file|max:2048',
        ]);

        $user = UserService::getAuthenticatedUser();

        $chat = Chat::find($validated['chat_id']);

        if (!$chat || !$chat->userIsParticipant($user->id)) {
            return response()->json(['error' => 'Chat not found'], 404);
        }

        $message = new Message();
        $message->chat_id = $chat->id;
        $message->sender_id = $user->id;
        $message->text = $validated['text'];
        if ($request->hasFile('file')) {
            $message->attachment = files('file');
        }
        $message->save();

        // Return the conversation using MessageResource
        return MessageResource::collection(
            Message::where('chat_id', $chat->id)
                ->whereNull('parent_message_id')
                ->with(['sender', 'reactions', 'replies'])
                ->get()
        );
    }

    public function react(Request $request)
    {

        $validated = $request->validate([
            'chat_id' => 'required|integer',
            'message_id' => 'required|integer',
            'reaction_id' => 'required|integer',
        ]);

        $user = UserService::getAuthenticatedUser();

        $chat = Chat::find($validated['chat_id']);
        $message = Message::find($validated['message_id']);
        $reaction = Reaction::find($validated['reaction_id']);

        if (!$chat || !$chat->userIsParticipant($user->id)) {
            return response()->json(['error' => 'Chat not found'], 404);
        }
        if (!$message) {
            return response()->json(['error' => 'Message not found'], 404);
        }
        if (!$reaction) {
            return response()->json(['error' => 'Reaction not found'], 404);
        }

        $message->reactions()->attach($validated['reaction_id']);

        // Return the conversation using MessageResource
        return MessageResource::collection(
            Message::where('chat_id', $chat->id)
                ->whereNull('parent_message_id')
                ->with(['sender', 'reactions', 'replies'])
                ->get()
        );
    }

    public function reply(Request $request)
    {
        $validated = $request->validate([
            'chat_id' => 'required|integer',
            'message_id' => 'required|integer',
            'reply' => 'nullable|string',
        ]);

        $user = UserService::getAuthenticatedUser();

        $chat = Chat::find($validated['chat_id']);
        $message = $chat->messages()->find($validated['message_id']);
        // $message = Message::find($validated['message_id']);

        if (!$chat || !$chat->userIsParticipant($user->id)) {
            return response()->json(['error' => 'Chat not found'], 404);
        }
        if (!$message) {
            return response()->json(['error' => 'Message not found'], 404);
        }

        $reply = $chat->messages()->make();
        // $reply = new Message()
        // $reply->chat_id = $chat->id;
        $reply->sender_id = $user->id;
        $reply->text = $validated['reply'];
        $reply->parent_message_id = $message->id;
        $reply->save();

        // Return the conversation using MessageResource
        return MessageResource::collection(
            Message::where('chat_id', $chat->id)
                ->whereNull('parent_message_id')
                ->with(['sender', 'reactions', 'replies'])
                ->get()
        );
    }

}