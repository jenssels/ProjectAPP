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
    function getById($id){
        // Thomas Vansprengel - ophalen van alle dagindelingen
        $this->db->where('id', $id);
        $query = $this->db->get('locatie');
        return $query->row();
    }
    //Thomas vansprengel - Locatie toevoegen
        function insert($locatie) {
            $this->db->insert('locatie', $locatie);
            return $this->db->insert_id();
        }
    function getAll(){
        // Thomas Vansprengel -     //Alle locaties halen
        $query = $this->db->get('locatie');
        return $query->result();
    }
    //Thomas vansprengel - Locatie verwijderen
    function delete($id){
        $this->db->where('id', $id);
        $this->db->delete('locatie');
        
    } 
    //Thomas vansprengel - locatie updaten
    function update($locatie)
        {
        $this->db->where('id', $locatie->id);
        $this->db->update('locatie', $locatie);
        }
}
