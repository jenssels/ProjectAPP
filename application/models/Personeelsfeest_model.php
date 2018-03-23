<?php

class Personeelsfeest_model extends CI_Model {

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

    /**
    *  Jens Sels - ophalen van alle personeelsfeesten
    * @return Alle personeelsfeesten
    */

    function getAll(){

        $query = $this->db->get('personeelsfeest');
        return $query->result();
    }
    
    /**
    *  Jens Sels - ophalen van een personeelsfeest
    * @param $id Id van het personeelsfeest
    * @return Het personeelsfeest
    */
    function get($id){
        $this->db->where('id', $id);
        $query = $this->db->get('personeelsfeest');
        return $query->row();
    }
}
