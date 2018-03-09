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

    function __construct()
    {
        parent::__construct();
    }
    
    function getAllPersoneelsLedenWherePersoneelsFeest($feestId){
        // Jens Sels - ophalen van alle gebruikers van geselecteerde personeelsfeest
        $query = $this->db->get('personeelsfeest');
        $query = $this->db->where('personeelsfeestId', $feestId);
        $query = $this->db->where('typeId', '3');
        return $query->result();
    }
    
    function getAllVrijwilligersWherePersoneelsFeest($feestId){
        // Jens Sels - ophalen van alle gebruikers van geselecteerde personeelsfeest
        $query = $this->db->get('personeelsfeest');
        $query = $this->db->where('personeelsfeestId', $feestId);
        $query = $this->db->where('typeId', '2');
        return $query->result();
    }
}
