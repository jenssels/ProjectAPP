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
    
    /**
     * Stef Goor - Ophalen van alle fotos
     * @return Alle fotos
     */
    function getAll(){
        $query = $this->db->get('foto');
        return $query->result();
    }
    
    /**
     * Stef Goor - Ophalen van alle fotos van een album
     * @param $albumId Id van het album
     * @return Alle fotos van een album
     */
    function getAllByAlbum($albumId){
        $this->db->where('albumId', $albumId);
        $query = $this->db->get('foto');
        return $query->result();
    }
    
    /**
     * Stef Goor - ophalen van eerste foto van een bepaald album om te tonen op het overzicht van de albums
     * @param $albumId Id van het album
     * @return De eerste foto van een album
     */
    function getEersteFoto($albumId){
        $this->db->where('albumId', $albumId);
        $query = $this->db->get('foto');
        if ($query->num_rows() > 0){
            return $query->first_row()->naam;
        }
        else{
            return false;
        }
    }
    
    /*
     * Jorne Lambrechts - verwijder alle foto's van bepaald album
     */
    function deleteFotosWhereAlbum($albumId){
        $this->db->where('albumId', $albumId);
        $this->db->delete(foto);
    }
    
    /*
     * Jorne Lambrechts - Voegt foto's toe aan database
     */
    function insert($foto){
        $this->db->insert('foto', $foto);
        return $this->db->insert_id();
    }
                /**
     * Jorne Lambrechts
     * Foto verwijderen
     */
    function delete($fotoId){    
        $this->db->where('id', $fotoId);
        $this->db->delete('foto');
    }
}
