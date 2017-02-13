<?php
class WeekRecord
{
    const SLIM_DB_TABLE = 'week_records';

    public static function idol_ranking($week_id)
    {
        $results = ORM::for_table(self::SLIM_DB_TABLE)
            ->select_many_expr(['idol_id' => 'idol_id', 'fan_count' => 'SUM(fan_count)'])
            ->where('week_id', intval($week_id))
            ->group_by('idol_id')
            ->order_by_desc('fan_count')->find_many();

        $player_count_results = ORM::for_table(self::SLIM_DB_TABLE)
            ->select_many_expr(['idol_id', 'player_count' => 'COUNT(player_id)'])
            ->where('week_id', intval($week_id))
            ->group_by('idol_id')->find_many();

        $player_count = [];
        foreach ($player_count_results as $result) {
            $player_count[$result->idol_id] = $result->player_count;
        }

        $ret = [];
        foreach ($results as $i => $result) {
            array_push($ret, [
                'rank' => $i + 1,
                'idol_id' => $result->idol_id,
                'fan_count' => $result->fan_count,
                'player_count' => $player_count[$result->idol_id]
            ]);
        }

        return $ret;
    }

    public static function player_ranking($week_id, array $params)
    {
        $idol_id = isset($params['idol_id']) ? $params['idol_id'] : null;
        list($offset, $limit) = self::parse_paging_info($params);

        if ($idol_id) {
            $results = ORM::for_table(self::SLIM_DB_TABLE)
                ->select_many_expr(['week_id', 'player_id', 'name', 'fan_count' => 'SUM(fan_count)'])
                ->where('week_id', intval($week_id))
                ->where('idol_id', intval($idol_id))
                ->group_by('player_id')
                ->offset($offset)->limit($limit)
                ->left_outer_join('players', [self::SLIM_DB_TABLE . '.player_id', '=', 'players.id'])
                ->order_by_desc('fan_count')->order_by_asc('player_id')->find_many();
        } else {
            $results = ORM::for_table(self::SLIM_DB_TABLE)
                ->select_many_expr(['week_id', 'player_id', 'name', 'fan_count' => 'SUM(fan_count)'])
                ->where('week_id', intval($week_id))
                ->group_by('player_id')
                ->offset($offset)->limit($limit)
                ->left_outer_join('players', [self::SLIM_DB_TABLE . '.player_id', '=', 'players.id'])
                ->order_by_desc('fan_count')->order_by_asc('player_id')->find_many();
        }

        $ret = [];
        foreach ($results as $i => $result) {
            array_push($ret, [
                'rank' => intval($i + $offset + 1),
                'week_id' => intval($result->week_id),
                'idol_id' => intval($idol_id),
                'player_id' => $result->player_id,
                'name' => $result->name,
                'fan_count' => intval($result->fan_count),
            ]);
        }


        return $ret;
    }

    private static function parse_paging_info(array $params)
    {
        $offset = isset($params['o']) ? intval($params['o']) : 0;
        $limit = isset($params['l']) ? intval($params['l']) : 100;

        return [$offset, $limit];
    }
}
