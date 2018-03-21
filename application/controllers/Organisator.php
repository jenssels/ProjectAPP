<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Organisator extends CI_Controller {
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index() {
        $data['titel'] = 'Home';
        $data['paginaverantwoordelijke'] = 'Joren Synaeve';
        $data['emailGebruiker'] = '';
        $partials = array('hoofding' => 'hoofding',
            'inhoud' => 'welkom_view',
            'voetnoot' => 'voetnoot');
        $this->template->load('main_master', $partials, $data);
    }

    public function mail() {
        $config['useragent'] = 'CodeIgniter';
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';
        $config['smtp_user'] = 'team17project@gmail.com'; // Your gmail id
        $config['smtp_pass'] = 'project3'; // Your gmail Password
        $config['smtp_port'] = 465;
        $config['wordwrap'] = TRUE;
        $config['wrapchars'] = 76;
        $config['mailtype'] = 'html';
        $config['charset'] = 'iso-8859-1';
        $config['validate'] = FALSE;
        $config['priority'] = 3;
        $config['newline'] = "\r\n";
        $config['crlf'] = "\r\n";

        $this->load->library('email');
        $this->email->initialize($config);

        $this->email->from('team17project@gmail.com', 'TSS DEV');
        $this->email->to('jenssels1998@gmail.com');
        $this->email->cc('bla');

        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');

        $this->email->send();
    }

    public function mailView() {
        // Jens Sels - Tonen van pagina om mails te versturen
        $this->load->model('Persoon_model');
        $this->load->model('Dagindeling_model');
        $this->load->model('Taak_model');
        $this->load->model('Optie_model');
        $this->load->model('Shift_model');
    }

    public function personeelsFeestOverzicht() {
        // Jens Sels - Tonen van overzicht personeelsfeesten
        $this->load->model('Personeelsfeest_model');
        $data['personeelsFeesten'] = $this->Personeelsfeest_model->getAll();

        $partials = array("hoofding" => "hoofding",
            "inhoud" => "personeelsFeestOverzicht",
            "voetnoet" => "voetnoet");
        $data['emailGebruiker'] = 'jorensynaeve@hotmail.com';
        $data['titel'] = 'Personeelsfeest overzicht';
        $data['paginaverantwoordelijke'] = 'Jens Sels';
        
        $this->load->model('personeelsfeest_model');
        $data['personeelsFeesten'] = $this->personeelsfeest_model->getAll();
        
        $partials = array("hoofding" => "hoofding",
            "inhoud" => "personeelsFeestOverzicht",
            "voetnoot" => "voetnoot");
        $this->template->load('main_master', $partials, $data);
    }
    
    public function ajaxHaalDeelnemersOp(){
        $id = $this->input->get('id');
        // Jens Sels - Ophalen vrijwilligers en personeelsleden
        $this->load->model('persoon_model');
        
        $data['personeelsLeden'] = $this->persoon_model->getAllPersoneelsLedenWherePersoneelsFeest($id);
        $data['vrijwilligers'] = $this->persoon_model->getAllVrijwilligersWherePersoneelsFeest($id);
        
        $this->load->view('ajax_overzichtGebruikers', $data);
    }

    public function login() {
        $data['titel'] = 'Login';
        $data['paginaverantwoordelijke'] = 'Jorne Lambrechts';
        $data['emailGebruiker'] = 'jorensynaeve@hotmail.com';
        $partials = array("hoofding" => "hoofding",
            "inhoud" => "inloggen",
            "voetnoot" => "voetnoot");
        $this->template->load('main_master', $partials, $data);
    }
    
    /**
     * Toont een formulierpagina om een nieuwe organisator toe te voegen.
     */
    public function maakNieuweOrganisator() {
        $data['titel'] = 'Nieuwe organisator toevoegen';
        $data['paginaverantwoordelijke'] = 'Joren Synaeve';
        $data['emailGebruiker'] = 'jorensynaeve@hotmail.com';
        $partials = array('hoofding' => 'hoofding',
            'inhoud' => 'organisator/organisator_form',
            'voetnoot' => 'voetnoot');
        $this->template->load('main_master', $partials, $data);
    }
    
    /**
     * Registreert de nieuwe gebruiker indien er op 'Bevestigen' geklikt werd. Gaat terug naar de vorige pagina wanneer er op 'Annuleren' geklikt werd.
     */
    public function registreerNieuweOrganisator() {
        $knop = $this->input->post('knop');
        if ($knop == "Annuleren") {
            redirect('');
        } else {
            $organisator = new stdClass();
            
            $organisator->gebruikersnaam = $this->input->post('gebruikersnaam');
            $organisator->voornaam = $this->input->post('gebruikersnaam');
            $organisator->naam = $this->input->post('gebruikersnaam');
            $organisator->email = $this->input->post('gebruikersnaam');
            $organisator->wachtwoord = $this->input->post('gebruikersnaam');
            $organisator->typeId = 2;
            $organisator->gebruikersnaam = $this->input->post('gebruikersnaam');            
        }
    }
}
