<?php
class EventRecord
{
    const SLIM_DB_TABLE = 'event_records';

    public static function for_event($event_id, array $params)
    {
        $idol_id = isset($params['idol_id']) ? $params['idol_id'] : null;
        list($offset, $limit) = self::parse_paging_info($params);

        if ($idol_id) {
            $results = ORM::for_table(self::SLIM_DB_TABLE)
                ->where('event_id', intval($event_id))
                ->where('idol_id', intval($idol_id))
                ->left_outer_join('players', [self::SLIM_DB_TABLE . '.player_id', '=', 'players.id'])
                ->offset($offset)->limit($limit)
                ->order_by_desc('point')->order_by_asc('rank')->find_many();
            return self::convert_results($results);
        } else {
            $results = ORM::for_table(self::SLIM_DB_TABLE)
                ->where('event_id', intval($event_id))
                ->offset($offset)->limit($limit)
                ->left_outer_join('players', [self::SLIM_DB_TABLE . '.player_id', '=', 'players.id'])
                ->order_by_desc('point')->order_by_asc('rank')->find_many();
            return self::convert_results($results);
        }
    }

    public static function for_player($player_id, array $params)
    {
        if ($player_id) {
            preg_match('/\d+/', $player_id, $matches);
            $player_id = empty($matches) ? null : $matches[0];
        }
        list($offset, $limit) = self::parse_paging_info($params);

        $results = ORM::for_table(self::SLIM_DB_TABLE)
            ->where('player_id', $player_id)
            ->offset($offset)->limit($limit)
            ->order_by_desc('event_id')->find_many();
        return self::convert_results($results);
    }

    private static function parse_paging_info(array $params)
    {
        $offset = isset($params['o']) ? intval($params['o']) : 0;
        $limit = isset($params['l']) ? intval($params['l']) : 100;

        return [$offset, $limit];
    }

    private static function convert_results(array $results)
    {
        $ret = [];
        foreach ($results as $result) {
            array_push($ret, [
                'id' => $result->id,
                'name' => $result->name,
                'event_id' => $result->event_id,
                'idol_id' => $result->idol_id,
                'rank' => $result->rank,
                'point' => $result->point,
                'player_id' => $result->player_id
            ]);
        }

        return $ret;
    }
}
