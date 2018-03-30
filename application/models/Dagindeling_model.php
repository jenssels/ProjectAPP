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
     * Joren Synaeve
     * Ophalen van de dagindeling met een bepaald id
     * @param $dagindelingId id van de dagindeling
     * @return de dagindeling met het bepaalde id
     */
    function get($dagindelingId) {
        $this->db->where('id', $dagindelingId);
        $query = $this->db->get('dagindeling');
        return $query->row();
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
    
    function insert($dagindeling) {
        $this->db->insert('dagindeling', $dagindeling);
        return $this->db->insert_id();
    }
    
    function getByTaak($id){
        // Thomas Vansprengel - ophalen van alle dagindelingen
        $this->db->where('id', $id);
        $query = $this->db->get('dagindeling');
        return $query->row();
    }
    
    function getAllDagindelingenWherePersoneelsfeestWithOpties($feestId) {
        $this->db->where('personeelsfeestid', $feestId);
        $query = $this->db->get('dagindeling');
        $dagindelingen = $query->result();
        $this->load->model('optie_model');
        foreach ($dagindelingen as $dagindeling) {
            $dagindeling->opties = $this->optie_model->getAllWhereDagindeling($dagindeling->id);
        }
        
        return $dagindelingen;
    }
}
