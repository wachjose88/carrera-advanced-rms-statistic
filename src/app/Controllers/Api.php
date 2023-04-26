<?php

namespace App\Controllers;

use App\Models\CarModel;
use App\Models\CompetitionModel;
use App\Models\ConfigModel;
use App\Models\LapModel;
use App\Models\PlayerModel;
use App\Models\RacingPlayerModel;

class Api extends BaseController
{
    public function upload()
    {
        $result = array();
        $tracklength = $this->request->getPost('tracklength');
        if (!is_null($tracklength))
        {
            $configm = new ConfigModel();
            $configtl = $configm->getConfig('TRACKLENGTH');
            $configtlnew = array(
                    'configkey' => 'TRACKLENGTH',
                    'value' => $tracklength
            );
            if (!is_null($configtl))
            {
                $configtlnew['id'] = $configtl['id'];
            }
            $savectl = $configm->save($configtlnew);
            $result['tracklength'] = $savectl;
        }
        $carsp = $this->request->getPost('cars');
        if(!is_null($carsp))
        {
            $carsr = array();
            $cars = json_decode($carsp, true);
            foreach($cars as $car)
            {
                $mc = new CarModel();
                $mcexists = $mc->where('id', $car['id'])->find();
                $mcs = false;
                if(count($mcexists) > 0)
                {
                    $mcs = $mc->save([
                            'id' => $car['id'],
                            'name' => $car['name'],
                            'number' => $car['number'],
                            'tires' => $car['tires'],
                            'scale' => intval($car['scale'])
                    ]);
                }
                else
                {
                    $mcs = $mc->insert([
                            'id' => $car['id'],
                            'name' => $car['name'],
                            'number' => $car['number'],
                            'tires' => $car['tires'],
                            'scale' => intval($car['scale'])
                    ]);
                }

                if($mcs) {
                    $carsr[] = $car['id'];
                }
            }
            $result['cars'] = $carsr;
        }
        $playersp = $this->request->getPost('players');
        if(!is_null($playersp))
        {
            $playersr = array();
            $players = json_decode($playersp, true);
            foreach($players as $player)
            {
                $mp = new PlayerModel();
                $mpexists = $mp->where('id', $player['id'])->find();
                $mps = false;
                if(count($mpexists) > 0)
                {
                    $mps = $mp->save([
                            'id' => $player['id'],
                            'username' => $player['username'],
                            'name' => $player['name']
                    ]);
                }
                else
                {
                    $mps = $mp->insert([
                            'id' => $player['id'],
                            'username' => $player['username'],
                            'name' => $player['name']
                    ]);
                }

                if($mps) {
                    $playersr[] = $player['id'];
                }
            }
            $result['players'] = $playersr;
        }
        $racingplayersp = $this->request->getPost('racingplayers');
        if(!is_null($racingplayersp))
        {
            $racingplayersr = array();
            $racingplayers = json_decode($racingplayersp, true);
            foreach($racingplayers as $racingplayer)
            {
                $mrp = new RacingPlayerModel();
                $mrps = false;
                $mrpexists = $mrp->where('id', $racingplayer['id'])->find();
                if(count($mrpexists) > 0)
                {
                    $mrps = $mrp->save([
                            'id' => $racingplayer['id'],
                            'competition_id' => $racingplayer['competition_id'],
                            'car_id' => $racingplayer['car_id'],
                            'player_id' => $racingplayer['player_id']
                    ]);
                }
                else
                {
                    $mrps = $mrp->insert([
                            'id' => $racingplayer['id'],
                            'competition_id' => $racingplayer['competition_id'],
                            'car_id' => $racingplayer['car_id'],
                            'player_id' => $racingplayer['player_id']
                    ]);
                }

                if($mrps) {
                    $racingplayersr[] = $racingplayer['id'];
                }
            }
            $result['racingplayers'] = $racingplayersr;
        }
        $lapsp = $this->request->getPost('laps');
        if(!is_null($lapsp))
        {
            $lapsr = array();
            $laps = json_decode($lapsp, true);
            foreach($laps as $lap)
            {
                $ml = new LapModel();
                $mls = false;
                $mlexists = $ml->where('id', $lap['id'])->find();
                if(count($mlexists) > 0)
                {
                    $mls = $ml->save([
                            'id' => $lap['id'],
                            'timestamp' => $lap['timestamp'],
                            'fuel' => $lap['fuel'],
                            'pit' => $lap['pit'],
                            'racingplayer_id' => $lap['racingplayer_id']
                    ]);
                }
                else
                {
                    $mls = $ml->insert([
                            'id' => $lap['id'],
                            'timestamp' => $lap['timestamp'],
                            'fuel' => $lap['fuel'],
                            'pit' => $lap['pit'],
                            'racingplayer_id' => $lap['racingplayer_id']
                    ]);
                }

                if($mls) {
                    $lapsr[] = $lap['id'];
                }
            }
            $result['laps'] = $lapsr;
        }
        $competitionsp = $this->request->getPost('competitions');
        if(!is_null($competitionsp))
        {
            $competitionsr = array();
            $competitions = json_decode($competitionsp, true);
            foreach($competitions as $competition)
            {
                $mco = new CompetitionModel();
                $mcos = false;
                $mcoexists = $mco->where('id', $competition['competition']['id'])->find();
                if(count($mcoexists) > 0)
                {
                    $mcos = $mco->save([
                            'id' => $competition['competition']['id'],
                            'title' => $competition['competition']['title'],
                            'time' => $competition['competition']['time'],
                            'mode' => $competition['competition']['mode'],
                            'sortmode' => $competition['competition']['sortmode'],
                            'duration' => $competition['competition']['duration']
                    ]);
                }
                else
                {
                    $mcos = $mco->insert([
                            'id' => $competition['competition']['id'],
                            'title' => $competition['competition']['title'],
                            'time' => $competition['competition']['time'],
                            'mode' => $competition['competition']['mode'],
                            'sortmode' => $competition['competition']['sortmode'],
                            'duration' => $competition['competition']['duration']
                    ]);
                }

                foreach($competition['result'] as $racingplayer)
                {
                    $mrp = new RacingPlayerModel();
                    $mrps = $mrp->save([
                            'id' => $racingplayer['pid'],
                            'rank' => $racingplayer['rank'],
                            'laps' => $racingplayer['laps'],
                            'time' => $racingplayer['time'],
                            'bestlap' => $racingplayer['bestlap'],
                            'diff' => $racingplayer['diff']
                    ]);
                }
                if($mcos) {
                    $competitionsr[] = $competition['competition']['id'];
                }
            }
            $result['competitions'] = $competitionsr;
        }
        echo json_encode($result);
    }
}
