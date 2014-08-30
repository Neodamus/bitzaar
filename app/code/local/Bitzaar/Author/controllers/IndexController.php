<?php

class Bitzaar_Author_IndexController extends Mage_Core_Controller_Front_Action {
	
	function indexAction() {		
				
		$this->loadLayout();
		
		$post = $this->getRequest()->getPost();
		$action = $post['action'];
		$block = $this->getLayout()->getBlock('author');
		if (isset($action) && $action != '') {
			$block->setMethod($action);			
		}
		
		if (isset($_FILES['attachment']['name']) && $_FILES['attachment']['name'] != '') {	
			$file = $_FILES['attachment'];
			$block->setFile($file);
		}
		
		$this->renderLayout();
		
	}
	
}