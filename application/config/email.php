<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(

    'useragent'=> "CodeIgniter",
    'mailpath' => "/usr/bin/sendmail",
    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
    'smtp_host' => 'mail.phed.com.ng', 
    'smtp_port' => '465',
    'smtp_user' => 'noms@phed.com.ng',
    'smtp_pass' => '387#phed#',
    'smtp_crypto' => 'ssl', //can be 'ssl' or 'tls' for example
    'mailtype' => 'html', //plaintext 'text' mails or 'html'
    'smtp_timeout' => '30', //in seconds
    'charset' => 'iso-8859-1',
    'wordwrap' => TRUE
);