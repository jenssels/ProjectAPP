<?php
/**
 * @class Taakdeelname_model
 * @brief Model-klasse voor taakdeelnames
 *
 * Model-klasse die alle methodes bevat om de database-tabel taakdeelname te gebruiken
 */

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
     * Thomas Vansprengel 
     * Ophalen overzicht van deelnemers aan de hand van shift
     * @param $id Shift id
     */
    function getAllWhereId($id)
     {
        $this->db->where('shiftid', $id);
        $query = $this->db->get('taakdeelname');
        $deelnames = $query->result();
        
        $this->load->model('Persoon_model');
        foreach ($deelnames as $deelname){
            $deelname->persoon = $this->persoon_model->getByPersoonid($deelname->persoonId);     
        }    
        return $deelnames;
    }
    
             /**
     * Thomas Vansprengel & Jens Sels
     * Taakdeelname toevoegen
     * @return Id van insert
     */

    function insert($taakdeelname) {
            $this->db->insert('taakdeelname', $taakdeelname);
            return $this->db->insert_id();
        }
    /**
     * Jens Sels - Ophalen van alle deelnemers van een shift
     * @param $shiftId Id van shift
     * @return Lijst met deelnemers
     */
    function getAllWithDeelnemersWhereShift($shiftId){
        $personen = array();
        $this->load->model('persoon_model');
        $this->db->where('shiftId', $shiftId);
        $query = $this->db->get('taakdeelname');
        $taakdeelnamens = $query->result();
        foreach($taakdeelnamens as $taakdeelname){
            array_push($personen, $this->persoon_model->getByPersoonid($taakdeelname->persoonId));
        }
        return $personen;
    }
    /**
     * Jens Sels - Opvragen aantal taakdeelnames van een persoon
     * @param $persoonId Id van een persoon
     * @return Aantal taakdeelnames
     */
    function getCountWherePersoon($persoonId){
        $this->db->where('persoonId', $persoonId);
        $aantal = $this->db->get('taakdeelname');
        return $aantal->num_rows();

    }
     /**
     * Jens Sels - Ophalen van alle inschrijvingen van een shift
     * @param $shiftId Id van een taak
     * @return Aantal inschrijvingen
     */
    function getCountWhereShift($shiftId){
        $this->db->where('shiftid', $shiftId);
        $aantal =  $this->db->get('taakdeelname');
        return $aantal->num_rows();

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
     * @param $shiftId Id van een taak
     * @return Alle keuzes van taken van een taak
     */
    function getAllWhereShift($shiftid){
        $this->db->where('shiftid', $shiftid);
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
