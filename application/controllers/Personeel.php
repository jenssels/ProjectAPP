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
            $data['emailGebruiker'] = $this->session->userdata('emailgebruiker');
            
            $data['albums'] = $this->Album_model->getAll();
            $data['fotos'] = $this->Foto_model->getAll();
            
            $partials = array('hoofding' => 'hoofding',
            'inhoud' => 'personeel/dagindelingInvullen',
            'voetnoot' => 'voetnoot');
            $this->template->load('main_master', $partials, $data);
	}        
}
