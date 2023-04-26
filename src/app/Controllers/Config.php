<?php

namespace App\Controllers;
use App\Models\CarModel;
use App\Models\CompetitionModel;
use App\Models\ConfigModel;
use App\Models\PlayerModel;
use App\Models\RacingPlayerModel;

class Config extends BaseController
{
	public function index()
	{
        $configm = new ConfigModel();
        $configtitle = $configm->getConfig('TITLE');
        $configbanner = $configm->getConfig('BANNER');
        $data = array(
                'title' => lang('carrera.config'),
                'configtitle' => $configtitle,
                'configbanner' => $configbanner
        );

        if ($this->request->getMethod() == 'post')
        {
            $input = $this->validate([
                    'title' => 'required|min_length[3]|max_length[255]',
                    'banner' => [
                            'if_exist',
                            'uploaded[banner]',
                            'mime_in[file,image/jpg,image/jpeg,image/png]',
                            'max_size[file,4096]',
                    ]
            ]);
            if (!$input)
            {
                $data['validation'] = $this->validator;
            }
            else
            {
                $inputtitle['configkey'] = 'TITLE';
                $inputtitle['value'] = $this->request->getVar('title');
                if (!is_null($configtitle)) {
                    $inputtitle['id'] = $configtitle['id'];
                }
                $save = $configm->save($inputtitle);

                $img = $this->request->getFile('banner');
                if (!empty($img->getName())) {
                    $inputbanner['configkey'] = 'BANNER';
                    $inputbanner['value'] = $img->getName();
                    if (!is_null($configbanner)) {
                        $inputbanner['id'] = $configbanner['id'];
                        unlink(__DIR__ . '/../../public/uploads/config/' . $configbanner['value']);
                    }
                    $save = $configm->save($inputbanner);
                    $img->move(__DIR__ . '/../../public/uploads/config');
                }


                $data['configtitle'] = $configm->getConfig('TITLE');
                $data['configbanner'] = $configm->getConfig('BANNER');
                $data['success'] = lang('carrera.configsuccess');
            }
        }

		echo view('parts/header', $data);
        echo view('config', $data);
		echo view('parts/footer');
	}
}
