<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Personeel extends CI_Controller {

	public function index($hashcode, $feestId)
	{
            $data['titel'] = 'Dagindeling invullen';
            $data['paginaverantwoordelijke'] = 'Joren Synaeve';
            // User data zetten in sessie
            $this->load->model('persoon_model');
            $personeelslid = $this->persoon_model->getPersoneelslid($hashcode);
            $this->session->set_userdata('emailgebruiker', $personeelslid->email);
            $data['emailGebruiker'] = $this->session->userdata('emailgebruiker');
            // Toon alle dagindeling met opties het voor het personeelslid
            $this->load->model('dagindeling_model');
            $data['dagindelingenMetOpties'] = $this->dagindeling_model->getAllDagindelingenWherePersoneelsfeestWithOpties($feestId);
            
            $partials = array('hoofding' => 'hoofding',
            'inhoud' => 'personeel/dagindelingInvullen',
            'voetnoot' => 'voetnoot');
            $this->template->load('main_master', $partials, $data);
	}
        
        // Stef Goor - Toon het overzicht van alle albums met daarbij de eerste foto van elk album
        public function overzichtAlbums(){
            $data['titel'] = 'Overzicht albums';
            $data['paginaverantwoordelijke'] = 'Stef Goor';
            
            $this->load->model('persoon_model');
            $data['emailGebruiker'] = $this->session->userdata('emailgebruiker');
            
            $this->load->model('album_model');
            $data['albums'] = $this->album_model->getAll();
            $albums = $data['albums'];
            $this->load->model('foto_model');
            $data['fotos'] = $this->foto_model->getAll();
            
            // Eerste foto van elk album ophalen
            foreach ($albums as $album) {
                $album->eersteFoto = $this->foto_model->getEersteFoto($album->id);
            }
            
            $partials = array('hoofding' => 'hoofding',
            'inhoud' => 'overzichtAlbums',
            'voetnoot' => 'voetnoot');
            $this->template->load('main_master', $partials, $data);
        }   
        
        public function toonAlbum($albumId) {
            $data['titel'] = 'Album bekijken';
            $data['paginaverantwoordelijke'] = 'Stef Goor';
            
            $this->load->model('persoon_model');
            $data['emailGebruiker'] = $this->session->userdata('emailgebruiker');
            
            $this->load->model('album_model');
            $data['album'] = $this->album_model->getAlbum($albumId);
            $this->load->model('foto_model');
            $data['fotos'] = $this->foto_model->getAllByAlbum($albumId);
            
            $partials = array('hoofding' => 'hoofding',
            'inhoud' => 'overzichtAlbums',
            'voetnoot' => 'voetnoot');
            $this->template->load('main_master', $partials, $data);
        }
}