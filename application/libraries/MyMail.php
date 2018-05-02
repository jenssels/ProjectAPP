<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MyMail{
    function __construct()
    {
        
    }

    public function stuurMail($titel, $message, $mail, $type, $hash, $isInschrijfLink = false) {
        $CI =& get_instance();
        $config = Array('protocol' => 'smtp', 'smtp_host' => 'ssl://smtp.gmail.com', 'smtp_port' => 465, 'smtp_user' => 'team17project@gmail.com', 'smtp_pass' => 'team17project', 'mailtype' => 'html', 'charset' => 'utf-8');
        if ($isInschrijfLink) {
            if ($type === 'personeel') {
                $link = '<a href="' . base_url('index.php/personeel/index/' . $hash) . '">Uitnodigings mail voor personeelsfeest Thomas More</a>';

            } else {
                $link = '<a href="' . base_url('index.php/vrijwilliger/index/' . $hash) . '">Uitnodigings mail voor personeelsfeest Thomas More</a>';
            }
            $message .= '\n Gebruik onderstaande link om uw keuzes voor het personeelsfeest door te geven: \n \n ' . $link;
        }
        $CI->load->library('email');
        $CI->load->library('encrypt');
        $CI->email->initialize($config);
        $CI->email->set_newline("\r\n");
        $CI->email->set_mailtype("html");
        $CI->email->from('team17project@gmail.com', 'Personeelsfeest Thomas More');
        $CI->email->to($mail);
        $CI->email->subject($titel);
        $CI->email->message(str_replace('\n', '<br />', $message));
        $CI->email->send();
    }
}