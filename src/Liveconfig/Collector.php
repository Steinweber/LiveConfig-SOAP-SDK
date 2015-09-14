<?php
class Liveconfig_Collector
{
    protected $automap=true;
    protected $collectorData = array();
    protected $processed = array();

    final public function __construct()
    {
        if (func_num_args() == 1 && is_array(func_get_arg(0))) {
            $array = func_get_arg(0);
            if(isset($this->automap) && $this->automap != false){
                $this->mapTypes($array);
            }else{
                $this->collectorData = $array;
            }
        }
        if(in_array('constructor',get_class_methods($this))){
            $this->constructor();
        }
    }

    protected function mapTypes($array)
    {

        foreach ($array as $key => $val) {
            if ( !property_exists($this, $this->keyClass($key)) && property_exists($this, $key)) {
                $this->$key = $val;
                unset($array[$key]);
            }elseif(property_exists($this, $this->keyClass($key))){
                $class = $this->{$this->keyClass($key)};
                $this->$key = new $class ($val);
                unset($array[$key]);
            }
        }
        $this->collectorData = $array;
    }

    protected function keyClass($key)
    {
        return $key . "Class";
    }
}