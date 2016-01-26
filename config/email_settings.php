<?php defined('BASEPATH') or exit('No direct script access allowed');

$config['email_settings'] = array(
    'admin_info' => array(
        'from' => 'info@pinet.co',
        'name' => 'Pinet Support'
    ),
    'qq' => array(
        'useragent' => "Pinet",
        'mailtype' => "html",
        'protocol' => "smtp",
        'smtp_crypto' => "ssl",
        'smtp_host' => "smtp.exmail.qq.com",
        'smtp_user' => "info@pinet.co",
        'smtp_pass' => "info_password",
        'smtp_port' => "465",
        'crlf' => "\r\n",
        'newline' => "\r\n"
    )
);
