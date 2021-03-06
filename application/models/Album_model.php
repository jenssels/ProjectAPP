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
            /**
     * Stef Goor - ophalen van alle albums
     * @return Een alle albums
     */
    function getAll(){
        $query = $this->db->get('album');
        return $query->result();
    }
        /**
     * Stef Goor
     * Ophalen van info over bepaald album
     * @param $albumId id van album
     * @return een album aan de hand van de id
     */
    function getAlbum($albumId){
        $this->db->where('id', $albumId);
        $query = $this->db->get('album');
        return $query->row();
    }
        /**
     * Joren Synaeve
     * Ophalen van alle albums met bijhorende fotos
     * @return alle albums met fotos
     */
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
