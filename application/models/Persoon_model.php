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

    function getAllPersoneelsLedenWherePersoneelsFeest($feestId) {
        // Jens Sels - ophalen van alle gebruikers van geselecteerde personeelsfeest
        $this->db->where('personeelsfeestId', $feestId);
        $this->db->where('typeId', '3');
        $query = $this->db->get('persoon');

        return $query->result();
    }

    function getAllVrijwilligersWherePersoneelsFeest($feestId) {
        // Jens Sels - ophalen van alle gebruikers van geselecteerde personeelsfeest
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
     * 
     * @param type $hashcode
     */
    function getPersoneelslid($hashcode) {
        $this->db->where('hashcode', $hashcode);
        $query = $this->db->get('persoon');
        
        return $query->result();
    }

}
