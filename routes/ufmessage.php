<?php

/**
 * Routes for administrative user management.  Overrides routes defined in routes://users.php
 */

$app->group('/api/ufmessage', function () {
    $rController = 'UserFrosting\Sprinkle\UfMessage\Controller\CRUD\UfMessageCRUDController';
    $this->get('', $rController . ':getList');
    $this->get('/r/{message_id}', $rController . ':getInfo');

    $this->post('', $rController . ':create');
    $this->put('/r/{message_id}', $rController . ':update');
    //$this->put('/r/{message_id}/{field}', $rController . ':updateField');
    $this->post('/r/{message_id}/{field}', $rController . ':updateField');

    $cDtController = 'UserFrosting\Sprinkle\UfMessage\Controller\Datatables\UfMessageDTController';
    $this->post('/dt', $cDtController . ':getList');
    $this->post('/dt/{message_id}', $cDtController . ':getList');
    $this->post('/dt2', $cDtController . ':getList')->setArgument('user_id', 'current');
    $this->post('/dt2/{user_id}', $cDtController . ':getList');
    $this->post('/dt2/{user_id}/{message_id}', $cDtController . ':getList');
})->add('authGuard');

$app->group('/ufmessage', function () {
    $rController = 'UserFrosting\Sprinkle\UfMessage\Controller\CRUD\UfMessageCRUDController';
    $this->get('/new', $rController . ':getCRUDPage')->setArgument('action', 'create');
    $this->get('/{message_id}', $rController . ':getCRUDPage')->setArgument('action', 'update');
})->add('authGuard');

$app->group('/ufmessages', function () {
    $rController = 'UserFrosting\Sprinkle\UfMessage\Controller\CRUD\UfMessageCRUDController';
    $this->get('', $rController . ':pageList')->setName('uri_ufmessages');
})->add('authGuard');
