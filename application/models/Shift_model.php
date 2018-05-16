<?php

class Shift_model extends CI_Model {

    // +----------------------------------------------------------
    // | Personeelsfeest - Dagindeling_model.php
    // +----------------------------------------------------------
    // | 2 ITF Project APP/BIT Team 17 - 2017-2018
    // +----------------------------------------------------------
    // | Dagindeling model
    // +----------------------------------------------------------
    // | Auteur: [naam]
    // +----------------------------------------------------------

    function __construct()
    {
        parent::__construct();
    }

    
    function getById($id){
        $this->db->where('id', $id);
        $query = $this->db->get('shift');
        return $query->row();
    }   
    /**
     * Jens Sels - Ophalen van alle shifts van een taak
     * @param $taakId Id van een taak
     * @return Alle shifts van een taak
     */
    function getAllWhereTaak($taakId){
        $this->db->where('taakId', $taakId);
        $query = $this->db->get('shift');
        return $query->result();
    }
    /**
     * Jens Sels - Ophalen van shift en aantal deelnemers van de shift
     * @param $id Id van shift
     * @return Shift object
     */
    function getWithCount($id){
        $this->db->where('id', $id);
        $query = $this->db->get('shift');
        $shift = $query->row();
        $this->load->model('taakDeelname_model');
        $shift->deelnemers = $this->taakDeelname_model->getCountWhereShift($shift->id);
        return $shift;
        
    }
    
    /**
     * Jens Sels - Ophalen van alle shiften van een taak en hoeveel personen eraan deelnemen
     * @param $taakId Id van een taak
     * @return Alle shiften van een taak
     */
    function getAllWithDeelnamensWhereTaak($taakId){
        $this->load->model('TaakDeelname_model');
        $this->db->where('taakId', $taakId);
        $query = $this->db->get('shift');
        $shiften = $query->result();
        foreach ($shiften as $shift){
            $shift->deelnemers = $this->TaakDeelname_model->getCountWhereShift($shift->id);
        }
        return $shiften;
    }
    
    /**
     * Jens Sels - Verwijder shift en al zijn deelnames
     * @param $shiftId Id van een shift
     */
    function delete($shiftId){   
        $this->load->model('TaakDeelname_model');
        $taakDeelnames = $this->TaakDeelname_model->getAllWhereShift($shiftId);
        // Alle keuzes van taken doorlopen en ze verwijderen
        foreach($taakDeelnames as $taakDeelname){
            $this->TaakDeelname_model->delete($taakDeelname->id);
        }
        $this->db->where('id', $shiftId);
        $this->db->delete('shift');
    }
             /**
     * Thomas Vansprengel & Jens Sels
     * Ophalen van alle shiften aan de hand van bepaalde taak
     * @param $id Id van de taak 
     */
        function getAllWithTaakWhereTaak($id){
        $this->db->where('taakId', $id);
        $query = $this->db->get('shift');
        $shiften = $query->result();
        
        $this->load->model('taak_model');
        $this->load->model('taakdeelname_model');
    
            foreach ($shiften as $shift) {
                $shift->taak = $this->taak_model->getByShift($shift->taakId);
                $shift->deelnemers = $this->taakdeelname_model->getCountWhereShift($shift->id);
            }
        
            return $shiften;
        }     
             /**
     * Thomas Vansprengel 
     * Haal alle shiften op
     */
        function getAll(){
        $query = $this->db->get('taak');
        return $query->result();
        }   
             /**
     * Thomas Vansprengel 
     * Haal alle shiften op met de bijhorende taken
     */
        function getAllWithTaak(){
        $query = $this->db->get('shift');
        $shiften = $query->result();
        
        $this->load->model('taak_model');
        $this->load->model('taakdeelname_model');
            foreach ($shiften as $shift) {
                $shift->taak = $this->taak_model->getByShift($shift->taakId);
                $shift->deelnemers = $this->taakdeelname_model->getCountWhereShift($shift->id);
            }
            return $shiften;
        }       
         function insert($shift) {
            $this->db->insert('shift', $shift);
            return $this->db->insert_id();
        }
        function update($shift)
        {
        $this->db->where('id', $shift->id);
        $this->db->update('shift', $shift);
        }
}
