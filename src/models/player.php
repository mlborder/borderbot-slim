<?php
class Player
{
    public static function find($id)
    {
        $result = ORM::for_table('players')->where('id', $id)->find_one();
        if ($result) {
            return ['id' => $result->id, 'name' => $result->name ];
        } else {
            return ['id' => $id, 'name' => "id: $id" ];
        }
    }
}
