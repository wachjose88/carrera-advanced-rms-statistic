<?php

namespace App\Models;

use CodeIgniter\Model;

class RacingPlayerModel extends Model
{
    protected $table = 'racingplayers';

    protected $allowedFields = ['id', 'competition_id', 'car_id',
            'player_id', 'rank', 'laps', 'time', 'bestlap', 'diff'];

    protected $useAutoIncrement = false;

    public function getPlayersOfComp($cid, $player_ids = null) {
        $pm = new PlayerModel();
        $rps = $this->select()->where('competition_id', $cid)->findAll();
        $players = array();
        foreach($rps as $rp) {
            if(!is_null($player_ids)) {
                if(in_array($rp['player_id'], $player_ids)) {
                    $players[$rp['player_id']] = $pm->getPlayer($rp['player_id']);
                }
            }
            else {
                $players[$rp['player_id']] = $pm->getPlayer($rp['player_id']);
            }

        }
        return $players;
    }

    public function getCompNums($pid) {
        $cm = new CompetitionModel();
        $trainings = $cm->getTrainings();
        $qualifyings = $cm->getQualifyings();
        $races = $cm->getRaces();
        $rps = $this->select()->where('player_id', $pid)->findAll();
        $nums = array(
                'trainingwins' => 0,
                'qualifyingwins' => 0,
                'racewins' => 0,
                'trainings' => 0,
                'qualifyings' => 0,
                'races' => 0,
                'competition_trainings' => array(),
                'competition_qualifyings' => array(),
                'competition_races' => array()
        );
        foreach($rps as $rp) {
            if(in_array($rp['competition_id'], array_column($trainings, 'id'))) {
                $nums['trainings'] = $nums['trainings'] + 1;
                if($rp['rank'] === '1') {
                    $nums['trainingwins'] = $nums['trainingwins'] + 1;
                }
                $nums['competition_trainings'][] = $trainings[$rp['competition_id']];
            }
            else if(in_array($rp['competition_id'], array_column($qualifyings, 'id'))) {
                $nums['qualifyings'] = $nums['qualifyings'] + 1;
                if($rp['rank'] === '1') {
                    $nums['qualifyingwins'] = $nums['qualifyingwins'] + 1;
                }
                $nums['competition_qualifyings'][] = $qualifyings[$rp['competition_id']];
            }
            else if(in_array($rp['competition_id'], array_column($races, 'id'))) {
                $nums['races'] = $nums['races'] + 1;
                if($rp['rank'] === '1') {
                    $nums['racewins'] = $nums['racewins'] + 1;
                }
                $nums['competition_races'][] = $races[$rp['competition_id']];
            }
        }
        usort($nums['competition_trainings'], function ($a, $b) { return strcmp($b["time"], $a["time"]); });
        usort($nums['competition_qualifyings'], function ($a, $b) { return strcmp($b["time"], $a["time"]); });
        usort($nums['competition_races'], function ($a, $b) { return strcmp($b["time"], $a["time"]); });
        return $nums;
    }

    public function getStatisticOfPlayers($pid) {
        $rps = $this->select()->where('player_id', $pid)->findAll();
        $statistic = array(
                'laps' => 0,
                'bestlap' => INF,
                'competitions' => $this->where('player_id', $pid)->countAll(),
        );
        foreach($rps as $rp) {
            $statistic['laps'] += $rp['laps'];
            $bestlap = floatval(str_replace(',', '.', $rp['bestlap']));
            if($bestlap < $statistic['bestlap'] && $bestlap > 3.0) {
                $statistic['bestlap'] = $bestlap;
            }
        }
        return $statistic;
    }

    public function getStatisticOfCars($cid) {
        $rps = $this->select()->where('car_id', $cid)->findAll();
        $statistic = array(
                'laps' => 0,
                'bestlap' => INF,
                'bestlap' => INF,
        );
        foreach($rps as $rp) {
            $statistic['laps'] += $rp['laps'];
            $bestlap = floatval(str_replace(',', '.', $rp['bestlap']));
            if($bestlap < $statistic['bestlap'] && $bestlap > 3.0) {
                $statistic['bestlap'] = $bestlap;
            }
        }
        return $statistic;
    }

    public function getWinsOfCars($cid) {
        $cm = new CompetitionModel();
        $trainings = $cm->getTrainings();
        $qualifyings = $cm->getQualifyings();
        $races = $cm->getRaces();
        $rps = $this->select()->where('car_id', $cid)->findAll();
        $nums = array(
                'trainingwins' => 0,
                'qualifyingwins' => 0,
                'racewins' => 0,
                'trainings' => 0,
                'qualifyings' => 0,
                'races' => 0,
                'competition_trainings' => array(),
                'competition_qualifyings' => array(),
                'competition_races' => array()
        );
        foreach($rps as $rp) {
            if(in_array($rp['competition_id'], array_column($trainings, 'id'))) {
                $nums['trainings'] = $nums['trainings'] + 1;
                if($rp['rank'] === '1') {
                    $nums['trainingwins'] = $nums['trainingwins'] + 1;
                }
                $nums['competition_trainings'][] = $trainings[$rp['competition_id']];
            }
            else if(in_array($rp['competition_id'], array_column($qualifyings, 'id'))) {
                $nums['qualifyings'] = $nums['qualifyings'] + 1;
                if($rp['rank'] === '1') {
                    $nums['qualifyingwins'] = $nums['qualifyingwins'] + 1;
                }
                $nums['competition_qualifyings'][] = $qualifyings[$rp['competition_id']];
            }
            else if(in_array($rp['competition_id'], array_column($races, 'id'))) {
                $nums['races'] = $nums['races'] + 1;
                if($rp['rank'] === '1') {
                    $nums['racewins'] = $nums['racewins'] + 1;
                }
                $nums['competition_races'][] = $races[$rp['competition_id']];
            }
        }
        usort($nums['competition_trainings'], function ($a, $b) { return strcmp($b["time"], $a["time"]); });
        usort($nums['competition_qualifyings'], function ($a, $b) { return strcmp($b["time"], $a["time"]); });
        usort($nums['competition_races'], function ($a, $b) { return strcmp($b["time"], $a["time"]); });
        return $nums;
    }

    public function getWins() {
        $pm = new PlayerModel();
        $rps = $this->selectCount('id')->select('rank, player_id')->groupBy('player_id')
            ->where('rank', 1)->findAll();
        $i = 0;
        foreach($rps as $rp) {
            $rps[$i]['player'] = $pm->getPlayer($rp['player_id']);
            $i++;
        }
        return $rps;
    }

    public function getRpOfCompetition($cid, $player_ids = null) {
        $pm = new PlayerModel();
        $cm = new CarModel();
        $lm = new LapModel();
        $configm = new ConfigModel();
        $rps1 = $this->where('competition_id', $cid)->orderBy('rank')->findAll();
        $rps = array();
        foreach($rps1 as $id => $rp1) {
            if(!is_null($player_ids)) {
                if(in_array($rp1['player_id'], $player_ids)) {
                    $rps[$id] = $rp1;
                }
            }
            else {
                $rps[$id] = $rp1;
            }
        }
        $i = 0;
        foreach($rps as $rp) {
            $car = $cm->getCar($rp['car_id']);
            $rps[$i]['car'] = $car;
            $rps[$i]['player'] = $pm->getPlayer($rp['player_id']);
            $rps[$i]['laps'] = $lm->getLaps($rp['id'], $car);
            $timestamp = $rps[$i]['laps'][array_key_last($rps[$i]['laps'])]['timestamp'];
            $tracklength = intval($configm->getConfigValue('TRACKLENGTH'));
            $bestlap = intval(floatval(str_replace(',', '.', $rp['bestlap'])) * 1000);
            $bestlapspeedreal = $tracklength / $bestlap * 3.6;
            $rps[$i]['bestlapspeedreal'] = round($bestlapspeedreal, 2);
            $rps[$i]['bestlapspeedscaled'] = round($bestlapspeedreal * $car['scale'], 2);
            $tracklength = $tracklength * (count($rps[$i]['laps']) - 1);
            $speedreal = $tracklength / intval($timestamp) * 3.6;
            $speedscaled = $speedreal * $car['scale'];
            $rps[$i]['speedreal'] = round($speedreal, 2);
            $rps[$i]['speedscaled'] = round($speedscaled, 2);
            $i++;
        }
        return $rps;
    }
}