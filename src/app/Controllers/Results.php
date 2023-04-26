<?php

namespace App\Controllers;
use App\Models\CarModel;
use App\Models\CompetitionModel;
use App\Models\ConfigModel;
use App\Models\RacingPlayerModel;

class Results extends BaseController
{
	public function index()
	{
        $compm = new CompetitionModel();

        $data = array(
                'title' => lang('carrera.results'),
                'trainings' => $compm->getTrainings(),
                'qualifyings' => $compm->getQualifyings(),
                'races' => $compm->getRaces()
        );
		echo view('parts/header', $data);
        echo view('results', $data);
		echo view('parts/footer');
	}

    public function details($id) {
        $compm = new CompetitionModel();
        $rpm = new RacingPlayerModel();
        $configm = new ConfigModel();
        $c = $compm->getCompetition($id);
        $tracklength = intval($configm->getConfigValue('TRACKLENGTH')) / 1000;
        $complength = $compm->getLength($c);
        if (!is_null($complength))
        {
            $complength = $tracklength * $complength;
        }

        $data = array(
                'title' => $c['title'],
                'competition' => $c,
                'players' => $rpm->getRpOfCompetition($id),
                'mode' => $compm->getMode($c),
                'duration' => $compm->getDuration($c),
                'usebestlap' => $c['sortmode'] == $compm::SORT_MODE__LAPTIME,
                'complength' => $complength,
                'tracklength' => $tracklength
        );
        echo view('parts/header', $data);
        echo view('details', $data);
        echo view('parts/footer');
    }
}
