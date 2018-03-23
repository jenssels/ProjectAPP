<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Personeel extends CI_Controller {

	public function index($hashcode)
	{
            $data['titel'] = 'Dagindeling invullen';
            $data['paginaverantwoordelijke'] = 'Joren Synaeve';
            $this->load->model('persoon_model');
            $personeelslid = $this->persoon_model->getPersoneelslid($hashcode);
            $data['emailgebruiker'] = $personeelslid->email;
            
            $partials = array('hoofding' => 'hoofding',
            'inhoud' => 'organisator/organisator_form',
            'voetnoot' => 'voetnoot');
            $this->template->load('main_master', $partials, $data);
	}
        
        public function 
}
