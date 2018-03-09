<?php

class Persoonslfeest_model extends CI_Model {

    // +----------------------------------------------------------
    // | Personeelsfeest - Type_model.php
    // +----------------------------------------------------------
    // | 2 ITF Project APP/BIT Team 17 - 2017-2018
    // +----------------------------------------------------------
    // | Type model
    // +----------------------------------------------------------
    // | Auteur: [naam]
    // +----------------------------------------------------------

    function __construct()
    {
        parent::__construct();
    }    
    
    function getAll(){
        // Jens Sels - ophalen van alle personeelsfeesten
        $query = $this->db->get('personeelsfeest');
        return $query->result();
    }
}
