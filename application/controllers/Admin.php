<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
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
        $data['title'] = 'Home';
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
        $data['title'] = 'Apple toestellen';
        $data['paginaverantwoordelijke'] = 'Jens Sels';
        $partials = array("hoofding" => "hoofding",
            "inhoud" => "personeelsFeestOverzicht",
            "voetnoot" => "voetnoot");
        $this->template->load('main_master', $partials, $data);
    }

    public function login() {
        $data['title'] = 'Login';
        $data['paginaverantwoordelijke'] = 'Jorne Lambrechts';
        $data['emailGebruiker'] = 'jorensynaeve@hotmail.com';
        $partials = array("hoofding" => "hoofding",
            "inhoud" => "inloggen",
            "voetnoot" => "voetnoot");
        $this->template->load('main_master', $partials, $data);
    }
}
