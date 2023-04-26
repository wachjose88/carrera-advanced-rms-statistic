<?php

namespace App\Models;

use CodeIgniter\Model;

class CarModel extends Model
{
    protected $table = 'cars';

    protected $allowedFields = ['id', 'name', 'number', 'image', 'tires', 'scale'];
    protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    public function getCar($id) {
        return $this->find($id);
    }

    public function getCars() {
        $rpm = new RacingPlayerModel();
        $cars = $this->orderBy('name')->findAll();
        foreach($cars as $id => $car) {
            $cars[$id]['nums'] = $rpm->getWinsOfCars($car['id']);
        }
        return $cars;
    }
}