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
        $this->db->where('personeelsfeestid', $feestId);
        $query = $this->db->get('dagindeling');
        return $query->result();
    }
    
    /**
     * Jens Sels - Verwijder de dagindeling en alle opties en taken van de dagindeling
     * @param $dagindelingId Id van dagindeling
     */
    function delete($dagindelingId){
        $this->load->model('Optie_model');
        $this->load->model('Taak_model');      
        $opties = $this->Optie_model->getAllWhereDagindeling($dagindelingId);
        // Door alle opties gaan en ze verwijderen
        foreach($opties as $optie){
            $this->Optie_model->delete($optie->id);
        }
        $taken = $this->Taak_model->getAllWhereDagindeling($dagindelingId);
        // Door alle taken gaan en ze verwijderen
        foreach($taken as $taak){
            $this->Taak_model->delete($taak->id);
        }
        $this->db->where('id', $dagindelingId);
        $this->db->delete('dagindeling');
    }
}
