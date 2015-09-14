<?php

class Liveconfig_Service_Hosting extends Liveconfig_Service
{
    public $plan;
    public $subscription;
    public $domain;
    public $subdomain;
    public $database;
    public $mailbox;
    public $cron;
    public $password;
    public $ftp;

    public function __construct(Liveconfig_Client $client)
    {
        parent::__construct($client);
        $this->plan = new Liveconfig_Service_Hosting_PlanResource(
            $this,
            'plan',
            array(
                'methods' => array(
                    'HostingPlanAdd' => array(
                        'path' => '&l={api_user}&p={api_password}',
                        'parameters' => array(
                            'name' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'maxcustomers' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'maxusers' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => true,
                            ),
                            'webspace' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'ssi' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'php' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'cgi' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'ssl' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'cronjobs' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'apps' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'ftpaccounts' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'shellaccess' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'databases' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'subdomains' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'extdomains' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'mailboxes' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'mailaddrs' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'mailquota' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'traffic' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => true,
                            ),
                        ),
                    ),
                    'HostingPlanGet' => array(
                        'path' => '&l={api_user}&p={api_password}',
                        'parameters' => array(
                            'name' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                        ),
                    ),
                )
            )
        );
        $this->subscription = new Liveconfig_Service_Hosting_SubscriptionResource(
            $this,
            'subscription',
            array(
                'methods' => array(
                    'HostingSubscriptionAdd' => array(
                        'path' => '&l={api_user}&p={api_password}',
                        'parameters' => array(
                            'subscriptionname' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'password' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'resalecontract' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'webserver' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'mailserver' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'dbserver' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'customerid' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'plan' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'maxcustomers' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'webspace' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'ssi' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'php' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'cgi' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'ssl' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'cronjobs' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'apps' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'ftpaccounts' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'shellaccess' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'databases' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'subdomains' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'extdomains' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'mailboxes' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'mailaddrs' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'mailquota' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'traffic' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'webstats' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'comment' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                        ),
                    ),
                    'HostingSubscriptionGet' => array(
                        'path' => '&l={api_user}&p={api_password}',
                        'parameters' => array(
                            'subscriptionname' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                        ),
                    ),
                    'HostingSubscriptionEdit' => array(
                        'path' => '&l={api_user}&p={api_password}',
                        'parameters' => array(
                            'subscriptionname' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'plan' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'webserver' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'mailserver' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'dbserver' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'maxcustomers' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'maxusers' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'webspace' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'ssi' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'php' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'cgi' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'ssl' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'cronjobs' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'apps' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'ftpaccounts' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'shellaccess' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'databases' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'subdomains' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'extdomains' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'mailboxes' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'mailaddrs' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'mailquota' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'traffic' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'webstats' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'comment' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                        ),
                    ),
                    'HostingSubscriptionDelete' => array(
                        'path' => '&l={api_user}&p={api_password}',
                        'parameters' => array(
                            'subscriptionname' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                        ),
                    ),
                )
            )
        );
        $this->domain = new Liveconfig_Service_Hosting_DomainResource(
            $this,
            'domain',
            array(
                'methods' => array(
                    'HostingDomainAdd' => array(
                        'path' => '&l={api_user}&p={api_password}',
                        'parameters' => array(
                            'subscription' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'domain' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'mail' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'web' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'dnstemplate' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),

                        ),
                    ),
                )
            )
        );
        $this->subdomain = new Liveconfig_Service_Hosting_SubdomainResource(
            $this,
            'subdomain',
            array(
                'methods' => array(
                    'HostingSubdomainAdd' => array(
                        'path' => '&l={api_user}&p={api_password}',
                        'parameters' => array(
                            'subscription' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'subdomain' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'mail' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'web' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'ipgroup' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),

                        ),
                    ),
                )
            )
        );
        $this->database = new Liveconfig_Service_Hosting_DatabaseResource(
            $this,
            'database',
            array(
                'methods' => array(
                    'HostingDatabaseAdd' => array(
                        'path' => '&l={api_user}&p={api_password}',
                        'parameters' => array(
                            'subscription' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'name' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'login' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'comment' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'extern' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'create' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'password' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                        ),
                    ),
                )
            )
        );
        $this->mailbox = new Liveconfig_Service_Hosting_MailboxResource(
            $this,
            'mailbox',
            array(
                'methods' => array(
                    'HostingMailboxAdd' => array(
                        'path' => '&l={api_user}&p={api_password}',
                        'parameters' => array(
                            'subscription' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'name' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'domain' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'alias' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'mailbox' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'password' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'weblogin' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'quota' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'forward' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'autoresponder' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'autosubject' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'automessage' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'greylisting' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'spamfilter' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'spamwarn' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'spamreject' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                        ),
                    ),
                    'HostingMailboxEdit' => array(
                        'path' => '&l={api_user}&p={api_password}',
                        'parameters' => array(
                            'address' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'mailbox' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'password' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => false,
                            ),
                            'weblogin' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'quota' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'autoresponder' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'autosubject' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'automessage' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'greylisting' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'spamfilter' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'spamwarn' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                            'spamreject' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => false,
                            ),
                        ),
                    ),
                )
            )
        );
        $this->cron = new Liveconfig_Service_Hosting_CronResource(
            $this,
            'cron',
            array(
                'methods' => array(
                    'HostingCronAdd' => array(
                        'path' => '&l={api_user}&p={api_password}',
                        'parameters' => array(
                            'subscription' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'active' => array(
                                'location' => 'body',
                                'type' => 'integer',
                                'required' => true,
                            ),
                            'minute' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'hour' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'day' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'month' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'weekday' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'command' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                        ),
                    ),
                )
            )
        );
        $this->password = new stdClass();
        $this->password->user = new Liveconfig_Service_Hosting_PasswordUserResource(
            $this,
            'passwordUser',
            array(
                'methods' => array(
                    'HostingPasswordUserAdd' => array(
                        'path' => '&l={api_user}&p={api_password}',
                        'parameters' => array(
                            'subscription' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'login' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'password' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            )
                        ),
                    ),
                )
            )
        );
        $this->password->path = new Liveconfig_Service_Hosting_PasswordPathResource(
            $this,
            'passwordPath',
            array(
                'methods' => array(
                    'HostingPasswordPathAdd' => array(
                        'path' => '&l={api_user}&p={api_password}',
                        'parameters' => array(
                            'subscription' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'path' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'title' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'login' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            )
                        ),
                    ),
                )
            )
        );
        $this->ftp = new Liveconfig_Service_Hosting_FtpResource(
            $this,
            'ftp',
            array(
                'methods' => array(
                    'HostingFtpAdd' => array(
                        'path' => '&l={api_user}&p={api_password}',
                        'parameters' => array(
                            'subscription' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'login' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'password' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            ),
                            'path' => array(
                                'location' => 'body',
                                'type' => 'string',
                                'required' => true,
                            )
                        ),
                    ),
                )
            )
        );
    }
}

class Liveconfig_Service_Hosting_PlanResource extends Liveconfig_Service_Resource
{
    public function add($params,$optParams=array())
    {
        $params = array_merge($params, $optParams);
        return $this->call('HostingPlanAdd', array($params),'Liveconfig_Service_Hosting_PlanAddResponse');
    }

    public function get($params,$optParams=array())
    {
        $params = array_merge($params, $optParams);
        return $this->call('HostingPlanGet', array($params),'Liveconfig_Service_Hosting_PlanGetResponse');
    }
}

#HostingPlanAdd
class Liveconfig_Service_Hosting_PlanAddResponse extends Liveconfig_Collector
{
    public $id;
}

#HostingPlanGet
class Liveconfig_Service_Hosting_PlanGetResponse extends Liveconfig_Collector
{
    protected $automap = false;
    public $plans = array();

    protected function constructor(){
        if(
            isset($this->collectorData['plans']) &&
            isset($this->collectorData['plans']['HostingPlanDetails']) &&
            count($this->collectorData['plans']['HostingPlanDetails'])
        ){
            if(count($this->collectorData['plans']['HostingPlanDetails']) == count($this->collectorData['plans']['HostingPlanDetails'],1)){
                //Single result
                $this->plans[] = new Liveconfig_Service_Hosting_PlanDetails($this->collectorData['plans']['HostingPlanDetails']);
            }else{
                //Multiple results
                foreach($this->collectorData['plans']['HostingPlanDetails'] as $plan){
                    $this->plans[] = new Liveconfig_Service_Hosting_PlanDetails($plan);
                }
            }
            unset($this->collectorData['plans']);
        }
    }
}

class Liveconfig_Service_Hosting_PlanDetails extends Liveconfig_Collector{
    public $name;
    public $maxcustomers;
    public $maxusers;
    public $webspace;
    public $ssi;
    public $php;
    public $cgi;
    public $ssl;
    public $cronjobs;
    public $apps;
    public $ftpaccounts;
    public $shellaccess;
    public $databases;
    public $subdomains;
    public $extdomains;
    public $mailboxes;
    public $mailaddrs;
    public $mailquota;
    public $traffic;
}

##########
#Subscription
##########
class Liveconfig_Service_Hosting_SubscriptionResource extends Liveconfig_Service_Resource
{
    public function add($params,$optParams=array())
    {
        $params = array_merge($params, $optParams);
        return $this->call('HostingSubscriptionAdd', array($params),'Liveconfig_Service_Hosting_SubscriptionAddResponse');
    }

    public function get($params,$optParams=array())
    {
        $params = array_merge($params, $optParams);
        return $this->call('HostingSubscriptionGet', array($params),'Liveconfig_Service_Hosting_SubscriptionGetResponse');
    }

    public function edit($params,$optParams=array())
    {
        $params = array_merge($params, $optParams);
        return $this->call('HostingSubscriptionEdit', array($params),'Liveconfig_Service_Hosting_SubscriptionEditResponse');
    }

    public function delete($params,$optParams=array())
    {
        $params = array_merge($params, $optParams);
        return $this->call('HostingSubscriptionDelete', array($params),'Liveconfig_Service_Hosting_SubscriptionDeleteResponse');
    }
}

#HostingSubscriptionAdd
class Liveconfig_Service_Hosting_SubscriptionAddResponse extends Liveconfig_Collector
{
    public $id;
    public $subscriptionname;
}

#HostingSubscriptionGet
class Liveconfig_Service_Hosting_SubscriptionGetResponse extends Liveconfig_Collector
{
    public $hostname;
    public $customerid;
    public $plan;
    public $maxcustomers;
    public $maxusers;
    public $webspace;
    public $ssi;
    public $php;
    public $cgi;
    public $ssl;
    public $cronjobs;
    public $apps;
    public $ftpaccounts;
    public $shellaccess;
    public $databases;
    public $subdomains;
    public $extdomains;
    public $mailboxes;
    public $mailaddrs;
    public $mailquota;
    public $traffic;
    public $comment;
    public $domains = array();
    public $databaseList = array();

    protected function constructor(){

    }
}

class Liveconfig_Service_Hosting_DomainDetails extends Liveconfig_Collector{
    public $name;
}

class Liveconfig_Service_Hosting_DatabaseList extends Liveconfig_Collector{
    public $type;
    public $server;
    public $name;
    public $login;
}

#HostingSubscriptionEdit
class Liveconfig_Service_Hosting_SubscriptionEditResponse extends Liveconfig_Collector
{
    public $status;
}

#HostingSubscriptionEdit
class Liveconfig_Service_Hosting_SubscriptionDeleteResponse extends Liveconfig_Collector
{
    public $status;
}

##########
#Domain
##########
class Liveconfig_Service_Hosting_DomainResource extends Liveconfig_Service_Resource
{
    public function add($params,$optParams=array())
    {
        $params = array_merge($params, $optParams);
        return $this->call('HostingDomainAdd', array($params),'Liveconfig_Service_Hosting_DomainAddResponse');
    }
}

#HostingDomainAdd
class Liveconfig_Service_Hosting_DomainAddResponse extends Liveconfig_Collector
{
    public $id;
    public $webip = array();
}

##########
#Subdomain
##########
class Liveconfig_Service_Hosting_SubdomainResource extends Liveconfig_Service_Resource
{
    public function add($params,$optParams=array())
    {
        $params = array_merge($params, $optParams);
        return $this->call('HostingSubdomainAdd', array($params),'Liveconfig_Service_Hosting_SubdomainAddResponse');
    }
}

#HostingSubdomainAdd
class Liveconfig_Service_Hosting_SubdomainAddResponse extends Liveconfig_Collector
{
    public $id;
    public $webip = array();
}

##########
#Database
##########
class Liveconfig_Service_Hosting_DatabaseResource extends Liveconfig_Service_Resource
{
    public function add($params,$optParams=array())
    {
        $params = array_merge($params, $optParams);
        return $this->call('HostingDatabaseAdd', array($params),'Liveconfig_Service_Hosting_DatabaseAddResponse');
    }
}

#HostingDatabaseAdd
class Liveconfig_Service_Hosting_DatabaseAddResponse extends Liveconfig_Collector
{
    public $id;
}


##########
#Mailbox
##########
class Liveconfig_Service_Hosting_MailboxResource extends Liveconfig_Service_Resource
{
    public function add($params,$optParams=array())
    {
        $params = array_merge($params, $optParams);
        return $this->call('HostingMailboxAdd', array($params),'Liveconfig_Service_Hosting_MailboxAddResponse');
    }

    public function edit($params,$optParams=array())
    {
        $params = array_merge($params, $optParams);
        return $this->call('HostingMailboxEdit', array($params),'Liveconfig_Service_Hosting_MailboxEditResponse');
    }
}

#HostingMailboxAdd
class Liveconfig_Service_Hosting_MailboxAddResponse extends Liveconfig_Collector
{
    public $id;
    public $folder;
}

#HostingMailboxEdit
class Liveconfig_Service_Hosting_MailboxEditResponse extends Liveconfig_Collector
{
    public $status;
}

##########
#Cron
##########
class Liveconfig_Service_Hosting_CronResource extends Liveconfig_Service_Resource
{
    public function add($params,$optParams=array())
    {
        $params = array_merge($params, $optParams);
        return $this->call('HostingCronAdd', array($params),'Liveconfig_Service_Hosting_CronAddResponse');
    }
}

#HostingCronAdd
class Liveconfig_Service_Hosting_CronAddResponse extends Liveconfig_Collector
{
    public $status;
}

##########
#PasswordUser
##########
class Liveconfig_Service_Hosting_PasswordUserResource extends Liveconfig_Service_Resource
{
    public function add($params,$optParams=array())
    {
        $params = array_merge($params, $optParams);
        return $this->call('HostingPasswordUserAdd', array($params),'Liveconfig_Service_Hosting_PasswordUserAddResponse');
    }
}

#HostingPasswordUserAdd
class Liveconfig_Service_Hosting_PasswordUserAddResponse extends Liveconfig_Collector
{
    public $status;
}

##########
#PasswordPath
##########
class Liveconfig_Service_Hosting_PasswordPathResource extends Liveconfig_Service_Resource
{
    public function add($params,$optParams=array())
    {
        $params = array_merge($params, $optParams);
        return $this->call('HostingPasswordPathAdd', array($params),'Liveconfig_Service_Hosting_PasswordPathAddResponse');
    }
}

#HostingPasswordPathAdd
class Liveconfig_Service_Hosting_PasswordPathAddResponse extends Liveconfig_Collector
{
    public $status;
}

##########
#FTP
##########
class Liveconfig_Service_Hosting_FtpResource extends Liveconfig_Service_Resource
{
    public function add($params,$optParams=array())
    {
        $params = array_merge($params, $optParams);
        return $this->call('HostingFtpAdd', array($params),'Liveconfig_Service_Hosting_FtpAddResponse');
    }
}

#HostingFtpAdd
class Liveconfig_Service_Hosting_FtpAddResponse extends Liveconfig_Collector
{
    public $status;
}