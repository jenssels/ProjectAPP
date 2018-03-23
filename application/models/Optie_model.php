<?php

class Optie_model extends CI_Model {

    // +----------------------------------------------------------
    // | Personeelsfeest - Optie_model.php
    // +----------------------------------------------------------
    // | 2 ITF Project APP/BIT Team 17 - 2017-2018
    // +----------------------------------------------------------
    // | Optie model
    // +----------------------------------------------------------
    // | Auteur: [naam]
    // +----------------------------------------------------------

    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Jens Sels - Ophalen van alle opties van een dagindeling
     * @param $dagindelingId Id van een dagindeling
     * @return Alle opties van een dagindeling
     */
    function getAllWhereDagindeling($dagindelingId){
        $this->db->where('dagindelingid', $dagindelingId);
        $query = $this->db->get('optie');
        return $query->result();
    }
    
    /**
     * Jens Sels - Verwijder optie en al zijn deelnames 
     * @param $optieId Id van een optie
     */
    function delete($optieId){
        $this->load->model('OptieDeelname_model');
              
        $optieDeelnames = $this->OptieDeelname_model->getAllWhereOptie($optieId);
        // Alle keuzes van opties doorlopen en ze verwijderen
        foreach($optieDeelnames as $optieDeelname){
            $this->OptieDeelname_model->delete($optieDeelname->id);
        }
        $this->db->where('id', $optieId);
        $this->db->delete('optie');
    }
}
