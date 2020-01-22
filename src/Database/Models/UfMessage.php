<?php

/**
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/licenses/UserFrosting.md (MIT License)
 */

namespace UserFrosting\Sprinkle\UfMessage\Database\Models;

use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\SoftDeletes;
use UserFrosting\Sprinkle\Core\Database\Models\Model;
use UserFrosting\Sprinkle\Core\Facades\Debug;

/**
 * UF Message Model Class
 * *
 * @author Srinvas Nukala (https://srinivasnukala.com)
 * @property there is a huge list
 */
class UfMessage extends Model
{
    use SoftDeletes;

    /**
     * The name of the table for the current model.
     *
     * @var string
     */
    protected $table = 'uf_message';

    /**
     * Fields that should be mass-assignable when creating a new User.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id', 'event', 'type', 'message_date', 'subject', 'from', 'to', 'cc', 'bcc', 'body',
        'attachment', 'visible', 'notification', 'status'
    ];

    /**
     * A list of attributes to hide by default when using toArray() and toJson().
     *
     * @link https://laravel.com/docs/5.4/eloquent-serialization#hiding-attributes-from-json
     * @var string[]
     */
    protected $hidden = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var string[]
     */
    protected $dates = ['message_date'];

    /**
     * Enable timestamps for Users.
     *
     * @var bool
     */

    public $timestamps = true;
}
