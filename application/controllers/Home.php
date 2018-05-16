<?php
/**
 * @class Home
 * @brief Controller-klasse voor Home
 *
 * Controller klasse met alle methodes die gebruikt worden in Home
 */


defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
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
    
    public function __construct() {
        parent::__construct();
    }
    
                /**
     * Joren Synaeve - Homepagina
     */
    public function index() {
        $data['titel'] = 'Home';
        $data['paginaverantwoordelijke'] = 'Joren Synaeve';
        
        if(!$this->authex->isAangemeld()){
            $data['emailGebruiker'] = '';
        } else {
            $data['emailGebruiker'] = $this->session->userdata('organisatorMail');
        }

        $partials = array('hoofding' => 'hoofding',
            'inhoud' => 'welkom_view',
            'voetnoot' => 'voetnoot');
        $this->template->load('main_master', $partials, $data);
    }
    
    
    /**
     * Toont de inlogpagina voor de organisator.
     */
    public function aanmelden() {
        $data['titel'] = 'Aanmelden';
        $data['paginaverantwoordelijke'] = 'Jorne Lambrechts';
        $data['emailGebruiker'] = '';
        $partials = array("hoofding" => "hoofding",
            "inhoud" => "organisator/aanmelden",
            "voetnoot" => "voetnoot");
        $this->template->load('main_master', $partials, $data);
    }
    
    /**
     * Joren Synaeve
     * Meldt de huidige gebruiker af door de sessie te verwijderen en toont de homepagina
     */
    public function afmelden () {
        $this->authex->meldAf();
        redirect('');
    }
    
    /**
     * Controleert de gegevens die ingevuld zijn door de organisator om in te loggen.
     * Indien ze juist zijn, gaat hij naar ... pagina.
     * Indien ze fout zijn, wordt er een foutmelding getoond.
     */
    public function controleerAanmelden() {
        $email = $this->input->post('email');
        $wachtwoord = $this->input->post('wachtwoord');
        $typeId = 1;
        
        //controleren of men wil aanmelden of op annuleer klikte
        if($this->input->post('aanmelden') != null){
            if ($this->authex->meldAan($email, $wachtwoord, $typeId)) {
                redirect('organisator/personeelsFeestOverzicht');
            } else {
                redirect('home/foutAanmelden');
            }
        } else {
            redirect ('home/index');
        }
    }
    
                /**
     * Jorne Lambrechts - Foutmelding als aanmelden niet lukt
     */
    public function foutAanmelden(){
        $data['titel'] = 'Aanmeld fout!';
        $data['paginaverantwoordelijke'] = 'Jorne Lambrechts';
        $data['emailGebruiker'] = anchor('organisator/aanmelden', 'Organisator login');
        $data['foutmelding'] = "Er bestaat geen organisator met de opgegeven inloggevens";
        $partials = array('hoofding' => 'hoofding',
            'inhoud' => 'errors/error',
            'voetnoot' => 'voetnoot');
        $this->template->load('main_master', $partials, $data);
    }
    
                /**
     * Joren Synaeve - Errorpagina als persoon niet is aangemeld
     */
    public function isNietAangemeld() {
        $data['titel'] = 'Geen toegang!';
        $data['paginaverantwoordelijke'] = 'Joren Synaeve';
        $data['emailGebruiker'] = '';
        
        $partials = array('hoofding' => 'hoofding',
            'inhoud' => 'errors/geenToegang',
            'voetnoot' => 'voetnoot');
        $this->template->load('main_master', $partials, $data);
    }
    
    /**
     * Joren Synaeve - Functie om een bestand te downloaden
     * @param $bestandsnaam De naam van het te downloaden bestand
     */
    public function downloadBestand($bestandsnaam) {
        force_download('assets/files/' . $bestandsnaam, NULL);
    }
}

