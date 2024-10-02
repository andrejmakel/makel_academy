<?php
namespace AppLogger\Logger\Models;

use AppUser\User\Models\User;
use Model;

/**
 * Log Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class Log extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table name
     */
    public $table = 'applogger_logger_logs';

    // Define the belongsTo relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @var array rules for validation
     */
    public $rules = [];

    protected $fillable = ['arrival', 'username', 'delay'];

    public $timestamps = true;
}
