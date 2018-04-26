<?php

class Persoon_model extends CI_Model {

    // +----------------------------------------------------------
    // | Personeelsfeest - Persoon_model.php
    // +----------------------------------------------------------
    // | 2 ITF Project APP/BIT Team 17 - 2017-2018
    // +----------------------------------------------------------
    // | Persoon model
    // +----------------------------------------------------------
    // | Auteur: [naam]
    // +----------------------------------------------------------

    function __construct() {
        parent::__construct();
    }

    function getByPersoonid($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('persoon');
        return $query->row();
    }

    /**
     * Jens Sels - Opvragen van het totaal aantal inschrijvingen van de personeelsleden en vrijwilligers van een bepaald personeelsfeest
     * @param $feestId Id van een personeelsfeest
     * @return Totaal aantal inschrijvingen
     */
    function getInschrijvingenWherePersoneelsFeest($feestId){
        $this->load->model('TaakDeelname_model');
        $this->load->model('OptieDeelname_model');
        $deelnemers = 0;
        $helpers = 0;
        $this->db->where('personeelsfeestId', $feestId);
        $query = $this->db->get('persoon');
        $personen =  $query->result();
        foreach($personen as $persoon){
            if($this->OptieDeelname_model->getCountWherePersoon($persoon->id) > 0){
                $deelnemers++;
            }
            if($this->TaakDeelname_model->getCountWherePersoon($persoon->id) > 0){
                $helpers++;
            }
        }
        return array('deelnemers' => $deelnemers, 'helpers' => $helpers);
    }
    /**
     * Jens Sels - Ophalen van alle personen van een personeelsfeest
     * @param $feestId Id van een personeelsfeest
     * @return Alle personen van een personeelsfeest
     */
    function getAllWherePersoneelsFeest($feestId) {
        $this->db->where('personeelsfeestId', $feestId);
        $query = $this->db->get('persoon');

        return $query->result();
    }

    /**
     * Jens Sels - ophalen van alle hashcodes
     * @return Alle hashcodes
     */
    function getAllHashCodes(){
        $this->db->select('hashcode');
        $query = $this->db->get('persoon');

        return $query->result();
    }

    /**
     * Jens Sels - Toevoegen van persoon
     * @param $persoon Persoon object
     * @return Id van toegevoegd persoon
     */
    function insert($persoon) {
        $this->db->insert('persoon', $persoon);
        return $this->db->insert_id();
    }

    /**
     * Jens Sels - Ophalen van alle personen met een email van een bepaald personeelsfeest
     * @param $feestId Id van personeelsfeest
     * @param $email Email van persoon
     * @return Alle personen met een email van een bepaald personeelsfeest
     */
    function getAllWherePersoneelsFeestAndEmail($feestId, $email) {
        $this->db->where('personeelsfeestId', $feestId);
        $this->db->where('email', $email);
        $query = $this->db->get('persoon');

        return $query->result();
    }

    /**
     * Jens Sels - Verwijder een persoon en al zijn keuzes voor opties en taken
     * @param $persoonId Id van een persoon
     */
    function delete($persoonId) {
        $this->load->model('OptieDeelname_model');
        $this->load->model('TaakDeelname_model');

        $optieDeelnames = $this->OptieDeelname_model->getAllWherePersoon($persoonId);
        // Alle keuzes van opties doorlopen en ze verwijderen
        foreach ($optieDeelnames as $optieDeelname) {
            $this->OptieDeelname_model->delete($optieDeelname->id);
        }

        $taakDeelnames = $this->TaakDeelname_model->getAllWherePersoon();
        // Alle keuzes van taken doorlopen en ze verwijderen
        foreach ($taakDeelnames as $taakDeelname) {
            $this->TaakDeelname_model->delete($taakDeelname->id);
        }
        $this->db->where('id', $persoonId);
        $this->db->delete('persoon');
    }

    /**
     *  Jens Sels - Ophalen van alle gebruikers van geselecteerde personeelsfeest
     * @param $feestId Id van personeelsfeest
     * @return Alle personeelsleden van het personeelsfeest 
     */
    function getAllPersoneelsLedenWherePersoneelsFeest($feestId) {
        $this->db->where('personeelsfeestId', $feestId);
        $this->db->where('typeId', '3');
        $query = $this->db->get('persoon');

        return $query->result();
    }

    /**
     *  Jens Sels - Ophalen van alle gebruikers van geselecteerde personeelsfeest
     * @param $feestId Id van personeelsfeest
     * @return Alle vrijwilligers van het personeelsfeest 
     */
    function getAllVrijwilligersWherePersoneelsFeest($feestId) {

        $this->db->where('personeelsfeestId', $feestId);
        $this->db->where('typeId', '2');
        $query = $this->db->get('persoon');

        return $query->result();
    }

    /**
     * Voegt de nieuwe organisator toe aan de database.
     * @param $organisator Het organisator object
     * @return Het id van het nieuwe record
     */
    function insertOrganisator($organisator) {
        $this->db->insert('persoon', $organisator);
        return $this->db->insert_id();
    }

    function getOrganisator($email, $wachtwoord, $typeId) {
        //ophalen van de organisator
        $this->db->where('email', $email);
        $this->db->where('typeId', $typeId);
        $query = $this->db->get('persoon');

        $organisator = $query->row();

        if (password_verify($wachtwoord, $organisator->wachtwoord)) {
            return $organisator;
        } else {
            return null;
        }
    }

    /**
     * Joren Synaeve
     * @param $hashcode De hashcode van het op te halen personeelslid
     * @return Het persoonobject
     */
    function getWhereHashcode($hashcode) {
        $this->db->where('hashcode', $hashcode);
        $query = $this->db->get('persoon');

        return $query->row();
    }

    /**
     * Zoekt in de tabel persoon naar een record dat match met de ingevoerde gegevens     
     * @param type $email
     * @param type $wachtwoord
     * @param type $typeId
     * @return Het record uit de databas dat voldoet aan de voorwaarden, false als er geen gevonden kan worden
     */
    function controleerAanmeldgegevens($email, $wachtwoord, $typeId) {
        $this->db->where('email', $email);
        $this->db->where('wachtwoord', $wachtwoord);
        $this->db->where('typeId', $typeId);
        $query = $this->db->get('persoon');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * Joren Synaeve
     * Haalt alle personen uit de database met een bepaald typeId. 
     * @param $id Het typeId waarop gezocht wordt
     * @return Een persoonobject
     * @return Een false wanneer er geen personen gevonden worden
     */
    function getAllWhereTypeId($id) {
        $this->db->where('typeId', $id);
        $query = $this->db->get('persoon');
        
        return $query->result();
    }

}
