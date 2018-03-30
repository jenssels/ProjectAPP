<?php

class Locatie_model extends CI_Model {

    // +----------------------------------------------------------
    // | Personeelsfeest - Locatie_model.php
    // +----------------------------------------------------------
    // | 2 ITF Project APP/BIT Team 17 - 2017-2018
    // +----------------------------------------------------------
    // | Locatie model
    // +----------------------------------------------------------
    // | Auteur: [naam]
    // +----------------------------------------------------------

    function __construct()
    {
        parent::__construct();
    }       
    
        function getByTaak($id){
        // Thomas Vansprengel - ophalen van alle dagindelingen
        $this->db->where('id', $id);
        $query = $this->db->get('locatie');
        return $query->row();
    }
    

    function getAll(){
        // Thomas Vansprengel -     //Alle locaties halen
        $query = $this->db->get('locatie');
        return $query->result();
    }
}
