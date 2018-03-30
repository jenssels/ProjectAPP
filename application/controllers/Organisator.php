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

        $data['emailGebruiker'] = $this->session->userdata('organisatorMail');
        $data['titel'] = 'Personeelsfeest overzicht';
        $data['paginaverantwoordelijke'] = 'Jens Sels';

        $this->template->load('main_master', $partials, $data);
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
        $data['emailGebruiker'] = $this->session->userdata('organisatorMail');
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
        $data['emailGebruiker'] = $this->session->userdata('organisatorMail');
        $data['titel'] = 'Personeelsfeest personeel uploaden';
        $data['paginaverantwoordelijke'] = 'Jens Sels';

        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Jens Sels - Ajax die de excel file gaat uploaden
     */
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
            unlink($data['full_path']);
            $this->load->view('ajax_uploadStatus', $data);
        }
    }

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
     */

    public function readExcel($data) {
        chmod($data['full_path'], 0775);
        $this->spreadsheet_excel_reader->setOutputEncoding('CP1251');
        $data = $this->spreadsheet_excel_reader->read($data['full_path'], false);
        $sheets = $this->spreadsheet_excel_reader->sheets[0];
        error_reporting(0);
        $data_excel = array();
        for ($i = 2; $i <= $sheets['numRows']; $i++) {
            if ($sheets['cells'][$i][1] == '')
                break;
            $data_excel[$i - 1]['Voornaam'] = $sheets['cells'][$i][1];
            $data_excel[$i - 1]['Naam'] = $sheets['cells'][$i][2];
            $data_excel[$i - 1]['Email'] = $sheets['cells'][$i][3];
        } return $data_excel;
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
     * Joren Synaeve
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

    /**
     * Joren Synaeve
     * @param type $dagindelingId     * 
     * Verwijdert de dagindeling
     */
    public function verwijderDagindeling($personeelsfeestId, $dagindelingId) {
        $this->load->model('dagindeling_model');
        $this->dagindeling_model->delete($dagindelingId);

        redirect('organisator/beheerDagindeling/' . $personeelsfeestId);
    }

}
