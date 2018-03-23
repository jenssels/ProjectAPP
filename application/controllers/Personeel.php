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
            
            $partials = array('hoofding' => 'hoofding',
            'inhoud' => 'personeel/dagindelingInvullen',
            'voetnoot' => 'voetnoot');
            $this->template->load('main_master', $partials, $data);
	}
        
        public function overzichtAlbums(){
            $data['titel'] = 'Overzicht albums';
            $data['paginaverantwoordelijke'] = 'Stef Goor';
            
            $this->load->model('persoon_model');
            $data['emailGebruiker'] = $this->session->userdata('emailgebruiker');
            
            $this->load->model('album_model');
            $data['albums'] = $this->album_model->getAll();
            $this->load->model('foto_model');
            $data['fotos'] = $this->foto_model->getAll();
            
            $partials = array('hoofding' => 'hoofding',
            'inhoud' => 'overzichtAlbums',
            'voetnoot' => 'voetnoot');
            $this->template->load('main_master', $partials, $data);
        }
}