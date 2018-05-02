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

    public function stuurTestMail() {
        $this->stuurMail('Test mail met link', 'Dit is een test bericht \n nieuwe lijn', 'jenssels1998@gmail.com', 'personeel', '6xkY28eLg9ho1tfu', true);
    }

    /**
     * Jens Sels - Tonen van inschrijvingen van een personeelsfeest
     * @param $feestId Id van een personeelsfeest
     */
    public function personeelsFeestInschrijvingen($feestId) {
        $this->load->model('Personeelsfeest_model');
        $data["personeelsfeest"] = $this->Personeelsfeest_model->getWithInschrijvingenWherePersoneelsfeest($feestId);
        $partials = array("hoofding" => "hoofding", "inhoud" => "personeelsFeestInschrijvingen", "voetnoot" => "voetnoot");
        $data['titel'] = 'Inschrijvingen ' . strtolower($data['personeelsfeest']->naam);
        $data['paginaverantwoordelijke'] = 'Jens Sels';

        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Jens Sels - Functie die mail gaat versturen via gmail
     * @param $titel Titel van de mail 
     * @param $message Inhoud die via de mail word verstuurd
     * @param $mail Mail adres naar wie de mail verstuurd word
     * @param $type Type persoon naar wie de mail word verstuurd
     * @param $hash Code die aan link word toegevoegd zodat ze op de site kunnen inloggen
     * @param $isInschrijfLink Moet er een inschrijflink meegestuurd worden ? 
     */
    public function stuurMail($titel, $message, $mail, $type, $hash, $isInschrijfLink = false) {
        $config = Array('protocol' => 'smtp', 'smtp_host' => 'ssl://smtp.gmail.com', 'smtp_port' => 465, 'smtp_user' => 'team17project@gmail.com', 'smtp_pass' => 'team17project', 'mailtype' => 'html', 'charset' => 'utf-8');
        if ($isInschrijfLink) {
            if ($type === 'personeel') {
                $link = base_url('index.php/personeel/index/' . $hash);
            } else {
                $link = base_url('index.php/vrijwilliger/index/' . $hash);
            }
            $message .= '\n Gebruik onderstaande link om u keuzes voor het personeelsfeest door te geven: \n ' . $link;
        }
        $this->load->library('email');
        $this->load->library('encrypt');
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->from('team17project@gmail.com', 'Personeelsfeest Thomas More');
        $this->email->to($mail);
        $this->email->subject($titel);
        $this->email->message(str_replace('\n', '<br />', $message));
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

    /**
     * Thomas Vansprengel - Verwijder een taak via de ID
     * @param $id Id van de te verwijderen taak
     */
    public function verwijdertaak($id) {
        $this->load->model('taak_model');
        $this->taak_model->delete($id);
        $referred_from = $this->session->userdata('referred_from_taak');
        redirect($referred_from, 'refresh');
    }

    /**
     * Thomas Vansprengel 
     * Functie om de aangepaste informatie van taak weg te schrijven
     */
    public function pasTaakAan() {
        $info = new stdClass();

        $info->id = $this->input->post('id');
        $info->naam = $this->input->post('naam');
        $info->beschrijving = $this->input->post('beschrijving');
        $info->dagindelingid = $this->input->post('dagindeling');
        $info->locatieid = $this->input->post('locatie');

        $this->load->model('Taak_model');
        $this->Taak_model->update($info);

        $referred_from = $this->session->userdata('referred_from_taak');
        redirect($referred_from, 'refresh');
    }

    /**
     * Thomas Vansprengel 
     * Functie om shiften van de taak te beheren
     * @param $id Taak id
     */
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

    /**
     * Thomas Vansprengel 
     * Een nieuwe taak maken met lege tekstvakken
     */
    public function taakToevoegen() {

        $this->load->model('Locatie_model');
        $data['locaties'] = $this->Locatie_model->getAll();

        $this->load->model('Dagindeling_model');
        $data['dagindelingen'] = $this->Dagindeling_model->getAll();

        $partials = array("hoofding" => "hoofding",
            "inhoud" => "taakToevoegen",
            "voetnoot" => "voetnoot");
        $data['emailGebruiker'] = $this->session->userdata('emailgebruiker');
        $data['titel'] = 'Taak Toevoegen';
        $data['paginaverantwoordelijke'] = 'Thomas Vansprengel';

        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Thomas Vansprengel 
     * De functie om de ingegeven informatie weg te schrijven in de tabel
     */
    public function voegTaakToe() {
        $taak = new stdClass();
        $taak->id = $this->input->post('id');
        $taak->naam = $this->input->post('naam');
        $taak->beschrijving = $this->input->post('beschrijving');
        $taak->dagindelingid = $this->input->post('dagindeling');
        $taak->locatieid = $this->input->post('locatie');

        $this->load->model('Taak_model');
        $this->Taak_model->insert($taak);


        $referred_from = $this->session->userdata('referred_from_taak');
        redirect($referred_from, 'refresh');
    }

    /**
     * Thomas Vansprengel 
     * Een taak aanpassen met de gegeven informatie in de tekstvakken
     * @param $id Taak id dat aangepast word
     */
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

    /**
      <<<<<<< HEAD
      =======
     * Thomas Vansprengel 
     * Toon het overzicht om de taken te beheren
     */
    public function takenBeheren() {
        $this->load->model('taak_model');
        $data['taken'] = $this->taak_model->getAllWithDagindeling();

        $partials = array("hoofding" => "hoofding",
            "inhoud" => "takenBeheren",
            "voetnoot" => "voetnoot");
        $data['emailGebruiker'] = $this->session->userdata('emailgebruiker');
        $data['titel'] = "Taken beheren";
        $data['paginaverantwoordelijke'] = 'Thomas Vansprengel';

        $this->template->load('main_master', $partials, $data);
    }

    /**
      >>>>>>> dc32fe06c01a52d4aeced78300d025bb9b06c978
     * Thomas Vansprengel 
     * Toon het overzicht om een individuele taak te beheren aan de hand van een dagindeling
     * @param $dagindelingId Taak aanpassen aan de hand van deze dagindeling
     */
    public function taakBeheren($dagindelingId) {
        $this->load->model('taak_model');
        $data['taken'] = $this->taak_model->getAllWithDagindelingWhereDagindelingId($dagindelingId);
        $data['dagindelingid'] = $dagindelingId;

        $partials = array("hoofding" => "hoofding",
            "inhoud" => "takenBeheren",
            "voetnoot" => "voetnoot");
        $data['titel'] = 'Personeelsfeest overzicht';
        $data['emailGebruiker'] = $this->session->userdata('emailgebruiker');
        $data['titel'] = 'Taken beheren';
        $data['paginaverantwoordelijke'] = 'Thomas Vansprengel';

        $this->template->load('main_master', $partials, $data);

        $this->session->set_userdata('referred_from_taak', current_url());
    }

    /**
     * Thomas Vansprengel 
     * Toon overzicht om locaties te beheren
     */
    public function locatiesBeheren() {
        $this->load->model('locatie_model');
        $data['locaties'] = $this->locatie_model->getAll();

        $partials = array("hoofding" => "hoofding",
            "inhoud" => "locatiesBeheren",
            "voetnoot" => "voetnoot");
        $data['emailGebruiker'] = $this->session->userdata('emailgebruiker');
        $data['titel'] = "Locaties beheren";
        $data['paginaverantwoordelijke'] = 'Thomas Vansprengel';

        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Thomas Vansprengel 
     * Functie om een locatie te verwijderen aan de hand van een id
     * @param $id De gegeven locatie ID te verwijderen
     */
    public function verwijderLocatie($id) {
        $this->load->model('locatie_model');
        $this->locatie_model->delete($id);
        $this->locatiesBeheren();
    }

    /**
     * Thomas Vansprengel 
     * Overzicht tonen om een nieuwe locatie aan te maken
     */
    public function locatieToevoegen() {
        $this->load->model('Locatie_model');
        $data['locaties'] = $this->Locatie_model->getAll();
        $partials = array("hoofding" => "hoofding",
            "inhoud" => "locatieToevoegen",
            "voetnoot" => "voetnoot");
        $data['emailGebruiker'] = $this->session->userdata('emailgebruiker');
        $data['titel'] = 'Locatie Toevoegen';
        $data['paginaverantwoordelijke'] = 'Thomas Vansprengel';

        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Thomas Vansprengel 
     * Functie om de gegevens van een nieuwe locatie weg te schrijven
     */
    public function voegLocatieToe() {
        $locatie = new stdClass();
        $locatie->id = $this->input->post('id');
        $locatie->naam = $this->input->post('naam');
        $locatie->adres = $this->input->post('adres');
        $locatie->plaats = $this->input->post('plaats');

        $this->load->model('locatie_model');
        $this->locatie_model->insert($locatie);

        $this->locatiesBeheren();
    }

    /**
     * Thomas Vansprengel 
     * Pas een locatie aan aan de hand van een ID
     * @param $id Locatie id
     */
    public function editLocatie($id) {
        $this->load->model('locatie_model');
        $data['locatie'] = $this->locatie_model->getById($id);

        $partials = array("hoofding" => "hoofding",
            "inhoud" => "locatieBewerken",
            "voetnoot" => "voetnoot");
        $data['titel'] = 'Personeelsfeest overzicht';
        $data['paginaverantwoordelijke'] = 'Thomas Vansprengel';

        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Thomas Vansprengel 
     * Functie om locatie aan te passen met nieuwe informatie
     */
    public function pasLocatieAan() {
        $locatie = new stdClass();
        $locatie->id = $this->input->post('id');
        $locatie->naam = $this->input->post('naam');
        $locatie->adres = $this->input->post('adres');
        $locatie->plaats = $this->input->post('plaats');

        $this->load->model('locatie_model');
        $this->locatie_model->update($locatie);


        $this->locatiesBeheren();
    }

    /**
     * Jens Sels - Functie die excel bestand gaat uploaden en uitlezen
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

            $this->load->view('ajax_uploadStatus', $data);
        }
    }

    /**
     * Jens Sels - Ajax die persoon gaar toevoegen aan personeelsfeest
     */
    public function ajaxAddPersoon() {
        $this->load->model('Persoon_model');
        $hashCodes = $this->persoon_model->getAllHashCodes();
        $feestId = $this->session->userdata('feestId');
        $mails = $this->persoon_model->getAllMailsWhereFeest($feestId);
        $voornaam = $this->input->get('voornaam');
        $naam = $this->input->get('naam');
        $email = strval($this->input->get('email'));
        $hash = random_string('alnum', 16);
        while (in_array($hash, $hashCodes)) {
            $hash = random_string('alnum', 16);
        }
        if (in_array($email, $mails)) {
            $data['personeel'] = 'Mail adres al aanwezig - ' . $voornaam . ' ' . $naam . '</br>';
        } else {
            $check = $this->insertPersoon($feestId, $voornaam, $naam, $email, $hash);
            if ($check) {
                $data['personeel'] = 'Toegevoegd - ' . $voornaam . ' ' . $naam . '</br>';
            } else {
                $data['personeel'] = 'Al aanwezig in de database - ' . $voornaam . ' ' . $naam . '</br>';
            }
        }
        $this->load->view('ajax_uploadStatus', $data);
    }

    /**
     * Jens Sels - Ajax functie die lijst toont met deelnemers van een optie of shift
     */
    public function ajaxToonDeelnemers() {
        $this->load->model('optiedeelname_model');
        $this->load->model('taakdeelname_model');
        $id = $this->input->get('id');
        $type = $this->input->get('type');
        $deelnemers = "";
        if ($type == 'optie') {
            $deelnemers = $this->optiedeelname_model->getAllWithDeelnemersWhereOptie($id);
        } else {
            $deelnemers = $this->taakdeelname_model->getAllWithDeelnemersWhereShift($id);
            ;
        }
        $data["deelnemers"] = $deelnemers;
        $this->load->view('ajax_toonDeelnemers', $data);
    }

    /**
     * Jens Sels - Ajax functie die controleerd of het maximum aantal deelnemers overschreden is
     * @return Volzet of niet
     */
    public function ajaxCheckVolzet() {
        $check = "leeg";
        $id = $this->input->get('id');
        $this->load->model('shift_model');
        $shift = $this->shift_model->getWithCount($id);
        if ((int) $shift->deelnemers >= (int) $shift->maxAantal) {
            $check = "true";
        } else {
            $check = "false";
        }
        print_r($check);
        return $check;
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
        $feestId = $this->session->userdata('feestId');
        $this->load->model('Persoon_model');
        $hashCodes = $this->persoon_model->getAllHashCodes();
        $mails = $this->persoon_model->getAllMailsWhereFeest($feestId);
        for ($i = 1; $i < (count($personeel) + 1); $i++) {
            $hash = random_string('alnum', 16);
            while (in_array($hash, $hashCodes)) {
                $hash = random_string('alnum', 16);
            }
            $voornaam = $personeel[$i]["Voornaam"];
            $naam = $personeel[$i]["Naam"];
            $email = strval($personeel[$i]["Email"]);
            if (in_array($email, $mails)) {
                $data['personeel'] = 'Mail adres al aanwezig - ' . $voornaam . ' ' . $naam . '</br>';
            } else {
                $check = $this->insertPersoon($feestId, $voornaam, $naam, $email, $hash);
                if ($check) {
                    $data['personeel'] = 'Toegevoegd - ' . $voornaam . ' ' . $naam . '</br>';
                } else {
                    $data['personeel'] = 'Al aanwezig in de database - ' . $voornaam . ' ' . $naam . '</br>';
                }
            }
        }
        return $data['personeel'];
    }

    /**
     * Jens Sels - Toevoegen van personeelslid als hij nog niet aanwezig is in een personeelsfeest
     * @param $feestId Id van personeelsfeest
     * @param $voornaam Voornaam van personeelslid
     * @param $naam naam van personeelslid
     * @param $email Email van personeelslid
     * @param $hash Hashcode waarmee het personeelslid naar de webpagina kan surfen
     * @return True als personeelslid is toegevoegd en false als hij al in de databank zit
     */
    public function insertPersoon($feestId, $voornaam, $naam, $email, $hash) {
        $this->load->model('Persoon_model');
        $personeelDatabase = $this->Persoon_model->getAllWherePersoneelsFeestAndEmail($feestId, $email);
        if (count($personeelDatabase) == 0) {
            $persoonObject = new stdClass();
            $persoonObject->voornaam = $voornaam;
            $persoonObject->naam = $naam;
            $persoonObject->email = $email;
            $persoonObject->hashcode = $hash;
            $persoonObject->typeId = 3;
            $persoonObject->personeelsfeestId = $feestId;
            $id = $this->Persoon_model->insert($persoonObject);
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
    public function beheerOrganisatoren() {
        // Standaardvariabelen
        $data['titel'] = 'Organisatoren beheren';
        $data['paginaverantwoordelijke'] = 'Joren Synaeve';
        // Organisatoren laden
        $this->load->model('persoon_model');
        $data['organisatoren'] = $this->persoon_model->getAllWhereTypeId('1');
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
        $hashCodes = $this->persoon_model->getAllHashCodes();
        $knop = $this->input->post('knop');
        if ($knop == "Annuleren") {
            redirect('');
        } else {
            $organisator = new stdClass();

            $organisator->voornaam = $this->input->post('voornaam');
            $organisator->naam = $this->input->post('naam');
            $organisator->email = $this->input->post('email');
            $organisator->wachtwoord = password_hash($this->input->post('wachtwoord'), PASSWORD_DEFAULT);
            $hash = random_string('alnum', 16);
            while (in_array($hash, $hashCodes)) {
                $hash = random_string('alnum', 16);
            }
            $organisator->hashcode = $hash;
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
        $data['paginaverantwoordelijke'] = 'Jorne Lambrechts';
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

    /**
     * Jens Sels
     * 
     */
    public function haalAjaxOp_OptiesBijDagindeling() {
        $dagindelingId = $this->input->get('dagindelingId');

        $this->load->model('optie_model');
        $data['opties'] = $this->optie_model->getAllWhereDagindeling($dagindelingId);

        $this->load->model('dagindeling_model');
        $data['dagindeling'] = $this->dagindeling_model->get($dagindelingId);

        $this->load->view('organisator/ajax_selectOptiesBijDagindeling', $data);
    }

    /**
     * Stef Goor
     * Haalt ajax op met select van de opties bij een dagindeling of personeelsfeest
     */
    public function haalAjaxOp_SelectOptiesBijDagindeling() {
        $dagindelingId = $this->input->get('dagindelingId');
        $feestId = $this->input->get('feestId');
        $data['dagindelingId'] = $dagindelingId;

        $this->load->model('optie_model');
        $data['dagindelingen'] = $this->optie_model->getAllWherePersoneelsfeest($feestId);

        $this->load->view('organisator/ajax_selectOptiesBijDagindeling', $data);
    }

    /**
     * Stef Goor
     * Haalt ajax op met lijst van ontvangers
     */
    public function haalAjaxOp_SelectOntvangers() {
        $feestId = $this->input->get('feestId');

        $this->load->model('persoon_model');
        $data['personen'] = $this->persoon_model->getAllWherePersoneelsfeest($feestId);

        $this->load->view('organisator/ajax_selectOntvangers', $data);
    }

    /**
     * Jorne Lambrechts
     * @param $albumId Het id van het te verwijderen album
     * Verwijdert het gekozen album en de foto's die bij het album horen
     */
    public function verwijderAjaxAlbum() {
        $albumId = $this->input->get('albumId');

        $this->load->model('album_model');
        $this->album_model->deleteWithFotos($albumId);

        redirect('organisator/overzichtAlbums');
    }

    /**
     * Stef Goor - Laad de view voor het sturen van mails
     * @param type $personeelsfeestId
     */
    public function mailSturen($personeelsfeestId) {
        $partials = array("hoofding" => "hoofding",
            "inhoud" => "organisator/mailSturen",
            "voetnoot" => "voetnoot");
        $data['titel'] = 'Mail Sturen';
        $data['paginaverantwoordelijke'] = 'Stef Goor';

        $data['feestId'] = $personeelsfeestId;

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
    public function beheerShiftenBijDagindeling($dagindelingId) {
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

    public function maakAlbum() {
        $data['titel'] = 'Album aanmaken';
        $data['paginaverantwoordelijke'] = 'Jorne Lambrechts';

        $this->load->model('personeelsfeest_model');
        $data['personeelsfeesten'] = $this->personeelsfeest_model->getAll();

        $partials = array('hoofding' => 'hoofding',
            'inhoud' => 'organisator/albumAanmaken',
            'voetnoot' => 'voetnoot');
        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Jorne Lambrechts
     * maakt nieuw album aan als er op aanmaken werd geklikt
     * gaat terug naar het overzicht van albums als er op annuleren werd geklikt
     */
    public function registreerAlbum() {
        $knop = $this->input->post('knop');

        if ($knop == 'Annuleren') {
            redirect('organisator/overzichtAlbums');
        } else {
            $album = new stdClass();

            $album->naam = $this->input->post('naam');
            $album->personeelsfeestId = $this->input->post('personeelsfeest');

            $this->load->model('album_model');
            $albumId = $this->album_model->insert($album);
            $this->session->set_userdata('albumId', $albumId);

            redirect('organisator/toevoegenFotos');
        }
    }

    public function toevoegenFotos() {
        $data['titel'] = 'Foto\'s toevoegen';
        $data['paginaverantwoordelijke'] = 'Jorne Lambrechts';
        $data['albumId'] = $this->session->userdata('albumId');

        $partials = array('hoofding' => 'hoofding',
            'inhoud' => 'organisator/uploadFotos',
            'voetnoot' => 'voetnoot');
        $this->template->load('main_master', $partials, $data);
    }

    /*
     * Jorne Lambrechts - Upload de gekozen foto's naar de server en zet 
     * de nodige gegevens in database
     */

    public function uploadFeestFotos() {
        if ($this->input->post('doorgaan') && !empty($_FILES['fotos']['name'])) {
            $aantal = count($_FILES['fotos']['name']);
            for ($i = 0; $i < $aantal; $i++) {
                $_FILES['foto']['name'] = $_FILES['fotos']['name'][$i];
                $_FILES['foto']['type'] = $_FILES['fotos']['type'][$i];
                $_FILES['foto']['tmp_name'] = $_FILES['fotos']['tmp_name'][$i];

                $config['upload_path'] = './assets/fotos';
                $config['allowed_types'] = 'gif|jpg|png';

                $this->upload->initialize($config);

                if ($this->upload->do_upload('foto')) {
                    $fotoData = $this->upload->data();
                    $foto = new stdClass();
                    $foto->naam = $fotoData['file_name'];
                    $foto->albumId = $this->input->post('albumId');

                    $this->load->model('foto_model');
                    $this->foto_model->insert($foto);
                }
            }
            redirect('organisator/overzichtAlbums');
        }
    }

    /*
     * Jorne Lambrechts - Toon de foto's van een album (zonder bewerkingsknoppen)
     */

    public function toonAlbum($albumId) {
        $data['titel'] = 'Album bekijken';
        $data['paginaverantwoordelijke'] = 'Stef Goor';

        /* $this->load->model('persoon_model');
          $data['emailGebruiker'] = $this->session->userdata('emailgebruiker'); */

        $this->load->model('album_model');
        $data['album'] = $this->album_model->getAlbum($albumId);
        $this->load->model('foto_model');
        $data['fotos'] = $this->foto_model->getAllByAlbum($albumId);

        $partials = array('hoofding' => 'hoofding',
            'inhoud' => 'organisator/overzichtFotos',
            'voetnoot' => 'voetnoot');
        $this->template->load('main_master', $partials, $data);
    }

    /*
     * Jorne Lambrechts - Toon foto's van een album (met bewerkingsknoppen)
     */

    public function albumBewerken($albumId) {
        $data['titel'] = 'Album bewerken';
        $data['paginaverantwoordelijke'] = 'Jorne Lambrechts';
        $data['albumId'] = $albumId;

        /* $this->load->model('persoon_model');
          $data['emailGebruiker'] = $this->session->userdata('emailgebruiker'); */

        $this->load->model('album_model');
        $data['album'] = $this->album_model->getAlbum($albumId);
        $this->load->model('foto_model');
        $data['fotos'] = $this->foto_model->getAllByAlbum($albumId);

        $partials = array('hoofding' => 'hoofding',
            'inhoud' => 'organisator/overzichtFotos',
            'voetnoot' => 'voetnoot');
        $this->template->load('main_master', $partials, $data);
    }

    public function verwijderAjaxFoto() {
        $fotoId = $this->input->get('fotoId');

        $this->load->model('foto_model');
        $this->foto_model->delete($fotoId);

        redirect('organisator/albumBewerken');
    }

    /**
     * Joren Synaeve - Verwijdert een organisator
     * @param $hashcode de hashcode van de te verwijderen organisator
     */
    public function verwijderOrganisator($hashcode) {
        $this->load->model('persoon_model');
        $persoon = $this->persoon_model->getWhereHashcode($hashcode);
        $this->persoon_model->delete($persoon->id);

        redirect('organisator/beheerOrganisatoren');
    }

}
