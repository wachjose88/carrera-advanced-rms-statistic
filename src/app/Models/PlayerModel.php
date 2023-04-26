<?php

namespace App\Models;

use CodeIgniter\Model;

class PlayerModel extends Model
{
    protected $table = 'players';

    protected $allowedFields = ['id', 'username', 'name', 'image'];

    protected $useAutoIncrement = false;

    public function getPlayers() {
        $pls = $this->orderBy('name')->findAll();
        $rpm = new RacingPlayerModel();
        $i = 0;
        foreach($pls as $pl) {
            $pls[$i]['nums'] = $rpm->getCompNums($pl['id']);
            $i++;
        }
        return $pls;
    }

    public function getPlayer($id) {
        return $this->find($id);
    }
}