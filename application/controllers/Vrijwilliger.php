<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vrijwilliger extends CI_Controller {

    public function index() {
        
    }

    /**
     * Thomas Vansprengel
     * Laat vrijwilligers taakindeling invullen
     */
    public function taakindeling() {
        $this->load->model('shift_model');
        $this->load->model('locatie_model');
        $this->load->helper('form');
        $shiften = $this->shift_model->getAllWithTaak();
        foreach ($shiften as $shift) {
            $shift->taak->locatie = $this->locatie_model->getById($shift->taak->locatieId);
        }
        $data['shiften'] = $shiften;

        $partials = array("hoofding" => "hoofding",
            "inhoud" => "vrijwilligerTaakindeling",
            "voetnoot" => "voetnoot");
        $data['emailGebruiker'] = 'jorensynaeve@hotmail.com';
        $data['titel'] = 'Taakindeling invullen';
        $data['paginaverantwoordelijke'] = 'Thomas Vansprengel';

        $this->template->load('main_master', $partials, $data);
    }
    /**
     * Thomas Vansprengel
     * Toont overzicht van vrijwilligers
     */
    public function overzicht($id) {
        $this->load->model('TaakDeelname_model');
        $data['deelnames'] = $this->TaakDeelname_model->getAllWhereId($id);

        $partials = array("hoofding" => "hoofding",
            "inhoud" => "vrijwilligerOverzicht",
            "voetnoot" => "voetnoot");
        $data['emailGebruiker'] = 'jorensynaeve@hotmail.com';
        $data['titel'] = 'Taakindeling invullen';
        $data['paginaverantwoordelijke'] = 'Thomas Vansprengel';

        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Stef Goor
     * Toont het overzicht van alle albums met eventueel een thumbnail erbij
     */
    public function overzichtAlbums() {
        $data['titel'] = 'Overzicht albums';
        $data['paginaverantwoordelijke'] = 'Stef Goor';

        $this->load->model('persoon_model');
        $data['emailGebruiker'] = $this->session->userdata('emailgebruiker');

        $this->load->model('album_model');
        $data['albums'] = $this->album_model->getAll();
        $albums = $data['albums'];
        $this->load->model('foto_model');
        $data['fotos'] = $this->foto_model->getAll();

        foreach ($albums as $album) {
            $album->eersteFoto = $this->foto_model->getEersteFoto($album->id);
        }

        $partials = array('hoofding' => 'hoofding',
            'inhoud' => 'vrijwilliger/overzichtAlbums',
            'voetnoot' => 'voetnoot');
        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Stef Goor
     * Toont alle fotos van een bepaald album
     */
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
            'inhoud' => 'vrijwilliger/overzichtFotos',
            'voetnoot' => 'voetnoot');
        $this->template->load('main_master', $partials, $data);
    }

}
