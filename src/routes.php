<?php
define('SLIM_DB_TABLE', 'event_records');

// Find by event_id
$app->get('/events/{id}/records', function($request, $response, $args) {
    $event_id = intval($args['id']);
    $params = $request->getQueryParams();

    if (isset($params['idol_id'])) {
        $idol_id = intval($params['idol_id']);
        $results = ORM::for_table(SLIM_DB_TABLE)
            ->where('event_id', $event_id)
            ->where('idol_id', $idol_id)
            ->order_by_asc('rank')
            ->limit(5000)
            ->find_many();
    } else {
        $results = ORM::for_table(SLIM_DB_TABLE)
            ->where('event_id', $event_id)
            ->order_by_asc('idol_id')
            ->order_by_asc('rank')
            ->limit(5000)
            ->find_many();
    }

    $rankings = [];
    foreach ($results as $result) {
        array_push($rankings, [
            'id' => $result->id,
            'event_id' => $result->event_id,
            'idol_id' => $result->idol_id,
            'rank' => $result->rank,
            'point' => $result->point,
            'player_id' => $result->player_id
        ]);
    }

    $response->write(json_encode($rankings));
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
    $results = ORM::for_table(SLIM_DB_TABLE)
        ->where('player_id', $args['id'])
        ->order_by_asc('event_id')
        ->find_many();

    $ret = [];
    foreach ($results as $result) {
        array_push($ret, [
            'id' => $result->id,
            'event_id' => $result->event_id,
            'idol_id' => $result->idol_id,
            'rank' => $result->rank,
            'point' => $result->point,
            'player_id' => $result->player_id
        ]);
    }
    $response->write(json_encode($ret));
    return $response->withHeader('Content-type', 'application/json');
});

// Return dummy response
$app->get('/[{name}]', function ($request, $response, $args) {
    $response->write(json_encode(['status' => 'Not Found']));
    return $response->withStatus(404)->withHeader('Content-type', 'application/json');
});
