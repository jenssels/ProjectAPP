<?php

class Taak_model extends CI_Model {

    // +----------------------------------------------------------
    // | Personeelsfeest - Taak_model.php
    // +----------------------------------------------------------
    // | 2 ITF Project APP/BIT Team 17 - 2017-2018
    // +----------------------------------------------------------
    // | Taak model
    // +----------------------------------------------------------
    // | Auteur: [naam]
    // +----------------------------------------------------------

    function __construct()
    {
        parent::__construct();
    }     
    /**
     * Jens Sels - Ophalen van alle taken van een dagindeling
     * @param $dagindelingId Id van een dagindeling
     * @return Alle taken van een dagindeling
     */
    function getAllWhereDagindeling($dagindelingId){
        $this->db->where('dagindelingid', $dagindelingId);
        $query = $this->db->get('taak');
        return $query->result();
    }
    
    /**
     * Jens Sels - Opvragen van alle taken met zijn shiften
     * @param $dagindelingId Id van een dagindeling
     * @return Alle taken van een dagindeling
     */
    function getAllWithDeelnamesWhereDagindeling($dagindelingId){
        $this->load->model('Shift_model');
        $this->db->where('dagindelingid', $dagindelingId);
        $query = $this->db->get('taak');
        $taken = $query->result();
        foreach($taken as $taak){
            $taak->shiften = $this->Shift_model->getAllWithDeelnamensWhereTaak($taak->id);
        }
        return $taken;
    }
    
    /**
     * Jens Sels - Verwijder taak en al zijn shifts 
     * @param $taakId Id van een taak
     */
    function delete($taakId){
        $this->load->model('Shift_model');
        $shifts = $this->Shift_model->getAllWhereTaak($taakId);
        // Door alle shifts gaan en ze verwijderen
        foreach($shifts as $shift){
            $this->Shift_model->delete($shift->id);
        }
        $this->db->where('id', $taakId);
        $this->db->delete('taak');
        
    }
    
        function insert($taak) {
            $this->db->insert('taak', $taak);
            return $this->db->insert_id();
        }
        function update($taak)
        {
        $this->db->where('id', $taak->id);
        $this->db->update('taak', $taak);
        }
         /**
     * Thomas Vansprengel 
     * Haal alle gegevens uit tabel
     */
        function getAll(){
        $query = $this->db->get('taak');
        return $query->result();
        }   
         /**
        * Thomas Vansprengel 
        * Haal alle taken aan de hand van de shift
        * @param $id shift Id
        * @return Een rij met taak en shift
        */
        function getByShift($id){
        // Thomas Vansprengel
        $this->db->where('id', $id);
        $query = $this->db->get('taak');
        return $query->row();
        }
         /**
     * Thomas Vansprengel 
     * Toon alle taken in relatie met de tabel dagindeling
          * @return Overzicht van alle taken met dagindeling
     */
        function getAllWithDagindeling(){
        $query = $this->db->get('taak');
        $taken = $query->result();
        
        $this->load->model('dagindeling_model');
        $this->load->model('locatie_model');
            foreach ($taken as $taak) {
                $taak->dagindeling = $this->dagindeling_model->getByTaak($taak->dagindelingId);
                $taak->locatie = $this->locatie_model->getById($taak->dagindelingId);
            }

        return $taken;
        }
     /**
     * Thomas Vansprengel 
     * Toon een bepaalde taak met dagindeling aan de hand van een dagindeling Id
     * @param $dagindelingId dagindeling ID waar je de taak van haalt
              * @return Overzicht van alle taken met dagindeling aan de hand van dagindelingid
     */
        function getAllWithDagindelingWhereDagindelingId($dagindelingId){
        $this->db->where('dagindelingId', $dagindelingId);
        $query = $this->db->get('taak');
        $taken = $query->result();
        
        $this->load->model('dagindeling_model');
        $this->load->model('locatie_model');
            foreach ($taken as $taak) {
                $taak->dagindeling = $this->dagindeling_model->getByTaak($taak->dagindelingId);
                $taak->locatie = $this->locatie_model->getById($taak->locatieId);
            }
        return $taken;
        }
             /**
     * Thomas Vansprengel 
     * Haal een bepaalde taak op met de dagindeling
     * @param $id Dagindeling id
              * @return Een bepaalde taak aan de hand van dagindelingid
     */
        function getWithDagindeling($id){
        $this->db->where('id', $id);
        $query = $this->db->get('taak');
        $taak = $query->row();
        
        $this->load->model('dagindeling_model');
        $this->load->model('locatie_model');
        $taak->dagindeling = $this->dagindeling_model->getByTaak($taak->dagindelingId);
        $taak->locatie = $this->locatie_model->getByTaak($taak->dagindelingId);
        
        return $taak;
        }
}
