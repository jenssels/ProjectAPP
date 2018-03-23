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
        $this->db->where('id', $dagindelingId);
        $query = $this->db->get('taak');
        return $query->result();
    }
    
    /**
     * Jens Sels - Verwijder taak en al zijn shifts 
     * @param $taakId Id van een taak
     */
    function delete($taakId){
        $this->load->model('Shift_model');
        $shifts = $this->Shift_model->getAllWhereTaak($taak->id);
        // Door alle shifts gaan en ze verwijderen
        foreach($shifts as $shift){
            $this->Shift_model->delete($shift->id);
        }
        $this->db->where('id', $taakId);
        $this->db->delete('taak');
        
    }
}
