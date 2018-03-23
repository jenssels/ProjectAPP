<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Personeel extends CI_Controller {

	public function index($hashcode)
	{
            $data['titel'] = 'Dagindeling invullen';
            $data['paginaverantwoordelijke'] = 'Joren Synaeve';
            $this->load->model('persoon_model');
            $personeelslid = $this->persoon_model->getPersoneelslid($hashcode);
            $this->session->set_userdata('emailgebruiker', $personeelslid->email);
            $data['emailgebruiker'] = $this->session->userdata('emailgebruiker');
            
            $partials = array('hoofding' => 'hoofding',
            'inhoud' => 'persoon/dagindelingInvullen',
            'voetnoot' => 'voetnoot');
            $this->template->load('main_master', $partials, $data);
	}        
}
