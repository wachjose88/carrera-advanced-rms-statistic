<?php

namespace App\Controllers;
use App\Models\CarModel;
use App\Models\CompetitionModel;
use App\Models\ConfigModel;
use App\Models\RacingPlayerModel;

class Home extends BaseController
{
	public function index()
	{
        $compm = new CompetitionModel();
        $rpm = new RacingPlayerModel();
        $configm = new ConfigModel();
        $tracklength = $configm->getConfigValue('TRACKLENGTH');
        if (!is_null($tracklength))
        {
            $tracklength = intval($tracklength) / 1000;
        }
        $data = array(
                'title' => lang('carrera.home'),
                'wins' => $rpm->getWins(),
                'numtrainings' => $compm->getNumTrainings(),
                'numqualifyings' => $compm->getNumQualifyings(),
                'numraces' => $compm->getNumRaces(),
                'sitetitle' => $configm->getConfigValue('TITLE'),
                'tracklength' => $tracklength
        );
		echo view('parts/header', $data);
        echo view('home', $data);
		echo view('parts/footer');
	}
}
