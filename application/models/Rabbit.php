<?php

class Application_Model_Rabbit
{
    protected $urls = array();
    /**
     * @param string $string
     * @return void
     */
    public function setUrl($string)
    {
        $this->urls = explode("\n", $string);
    }

    public function getUrl()
    {
        return $this->urls;
    }
}

