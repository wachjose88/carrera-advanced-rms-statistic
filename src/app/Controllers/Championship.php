<?php

namespace App\Controllers;
use App\Models\CarModel;
use App\Models\CompetitionModel;
use App\Models\PlayerModel;
use App\Models\RacingPlayerModel;

class Championship extends BaseController
{
	public function index($showonly = 0)
	{
        $only = explode(',', $showonly);
        $filter = $only;
        if(count($only) == 1 && $only[0] == 0) {
            $only = null;
        }
        $playersm = new PlayerModel();
        $competitionm = new CompetitionModel();

        $byyear = $competitionm->getRaceResultsByYear($only);

        $data = array(
                'title' => lang('carrera.championship'),
                'championships' => $byyear,
                'filter' => $filter,
                'players' => $playersm->getPlayers()
        );
		echo view('parts/header', $data);
        echo view('championship', $data);
		echo view('parts/footer');
	}
}
