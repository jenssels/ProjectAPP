<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Personeel extends CI_Controller {

    /**
     * Joren Synaeve
     * Toont de indexpagina voor de deelnemer. Op deze pagina kan de deelnemer zijn/haar dagindeling invullen.
     * @param $hashcode De hashcode van de deelnemer
     * @param $feestId Het id van het personeelsfeest waarvoor de deelnemer uitgenodigd is
     */
    public function index($hashcode) {
        // Gegevens ophalen van persoon
        $this->load->model('persoon_model');
        $personeelslid = $this->persoon_model->getWhereHashcode($hashcode);
        $this->session->set_userdata('emailgebruiker', $personeelslid->email);
        $this->session->set_userdata('gebruikerTypeId', $personeelslid->typeId);
        $this->controleerDagindelingIsIngevuld($hashcode);
    }

    /**
     * Joren Synaeve
     * Controleert of een persoon de dagindeling al ingevuld heeft
     * @param $hashcode De hashcode van de persoon 
     */
    public function controleerDagindelingIsIngevuld($hashcode) {
        // Gegevens ophalen van persoon
        $this->load->model('persoon_model');
        $personeelslid = $this->persoon_model->getWhereHashcode($hashcode);
        // Alle opties ophalen die een persoon al gekozen heeft
        $this->load->model('optiedeelname_model');
        $optieDeelnames = $this->optiedeelname_model->getAllWherePersoon($personeelslid->id);
        if (count($optieDeelnames) > 0) {
            redirect('personeel/toonOverzichtIngevuldeDagindeling/' . $hashcode);
        } else {
            redirect('personeel/dagindelingInvullen/' . $hashcode);
        }
    }

    /**
     * Joren Synaeve
     * Toont de pagina waarop een persoon zijn dagindeling kan invullen
     * @param $hashcode De hashcode van de peroon
     */
    public function dagindelingInvullen($hashcode) {
        // Gegevens ophalen van persoon
        $this->load->model('persoon_model'); 
        $personeelslid = $this->persoon_model->getWhereHashcode($hashcode);
        
        if ($personeelslid != null) {
            $data['deelnemer'] = $personeelslid;
            $data['titel'] = 'Dagindeling invullen';
            $data['paginaverantwoordelijke'] = 'Joren Synaeve';
        
            // Toon alle dagindeling met opties het voor het personeelslid
            $this->load->model('dagindeling_model');
            $data['dagindelingenMetOpties'] = $this->dagindeling_model->getAllDagindelingenWherePersoneelsfeestWithOpties($personeelslid->personeelsfeestId);

            $partials = array('hoofding' => 'hoofding',
            'inhoud' => 'personeel/dagindelingInvullen',
            'voetnoot' => 'voetnoot');
        } else {
            $data['paginaverantwoordelijke'] = 'Jorne Lambrechts';
            $data['foutmelding'] = 'Deze hashcode hoort bij geen personeelslid, controleer uw hashcode';
            $data['titel'] = 'Dagindeling invullen: foutmelding';
            $partials = array('hoofding' => 'hoofding',
            'inhoud' => 'errors/error.php',
            'voetnoot' => 'voetnoot');
        }
        

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
            'inhoud' => 'personeel/overzichtAlbums',
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
            'inhoud' => 'personeel/overzichtFotos',
            'voetnoot' => 'voetnoot');
        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Joren Synaeve 
     * Haalt de ingevulde waarden op en schrijft dit weg in de database
     */
    public function bevestigIngevuldeDagindeling($hashcode) {
        // Gegevens van persoon ophalen
        $this->load->model('persoon_model');
        $persoon = $this->persoon_model->getWhereHashcode($hashcode);
        
        $this->load->model('optiedeelname_model');
        $optieDeelnames = $this->optiedeelname_model->getAllWherePersoon($persoon->id);
        
        // Gekozen opties ophalen en wegschrijven in database
        $aantalSelects = $this->input->post('aantalSelects');
        $this->load->model('optiedeelname_model');
        for ($i = 0; $i < $aantalSelects; $i++) {
            $optieDeelname = new stdClass();

            $optieDeelname->optieId = $this->input->post($i + 1);
            $optieDeelname->persoonId = $persoon->id;
            // Wegschrijven in database
            $this->optiedeelname_model->insert($optieDeelname);
        }

        // Laden van overzichtspagina
        $this->toonOverzichtIngevuldeDagindeling($hashcode);
    }

    /**
     * Joren Synaeve
     * @param $hashcode De hashcode van de deelnemer
     * @param $feestId Het id van het personeelsfeest waarvoor de deelnemer uitgenodigd is
     */
    public function toonOverzichtIngevuldeDagindeling($hashcode) {
        // Gegevens ophalen van persoon
        $this->load->model('persoon_model');
        $personeelslid = $this->persoon_model->getWhereHashcode($hashcode);
        $data['deelnemer'] = $personeelslid;
        
        // Standaardvariabelen
        $data['titel'] = 'Overzicht ingevulde dagindeling';
        $data['paginaverantwoordelijke'] = 'Joren Synaeve';
        $this->session->set_userdata('emailgebruiker', $personeelslid->email);

        // Dagindeling ophalen
        $this->load->model('dagindeling_model');
        $data['dagindelingen'] = $this->dagindeling_model->getAllWherePersoneelsfeest($personeelslid->personeelsfeestId);

        // Opties ophalen van persoon
        $this->load->model('optiedeelname_model');
        $data['optiedeelnames'] = $this->optiedeelname_model->getAllWherePersoonWithOpties($personeelslid->id);
        // Laden van pagina
        $partials = array('hoofding' => 'hoofding',
            'inhoud' => 'personeel/overzichtIngevuldeDagindeling',
            'voetnoot' => 'voetnoot');

        $this->template->load('main_master', $partials, $data);
    }
    
   /**
    * Jorne Lambrechts
    * @param id De id van de optiedeelname die bewerkt moet worden
    */ 
    public function bewerkDagindeling($id){
        //models laden
        $this->load->model('optiedeelname_model');
        $this->load->model('optie_model');
        $this->load->model('dagindeling_model');
        $this->load->model('persoon_model');
        
        //variabelen
        $optiedeelname = $this->optiedeelname_model->getWhereId($id);
        $optie = $this->optie_model->get($optiedeelname->optieId);
        $deelnemer = $this->persoon_model->getByPersoonId($optiedeelname->persoonId);
        $data['opties'] = $this->optie_model->getAllWhereDagindeling($optie->dagindelingId);
        $data['dagindeling'] = $this->dagindeling_model->get($optie->dagindelingId);
        $data['optieDeelnameId'] = $id;
        $data['deelnemer'] = $deelnemer;
        
        //standaardvariabelen
        $data['titel'] = 'Dagindeling bewerken';
        $data['paginaverantwoordelijke'] = 'Jorne Lambrechts';
        $this->session->set_userdata('emailgebruiker', $deelnemer->email);
        
        $partials = array('hoofding' => 'hoofding',
            'inhoud' => 'personeel/dagindelingBewerken',
            'voetnoot' => 'voetnoot');

        $this->template->load('main_master', $partials, $data);
    }
    
    /**
     * Jorne Lambrechts - de optiedeelname updaten
     * @param id De id van de optiedeelname die gewijzigd wordt
     */
    public function bewerkIngevuldeDagindeling($id){
        //models laden
        $this->load->model('optiedeelname_model');
        $this->load->model('persoon_model');
        
        //variabelen
        $optieId = $this->input->post('optie');
        $optieDeelname = $this->optiedeelname_model->getWhereId($id);
        $persoon = $this->persoon_model->getByPersoonId($optieDeelname->persoonId);
        $hashcode = $persoon->hashcode;
        
        $this->optiedeelname_model->update($id, $optieId);
        $this->toonOverzichtIngevuldeDagindeling($hashcode);
        
    }
}
