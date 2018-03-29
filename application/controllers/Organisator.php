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
        
        if(!$this->authex->isAangemeld()){
            $data['emailGebruiker'] = anchor('organisator/aanmelden', 'Organisator login');
        } else {
            $data['emailGebruiker'] = $this->session->userdata('organisatorMail');
        }

        $partials = array('hoofding' => 'hoofding',
            'inhoud' => 'welkom_view',
            'voetnoot' => 'voetnoot');
        $this->template->load('main_master', $partials, $data);
    }
    /** 
    * Jens Sels - Tonen van overzicht personeelsfeesten
    */
    public function personeelsFeestOverzicht() {
        
        $this->load->model('Personeelsfeest_model');
        $data['personeelsFeesten'] = $this->Personeelsfeest_model->getAll();

        $partials = array("hoofding" => "hoofding",
            "inhoud" => "personeelsFeestOverzicht",
            "voetnoot" => "voetnoot");
        $data['emailGebruiker'] = $this->session->userdata('organisatorMail');
        $data['titel'] = 'Personeelsfeest overzicht';
        $data['paginaverantwoordelijke'] = 'Jens Sels';
        
        $this->template->load('main_master', $partials, $data);
    }
    
    /** 
    * Jens Sels - Openen van pagina om personeelsfeest aan te maken of wijzigen
    * @param $feestId Id van personeelsfeest of waarde = 'nieuw' als je nieuw personeelsfeest wilt aanmaken
    */
    
    public function personeelsFeestAanmakenForm($feestId){
        if ($feestId == 'nieuw'){
            $nu = date("Y-m-d");
            $data['titel'] = 'Personeelsfeest aanmaken';
            $feest = new stdClass();
            $feest->id = 0;
            $feest->naam = "";
            $feest->beschrijving = "";
            $feest->datum = $nu;
            $feest->inschrijfdeadline = $nu;
            $data['feest'] = $feest;          
        }
        else{
            $this->load->model('Personeelsfeest_model');
            $data['feest'] = $this->Personeelsfeest_model->get($feestId);
            $data['titel'] = 'Personeelsfeest bewerken';
        }
        
        $partials = array("hoofding" => "hoofding",
            "inhoud" => "personeelsFeestAanmaken",
            "voetnoot" => "voetnoot");
        $data['emailGebruiker'] = 'jenssels1998@gmail.com';
        $data['paginaverantwoordelijke'] = 'Jens Sels';
        
        $this->template->load('main_master', $partials, $data);
    }
    
    /**
     * Jens Sels - Aanmaken of bewerken van personeelsfeesten
     */
    public function personeelsFeestAanmaken(){
        $feest = new stdClass();
        $feest->id = $this->input->post('id');
        $feest->naam = $this->input->post('naam');
        $feest->beschrijving = $this->input->post('beschrijving');
        $feest->datum = zetOmNaarYYYYMMDD($this->input->post('datum'));
        $feest->inschrijfdeadline = zetOmNaarYYYYMMDD($this->input->post('inschrijfdeadline'));
        $this->load->model('Personeelsfeest_model');
        if($feest->id == 0){
            $feest->id = $this->Personeelsfeest_model->insert($feest);
        }
        else{
            $this->Personeelsfeest_model->update($feest);
        }
        
        $this->personeelsFeestOverzicht();
    }
    
    /**
     * Jens Sels - Verwijderen van personeelsfeest en alles wat ermee te maken heeft
     * @param $feestId Id van personeelsfeest
     */
    public function personeelsFeestVerwijderen($feestId){
        $this->load->model('Personeelsfeest_model');
        
        $this->Personeelsfeest_model->delete($feestId);
        
        $this->personeelsFeestOverzicht();
    }
    
    /**
    *  Jens Sels - Ophalen vrijwilligers en personeelsleden en tonen in view met ajax
    */
    public function ajaxHaalDeelnemersOp(){      
        $id = $this->input->get('id');
        $this->load->model('persoon_model');
        
        $data['personeelsLeden'] = $this->persoon_model->getAllPersoneelsLedenWherePersoneelsFeest($id);
        $data['vrijwilligers'] = $this->persoon_model->getAllVrijwilligersWherePersoneelsFeest($id);
        
        $this->load->view('ajax_overzichtGebruikers', $data);
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
                redirect('organisator/foutAanmelden');
            }
        } else {
            redirect ('organisator/index');
        }
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
     * Registreert de nieuwe gebruiker indien er op 'Bevestigen' geklikt werd. 
     * Gaat terug naar de vorige pagina wanneer er op 'Annuleren' geklikt werd.
     */
    public function registreerNieuweOrganisator() {
        $knop = $this->input->post('knop');
        if ($knop == "Annuleren") {
            redirect('');
        } else {
            $organisator = new stdClass();
            
            $organisator->voornaam = $this->input->post('voornaam');
            $organisator->naam = $this->input->post('naam');
            $organisator->email = $this->input->post('email');
            $organisator->wachtwoord = $this->input->post('wachtwoord');
            $organisator->hashcode = random_string('alnum', 16);
            $organisator->typeId = 1;
            
            $this->load->model('persoon_model');
            $this->persoon_model->insertOrganisator($organisator);
        }
    }
    
    //Foutmelding als aanmelden fout loopt
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
     * Joren Synaeve
     * Toont een pagina met daarop de dagindeling van een specifiek personeelsfeest.
     * @param type $personeelsfeestId
     */
    public function beheerDagindeling($personeelsfeestId) {
        // Controleren van aanmelden
        if ($this->authex->isAangemeld()) {
            
        } else {
                        
        }
        
        // Standaardvariabelen
        $data['titel'] = 'Dagindeling beheren';
        $data['paginaverantwoordelijke'] = 'Joren Synaeve';
        $data['emailGebruiker'] = '';
        
        // Eigenlijke pagina laden
        $this->load->model('personeelsfeest_model');
        $data['personeelsfeest'] = $this->personeelsfeest_model->get($personeelsfeestId);
        
        $this->load->model('dagindeling_model');
        $data['dagindelingenBijFeest'] = $this->dagindeling_model->getAllWherePersoneelsfeest($personeelsfeestId);
        
        $partials = array('hoofding' => 'hoofding',
            'inhoud' => 'organisator/beheerDagindeling',
            'voetnoot' => 'voetnoot');
        $this->template->load('main_master', $partials, $data);
    }
    
    /**
     * Joren Synaeve
     * Gaat naar een pagina met formulier om een nieuwe dagindeling toe te voegen.
     */
    public function toevoegenDagindeling($personeelsfeestId) {
        // Controleren van aanmelden
        
        // Standaardvariabelen
        $data['titel'] = 'Dagindeling toevoegen';
        $data['paginaverantwoordelijke'] = 'Joren Synaeve';
        $data['emailGebruiker'] = '';
        
        // Eigenlijke pagina laden
        $this->load->model('personeelsfeest_model');
        $data['personeelsfeest'] = $this->personeelsfeest_model->get($personeelsfeestId);
        
        $partials = array('hoofding' => 'hoofding',
            'inhoud' => 'organisator/toevoegenDagindeling',
            'voetnoot' => 'voetnoot');
        $this->template->load('main_master', $partials, $data);
    }
    
    /**
     * Voegt de ingevoerde gegevens toe wanneer er op 'Bevestigen' werd geklikt.
     * Toont opnieuw het overzicht wanneer er op 'Annuleren' wordt geklikt.
     */
    public function voegDagindelingToe() {
        $knop = $this->input->post('knop');
        if ($knop == "Annuleren") {
            redirect('');
        } else {
            $dagindeling = new stdClass();
            
            $dagindeling->naam = $this->input->post('naam');
            $dagindeling->beginuur = $this->input->post('beginuur') . ':00';
            $dagindeling->einduur = $this->input->post('einduur') . ':00';
            $dagindeling->beschrijving = $this->input->post('beschrijving');
            $dagindeling->voorVrijwilliger = $this->input->post('voorVrijwilliger');  
            $dagindeling->personeelsfeestId = $this->input->post('personeelsfeestId');
            
            $this->load->model('dagindeling_model');
            $this->dagindeling_model->insert($dagindeling);
            
            redirect('organisator/beheerDagindeling/' . $dagindeling->personeelsfeestId);
        }
    }
}

