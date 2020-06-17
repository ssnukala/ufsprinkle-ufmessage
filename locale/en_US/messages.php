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
//$languageArr = CRUDUtil::getUSLanguageArr($lModels);
$languageArr["UFMESSAGE"] = [
    "1" => "UfMessage",
    "2" => "UfMessages",
    "ADD_NEW_UFMESSAGE" => "Add New UfMessage",
    "CREATE" => "Create UfMessage",
    "CREATED" => "UfMessage for <strong>{{name}}</strong> has been successfully created",
    "CREATION_SUCCESSFUL" => "UfMessage for <strong>{{name}}</strong> has been successfully created",
    "UPDATE_UFMESSAGE" => "Modify UfMessage Record",
    "UPDATED" => "UfMessage updated successfully",
    "UPDATE_SUCCESSFUL" => "UfMessage for <strong>{{name}}</strong> has been successfully updated",
    "DETAILS_UPDATED" => "UfMessage details updated for member <strong>{{name}}</strong>",
    "DELETE" => "Delete UfMessage",
    "DELETE_CONFIRM" => "Are you sure you want to delete : UfMessage <strong>{{name}}</strong>?",
    "DELETE_YES" => "Yes, delete UfMessage",
    "DELETED" => "UfMessage <strong>{{name}}</strong> deleted",
    "DELETION_SUCCESSFUL" => "UfMessage <strong>{{name}}</strong> has been successfully deleted.",
    "DISABLE" => "Disable UfMessage",
    "DISABLE_SUCCESSFUL" => "UfMessage record has been successfully disabled.",
    "DISABLE_FAILED" => "Failed to disable UfMessage record.",
    "EDIT" => "Edit UfMessage",
    "ENABLE" => "Enable UfMessage",
    "ENABLE_SUCCESSFUL" => "UfMessage record has been successfully enabled.",
    "ENABLE_FAILED" => "Failed to enable UfMessage record.",
    "INFO_PAGE" => "UfMessage information page for {{name}}",
    "LATEST" => "Latest UfMessage data",
    "PAGE_DESCRIPTION" => "Provides management tools to manage UfMessage data including the ability to list, edit details, enable/disable, and more.",
    "SUMMARY" => "UfMessage Summary",
    "VIEW_ALL" => "View all UfMessage data",
    "LIST_TITLE" => "UfMessage Records",
    "C" => [
        "ID" => "Id",
        "USER_ID" => "User Id",
        "MESSAGE_DATE" => "Message Date",
        "EXPIRE_DATE" => "Expire Date",
        "TYPE" => "Type",
        "EVENT" => "Event",
        "SUBJECT" => "Subject",
        "FROM" => "From",
        "TO" => "To",
        "CC" => "Cc",
        "BCC" => "Bcc",
        "BODY" => "Body",
        "CONTEXT" => "Context",
        "ATTACHMENT" => "Attachment",
        "VISIBLE" => "Visible",
        "NOTIFICATION" => "Notification",
        "STATUS" => "Status",
        "CREATED_BY" => "Created By",
        "UPDATED_BY" => "Updated By",
        "CREATED_AT" => "Created At",
        "UPDATED_AT" => "Updated At",
        "DELETED_AT" => "Deleted At"
    ]
];


return $languageArr;
