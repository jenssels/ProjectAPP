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
     * Joren - Ophalen van alle optiedeenames met bijhorende opties van een persoon
     * @param $persoonId Id van een persoon
     * @return Alle keuzes van opties van een persoon
     */
    function getAllWherePersoonWithOpties($persoonId) {
        $this->db->where('persoonid', $persoonId);
        $query = $this->db->get('optiedeelname');
        $optiedeelnames = $query->result();
        $this->load->model('optie_model');
        $this->load->model('dagindeling_model');
        foreach ($optiedeelnames as $optiedeelname) {
            $optiedeelname->optie = $this->optie_model->get($optiedeelname->optieId);
            $optiedeelname->optie->dagindeling = $this->dagindeling_model->get($optiedeelname->optie->dagindelingId);
        }
        
        return $optiedeelnames;
    }
    
    /**
     * Jens Sels - Opvragen van deelnemers van een optie
     * @param $optieId Id van een optie
     * @return Lijst met personen
     */    
    function getAllWithDeelnemersWhereOptie($optieId){
        $personen = array();
        $this->load->model('persoon_model');
        $this->db->where('optieid', $optieId);
        $query = $this->db->get('optiedeelname');
        $optiedeelnamens = $query->result();
        foreach($optiedeelnamens as $optiedeelname){
            array_push ($personen, $this->persoon_model->getByPersoonid($optiedeelname->persoonId));
        }
        return $personen;
    }
    
    /**
     * Jens Sels - Ophalen van aantal optiedeelnames van een persoon
     * @param $persoonId Id van een persoon
     * @return Aantal optiedeelnames
     */
    function getCountWherePersoon($persoonId){
        
        $this->db->where('persoonid', $persoonId);
        $aantal = $this->db->get('optiedeelname');
        return $aantal->num_rows();
    }
    
    /**
     * Jens Sels - Ophalen van het aantal inschrijvingen van een optie
     * @param $optieId Id van de optie
     * @return Aantal inschrijvingen
     */
    function getCountWhereOptie($optieId){
        
        $this->db->where('optieid', $optieId);
        $aantal = $this->db->get('optiedeelname');
        return $aantal->num_rows();
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
    
    /**
     * Joren Synaeve - Voegt een nieuwe optieDeelname toe
     * @param Een $optieDeelname object
     * @return Het id van het nieuwe optieDeelname record
     */
    function insert($optieDeelname) {
        $this->db->insert('optiedeelname', $optieDeelname);
        return $this->db->insert_id();
    }
    
    /**
     * Jorne Lambrechts - een optiedeelname uit de database halen
     * @param $id het ID van de optiedeelname die nodig is
     */
    function getWhereId($id){
        $this->db->where('id', $id);
        $query = $this->db->get('optiedeelname');
        return $query->row();
    }
    
    /**
     * Jorne Lambrechts - optiedeelname bewerken a.d.h.v. de meegegeven Id
     * @param Id De id van de optiedeelname die bewerkt moet worden.
     * @param optieId is het de nieuwe optieId die in de database moet komen.
     */
    function update($id, $optieId){
        $this->db->set('optieId', $optieId);
        $this->db->where('id', $id);
        $this->db->update('optiedeelname');
    }
}
