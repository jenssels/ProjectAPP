<?php

class OptieDeelname_model extends CI_Model {

    // +----------------------------------------------------------
    // | Personeelsfeest - OptieDeelname_model.php
    // +----------------------------------------------------------
    // | 2 ITF Project APP/BIT Team 17 - 2017-2018
    // +----------------------------------------------------------
    // | OptieDeelname model
    // +----------------------------------------------------------
    // | Auteur: Jens Sels
    // +----------------------------------------------------------

    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Jens Sels - Ophalen van alle keuzes van opties van een persoon
     * @param $persoonId Id van een persoon
     * @return Alle keuzes van opties van een persoon
     */
    function getAllWherePersoon($persoonId){
        $this->db->where('persoonid', $persoonId);
        $query = $this->db->get('optiedeelname');
        return $query->result();
    }
    
    /**
     * Jens Sels - Ophalen van alle keuzes van opties van een optie
     * @param $optieId Id van een optie
     * @return Alle keuzes van opties van een optie
     */
    function getAllWhereOptie($optieId){
        $this->db->where('optieid', $optieId);
        $query = $this->db->get('optiedeelname');
        return $query->result();
    }
    
    /**
     * Jens Sels - Verwijder een keuze van een optie
     * @param $optieDeelnameId Id van een keuze van een optie
     */
    function delete($optieDeelnameId){
        $this->db->where('id', $optieDeelnameId);
        $this->db->delete('optiedeelname');
    }
}
