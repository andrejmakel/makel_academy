<?php
namespace AppChat\Chat\Models;

use AppUser\User\Models\User;
use Model;

/**
 * Chat Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class Chat extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table name
     */
    public $table = 'appchat_chat_chats';

    protected $fillable = ['name', 'user_one_id', 'user_two_id'];

    public $timestamps = true;

    // Relationships 
    public $belongsToMany = [
        'users' => User::class
    ];

    // Each chat has many messages
    public $hasMany = [
        'messages' => [Message::class]
    ];

    // Check if a user is part of this chat
    public function isUserInChat($userId)
    {
        return $this->user_one_id == $userId || $this->user_two_id == $userId;
    }

    public function userIsParticipant($userId)
    {
        return $this->users()->where('user_id', $userId)->exists();
    }

    /**
     * @var array rules for validation
     */
    public $rules = [];
}
