<?php

namespace App\Http\Controllers;

use App\DirectMessage;
use App\User;
use Illuminate\Http\Request;

class DirectMessageController extends Controller
{
	public function index()
	{
		$id = auth()->id();
		/*return DirectMessage::selectRaw("DISTINCT
(CASE WHEN user_id_from = 2 THEN user_id_to ELSE user_id_from END) user_id,
(SELECT name FROM users WHERE id = user_id) user_name,
(SELECT body FROM direct_messages
WHERE (user_id_from = 2 AND user_id_to = user_id) OR (user_id_from = user_id AND user_id_to = 2)
ORDER BY id DESC LIMIT 1) last_body,
(SELECT created_at FROM direct_messages WHERE body = last_body) created_at", [$id, $id, $id])->get();*/

		return DirectMessage::whereRaw('id IN (SELECT max(id) max FROM direct_messages WHERE user_id_from = ? OR user_id_to = ?
		GROUP BY (CASE WHEN user_id_from = ? THEN user_id_to ELSE user_id_from END)) ORDER BY created_at DESC', [$id, $id, $id])->get();
	}

	public function store(User $user)
	{
		$this->validate(request(), [
			'body' => 'required'
		]);

		if ($user->id === auth()->id()) {
			abort(403, 'You cannot send a message to yourself');
		}

		$message = [
			'body' => request('body'),
			'user_id_from' => auth()->id(),
			'user_id_to' => $user->id
		];

		DirectMessage::create($message);

		return response(['status' => 'Message sent']);
	}

	public function show(User $user)
	{
		$loggedId = auth()->id();
		return DirectMessage::whereRaw("(user_id_from = ? AND user_id_to = ?)
		OR (user_id_from = ? AND user_id_to = ?)", [$loggedId, $user->id, $user->id, $loggedId])->get();
	}
}
