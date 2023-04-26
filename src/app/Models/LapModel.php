<?php

namespace App\Models;

use CodeIgniter\Model;

class LapModel extends Model
{
    protected $table = 'laps';

    protected $allowedFields = ['id', 'timestamp', 'fuel',
            'pit', 'racingplayer_id'];

    protected $useAutoIncrement = false;

    public static function formatTime($timestamp, $long=true) {
        if(is_null($timestamp)) {
            return 'n/a';
        }
        $s = (int)($timestamp / 1000);
        $ms = (int)($timestamp % 1000);

        if(!$long) {
            $sms = (float) ($s . '.' . sprintf('%03d', $ms));
            return sprintf('%.3f', $sms);
        }
        elseif($s < 3600) {
            $sms = (float)(($s%60) . '.' . sprintf('%03d', $ms));
            $t = sprintf('%d:', (int)($s / 60));
            return $t . sprintf('%06.3f', $sms);
        }
        else {
            $sms = (float)(($s%60) . '.' . sprintf('%03d', $ms));
            $t = sprintf('%d:%02d:', (int)($s / 3600), (int)(($s/60) % 60));
            return $t . sprintf('%06.3f', $sms);
        }
    }

    public function getNumLaps() {
        return $this->countAll();
    }

    public function getLaps($rpid, $car) {
        $laps = $this->where('racingplayer_id', $rpid)->orderBy('timestamp')->findAll();
        $lasttimestamp = 0;
        $configm = new ConfigModel();
        $tracklength = intval($configm->getConfigValue('TRACKLENGTH'));
        foreach($laps as $i => $lap) {
            $laps[$i]['fuelinp'] = round(100.0 / 15.0 * (float)$lap['fuel'], 2);
            $laps[$i]['timef'] = self::formatTime($lap['timestamp']);
            $laptime = $lap['timestamp'] - $lasttimestamp;
            $lapspeedreal = $tracklength / $laptime * 3.6;
            $lapspeedscaled = $lapspeedreal * $car['scale'];
            $laps[$i]['lapspeedreal'] = round($lapspeedreal, 2);
            $laps[$i]['lapspeedscaled'] = round($lapspeedscaled, 2);
            $laps[$i]['laptimef'] = self::formatTime($laptime, false);
            $lasttimestamp = $lap['timestamp'];
        }
        return $laps;
    }
}