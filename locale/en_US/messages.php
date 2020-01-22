<?php

/**
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/licenses/UserFrosting.md (MIT License)
 *
 * US English message token translations for the 'RegSevak' sprinkle.
 *
 * @package userfrosting\i18n\en_US
 * @author Alexander Weissman
 */

use UserFrosting\Sprinkle\CRUD\Controller\CRUDUtilityController as CRUDUtil;

$lModels = [
    'uf_message' => 'UfMessage'
];

$languageArr = [];
$languageArr = CRUDUtil::getUSLanguageArr($lModels);

return $languageArr;
