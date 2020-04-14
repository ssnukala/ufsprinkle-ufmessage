<?php

/**
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/licenses/UserFrosting.md (MIT License)
 */

namespace UserFrosting\Sprinkle\UfMessage\Controller\CRUD;

use Psr\Http\Message\ServerRequestInterface as Request;
use UserFrosting\Sprinkle\CRUD\Controller\CRUDController;
use UserFrosting\Sprinkle\Core\Facades\Debug;
use UserFrosting\Sprinkle\UfMessage\Controller\Datatables\UfMessageDTController;

/**
 * Controller class for model-related requests, including listing models, CRUD for models, etc.
 *
 * @author Srinivas Nukala
 */

class UfMessageCRUDController extends CRUDController
{
    protected $crud_name = 'UF Message';

    protected $model_name = 'message';
    /**
     * The child classes will set the options here
     */
    public function setCRUDOptions()
    {
        $lcmodel = strtolower($this->model_name);
        $ucmodel = strtoupper($this->model_name);
        $options = [];
        $options['params_schema'] = "schema://requests/$lcmodel/get-by-id.yaml";

        $options['create'] = [
            'mappedClass' => 'uf_' . $lcmodel,
            'role' => 'cu_create_uf_' . $lcmodel,
            'data_schema' => [
                ['schema' => "schema://requests/$lcmodel/create.yaml", 'prefix' => $lcmodel],
            ],
            'success' => $ucmodel . '.CREATION_SUCCESSFUL',
            'failure' => $ucmodel . '.CREATION_FAILED',
            'logType' => $lcmodel . '_create',
            'form' => [
                "id" => $lcmodel . '_create',
                "source" => $lcmodel,
                "type" => 'form',
                "class" => 'hide-label',
                "title" => $ucmodel . ".ADD_NEW_" . $ucmodel,
                "submit_button" => "Submit",
                "method" => "POST",
                "action" => "/api/ufmessage",
                "fields" => '',
                "fieldsPerRow" => 2,
                "validators" => '',
                'options' => ['show_delete' => 'Y', 'show_buttons' => 'Y']
            ],
        ];
        $options['update'] = [
            'mappedClass' => 'uf_' . $lcmodel,
            'role' => 'cu_update_uf_' . $lcmodel,
            'data_schema' => [
                ['schema' => "schema://requests/$lcmodel/create.yaml", 'prefix' => $lcmodel]
            ],
            'field_schema' => "schema://requests/$lcmodel/field-edit.yaml",
            'success' => $ucmodel . '.UPDATE_SUCCESSFUL',
            'failure' => $ucmodel . '.UPDATE_FAILED',
            'logType' => 'uf_update_' . $lcmodel,
            'form' => [
                "id" => $lcmodel . '_update',
                "type" => 'form',
                "source" => $lcmodel,
                "class" => 'hide-label',
                "title" => $ucmodel . ".UPDATE_" . $ucmodel,
                "submit_button" => "Submit",
                "method" => "PUT",
                "action" => "/api/ufmessage/r/{row.id}",
                "fields" => '',
                "fieldsPerRow" => 2,
                "validators" => '',
                'options' => ['show_delete' => 'Y', 'show_buttons' => 'Y']

            ],
        ];
        $options['list'] = [
            'sprunje' => $lcmodel . '_sprunje',
            'role' => 'cu_list_uf_' . $lcmodel,
        ];
        $options['info'] = [
            'mappedClass' => 'uf_' . $lcmodel,
            'id' => $lcmodel . '_id',
            'role' => 'cu_info_uf_' . $lcmodel,
        ];

        $this->crud_options = $options;
        //        Debug::debug("Line 74 in model setOptions function ", $this->crud_options);

    }

    public function getCRUDPageParams()
    {
        $params = parent::getCRUDPageParams();
        $params['hasgeocode'] = 'N';
        return $params;
    }

    /**
     * Renders the Listing Datatable Object 
     *
     */
    public function setupListData()
    {
        $dtcontroller = new UfMessageDTController($this->ci);
        $return = ['dtcontroller' => $dtcontroller, 'params' => $this->getCRUDPageParams()];
        return $return;
    }

    public function mapClass($data)
    {
        /** @var UserFrosting\Sprinkle\Core\Util\ClassMapper $classMapper */
        $classMapper = $this->ci->classMapper;
        //Debug::debug("Line 68 data is  set", $data);
        if (isset($data['user_id'])) {
            $return = $classMapper->staticMethod('uf_message', 'where', 'user_id', $data['user_id'])->get();
        } else if (isset($data['message_id'])) {
            $return = $classMapper->staticMethod('uf_message', 'where', 'id', $data['message_id'])->get();
        } else {
            // Get the product
            $return = $classMapper->staticMethod('uf_message', 'where', 'status', 'A')->get();
        }
        //        Debug::debug("Line 72 returning product catalog data ", $return->toArray());
        return $return;
    }
}
