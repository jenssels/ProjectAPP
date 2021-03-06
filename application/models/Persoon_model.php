<?php
/**
 * @class Persoon_model
 * @brief Model-klasse voor personen
 *
 * Model-klasse die alle methodes bevat om de database-tabel persoon te gebruiken
 */

class Persoon_model extends CI_Model {

    // +----------------------------------------------------------
    // | Personeelsfeest - Persoon_model.php
    // +----------------------------------------------------------
    // | 2 ITF Project APP/BIT Team 17 - 2017-2018
    // +----------------------------------------------------------
    // | Persoon model
    // +----------------------------------------------------------
    // | Auteur: [naam]
    // +----------------------------------------------------------

    function __construct() {
        parent::__construct();
    }

    function getByPersoonid($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('persoon');
        return $query->row();
    }

    /**
     * Jens Sels - Opvragen van het totaal aantal inschrijvingen van de personeelsleden en vrijwilligers van een bepaald personeelsfeest
     * @param $feestId Id van een personeelsfeest
     * @return Totaal aantal inschrijvingen
     */
    function getInschrijvingenWherePersoneelsFeest($feestId) {
        $this->load->model('TaakDeelname_model');
        $this->load->model('optiedeelname_model');
        $deelnemers = 0;
        $helpers = 0;
        $this->db->where('personeelsfeestId', $feestId);
        $query = $this->db->get('persoon');
        $personen = $query->result();
        foreach ($personen as $persoon) {
            $optieCount = $this->optiedeelname_model->getCountWherePersoon($persoon->id);
            $taakCount = $this->TaakDeelname_model->getCountWherePersoon($persoon->id);
            if ($optieCount > 0) {
                $deelnemers++;
            }
            if ($taakCount > 0) {
                $helpers++;
            }
        }
        return array('deelnemers' => $deelnemers, 'helpers' => $helpers);
    }

    /**
     * Jens Sels - Ophalen van alle personen van een personeelsfeest
     * @param $feestId Id van een personeelsfeest
     * @return Alle personen van een personeelsfeest
     */
    function getAllWherePersoneelsFeest($feestId) {
        $this->db->where('personeelsfeestId', $feestId);
        $query = $this->db->get('persoon');

        return $query->result();
    }
    
    /**
     * Stef Goor - Ophalen van alle personeelsleden van een personeelsfeest
     * @param $feestId Id van een personeelsfeest
     * @return Alle personeelsleden van een personeelsfeest
     */
    function getAllPersoneelWherePersoneelsFeest($feestId) {
        $this->db->where('personeelsfeestId', $feestId);
        $this->db->where('typeId', '3');
        $query = $this->db->get('persoon');

        return $query->result();
    }
    
    /**
     * Stef Goor - Ophalen van alle personeelsleden van een personeelsfeest
     * @param $feestId Id van een personeelsfeest
     * @return Alle personeelsleden van een personeelsfeest
     */
    function getAllVrijwilligersWherePersoneelsFeest($feestId) {
        $this->db->where('personeelsfeestId', $feestId);
        $this->db->where('typeId', '2');
        $query = $this->db->get('persoon');

        return $query->result();
    }

    /**
     * Jens Sels - ophalen van alle hashcodes
     * @return Array met alle hashcodes
     */
    function getAllHashCodes() {
        $array = [];
        $this->db->select('hashcode');
        $query = $this->db->get('persoon');

        foreach ($query->result() as $result) {
            array_push($array, $result->hashcode);
        }
        return $array;
    }

    /**
     * Jens Sels - Ophalen van alle mails van een personeelsfeest
     * @param $feestId
     * @return Array met alle mails van een personeelsfeest
     */
    function getAllMailsWhereFeest($feestId) {
        $array = [];
        $this->db->select('email');
        $this->db->where('personeelsfeestId', $feestId);
        $query = $this->db->get('persoon');
        foreach ($query->result() as $result) {
            array_push($array, $result->email);
        }
        return $array;
    }

    /**
     * Jens Sels - Toevoegen van persoon
     * @param $persoon Persoon object
     * @return Id van toegevoegd persoon
     */
    function insert($persoon) {
        $this->db->insert('persoon', $persoon);
        return $this->db->insert_id();
    }

    /**
     * Jens Sels - Ophalen van alle personen met een email van een bepaald personeelsfeest
     * @param $feestId Id van personeelsfeest
     * @param $email Email van persoon
     * @return Alle personen met een email van een bepaald personeelsfeest
     */
    function getAllWherePersoneelsFeestAndEmail($feestId, $email) {
        $where = array('personeelsfeestId' => $feestId, 'email' => $email);
        $this->db->where($where);
        $query = $this->db->get('persoon');

        return $query->result();
    }

    /**
     * Jens Sels - Verwijder een persoon en al zijn keuzes voor opties en taken
     * @param $persoonId Id van een persoon
     */
    function delete($persoonId) {
        $this->load->model('optiedeelname_model');
        $this->load->model('TaakDeelname_model');

        $optieDeelnames = $this->optiedeelname_model->getAllWherePersoon($persoonId);
        // Alle keuzes van opties doorlopen en ze verwijderen
        foreach ($optieDeelnames as $optieDeelname) {
            $this->optiedeelname_model->delete($optieDeelname->id);
        }

        $taakDeelnames = $this->TaakDeelname_model->getAllWherePersoon($persoonId);
        // Alle keuzes van taken doorlopen en ze verwijderen
        foreach ($taakDeelnames as $taakDeelname) {
            $this->TaakDeelname_model->delete($taakDeelname->id);
        }
        $this->db->where('id', $persoonId);
        $this->db->delete('persoon');
    }

    /**
     *  Jens Sels - Ophalen van alle gebruikers van geselecteerde personeelsfeest
     * @param $feestId Id van personeelsfeest
     * @return Alle personeelsleden van het personeelsfeest 
     */
    function getAllPersoneelsLedenWherePersoneelsFeest($feestId) {
        $this->db->where('personeelsfeestId', $feestId);
        $this->db->where('typeId', '3');
        $query = $this->db->get('persoon');

        return $query->result();
    }

    /**
     * Voegt de nieuwe organisator toe aan de database.
     * @param $organisator Het organisator object
     * @return Het id van het nieuwe record
     */
    function insertOrganisator($organisator) {
        $this->db->insert('persoon', $organisator);
        return $this->db->insert_id();
    }

                /**
     * Organisator inloggen
     * @param $email email van gebruiker $wachtwoord wachtwoord van gebruiker $typeid het type gebruiker
     * @return Organisator als organisator is.
     */
    function getOrganisator($email, $wachtwoord, $typeId) {
        //ophalen van de organisator
        $this->db->where('email', $email);
        $this->db->where('typeId', $typeId);
        $query = $this->db->get('persoon');

        $organisator = $query->row();

        if (password_verify($wachtwoord, $organisator->wachtwoord)) {
            return $organisator;
        } else {
            return null;
        }
    }

    /**
     * Joren Synaeve
     * @param $hashcode De hashcode van het op te halen personeelslid
     * @return Het persoonobject
     */
    function getWhereHashcode($hashcode) {
        $this->db->where('hashcode', $hashcode);
        $query = $this->db->get('persoon');

        return $query->row();
    }

    /**
     * Zoekt in de tabel persoon naar een record dat match met de ingevoerde gegevens     
     * @param type $email
     * @param type $wachtwoord
     * @param type $typeId
     * @return Het record uit de databas dat voldoet aan de voorwaarden, false als er geen gevonden kan worden
     */
    function controleerAanmeldgegevens($email, $wachtwoord, $typeId) {
        $this->db->where('email', $email);
        $this->db->where('wachtwoord', $wachtwoord);
        $this->db->where('typeId', $typeId);
        $query = $this->db->get('persoon');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * Joren Synaeve
     * Haalt alle personen uit de database met een bepaald typeId. 
     * @param $id Het typeId waarop gezocht wordt
     * @return Een persoonobject
     * @return Een false wanneer er geen personen gevonden worden
     */
    function getAllWhereTypeId($id) {
        $this->db->where('typeId', $id);
        $query = $this->db->get('persoon');
        return $query->result();
    }

    /**
     * Jens Sels - Persoon toevoegen indien email nog niet gebruikt is
     * @param $persoon Object met gegevens van een persoon
     * @return String met info of de persoon is toegevoegd of niet
     */
    function insertWithCheck($persoon){
        $message = "";
        $message['stuur'] = false;
        $feestId = $persoon->personeelsfeestId;
        $mails = $this->getAllMailsWhereFeest($feestId);
        if (in_array($persoon->email, $mails)) {
            $message['inhoud'] = 'Mail adres al aanwezig - ' . $persoon->voornaam . ' ' . $persoon->naam . '</br>';
        } else {
            if (count($this->getAllWherePersoneelsFeestAndEmail($feestId, $persoon->email)) == 0) {
                $this->insert($persoon);
                $message['inhoud'] = 'De persoon is uitgenodigd en een mail is verstuurd - ' . $persoon->voornaam . ' ' . $persoon->naam . '</br>';
                $message['stuur'] = true;
            } else {
                $message['inhoud'] = 'Al aanwezig in de database - ' . $persoon->voornaam . ' ' . $persoon->naam . '</br>';
            }
        }
        return $message;
    }

    /**
     * Joren Synaeve
     * Controleert of een persoon al bestaat in de database. Retourneert een true of false.
     * @param $email
     * @param $typeID
     * @return boolean
     */
    function persoonBestaat($email, $typeID) {
        $array = array('email' => $email, 'typeId' => $typeID);
        $this->db->where($array);
        $query = $this->db->get('persoon');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Joren Synaeve
     * Retourneert een leeg persoon object
     */
    function getEmptyPersoon() {
        $persoon = new stdClass();

        $persoon->id = 0;
        $persoon->naam = '';
        $persoon->voornaam = '';
        $persoon->email = '';
    }
}
