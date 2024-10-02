<?php namespace Apptest\Test\Models;

use Model;

/**
 * Test Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class Test extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table name
     */
    public $table = 'apptest_test_tests';

    /**
     * @var array rules for validation
     */
    public $rules = [];
}
