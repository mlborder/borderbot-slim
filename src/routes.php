<?php
$app->get('/weeks/{id}', function($request, $response, $args) {
    $response->write(json_encode(['id' => $args['id']], JSON_UNESCAPED_UNICODE));
    return $response->withHeader('Content-type', 'application/json; charset=utf-8');
});

$app->get('/weeks/{id}/idol_records', function($request, $response, $args) {
    $records = WeekRecord::idol_ranking($args['id']);
    $response->write(json_encode($records, JSON_UNESCAPED_UNICODE));
    return $response->withHeader('Content-type', 'application/json; charset=utf-8');
});

$app->get('/weeks/{id}/player_records', function($request, $response, $args) {
    $params = $request->getQueryParams();
    $records = WeekRecord::player_ranking($args['id'], $params);
    $response->write(json_encode($records, JSON_UNESCAPED_UNICODE));
    return $response->withHeader('Content-type', 'application/json; charset=utf-8');
});

// Find by event_id
$app->get('/events/{id}/records', function($request, $response, $args) {
    $params = $request->getQueryParams();
    $records = EventRecord::for_event($args['id'], $params);
    $response->write(json_encode($records, JSON_UNESCAPED_UNICODE));
    return $response->withHeader('Content-type', 'application/json; charset=utf-8');
});

// Find player by id
$app->get('/players/{id}', function ($request, $response, $args) use ($app){
    $record = Player::find($args['id']);

    $response->write(json_encode($record, JSON_UNESCAPED_UNICODE));
    return $response->withHeader('Content-type', 'application/json; charset=utf-8');
});

// Find by player_id
$app->get('/players/{id}/records', function ($request, $response, $args) use ($app){
    $params = $request->getQueryParams();
    $records = EventRecord::for_player($args['id'], $params);

    $response->write(json_encode($records, JSON_UNESCAPED_UNICODE));
    return $response->withHeader('Content-type', 'application/json; charset=utf-8');
});

// Return dummy response
$app->get('/[{name}]', function ($request, $response, $args) {
    $response->write(json_encode(['status' => 'Not Found']));
    return $response->withStatus(404)->withHeader('Content-type', 'application/json');
});
