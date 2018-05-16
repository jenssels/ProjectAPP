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

    function __construct() {
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
     * Thomas Vansprengel - Ophalen van alle dagindelingen
     * @return Alle dagindelingen
     */
    function getAll() {
        $query = $this->db->get('dagindeling');
        return $query->result();
    }

    /**
     * Jens Sels - Ophalen van alle dagindelingen van een personeelsfeest
     * @param $feestId Id van personeelsfeest
     * @return alle dagindelingen van een personeelsfeest
     */
    function getAllWherePersoneelsfeest($feestId) {
        $this->db->where('personeelsfeestId', $feestId);
        $this->db->order_by('beginuur', 'asc');
        $query = $this->db->get('dagindeling');
        return $query->result();
    }

    /**
     * Jens Sels - Verwijder de dagindeling en alle opties en taken van de dagindeling
     * @param $dagindelingId Id van dagindeling
     */
    function delete($dagindelingId) {

        $this->load->model('Optie_model');
        $this->load->model('Taak_model');
        $opties = $this->Optie_model->getAllWhereDagindeling($dagindelingId);
        // Door alle opties gaan en ze verwijderen
        foreach ($opties as $optie) {
            $this->Optie_model->delete($optie->id);
        }
        $taken = $this->Taak_model->getAllWhereDagindeling($dagindelingId);
        // Door alle taken gaan en ze verwijderen
        foreach ($taken as $taak) {
            $this->Taak_model->delete($taak->id);
        }
        $this->db->where('id', $dagindelingId);
        $this->db->delete('dagindeling');
    }
    
    /**
     * Jens Sels - Opvragen van alle dagindelingen met zijn opties en taken van een personeelsfeest
     * @param $feestId Id van een personeelsfeest
     * @return Alle dagindelingen van een personeelsfeest
     */
    function getAllDagIndelingenWithOptiesAndTakenWhereFeest($feestId){
        $this->db->where('personeelsfeestid', $feestId);
        $query = $this->db->get('dagindeling');
        $dagindelingen =  $query->result();
        $this->load->model('Optie_model');
        $this->load->model('Taak_model');
        foreach($dagindelingen as $dagindeling){
           $dagindeling->opties = $this->Optie_model->getAllWithDeelnamesWhereDagindeling($dagindeling->id);
           $dagindeling->taken = $this->Taak_model->getAllWithDeelnamesWhereDagindeling($dagindeling->id);
        }
        return $dagindelingen;
    }
    
    function getAllDagIndelingenWithTakenWhereFeest($feestId){
        $this->db->where('personeelsfeestid', $feestId);
        $query = $this->db->get('dagindeling');
        $dagindelingen =  $query->result();
        $this->load->model('Optie_model');
        $this->load->model('Taak_model');
        foreach($dagindelingen as $dagindeling){
           $dagindeling->taken = $this->Taak_model->getAllWithShiftenAndLocatiesWhereDagindeling($dagindeling->id);
        }
        return $dagindelingen;
    }

    /**
     * Joren Synaeve - Voegt een nieuwe dagindeling toe aan de database
     * @param Een $dagindeling object
     * @return Het id van het nieuwe dagindeling record
     */
    function insert($dagindeling) {
        $this->db->insert('dagindeling', $dagindeling);
        return $this->db->insert_id();
    }
    
    /**
     * Joren Synaeve - Wijzigt een dagindeling 
     * @param Een $dagindeling object
     */
    function update($dagindeling) {
        $this->db->where('id', $dagindeling->id);
        $this->db->update('dagindeling', $dagindeling);
    }

    function getByTaak($id) {
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

    /**
     * Joren Synaeve - Maakt een leeg dagindeling object aan
     * @return Een leeg $dagindeling object
     */
    function getEmptyDagindeling() {
        $dagindeling = new stdClass();

        $dagindeling->id = 0;
        $dagindeling->naam = '';
        $dagindeling->beginuur = '00:00';
        $dagindeling->einduur = '00:00';
        $dagindeling->beschrijving = '';
        $dagindeling->voorVrijwilliger = 0;
        $dagindeling->personeelsfeestId = '';

        return $dagindeling;
    }

}
