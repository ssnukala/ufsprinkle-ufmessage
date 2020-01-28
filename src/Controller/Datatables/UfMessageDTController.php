<?php

namespace UserFrosting\Sprinkle\UfMessage\Controller\Datatables;

use UserFrosting\Sprinkle\Datatables\Controller\DatatablesController;
use UserFrosting\Sprinkle\UfMessage\Controller\CRUD\UfMessageCRUDController;
use UserFrosting\Sprinkle\Core\Facades\Debug;

/**
 * iListDTDBController
 *
 * @package UserFrosting-RegSevak
 * @author Srinivas Nukala
 * @link http://srinivasnukala.com
 */

class UfMessageDTController extends DatatablesController
{
	protected $sprunje_name = 'uf_message_sprunje';

	public function setupDatatable($properties = [])
	{
		$dtprop = [
			'htmlid' => 'ufmessage_dt_1',
			'schema' => 'schema://datatable/ufmessage.yaml',
			"ajax_url" => "/api/ufmessage/dt",
		];

		$dtprop['filters'] = [];
		$dtprop['formatters'] = [
			"tables/formatters/ufmessage_body.html.twig",
			"tables/formatters/ufmessage_edit.html.twig",
		];
		$dtprop['name'] = 'ufmessage_dt';
		$dtprop['title'] = 'UFMESSAGE.LIST_TITLE';

		$dtprop['crud_success_js'] = 'genericDTCRUDSuccess';
		$dtprop['newrow_template'] = 'partials/newrow.html.twig';

		$crudctrl = new UfMessageCRUDController($this->ci);

		$formArray = $crudctrl->getDTCRUDFormDetails('update', []);
		$formArray['dtid'] = $dtprop['htmlid'];
		$dtprop['crudformid'] = $formArray['id'];

		$formArray2 = $crudctrl->getCRUDFormDetails('create', []);
		$formArray2['dtid'] = $dtprop['htmlid'];
		$dtprop['source'] = $formArray2['source'];
		$dtprop['new_crudformid'] = $formArray2['id'];
		$dtprop['crud_forms'][$dtprop['htmlid']] = [
			'datatable' => $formArray,
			'new' => $formArray2,
		];

		//        Debug::debug("Line 43 the crudforms for datatable are ", $dtprop['crud_forms']);

		$newproperties = array_merge($dtprop, $properties);
		parent::setupDatatable($newproperties);
	}

	public function setControlBarOptions()
	{
		$ctlprop = [
			'schema' => 'schema://datatable/ufmessage-control.yaml',
			"ajax_url" => "/api/ufmessage/dt2",
			'newrow_template' => '',
			'tableclass' => 'table-condensed'
		];
		$ctlprop['formatters'] = [
			"tables/formatters/ufmessage_body-control.html.twig"
		];

		$this->setupDatatable($ctlprop);
	}

	public function getList($request, $response, $args)
	{
		$this->setSprunje($request, $response, $args);

		$this->sprunje->extendQuery(function ($query) use ($args) {
			if (isset($args['user_id'])) {
				if ($args['user_id'] == 'current') {
					$currentUser = $this->ci->currentUser;
					$args['user_id'] = $currentUser->id;
				}
				$query->where('user_id', $args['user_id']);
				Debug::debug("Line 126 args user id  args 'user_id' - " . $args['user_id'], $args);
			}
			return $query;
		});

		return $this->sprunje->toResponse($response);
	}
}
