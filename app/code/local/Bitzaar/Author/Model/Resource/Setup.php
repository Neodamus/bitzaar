<?php

class Bitzaar_Author_Model_Resource_Setup extends Mage_Core_Model_Resource_Db_Abstract
{
	protected function _construct()	{
		$this->_init('author/author', 'author_id');
	}
}