<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfigModel extends Model
{
    protected $table = 'config';

    protected $allowedFields = ['configkey', 'value'];
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    public function getConfig($key) {
        $result = $this->select()->where('configkey', $key)->find();
        if (count($result) < 1) {
            return null;
        }
        return $result[0];
    }

    public function getConfigValue($key) {
        $result = $this->select('value')->where('configkey', $key)->find();
        if (count($result) < 1) {
            return null;
        }
        return $result[0]['value'];
    }
}