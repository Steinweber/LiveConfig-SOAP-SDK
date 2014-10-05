<?php 

class LcAPI{
    
    private $functionlist=array();
    private $log;
    private $soap;
    
    public function __construct($registry)
    {
        $this->soap = $registry->get('soap');
        $this->log = $registry->get('log');
        $this->config = $registry->get('config');
        $this->functionlist = array(
            'TestSayHello',
            'LiveConfigVersion',
            'ContactAdd',
            'ContactEdit',
            'ContactGet',
            'CustomerAdd',
            'CustomerEdit',
            'CustomerGet',
            'HostingPlanAdd',
            'HostingPlanGet',
            'HostingSubscriptionAdd',
            'HostingSubscriptionDelete',
            'HostingSubscriptionGet',
            'HostingSubscriptionEdit',
            'HostingDomainAdd',
            'HostingSubdomainAdd',
            'HostingDatabaseAdd',
            'HostingMailboxAdd',
            'HostingMailboxEdit',
            'HostingCronAdd',
            'HostingPasswordUserAdd',
            'HostingPasswordPathAdd',
            'HostingFtpAdd',
            'UserAdd',
            'UserGet',
            'SessionCheck'
        );
    }
    
    public function request()
    {
        $args = func_get_args();
        if(func_num_args() === 0 || !in_array($args[0],$this->functionlist))
        {
            $this->log->write("Call SOAP function: ".$args[0]." => ERROR: Invalide function");
            return array('status'=>false,'response'=>'Invalide function');
        }
        #TODO: Add validation
        $args[1] = isset($args[1])?$args[1]:array();
        $args[2] = isset($args[2])?$args[2]:false;
            
        return $this->soap->request($args[0],$args[1],$args[2]);       
    }
}