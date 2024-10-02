<?php
namespace AppChat\Chat\Models;

use AppUser\User\Models\User;
use Model;
use System\Models\File;

/**
 * Message Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class Message extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table name
     */
    public $table = 'appchat_chat_messages';

    protected $fillable = ['chat_id', 'sender_id', 'text', 'file', 'parent_message_id'];

    public $timestamps = true;

    // Define the relationship with the chat this message belongs to
    public $belongsTo = [
        'chat' => [Chat::class],
        'sender' => [User::class, 'key' => 'sender_id']
    ];

    // Each message can have many replies (self-referencing)
    public $hasMany = [
        'replies' => [Message::class, 'key' => 'parent_message_id'],
    ];

    public $belongsToMany = [
        'reactions' => Reaction::class
    ];

    public $attachOne = [
        'attachment' => [File::class, 'public' => false]
    ];

    // Check if a message has a file
    public function hasFile()
    {
        return !empty($this->file);
    }
    /**
     * @var array rules for validation
     */
    public $rules = [];
}
