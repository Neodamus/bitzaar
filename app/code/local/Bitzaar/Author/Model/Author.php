<?php

class Bitzaar_Author_Model_Author extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('author/author');
    }	
	
    public static function getBasePath()
    {
        return Mage::getBaseDir('media') . DS . 'customer';
    }
}