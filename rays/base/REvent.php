<?php
/**
 * REvent base class
 * @author: Raysmond
 * @date: 13-11-28
 */

class REvent
{
    private $sender;
    private $params;

    public function __construct($sender, $params)
    {
        $this->sender = $sender;
        $this->params = $params;
    }

    public function getSender(){
        return $this->sender;
    }

    public function getParams(){
        return $this->params;
    }

}