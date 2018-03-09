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
        $this->db->where('personeelsfeestId', $feestId);
        $this->db->where('typeId', '3');
        $query = $this->db->get('persoon');
        
        return $query->result();
    }
    
    function getAllVrijwilligersWherePersoneelsFeest($feestId){
        // Jens Sels - ophalen van alle gebruikers van geselecteerde personeelsfeest
        $this->db->where('personeelsfeestId', $feestId);
        $this->db->where('typeId', '2');
        $query = $this->db->get('persoon');
        
        return $query->result();
    }
}
