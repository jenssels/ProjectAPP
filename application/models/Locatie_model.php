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
        /**
     * Thomas Vansprengel - Ophalen van een locatie aan de hand van id
     * @param $id Id van een locatie
     * @return Een locatie
     */
    function getById($id){
        $this->db->where('id', $id);
        $query = $this->db->get('locatie');
        return $query->row();
    }
        /**
     * Thomas Vansprengel - Locatie toevoegen
     * @return Een nieuwe id
     */
    function insert($locatie) {
        $this->db->insert('locatie', $locatie);
        return $this->db->insert_id();
    }
            /**
     * Thomas Vansprengel - Haal alle locaties op
     * @return Alle locaties
     */
    function getAll(){
        $query = $this->db->get('locatie');
        return $query->result();
    }
            /**
     * Thomas Vansprengel - Locatie verwijderen
     * @param $id Id van een locatie
     */
    function delete($id){
        $this->db->where('id', $id);
        $this->db->delete('locatie');
        
    } 
            /**
     * Thomas Vansprengel - Locatie aanpassen
     * @param $locatie Een locatie
     */
    function update($locatie)
        {
        $this->db->where('id', $locatie->id);
        $this->db->update('locatie', $locatie);
        }
        
    function getByTaak($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('locatie');
        return $query->row();
    }
}
