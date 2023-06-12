<?php

namespace App\Modules\Inboxes\Http\Controllers;

use App\Bootstrap\Http\Controllers\Controller;
use App\Modules\Users\Models\User;
use App\Modules\Inboxes\Models\Inbox;
use App\Modules\Inboxes\Repositories\InboxRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Bootstrap\Traits\SlugMaker;
use App\Modules\Inboxes\Repositories\MessageRepository;

class InboxesController extends Controller
{
    private $inboxRepository;
    private $messageRepository;

    public function __construct(InboxRepository $inboxRepository, MessageRepository $messageRepository)
    {
        $this->inboxRepository = $inboxRepository;
        $this->messageRepository = $messageRepository;
    }

    public function index(User $user)
    {
        $user = auth()->user();

        if (!$user) {
            abort(403);
        }

        $inboxes = $this->inboxRepository->fetchFromUser(
            $user->id,
        );

        return response(
            $inboxes,
            200
        );

    }

    public function getMessages ($inbox){
        $messages = $this->messageRepository->fetchFromInbox($inbox);
        return response(
            $messages,
            200
        );
    }

    public function show ()
    {
        if (!Auth::check()) {
            abort(403,
            "You must be logged in to view your inbox."
            );
        }

        $user = User::where('id', auth()->user()->id)->first();
        $messages = $this->messageRepository->fetchFromInbox($user->inbox()->id);
        return response(
            $messages,
            200
        );
    }

    public function update(Inbox $inbox, Request $request)
    {
        if ($inbox->user_id !== auth()->user()->id) {
            abort(403);
        }

        $inputs = $request->all();

        $this->inboxRepository->update($inbox, $inputs);

        return response(
            json_encode(
                [
                    'message' => 'Inbox updated successfully',
                    'inbox' => $inbox
                ]
            ),
            200
        );
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            abort(403,
            "You must be logged in to create a inbox."
            );
        }
        
        $inputs = $request->all();

        $inputs['user_id'] = auth()->user()->id;

        $inputs['slug'] = SlugMaker::make($inputs['title']);

        $inbox = $this->inboxRepository->create($inputs);

        return response(
            json_encode(
                [
                    'message' => 'Inbox created successfully',
                    'inbox' => $inbox
                ]
            ),
            200
        );
    }

    public function storeMessage (Request $request, $magicLink) {
        $message = $request->all();

        $inbox = Inbox::where('magic_link', $magicLink)->first();

        $message = $this->messageRepository->attachOnInbox($inbox->id, $message);

        return response(
            json_encode(
                [
                    'message' => 'Message created successfully',
                    'message' => $message
                ]
            ),
            200
        );
    }

    public function destroy(Inbox $inbox)
    {
        if (!Auth::check()) {
            abort(403,
            "You must be logged in to delete a inbox."
            );
        }

        if ($inbox->user_id !== auth()->user()->id) {
            abort(403);
        }
        $this->inboxRepository->destroy($inbox);
        return redirect()->back();
    }
}
