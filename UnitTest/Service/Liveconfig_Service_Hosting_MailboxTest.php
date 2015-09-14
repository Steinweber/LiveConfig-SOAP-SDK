<?php

class Liveconfig_Service_Hosting_MailboxTest extends PHPUnit_Framework_TestCase
{
    protected $subscription = 'web34';

    public function testHostingMailboxAdd()
    {
        $client = new Liveconfig_Client();
        $service = $client->getService('hosting');

        $params = array(
            'subscription'  => $this->subscription, #required
            'name'          => 'mail_'.rand(999,999999),
            'domain'        => 'example.com',
            //'alias'         => 'admin',
            'mailbox'       => 1,
            'password'      => 'Password'.rand(999,99999).'Test',
            'weblogin'      => 0,
            'quota'         => 1024,
            'forward'       => array('demo@example.com','master@example.com'),
            'autoresponder' => false,
            'autosubject'   => false,
            'automessage'   => false,
            'greylisting'   => 0,
            'spamfilter'    => 0,
            'spamwarn'      => 0,
            'spamreject'    => 0,

        );

        $result = $service->mailbox->add($params);
        $this->assertInstanceOf('Liveconfig_Service_Hosting_MailboxAddResponse',$result);
    }

    public function testHostingMailboxEdit()
    {
        $client = new Liveconfig_Client();
        $service = $client->getService('hosting');

        $params = array(
            'address'       => 'mail_467481@example.com', #required
            'mailbox'       => 1,
            'password'      => 'Password'.rand(999,99999).'Test',
            'weblogin'      => 0,
            'quota'         => 1024,
            'autoresponder' => false,
            'autosubject'   => false,
            'automessage'   => false,
            'greylisting'   => 0,
            'spamfilter'    => 0,
            'spamwarn'      => 0,
            'spamreject'    => 0,

        );

        $result = $service->mailbox->edit($params);
        $this->assertInstanceOf('Liveconfig_Service_Hosting_MailboxEditResponse',$result);
    }
}
