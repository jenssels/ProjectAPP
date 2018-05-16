<?php

class Personeelsfeest_model extends CI_Model {

    // +----------------------------------------------------------
    // | Personeelsfeest - Type_model.php
    // +----------------------------------------------------------
    // | 2 ITF Project APP/BIT Team 17 - 2017-2018
    // +----------------------------------------------------------
    // | Type model
    // +----------------------------------------------------------
    // | Auteur: [naam]
    // +----------------------------------------------------------

    function __construct()
    {
        parent::__construct();
    }    

    /**
    *  Jens Sels - ophalen van alle personeelsfeesten
    * @return Alle personeelsfeesten
    */
    function getAll(){
        $query = $this->db->get('personeelsfeest');
        return $query->result();
    }
    
    /**
     * Jens Sels - Functie die alle informatie van een personeelsfeest opvraagd en ook de totaal inschrijvingen van het feest
     * @param $id Id van een personeelsfeest
     * @return Een Personeelsfeest
     */
    function getWithInschrijvingenWherePersoneelsfeest($id){
        $this->load->model('dagindeling_model');
        $this->load->model('persoon_model');
        $this->db->where('id', $id);
        $query = $this->db->get('personeelsfeest');
        $personeelsfeest = $query->row();
        $personeelsfeest->dagindelingen = $this->dagindeling_model->getAllDagIndelingenWithOptiesAndTakenWhereFeest($personeelsfeest->id);
        $personeelsfeest->inschrijvingen = $this->persoon_model->getInschrijvingenWherePersoneelsFeest($personeelsfeest->id);
        return $personeelsfeest;
    }
    
                /**
     * Thomas Vansprengel - Functie die alle informatie van een personeelsfeest opvraagt samen met de dagindeling
     * @param $id Het id van personeelsfeest
     * @return Een personeelsfeest
     */
    function getWithDagindelingenwherePersoneelsfeest($id){
        $this->load->model('dagindeling_model');
        $this->load->model('persoon_model');
        $this->db->where('id', $id);
        $query = $this->db->get('personeelsfeest');
        $personeelsfeest = $query->row();
        $personeelsfeest->dagindelingen = $this->dagindeling_model->getAllDagIndelingenWithTakenWhereFeest($personeelsfeest->id);
        return $personeelsfeest;
    }
    
    
    /**
    *  Jens Sels - ophalen van een personeelsfeest
    * @param $id Id van het personeelsfeest
    * @return Het personeelsfeest
    */
    function get($id){
        $this->db->where('id', $id);
        $query = $this->db->get('personeelsfeest');
        return $query->row();
    }
    /**
    *  Jens Sels - nieuw personeelsfeest aanmaken
    * @param $feest personeelsfeest object
    * @return id van nieuw personeelsfeest
    */
    function insert($feest){
        $this->db->insert('personeelsfeest', $feest);
        return $this->db->insert_id();
    }
    /**
    *  Jens Sels - nieuw personeelsfeest aanmaken
    * @param $feest personeelsfeest object
    */
    function update($feest){
        $this->db->where('id', $feest->id);
        $this->db->update('personeelsfeest', $feest);
        
    }
    /**
     * Jens Sels - delete personeelsfeest en alle gerelateerde info
     * @param $feestId Id van personeelsfeest
     */
    function delete($feestId){
        $this->load->model('Dagindeling_model');
        $this->load->model('Persoon_model');
               
        $dagindelingen = $this->Dagindeling_model->getAllWherePersoneelsfeest($feestId);  
        // Door alle dagindelingen gaan en ze verwijderen
            foreach($dagindelingen as $dagindeling){
                $this->Dagindeling_model->delete($dagindeling->id);
            }
        
        
        $personen = $this->Persoon_model->getAllWherePersoneelsfeest($feestId);
        // Door alle personen gaan en ze verwijderen
            foreach($personen as $persoon){
                $this->Persoon_model->delete($persoon->id);
            }
        
        
        $this->db->where('id', $feestId);
        $this->db->delete('personeelsfeest');
    }
    

}
