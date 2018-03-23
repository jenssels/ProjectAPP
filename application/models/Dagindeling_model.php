<?php

class Dagindeling_model extends CI_Model {

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
    /**
     * Jens Sels - Ophalen van alle dagindelingen van een personeelsfeest
     * @param $feestId Id van personeelsfeest
     * @return alle dagindelingen van een personeelsfeest
     */
    function getAllWherePersoneelsfeest($feestId){
        $this->db->where('id', $feestId);
        $query = $this->db->get('personeelsfeest');
        return $query->result();
    }
    
    function delete($dagindelingId){
        
    }
}
