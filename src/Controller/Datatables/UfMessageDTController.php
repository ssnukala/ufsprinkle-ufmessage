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


	public function addTypeFilter($dtprop)
	{
		$types = ['PAY||ENR' => 'Payment', 'CRUD' => 'Update', 'OTH' => 'Other'];

		$filter2['options'] = $types;
		$filter2['type'] = 'select';
		$filter2['id'] = 'ufmesg_type_i';
		$filter2['label'] = 'Type';
		$filter2['name'] = 'type';
		$filter2['value'] = 'PAY||ENR';
		$filter2['data-source'] = 'row.type';
		$filter2['class'] = "form-control js-select2 input-sm";

		//$dtprop['filters']['url'] = $dtprop['ajax_url'];
		$dtprop['filters']['fields'][] = $filter2;
		return $dtprop;
	}

	public function addStatusFilter($dtprop)
	{
		$status = ['A' => 'Active', 'R' => 'Archived'];

		$filter2['options'] = $status;
		$filter2['type'] = 'select';
		$filter2['id'] = 'ufmesg_status_i';
		$filter2['label'] = 'Status';
		$filter2['name'] = 'status';
		$filter2['value'] = 'A';
		$filter2['data-source'] = 'row.status';
		$filter2['class'] = "form-control js-select2 input-sm";

		$dtprop['filters']['url'] = $dtprop['ajax_url'];
		$dtprop['filters']['title'] = 'Filters';
		$dtprop['filters']['fields'][] = $filter2;
		// pre draw filter is removed, implemented logic to get filter data in the datatable_utl.js just 
		// before the Ajax call.

		//Debug::debug("Line 38 returning dtprop from filters", $dtprop);
		return $dtprop;
	}

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
		$dtprop['filters']['fields'] = [];
		$dtprop = $this->addStatusFilter($dtprop);
		$dtprop = $this->addTypeFilter($dtprop);
		//Debug::debug("Line 77 dtprops UfMessageDTController ", $dtprop);
		$dtprop['createdRow'] = 'genericCreatedRow';

		$newproperties = array_merge($dtprop, $properties);
		parent::setupDatatable($newproperties);
	}

	public function getDatatableArray()
	{
		$retarr =  parent::getDatatableArray();
		//Debug::debug("Line 86 returning the datatable array ", $retarr);
		return $retarr;
	}

	public function setControlBarOptions()
	{
		$ctlprop = [
			'schema' => 'schema://datatable/ufmessage-control.yaml',
			"ajax_url" => "/api/ufmessage/dt2",
			'newrow_template' => '',
			'tableclass' => 'table-condensed',
			'rowclass' => 'uf_message_row'
		];
		$ctlprop['formatters'] = [
			"tables/formatters/ufmessage_body-control.html.twig"
		];

		$this->setupDatatable($ctlprop);
	}

	public function getList($request, $response, $args)
	{
		$this->setSprunje($request, $response, $args);
		$params = $request->getQueryParams();
		if (count($params) > 0) {
			$args = array_merge($params, $args);
		}
		//Debug::debug("Line 115 args array is  ", $args);

		$this->sprunje->extendQuery(function ($query) use ($args) {
			if (isset($args['user_id'])) {
				if ($args['user_id'] == 'current') {
					$currentUser = $this->ci->currentUser;
					$args['user_id'] = $currentUser->id;
					//$query->where('status', 'A');
				}
				$query->where('user_id', $args['user_id']);
				//Debug::debug("Line 126 args user id  args 'user_id' - " . $args['user_id'], $args);
			}
			if (isset($args['status'])) {
				$query->where('status', $args['status']);
			}
			return $query;
		});

		return $this->sprunje->toResponse($response);
	}
}
