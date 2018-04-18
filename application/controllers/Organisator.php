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
    public function __construct() {
        parent::__construct();

        if (!$this->authex->isAangemeld()) {
            redirect('home/isNietAangemeld');
        }
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

        $data['titel'] = 'Personeelsfeest overzicht';
        $data['paginaverantwoordelijke'] = 'Jens Sels';

        $this->template->load('main_master', $partials, $data);
    }
    
    public function stuurMail($titel,$message,$mail,$type,$hash, $isInschrijfLink = false){
        $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://smtp.gmail.com',
                'smtp_port' => 465,
                'smtp_user' => 'team17project@gmail.com',
                'smtp_pass' => 'team17project',
                'mailtype'  => 'html',  
                'charset'   => 'utf-8'
                );
        if ($isInschrijfLink){
            if($type = 'personeel'){
                $link = 'http://localhost//index.php/personeel/index/' . $hash;
            }
            else{
                $link = 'http://localhost//index.php/vrijwilliger/index/' . $hash;
            }
            $message += '\r\n Gebruik onderstaande link om u keuzes voor het personeelsfeest op te geven \r\n' + $link;
        }
        $this->load->library('email');
        $this->load->library('encrypt');
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->from('team17project@gmail.com', 'Personeelsfeest Thomas More');
        $this->email->to($mail); 
        $this->email->subject($titel);
        $this->email->message($message);    
        $this->email->send();    
    }

    /**
     * Jens Sels - Openen van pagina om personeelsfeest aan te maken of wijzigen
     * @param $feestId Id van personeelsfeest of waarde = 'nieuw' als je nieuw personeelsfeest wilt aanmaken
     */
    public function personeelsFeestAanmakenForm($feestId) {
        if ($feestId == 'nieuw') {
            $nu = date("Y-m-d");
            $data['titel'] = 'Personeelsfeest aanmaken';
            $feest = new stdClass();
            $feest->id = 0;
            $feest->naam = "";
            $feest->beschrijving = "";
            $feest->datum = $nu;
            $feest->inschrijfdeadline = $nu;
            $data['feest'] = $feest;
        } else {
            $this->load->model('Personeelsfeest_model');
            $data['feest'] = $this->Personeelsfeest_model->get($feestId);
            $data['titel'] = 'Personeelsfeest bewerken';
        }
        $partials = array("hoofding" => "hoofding", "inhoud" => "personeelsFeestAanmaken", "voetnoot" => "voetnoot");
        $data['paginaverantwoordelijke'] = 'Jens Sels';

        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Jens Sels - Aanmaken of bewerken van personeelsfeesten
     */
    public function personeelsFeestAanmaken() {
        $feest = new stdClass();
        $feest->id = $this->input->post('id');
        $feest->naam = $this->input->post('naam');
        $feest->beschrijving = $this->input->post('beschrijving');
        $feest->datum = zetOmNaarYYYYMMDD($this->input->post('datum'));
        $feest->inschrijfdeadline = zetOmNaarYYYYMMDD($this->input->post('inschrijfdeadline'));
        $this->load->model('Personeelsfeest_model');
        if ($feest->id == 0) {
            $feest->id = $this->Personeelsfeest_model->insert($feest);
        } else {
            $this->Personeelsfeest_model->update($feest);
        }

        redirect('/organisator/personeelsFeestUploadForm/' . $feest->id);
    }

    /**
     * Jens Sels - Upload pagina openen van personeelsfeest om personeelsleden toe te voegen
     * @param $feestId Id van personeelsfeest
     */
    public function personeelsFeestUploadForm($feestId) {
        $this->session->set_userdata('feestId', $feestId);
        $partials = array("hoofding" => "hoofding",
            "inhoud" => "personeelsFeestUploadForm",
            "voetnoot" => "voetnoot");
        $data['feestId'] = $feestId;
        $data['titel'] = 'Personeelsfeest personeel uploaden';
        $data['paginaverantwoordelijke'] = 'Jens Sels';

        $this->template->load('main_master', $partials, $data);
    }

    //Thomas vansprengel, taak verwijderen
    public function verwijdertaak($id) {
        $this->load->model('taak_model');
        $data['taken'] = $this->taak_model->delete($id);
        $this->taakBeheren();
    }

    public function pasTaakAan() {
        $info = new stdClass();

        $info->id = $this->input->post('id');
        $info->naam = $this->input->post('naam');
        $info->beschrijving = $this->input->post('beschrijving');
        $info->dagindelingid = $this->input->post('dagindeling');
        $info->locatieid = $this->input->post('locatie');

        $this->load->model('Taak_model');
        $this->Taak_model->update($info);


        $this->taakBeheren();
    }

    //Thomas vansprengel, taak verwijderen
    public function shifttaak($id) {
        $this->load->model('shift_model');
        $data['shiften'] = $this->shift_model->getAllWithTaakWhereTaak($id);

        $partials = array("hoofding" => "hoofding",
            "inhoud" => "taakShiften",
            "voetnoot" => "voetnoot");
        $data['titel'] = 'Personeelsfeest overzicht';
        $data['paginaverantwoordelijke'] = 'Thomas Vansprengel';

        $this->template->load('main_master', $partials, $data);
    }

    //Thomas vansprengel, taak verwijderen
    public function edittaak($id) {

        $this->load->model('Locatie_model');
        $data['locaties'] = $this->Locatie_model->getAll();

        $this->load->model('Dagindeling_model');
        $data['dagindelingen'] = $this->Dagindeling_model->getAll();

        $this->load->model('taak_model');
        $data['taak'] = $this->taak_model->getWithDagindeling($id);

        $partials = array("hoofding" => "hoofding",
            "inhoud" => "taakBewerken",
            "voetnoot" => "voetnoot");
        $data['titel'] = 'Personeelsfeest overzicht';
        $data['paginaverantwoordelijke'] = 'Thomas Vansprengel';

        $this->template->load('main_master', $partials, $data);
    }

    //Thomas Vansprengel, overzicht taak beheren
    public function taakBeheren() {

        $this->load->model('taak_model');
        $data['taken'] = $this->taak_model->getAllWithDagindeling();

        $partials = array("hoofding" => "hoofding",
            "inhoud" => "takenBeheren",
            "voetnoot" => "voetnoot");
        $data['titel'] = 'Personeelsfeest overzicht';
        $data['paginaverantwoordelijke'] = 'Thomas Vansprengel';

        $this->template->load('main_master', $partials, $data);
    }

    public function ajaxUploadFile() {
        $config['upload_path'] = './assets/files/';
        $config['allowed_types'] = 'xls';
        $config['encrypt_name'] = TRUE;
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('excel')) {
            $data['errors'] = array('error' => $this->upload->display_errors());

            $this->load->view('ajax_uploadStatus', $data);
        } else {
            $uploadData = $this->upload->data();
            $data_excel = $this->readExcel($uploadData);
            $data['personeel'] = $this->uploadPersoneel($data_excel);

            $this->load->view('ajax_uploadStatus', $data);
        }
    }

    /**
     * Jens Sels - Ajax die de excel file gaat uploaden
     */
    public function ajaxAddPersoon() {
        $feestId = $this->session->userdata('feestId');
        $voornaam = $this->input->get('voornaam');
        $naam = $this->input->get('naam');
        $email = strval($this->input->get('email'));
        $check = $this->insertPersoon($feestId, $voornaam, $naam, $email);
        if ($check) {
            $data['personeel'] = 'Toegevoegd - ' . $voornaam . ' ' . $naam . '</br>';
        } else {
            $data['personeel'] = 'Al aanwezig in de database - ' . $voornaam . ' ' . $naam . '</br>';
        }
        $this->load->view('ajax_uploadStatus', $data);
    }

    /*
     * Jens Sels - Uitlezen van excel bestand en terug geven van array met personeelsleden in
     * @param data Object met gegevens van het excel bestand
     */

    public function readExcel($data) {
        chmod($data['full_path'], 0775);
        $this->spreadsheet_excel_reader->setOutputEncoding('CP1251');
        $this->spreadsheet_excel_reader->read($data['full_path'], false);
        $sheets = $this->spreadsheet_excel_reader->sheets[0];
        error_reporting(0);
        $data_excel = array();
        for ($i = 2; $i <= $sheets['numRows']; $i++) {
            if ($sheets['cells'][$i][1] == '')
                break;
            $data_excel[$i - 1]['Voornaam'] = $sheets['cells'][$i][1];
            $data_excel[$i - 1]['Naam'] = $sheets['cells'][$i][2];
            $data_excel[$i - 1]['Email'] = $sheets['cells'][$i][3];
        } 
        unlink($data['full_path']);
        return $data_excel;
    }

    /**
     * Jens Sels - Alle personeelsleden toevoegen aan de databank
     * @param personeel Object met gegevens van de personeelsleden
     * @return Lijst met alle personeelsleden en of ze toegevoegd zijn of niet
     */
    public function uploadPersoneel($personeel) {
        $this->load->model('Persoon_model');
        $feestId = $this->session->userdata('feestId');
        $personeelsLijst = "";
        for ($i = 1; $i < (count($personeel) + 1); $i++) {
            $voornaam = $personeel[$i]["Voornaam"];
            $naam = $personeel[$i]["Naam"];
            $email = strval($personeel[$i]["Email"]);
            $check = $this->insertPersoon($feestId, $voornaam, $naam, $email);
            if ($check) {
                $personeelsLijst .= 'Toegevoegd - ' . $voornaam . ' ' . $naam . '</br>';
            } else {
                $personeelsLijst .= 'Al aanwezig in de database - ' . $voornaam . ' ' . $naam . '</br>';
            }
        }
        return $personeelsLijst;
    }

    /**
     * Jens Sels - Toevoegen van personeelslid als hij nog niet aanwezig is in een personeelsfeest
     * @param $feestId Id van personeelsfeest
     * @param $voornaam Voornaam van personeelslid
     * @param $naam naam van personeelslid
     * @param $email Email van personeelslid
     * @return True als personeelslid is toegevoegd en false als hij al in de databank zit
     */
    public function insertPersoon($feestId, $voornaam, $naam, $email) {
        $this->load->model('Persoon_model');
        $personeelDatabase = $this->Persoon_model->getAllWherePersoneelsFeestAndEmail($feestId, $email);
        if (count($personeelDatabase) == 0) {
            $persoonObject = new stdClass();
            $persoonObject->voornaam = $voornaam;
            $persoonObject->naam = $naam;
            $persoonObject->email = $email;
            $persoonObject->typeId = 3;
            $persoonObject->personeelsfeestId = $feestId;
            $this->Persoon_model->insert($persoonObject);
            return true;
        }
        return false;
    }

    /**
     * Jens Sels - Verwijderen van personeelsfeest en alles wat ermee te maken heeft
     * @param $feestId Id van personeelsfeest
     */
    public function personeelsFeestVerwijderen($feestId) {
        $this->load->model('Personeelsfeest_model');

        $this->Personeelsfeest_model->delete($feestId);

        redirect('/organisator/personeelsFeestOverzicht');
    }

    /**
     *  Jens Sels - Ophalen vrijwilligers en personeelsleden en tonen in view met ajax
     */
    public function ajaxHaalDeelnemersOp() {
        $id = $this->input->get('id');
        $this->load->model('persoon_model');

        $data['personeelsLeden'] = $this->persoon_model->getAllPersoneelsLedenWherePersoneelsFeest($id);
        $data['vrijwilligers'] = $this->persoon_model->getAllVrijwilligersWherePersoneelsFeest($id);

        $this->load->view('ajax_overzichtGebruikers', $data);
    }
    
    /**
     * Joren Synaeve
     * Toont een pagina waar alle organisatoren getoond worden.
     * Van hieruit kan je de organisatoren beheren.
     */
    public function beheerOrganisatoren () {
        // Standaardvariabelen
        $data['titel'] = 'Organisatoren beheren';
        $data['paginaverantwoordelijke'] = 'Joren Synaeve';
        // Organisatoren laden
        $this->load->model('persoon_model');
        $data['organisatoren'] = $this->persoon_model->getAllWhereTypeId(1);
        // Laden van pagina
        $partials = array('hoofding' => 'hoofding',
            'inhoud' => 'organisator/beheerOrganisatoren',
            'voetnoot' => 'voetnoot');
        $this->template->load('main_master', $partials, $data);
    }
    
    /**
     * Joren Synaeve
     * Haalt de details van een organisator op aan de hand van de hashcode van de persoon.
     * Toont hierna de details in de huidige pagina in een tabel.
     */
    public function ajaxHaalOrganisatorDetailsOp() {
        $hashcode = $this->input->get('hashcode');
        $this->load->model('persoon_model');
        $data['organisator'] = $this->persoon_model->getWhereHashcode($hashcode);
        
        $this->load->view('organisator/ajax_detailsOrganisator', $data);
    }

    /**
     * Toont een formulierpagina om een nieuwe organisator toe te voegen.
     */
    public function maakNieuweOrganisator() {
        $data['titel'] = 'Nieuwe organisator toevoegen';
        $data['paginaverantwoordelijke'] = 'Joren Synaeve';
        $data['emailGebruiker'] = $this->session->userdata('emailgebruiker');
        $partials = array('hoofding' => 'hoofding',
            'inhoud' => 'organisator/organisator_form',
            'voetnoot' => 'voetnoot');
        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Joren Synaeve
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
            $organisator->wachtwoord = password_hash($this->input->post('wachtwoord'), PASSWORD_DEFAULT);
            $organisator->hashcode = random_string('alnum', 16);
            $organisator->typeId = 1;

            $this->load->model('persoon_model');
            $this->persoon_model->insertOrganisator($organisator);
        }
        
        redirect('organisator/beheerOrganisatoren');
    }

    //Foutmelding als aanmelden fout loopt
    public function foutAanmelden() {
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
        // Standaardvariabelen
        $data['titel'] = 'Dagindeling beheren';
        $data['paginaverantwoordelijke'] = 'Joren Synaeve';
        $data['emailGebruiker'] = $this->session->userdata('organisatorMail');

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
    public function maakNieuweDagindeling($personeelsfeestId) {
        // Standaardvariabelen
        $data['titel'] = 'Dagindeling toevoegen';
        $data['paginaverantwoordelijke'] = 'Joren Synaeve';
        $data['emailGebruiker'] = $this->session->userdata('organisatorMail');

        // Dagindeling laden
        $this->load->model('dagindeling_model');
        $data['dagindeling'] = $this->dagindeling_model->getEmptyDagindeling();
        // Personeelsfeest laden
        $this->load->model('personeelsfeest_model');
        $data['personeelsfeest'] = $this->personeelsfeest_model->get($personeelsfeestId);

        $partials = array('hoofding' => 'hoofding',
            'inhoud' => 'organisator/dagindelingFormulier',
            'voetnoot' => 'voetnoot');
        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Joren Synaeve
     * Toont een pagina met een formulier om de gekozen dagindeling te bewerken.
     * @param $personeelsfeestId Het id van het personeelsfeest waaraan de dagindeling gelinkt is
     * @param $dagindelingId Het id van de gekozen dagindeling
     */
    public function wijzigDagindeling($personeelsfeestId, $dagindelingId) {
        // Standaardvariabelen
        $data['titel'] = 'Dagindeling bewerken';
        $data['paginaverantwoordelijke'] = 'Joren Synaeve';
        $data['emailGebruiker'] = $this->session->userdata('organisatorMail');

        // Dagindeling laden
        $this->load->model('dagindeling_model');
        $data['dagindeling'] = $this->dagindeling_model->get($dagindelingId);
        // Personeelsfeest laden
        $this->load->model('personeelsfeest_model');
        $data['personeelsfeest'] = $this->personeelsfeest_model->get($personeelsfeestId);

        $partials = array('hoofding' => 'hoofding',
            'inhoud' => 'organisator/dagindelingFormulier',
            'voetnoot' => 'voetnoot');
        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Joren Synaeve
     * Voegt de ingevoerde gegevens toe of update de huidige dagindeling wanneer er op 'Bevestigen' wordt geklikt.
     * Toont daarna opnieuw het overzicht.
     * Toont opnieuw het overzicht wanneer er op 'Annuleren' wordt geklikt.
     */
    public function registreerDagindeling() {
        $knop = $this->input->post('knop');
        if ($knop == "Annuleren") {
            redirect('');
        } else {
            $dagindeling = new stdClass();

            $dagindeling->id = $this->input->post('dagindelingId');
            $dagindeling->naam = $this->input->post('naam');
            $dagindeling->beginuur = $this->input->post('beginuur') . ':00';
            $dagindeling->einduur = $this->input->post('einduur') . ':00';
            $dagindeling->beschrijving = $this->input->post('beschrijving');
            $dagindeling->voorVrijwilliger = $this->input->post('voorVrijwilliger');
            $dagindeling->personeelsfeestId = $this->input->post('personeelsfeestId');

            $this->load->model('dagindeling_model');
            if ($dagindeling->id == 0) {
                $this->dagindeling_model->insert($dagindeling);
            } else {
                $this->dagindeling_model->update($dagindeling);
            }
            redirect('organisator/beheerDagindeling/' . $dagindeling->personeelsfeestId);
        }
    }

    /**
     * Joren Synaeve
     * @param $dagindelingId Het id van de te verwijderen dagindeling 
     * Verwijdert de gekozen dagindeling
     */
    public function verwijderDagindeling($personeelsfeestId, $dagindelingId) {
        $this->load->model('dagindeling_model');
        $this->dagindeling_model->delete($dagindelingId);

        redirect('organisator/beheerDagindeling/' . $personeelsfeestId);
    }

    /*
     * Jorne Lambrechts
     * naar overzicht van albums gaan voor de organisator
     */

    public function overzichtAlbums() {
        $data['titel'] = 'Overzicht Albums';
        $data['paginaverantwoordelijke'] = 'Jorene Lambrechts';
        $data['emailGebruiker'] = $this->session->userdata('organisatorMail');

        $this->load->model('album_model');
        $data['albums'] = $this->album_model->getAll();
        $albums = $data['albums'];
        $this->load->model('foto_model');
        $data['fotos'] = $this->foto_model->getAll();

        foreach ($albums as $album) {
            $album->eersteFoto = $this->foto_model->getEersteFoto($album->id);
        }

        $partials = array('hoofding' => 'hoofding',
            'inhoud' => 'organisator/overzichtAlbums',
            'voetnoot' => 'voetnoot');
        $this->template->load('main_master', $partials, $data);
    }

    public function haalAjaxOp_OptiesBijDagindeling() {
        $dagindelingId = $this->input->get('dagindelingId');

        $this->load->model('optie_model');
        $data['opties'] = $this->optie_model->getAllWhereDagindeling($dagindelingId);

        $this->load->model('dagindeling_model');
        $data['dagindeling'] = $this->dagindeling_model->get($dagindelingId);

        $this->load->view('organisator/ajax_optiesBijDagindeling', $data);
    }
    
    /**
     * Stef Goor - Laad de view voor het sturen van mails
     */
    public function mailSturen($personeelsfeestId) {
        $partials = array("hoofding" => "hoofding",
            "inhoud" => "organisator/mailSturen",
            "voetnoot" => "voetnoot");
        $data['titel'] = 'Mail Sturen';
        $data['paginaverantwoordelijke'] = 'Stef Goor';
        
        $this->load->model('persoon_model');
        $data['personen'] = $this->persoon_model->getAllWherePersoneelsFeest($personeelsfeestId);
        $data['personeelsleden'] = $this->persoon_model->getAllPersoneelsLedenWherePersoneelsFeest($personeelsfeestId);
        $data['vrijwillgers'] = $this->persoon_model->getAllVrijwilligersWherePersoneelsFeest($personeelsfeestId);
        
        
        $this->load->model('dagindeling_model');
        $data['dagindelingen'] = $this->dagindeling_model->getAllWherePersoneelsFeest($personeelsfeestId);
        
        $this->template->load('main_master', $partials, $data);
    }
    
    /**
     * Joren Synaeve
     * @param type $dagindelingId
     */
    public function beheerShiftenBijDagindeling ($dagindelingId) {
        // Standaardvariabelen
        $data['titel'] = 'Shiften beheren';
        $data['paginaverantwoordelijke'] = 'Joren Synaeve';
        
        // Taken laden met shiften aan
        $this->load->model('taak_model');
        $taken = $this->taak_model->getAllWhereDagindeling($dagindelingId);
        $this->load->model('shift_model');
        foreach ($taken as $taak) {
            $taak->shiften = $this->shift_model->getAllWhereTaak($taak->id);
        }
        $data['taken'] = $taken;
        
        $partials = array('hoofding' => 'hoofding',
            'inhoud' => 'organisator/beheerShiftenBijDagindeling',
            'voetnoot' => 'voetnoot');
        $this->template->load('main_master', $partials, $data);
    }
}
