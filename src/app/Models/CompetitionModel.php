<?php

namespace App\Models;

use CodeIgniter\Model;

class CompetitionModel extends Model
{
    const SORT_MODE__LAPS = 0;
    const SORT_MODE__LAPTIME = 1;

    const COMP_MODE__TRAINING = 3;
    const COMP_MODE__QUALIFYING_LAPS = 4;
    const COMP_MODE__QUALIFYING_TIME = 5;
    const COMP_MODE__QUALIFYING_LAPS_SEQ = 6;
    const COMP_MODE__QUALIFYING_TIME_SEQ = 7;
    const COMP_MODE__RACE_LAPS = 8;
    const COMP_MODE__RACE_TIME = 9;

    protected $table = 'competitions';

    protected $allowedFields = ['id', 'title', 'time', 'mode', 'sortmode', 'duration'];

    protected $useAutoIncrement = false;

    public function getDuration($competition) {
        switch ($competition['mode']) {
            case self::COMP_MODE__TRAINING:
                return '';
            case self::COMP_MODE__QUALIFYING_LAPS:
            case self::COMP_MODE__QUALIFYING_LAPS_SEQ:
            case self::COMP_MODE__RACE_LAPS:
                return $competition['duration'] . ' ' . lang('carrera.laps');
            case self::COMP_MODE__QUALIFYING_TIME:
            case self::COMP_MODE__QUALIFYING_TIME_SEQ:
            case self::COMP_MODE__RACE_TIME:
                return $competition['duration'] . ' ' . lang('carrera.minutes');
        }
    }

    public function getLength($competition) {
        switch ($competition['mode']) {
            case self::COMP_MODE__TRAINING:
                return null;
            case self::COMP_MODE__QUALIFYING_LAPS:
            case self::COMP_MODE__QUALIFYING_LAPS_SEQ:
            case self::COMP_MODE__RACE_LAPS:
            return intval($competition['duration']);
            case self::COMP_MODE__QUALIFYING_TIME:
            case self::COMP_MODE__QUALIFYING_TIME_SEQ:
            case self::COMP_MODE__RACE_TIME:
                return null;
        }
    }

    public function getMode($competition) {
        switch ($competition['mode']) {
            case self::COMP_MODE__TRAINING:
                return lang('carrera.training');
            case self::COMP_MODE__QUALIFYING_LAPS:
            case self::COMP_MODE__QUALIFYING_TIME:
            case self::COMP_MODE__QUALIFYING_LAPS_SEQ:
            case self::COMP_MODE__QUALIFYING_TIME_SEQ:
                return lang('carrera.qualifying');
            case self::COMP_MODE__RACE_LAPS:
            case self::COMP_MODE__RACE_TIME:
                return lang('carrera.race');
        }
    }

    public function getCompetition($id) {
        return $this->find($id);
    }

    public function getTrainings() {
        $races = $this->where('mode', self::COMP_MODE__TRAINING)
                ->orderBy('time', 'desc')->findAll();
        $indexedraces = array_column($races, null, 'id');
        return $indexedraces;
    }

    public function getQualifyings() {
        $races = $this->where("mode = " . self::COMP_MODE__QUALIFYING_LAPS
                . " OR mode = " . self::COMP_MODE__QUALIFYING_LAPS_SEQ
                . " OR mode = " . self::COMP_MODE__QUALIFYING_TIME
                . " OR mode = " . self::COMP_MODE__QUALIFYING_TIME_SEQ)
                ->orderBy('time', 'desc')->findAll();
        $indexedraces = array_column($races, null, 'id');
        return $indexedraces;
    }

    public function getRaces() {
        $races = $this->where("mode = " . self::COMP_MODE__RACE_LAPS
                . " OR mode = " . self::COMP_MODE__RACE_TIME)
                ->orderBy('time', 'desc')->findAll();
        $indexedraces = array_column($races, null, 'id');
        return $indexedraces;
    }

    public function getRaceResultsByYear($only) {
        $rpm = new RacingPlayerModel();
        $byyear = array();
        $races = $this->where("mode = " . self::COMP_MODE__RACE_LAPS
                               . " OR mode = " . self::COMP_MODE__RACE_TIME)
                ->orderBy('time', 'desc')->findAll();
        foreach($races as $race) {
            $year = date('Y', strtotime($race['time']));
            if(array_key_exists($year, $byyear)) {
                $plcs = $rpm->getPlayersOfComp($race['id']);
                if(is_null($only)) {
                    $race['players'] = $rpm->getRpOfCompetition($race['id']);
                    $byyear[$year]['races'][] = $race;
                    $byyear[$year]['num']++;
                    $byyear[$year]['players'] += $plcs;
                }
                else {
                    $pk = array_keys($plcs);
                    sort($pk);
                    sort($only);
                    if($pk == $only) {
                        $race['players'] = $rpm->getRpOfCompetition($race['id']);
                        $byyear[$year]['races'][] = $race;
                        $byyear[$year]['num']++;
                        $byyear[$year]['players'] += $plcs;
                    }
                }
            }
            else {
                $plcs = $rpm->getPlayersOfComp($race['id']);
                if(is_null($only)) {
                    $race['players'] = $rpm->getRpOfCompetition($race['id']);
                    $temp = array(
                            'num' => 1,
                            'races' => array($race),
                            'players' => $plcs
                    );
                    $byyear[$year] = $temp;
                }
                else {
                    $pk = array_keys($plcs);
                    sort($pk);
                    sort($only);
                    if ($pk == $only) {
                        $race['players'] = $rpm->getRpOfCompetition($race['id']);
                        $temp = array(
                                'num' => 1,
                                'races' => array($race),
                                'players' => $plcs
                        );
                        $byyear[$year] = $temp;
                    }

                }
            }

        }
        foreach($byyear as $y => $item) {
            foreach($item['players'] as $pid => $p) {
                if(!array_key_exists('wins', $byyear[$y]['players'][$pid])) {
                    $byyear[$y]['players'][$pid]['wins'] = 0;
                }
                foreach($item['races'] as $r) {
                    foreach($r['players'] as $rp) {
                        if($rp['player_id'] == $p['id']) {
                            $points = 0;
                            switch($rp['rank']) {
                                case '1':
                                    $points += 25;
                                    $byyear[$y]['players'][$pid]['wins']++;
                                    break;
                                case '2':
                                    $points += 18;
                                    break;
                                case '3':
                                    $points += 15;
                                    break;
                                case '4':
                                    $points += 12;
                                    break;
                                case '5':
                                    $points += 10;
                                    break;
                                case '6':
                                    $points += 8;
                                    break;
                            }
                            if(array_key_exists('points', $byyear[$y]['players'][$pid])) {
                                $byyear[$y]['players'][$pid]['points'] += $points;
                            }
                            else {
                                $byyear[$y]['players'][$pid]['points'] = $points;
                            }
                            if(array_key_exists('races', $byyear[$y]['players'][$pid])) {
                                $byyear[$y]['players'][$pid]['races']++;
                            }
                            else {
                                $byyear[$y]['players'][$pid]['races'] = 1;
                            }
                        }
                    }
                }
            }
        }
        function cmp($a, $b) {
            if($a['points'] == $b['points']) {
                return $a['wins'] < $b['wins'];
            }
            return $a['points'] < $b['points'];
        }
        foreach($byyear as $y1 => $item1) {
            usort($byyear[$y1]['players'], "\\App\Models\\cmp");
        }
        foreach($byyear as $y1 => $item1) {
            $lastplayer = null;
            $firstplayer = null;
            foreach($item1['players'] as $pid => $p) {
                if(is_null($lastplayer)) {
                    $byyear[$y1]['players'][$pid]['pos'] = 1;
                    $firstplayer = $byyear[$y1]['players'][$pid];
                    $byyear[$y1]['players'][$pid]['diff'] = ' ';
                }
                else {
                    if($lastplayer['points'] == $byyear[$y1]['players'][$pid]['points']
                            && $lastplayer['wins'] == $byyear[$y1]['players'][$pid]['wins']) {
                        $byyear[$y1]['players'][$pid]['pos'] = $lastplayer['pos'];
                    }
                    else {
                        $byyear[$y1]['players'][$pid]['pos'] = $lastplayer['pos'] + 1;
                    }
                    $byyear[$y1]['players'][$pid]['diff'] = $firstplayer['points'] - $byyear[$y1]['players'][$pid]['points'];
                }
                $lastplayer = $byyear[$y1]['players'][$pid];
            }
        }
        return $byyear;
    }

    public function getNumTrainings() {
        return $this->where('mode', self::COMP_MODE__TRAINING)->countAllResults();
    }

    public function getNumQualifyings() {
        return $this->where('mode', self::COMP_MODE__QUALIFYING_LAPS)->countAllResults()
                + $this->where('mode', self::COMP_MODE__QUALIFYING_LAPS_SEQ)->countAllResults()
                + $this->where('mode', self::COMP_MODE__QUALIFYING_TIME_SEQ)->countAllResults()
                + $this->where('mode', self::COMP_MODE__QUALIFYING_TIME)->countAllResults();
    }

    public function getNumRaces() {
        return $this->where('mode', self::COMP_MODE__RACE_LAPS)->countAllResults()
                + $this->where('mode', self::COMP_MODE__RACE_TIME)->countAllResults();
    }
}