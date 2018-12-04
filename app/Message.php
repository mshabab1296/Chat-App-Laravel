<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
	public $timestamps = false;
    public static function getChatBetween($user1, $user2)
    {
    	return Message::where([['from', $user1], ['to', $user2]])->orWhere([['from', $user2], ['to', $user1]]);
    }
}
