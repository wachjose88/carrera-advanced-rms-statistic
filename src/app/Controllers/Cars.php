<?php

namespace App\Controllers;
use App\Models\CarModel;
use App\Models\CompetitionModel;
use App\Models\ConfigModel;
use App\Models\PlayerModel;
use App\Models\RacingPlayerModel;

class Cars extends BaseController
{
	public function index()
	{
        $carsm = new CarModel();

        $data = array(
                'title' => lang('carrera.cars'),
                'cars' => $carsm->getCars()
        );
		echo view('parts/header', $data);
        echo view('cars', $data);
		echo view('parts/footer');
	}

    public function details($id)
    {
        helper(['form', 'url']);
        $carsm = new CarModel();

        $rpm = new RacingPlayerModel();
        $wins = $rpm->getWinsOfCars($id);
        $statistic = $rpm->getStatisticOfCars($id);

        $error = null;

        if ($this->request->getMethod() == 'post')
        {
            $input = $this->validate([
                    'file' => [
                            'uploaded[file]',
                            'mime_in[file,image/jpg,image/jpeg,image/png]',
                            'max_size[file,1024]',
                    ]
            ]);
            if (!$input)
            {
                $error = lang('carrera.uploaderror');
            }
            else
            {
                $img = $this->request->getFile('file');
                $save = $carsm->save(['id' => $id, 'image' => $img->getName()]);
                if ($save)
                {
                    $img->move(__DIR__ . '/../../public/uploads/cars');
                }
                else
                {
                    $error = lang('carrera.uploaderror');
                }

            }
        }

        $car = $carsm->getCar($id);
        $configm = new ConfigModel();
        $bestlaprealspeed = null;
        $bestlapscaledspeed = null;
        $tracklength = intval($configm->getConfigValue('TRACKLENGTH'));
        if ($statistic['bestlap'] != INF)
        {
            $bestlaprealspeed = ($tracklength / 1000.0) / $statistic['bestlap'] * 3.6;
            $bestlapscaledspeed = $bestlaprealspeed * $car['scale'];
        }
        $data = array(
                'title' => $car['name'] . ' (' . $car['number'] . ')',
                'car' => $car,
                'image' => $car['image'],
                'wins' => $wins,
                'statistic' => $statistic,
                'bestlaprealspeed' => round($bestlaprealspeed, 2),
                'bestlapscaledspeed' => round($bestlapscaledspeed, 2)
        );
        if (!is_null($error))
            $data['error'] = $error;

        echo view('parts/header', $data);
        echo view('cardetails', $data);
        echo view('parts/footer');
    }

    public function delete($id)
    {
        helper(['form', 'url']);
        $carsm = new CarModel();
        $car = $carsm->getCar($id);

        $error = null;

        if ($this->request->getMethod() == 'post')
        {
            unlink(__DIR__ . '/../../public/uploads/cars/' . $car['image']);
            $save = $carsm->save(['id' => $id, 'image' => null]);
            return redirect()->to("cars/details/$id");
        }
        $data = array(
                'title' => $car['name'] . ' (' . $car['number'] . ')',
                'car' => $car,
                'image' => $car['image']
        );

        echo view('parts/header', $data);
        echo view('cardelete', $data);
        echo view('parts/footer');
    }
}
