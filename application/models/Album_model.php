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
    
    // Stef Goor - ophalen van info over een bepaald album
    function getAlbum($albumId){
        $this->db->where('id', $albumId);
        $query = $this->db->get('album');
        return $query->row();
    }
    
    // Stef Goor - ophalen van alle albums met de bijhorende fotos
    function getAllWithFotos(){
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('album');
        $albums = $query->result();
        
        //Koppeleing met tabel foto
        $this->load->model('foto_model');
        foreach ($albums as $album) {
            $album->fotos = $this->foto_model->getAllByAlbum($album->id);
        }
        return $albums;
    }
    
    /*
     * Jorne Lambrechts - album met foto's verwijderen
     */
    function deleteWithFotos($albumId){
        $this->load->model('foto_model');
        $this->foto_model->deleteFotosWhereAlbum($albumId);
        
        $this->db->where('id', $albumId);
        $this->db->delete('album');
        
    }
    
    
    /*
     * Jorne Lambrechts - album aanmaken
     */
    function insert ($album){
        $this->db->insert('album', $album);
        return $this->db->insert_id();
    }
    
}
