<?php
namespace AppChat\Chat\Models;

use AppUser\User\Models\User;
use Model;

/**
 * Reaction Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class Reaction extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table name
     */
    public $table = 'appchat_chat_reactions';

    protected $fillable = ['message_id', 'user_id', 'emoji'];

    public $timestamps = true;

    public $belongsToMany = [
        'messages' => Message::class
    ];

    /**
     * @var array rules for validation
     */
    public $rules = [];
}
