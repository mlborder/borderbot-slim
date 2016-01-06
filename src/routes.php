<?php
require __DIR__ . '/models/event_record.php';

// Find by event_id
$app->get('/events/{id}/records', function($request, $response, $args) {
    $params = $request->getQueryParams();
    $records = EventRecord::for_event($args['id'], $params);

    $response->write(json_encode($records));
    return $response->withHeader('Content-type', 'application/json');
});

// Find player by id
$app->get('/players/{id}', function ($request, $response, $args) use ($app){
    $ret = ['id' => $args['id']];
    $response->write(json_encode($ret));
    return $response->withHeader('Content-type', 'application/json');
});

// Find by player_id
$app->get('/players/{id}/records', function ($request, $response, $args) use ($app){
    $params = $request->getQueryParams();
    $records = EventRecord::for_player($args['id'], $params);

    $response->write(json_encode($records));
    return $response->withHeader('Content-type', 'application/json');
});

// Return dummy response
$app->get('/[{name}]', function ($request, $response, $args) {
    $response->write(json_encode(['status' => 'Not Found']));
    return $response->withStatus(404)->withHeader('Content-type', 'application/json');
});
