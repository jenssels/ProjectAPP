<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Authex {

    // +----------------------------------------------------------
    // | TV Shop
    // +----------------------------------------------------------
    // | 2ITF - 201x-201x
    // +----------------------------------------------------------
    // | Authex library
    // |
    // +----------------------------------------------------------
    // | Nelson Wells (http://nelsonwells.net/2010/05/creating-a-simple-extensible-codeigniter-authentication-library/)
    // | 
    // | aangepast door Thomas More
    // +----------------------------------------------------------

    public function __construct() {
        $CI = & get_instance();

        $CI->load->model('persoon_model');
    }

    function meldAan($email, $wachtwoord, $typeId) {
        // Jorne Lambrechts - Meldt de organisator aan a.d.h.v. zijn e-mail en wachtwoord
        $CI = & get_instance();

        $organisator = $CI->persoon_model->getOrganisator($email, $wachtwoord, $typeId);

        if ($organisator == null) {
            return false;
        } else {
            $CI->session->set_userdata('organisator_id', $organisator->id);
            $CI->session->set_userdata('emailgebruiker', $email);
            return true;
        }
    }

    function isAangemeld() {
        // gebruiker is aangemeld als sessievariabele organisator_id bestaat
        $CI = & get_instance();

        if ($CI->session->has_userdata('organisator_id')) {
            return true;
        } else {
            return false;
        }
    }
    
    function meldAf () {
        $CI = & get_instance();
        $CI->session->sess_destroy();
        redirect('');
    }

}
