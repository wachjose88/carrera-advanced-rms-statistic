<?php

namespace App\Controllers;
use App\Models\CarModel;
use App\Models\CompetitionModel;
use App\Models\LapModel;
use App\Models\PlayerModel;
use App\Models\RacingPlayerModel;

class Players extends BaseController
{
	public function index()
	{
        $playersm = new PlayerModel();

        $data = array(
                'title' => lang('carrera.players'),
                'players' => $playersm->getPlayers(),
        );
		echo view('parts/header', $data);
        echo view('players', $data);
		echo view('parts/footer');
	}

    public function details($id)
    {
        helper(['form', 'url']);
        $playersm = new PlayerModel();
        $lapsm = new LapModel();
        $rpm = new RacingPlayerModel();
        $wins = $rpm->getCompNums($id);
        $statistic = $rpm->getStatisticOfPlayers($id);

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
                $save = $playersm->save(['id' => $id, 'image' => $img->getName()]);
                if ($save)
                {
                    $img->move(__DIR__ . '/../../public/uploads/players');
                }
                else
                {
                    $error = lang('carrera.uploaderror');
                }

            }
        }
        $player = $playersm->getPlayer($id);
        $data = array(
                'title' => $player['name'] . ' (' . $player['username'] . ')',
                'wins' => $wins,
                'statistic' => $statistic,
                'image' => $player['image'],
                'player' => $player,
                'lapsall' => $lapsm->getNumLaps()
        );
        echo view('parts/header', $data);
        echo view('playerdetails', $data);
        echo view('parts/footer');
    }

    public function delete($id)
    {
        helper(['form', 'url']);
        $playersm = new PlayerModel();
        $player = $playersm->getPlayer($id);

        if ($this->request->getMethod() == 'post')
        {
            unlink(__DIR__ . '/../../public/uploads/players/' . $player['image']);
            $save = $playersm->save(['id' => $id, 'image' => null]);
            return redirect()->to("players/details/$id");
        }
        $data = array(
                'title' => $player['name'] . ' (' . $player['username'] . ')',
                'player' => $player,
                'image' => $player['image']
        );

        echo view('parts/header', $data);
        echo view('playerdelete', $data);
        echo view('parts/footer');
    }
}
