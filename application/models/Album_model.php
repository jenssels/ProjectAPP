<?php
/**
 * @class Album_model
 * @brief Model-klasse voor albums
 * 
 * Model-klasse die alle methodes bevat om de database-tabel album te gebruiken
 */


class Album_model extends CI_Model {

    // +----------------------------------------------------------
    // | Personeelsfeest - Album_model.php
    // +----------------------------------------------------------
    // | 2 ITF Project APP/BIT Team 17 - 2017-2018
    // +----------------------------------------------------------
    // | Album model
    // +----------------------------------------------------------
    // | Auteur: Stef Goor
    // +----------------------------------------------------------

    function __construct()
    {
        parent::__construct();
    }
    
    // Stef Goor - ophalen van alle albums
    function getAll(){
        $query = $this->db->get('album');
        return $query->result();
    }
}
