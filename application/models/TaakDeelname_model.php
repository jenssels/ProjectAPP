<?php

class TaakDeelname_model extends CI_Model {

    // +----------------------------------------------------------
    // | Personeelsfeest - TaakDeelname_model.php
    // +----------------------------------------------------------
    // | 2 ITF Project APP/BIT Team 17 - 2017-2018
    // +----------------------------------------------------------
    // | TaakDeelname model
    // +----------------------------------------------------------
    // | Auteur: Jens Sels
    // +----------------------------------------------------------

    function __construct()
    {
        parent::__construct();
    }     
    
    /**
     * Jens Sels - Ophalen van alle keuzes van taken van een persoon
     * @param $persoonId Id van een persoon
     * @return Alle keuzes van taken van een persoon
     */
    function getAllWherePersoon($persoonId){
        $this->db->where('persoonid', $persoonId);
        $query = $this->db->get('taakdeelname');
        return $query->result();
    }
    
    /**
     * Jens Sels - Ophalen van alle keuzes van taken van een taak
     * @param $taakId Id van een taak
     * @return Alle keuzes van taken van een taak
     */
    function getAllWhereTaak($taakId){
        $this->db->where('taakid', $taakId);
        $query = $this->db->get('taakdeelname');
        return $query->result();
    }
    
    /**
     * Jens Sels - Verwijder een keuze van een taak
     * @param $taakDeelnameId Id van een keuze van een taak
     */
    function delete($taakDeelnameId){
        $this->db->where('id', $taakDeelnameId);
        $this->db->delete('taakdeelname');
    }
}
