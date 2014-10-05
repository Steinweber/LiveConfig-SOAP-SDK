<?php 
class System{
    public $registry;
    public function __construct()
    {
        $this->loadBasicClasses();
        $this->registry = new Registry;
        $config = new Config;
        $config->load('cfg');
        $this->registry->set('config',$config); 
        if($config->get('log_status')!=false)
        {
            require_once(DIR_LIBS.'log.php');
            $this->registry->set('log',new Log($config->get('log_file')));
        }       
        $this->registry->set('soap', new LcSoap($this->registry));
        $this->api = new LcAPI($this->registry);
        
    }
    
    private function loadBasicClasses()
    {
        require_once('config.php');
        require_once(DIR_ENGINE.'config.php');
        require_once(DIR_ENGINE.'registry.php');
        require_once(DIR_LIBS.'soap.php');
        require_once(DIR_LIBS.'api.php');
    }
}