<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vrijwilliger extends CI_Controller {

	public function index()
	{
		
	}
        
        public function taakindeling()
	{
	// Thomas Vansprengel - Taakindeling invullen
        $this->load->model('shift_model');
        $this->load->helper('form');
        $data['shiften'] = $this->shift_model->getAllWithTaak();

        $partials = array("hoofding" => "hoofding",
            "inhoud" => "vrijwilligerTaakindeling",
            "voetnoot" => "voetnoot");
        $data['emailGebruiker'] = 'jorensynaeve@hotmail.com';
        $data['titel'] = 'Taakindeling invullen';
        $data['paginaverantwoordelijke'] = 'Thomas Vansprengel';

        $this->template->load('main_master', $partials, $data);
	}

        
        public function overzicht($id)
	{
        // Thomas Vansprengel - Taakindeling invullen
        $this->load->model('TaakDeelname_model');
        $data['deelnames'] = $this->TaakDeelname_model->getAllWhereId($id);

        $partials = array("hoofding" => "hoofding",
            "inhoud" => "vrijwilligerOverzicht",
            "voetnoot" => "voetnoot");
        $data['emailGebruiker'] = 'jorensynaeve@hotmail.com';
        $data['titel'] = 'Taakindeling invullen';
        $data['paginaverantwoordelijke'] = 'Thomas Vansprengel';

        $this->template->load('main_master', $partials, $data);
            
        }
}
