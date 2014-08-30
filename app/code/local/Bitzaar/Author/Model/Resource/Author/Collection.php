<?php

class Bitzaar_Author_Model_Resource_Author_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract {
	
    protected function _construct()
    {
        $this->_init('author/author');
    }
	
	public function getId() {
		
		$arr = $this
			->addFieldToSelect('author_id')
            ->setOrder('author_id', 'desc')
            ->setPageSize(1)
			->load()
		;
		
		
        foreach ($arr as $id) {
            return $id['author_id'];
        }
	}
}