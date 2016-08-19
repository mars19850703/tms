<?php

class MY_Email extends CI_Email
{
    protected $ci;

    public function __construct($config = array())
    {
        parent::__construct($config);
        $this->ci = & get_instance();
    }

    public function sendMail($from, $to, $subject, $content, $mailType='html')
    {
        // $config['protocol'] = 'sendmail';
        // $config['mailpath'] = '/usr/sbin/sendmail';
        // $config['charset'] = 'iso-8859-1';
        // $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->ci->email->initialize($config);


        $this->ci->email->from($from['email'], (isset($from['name']))? $from['name'] : '');
        $this->ci->email->to($to['email']);
        // $this->ci->email->cc('another@another-example.com');
        // $this->ci->email->bcc('them@their-example.com');

        $this->ci->email->subject($subject);
        $this->ci->email->message($content);

        $this->ci->email->send();
    }


}
