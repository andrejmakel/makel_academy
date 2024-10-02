<?php
namespace AppUser\User\Models;

use AppChat\Chat\Models\Chat;
use AppChat\Chat\Models\Message;
use AppChat\Chat\Models\Reaction;
use AppLogger\Logger\Models\Log;
use October\Rain\Auth\Models\User as AuthUser;
use Illuminate\Support\Facades\Hash;
use October\Rain\Database\Model;

/**
 * User Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class User extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table name
     */
    public $table = 'appuser_user_users';

    // Define the hasMany relationship
    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    // A user can have multiple chats as user_one
    public $hasMany = [
        'messages' => [Message::class, 'key' => 'sender_id'],
        'reactions' => [Reaction::class, 'key' => 'user_id']
    ];

    public $belongsToMany = [
        'chats' => Chat::class
    ];

    // Helper method to get all chats the user is involved in
    public function allChats()
    {
        return $this->chatsAsUserOne->merge($this->chatsAsUserTwo);
    }

    protected $fillable = ['username', 'password', 'token'];

    protected $hidden = ['password'];

    public $rules = [
        'username' => 'required|unique:appuser_users',
        'password' => 'required|min:6',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
