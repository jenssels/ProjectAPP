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
    
    /**
     * Jens Sels - Ophalen van alle personen van een personeelsfeest
     * @param $feestId Id van een personeelsfeest
     * @return Alle personen van een personeelsfeest
     */
    function getAllWherePersoneelsFeest($feestId){
        $this->db->where('personeelsfeestId', $feestId);
        $query = $this->db->get('persoon');

        return $query->result();
    }
    
    /**
     * Jens Sels - Verwijder een persoon en al zijn keuzes voor opties en taken
     * @param $persoonId Id van een persoon
     */
    function delete($persoonId){
        $this->load->model('OptieDeelname_model');
        $this->load->model('TaakDeelname_model');
        
        $optieDeelnames = $this->OptieDeelname_model->getAllWherePersoon();
        // Alle keuzes van opties doorlopen en ze verwijderen
        foreach($optieDeelnames as $optieDeelname){
            $this->OptieDeelname_model->delete($optieDeelname->id);
        }
        
        $taakDeelnames = $this->TaakDeelname_model->getAllWherePersoon();
        // Alle keuzes van taken doorlopen en ze verwijderen
        foreach($taakDeelnames as $taakDeelname){
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
    
    function getOrganisator($email, $wachtwoord, $typeId){
        //ophalen van de organisator
        $this->db->where('email', $email);
        $this->db->where('wachtwoord', $wachtwoord);
        $this->db->where('typeId', $typeId);
        $query = $this->db->get('persoon');
        
        return $query->row();
    }
    
    /**
     * 
     * @param type $hashcode
     */
    function getPersoneelslid($hashcode) {
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

}
