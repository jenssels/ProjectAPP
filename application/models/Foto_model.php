<?php

class Foto_model extends CI_Model {

    // +----------------------------------------------------------
    // | Personeelsfeest - Foto_model.php
    // +----------------------------------------------------------
    // | 2 ITF Project APP/BIT Team 17 - 2017-2018
    // +----------------------------------------------------------
    // | Foto model
    // +----------------------------------------------------------
    // | Auteur: Stef Goor
    // +----------------------------------------------------------

    function __construct()
    {
        parent::__construct();
    }
    
    // Stef Goor - ophalen van alle foto's
    function getAll(){
        $query = $this->db->get('foto');
        return $query->result();
    }
    
    // Stef Goor - ophalen van alle foto's van een bepaald album
    function getAllByAlbum($albumId){
        $this->db->where('albumId', $albumId);
        $query = $this->db->get('foto');
        return $query->result();
    }
}
