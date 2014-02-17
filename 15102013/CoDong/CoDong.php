<?php
include_once('ICoDong.php');

class CoDong{
    private $_strategy;
    private $_dataPack;
    public function __construct(ICoDong $strategy){
        $this->_strategy=$strategy;
    }
    public function algorithm(Array $dataPack){
        $this->_dataPack=$dataPack;
        $this->_strategy->algorithm($this->_dataPack);
    }
}
