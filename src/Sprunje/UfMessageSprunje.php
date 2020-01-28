<?php

/**
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/licenses/UserFrosting.md (MIT License)
 */

namespace UserFrosting\Sprinkle\UfMessage\Sprunje;

use Illuminate\Database\Capsule\Manager as Capsule;
use UserFrosting\Sprinkle\Core\Facades\Debug;
use UserFrosting\Sprinkle\Datatables\Sprunje\DatatablesSprunje;

/**
 * RoleSprunje
 *
 * Implements Sprunje for the roles API.
 *
 * @author Srinivas Nukala (https://srinivasnukala.com)
 */
class UfMessageSprunje extends DatatablesSprunje
{
    protected $name = 'uf_message';

    protected $sortable = [
        'id', 'message_date', 'body'
    ];

    protected $filterable = [
        'to', 'body'
    ];

    protected $excludeForAll = [];

    /**
     * {@inheritDoc}
     */
    protected function baseQuery()
    {
        return $this->classMapper->createInstance('uf_message')->newQuery();
    }

    /**
     * Filter LIKE name OR description.
     *
     * @param Builder $query
     * @param mixed $value
     * @return $this
     */
    protected function filterInfo($query, $value)
    {
        // Split value on separator for OR queries
        $values = explode($this->orSeparator, $value);
        $query->where(function ($query) use ($values) {
            foreach ($values as $value) {
                $query->orLike('to', $value)
                    ->orLike('body', $value);
            }
        });
        return $this;
    }
    protected function sortBody($query, $direction)
    {
        $query->orderBy('message_date', $direction);
        return $this;
    }

    protected function applyTransformations($collection)
    {
        return $collection;
    }
}
