<?php

class Bitzaar_Author_Block_List extends Mage_Core_Block_Template
{
	public function listBooks() {
		$productModel = Mage::getModel('catalog/product');
		$productCollection = $productModel->getCollection();
		$productCollection->addAttributeToSelect('name', 'sku', 'uploaded_by')->addAttributeToFilter('uploaded_by', array('eq' => 'Jesus'));
		
		$output = array();
		foreach ($productCollection as $_product) {
			$output = array(
				'entity_id' => $_product->getId(),
				'name' => $_product->getName(),
				'sku' => $_product->getSku(),
				'uploaded_by' => $_product->getUploadedBy()
				);
			print_r($output);
		}
		
	}
	
	public function getCustomerId() {		
		
		if(Mage::getSingleton('customer/session')->isLoggedIn()) {
     		$customer = Mage::getSingleton('customer/session')->getCustomer();
      		return $customer->getId();
		}
		
		return 0;	
	}
	
	public function addBook($file) {
		
		$uploader = new Varien_File_Uploader($file);
		$filename = $file['name'];
		$path = Mage::getBaseDir('media') . DS . 'customer';
            if(!is_dir($path)){
         	   mkdir($path, 0777, true);
            }
        $uploader->save($path . DS, $filename);
		
		$sku = strtr($file['name'], array('.' => ''));
		$name = pathinfo($file['name'], PATHINFO_FILENAME);	
		$customerId = $this->getCustomerId();
		
		$productModel = Mage::getSingleton('catalog/product');
		$newProduct = array(
			'entity_type_id' => 4,
			'attribute_set_id' => 4,
			'store_id' => 0,
			'type_id' => 'downloadable',
			'sku' => $sku,
			'has_options' => 1,
			'required_options' => 1,
			'status' => 1,	// required to show in products?
			'visibility' => 4,
			'tax_class_id' => 0,
			'links_purchased_separately' => 1,
			'links_exist' => 1,
			'description' => 'test!',
			'short_description' => 'no',
			'meta_keyword' => NULL,
			'custom_layout_update' => NULL,
			'name' => $name,
			'url_key' => $name,
			'msrp_enabled' => 2,
			'msrp_display_actual_price_type' => 4,
			'meta_title' => NULL,
			'meta_description' => NULL,
			'image' => 'no_selection',
			'small_image' => 'no_selection',
			'thumbnail' => 'no_selection',
			'custom_design' => NULL,
			'page_layout' => NULL,
			'options_container' => 'container2',
			'gift_wrapping_available' => '0',
			'samples_title' => 'Samples',
			'links_title' => 'Links', 
			'gift_message_available' => NULL,
			'url_path' => $name . '.html',
			'price' => 0.01,
			'special_price' => NULL,
			'cost' => NULL,
			'msrp' => NULL,
			'news_from_date' => NULL,
			'news_to_date' => NULL,
			'special_from_date' => NULL, 
			'special_to_date' => NULL,
			'custom_design_from' => NULL,
			'custom_design_to' => NULL,
			'is_salable' => 1,
			'uploaded_by' => $customerId		
			);
		$productId = $productModel->setData($newProduct)->save()->getId();
		
		// mage_catalog_product_website
		$catalogProductWebsiteModel = Mage::getSingleton('catalog/product_website');
		$catalogProductWebsiteModel->addProducts(array(1), array($productId)); 
		
		// mage_cataloginventory_stock_item
		$stockItemModel = Mage::getSingleton('cataloginventory/stock_item');
		$newStockItem = array(
			'product_id' => $productId,
			'stock_id' => 1
			)
		;
		$id = $stockItemModel->setData($newStockItem)->setIsInStock(1)->save()->getId();
		$stockItemModel->load($id)->setQty(100)->save();
		
		// mage_cataloginventory_stock_status
		//$stockStatusModel = Mage::getSingleton('cataloginventory/stock_status');
		//$stockStatusModel->saveProductStatus($productId, 1, 100, 1, 1);
		
		// mage_downloadable_link
		$downloadableModel = Mage::getModel('downloadable/link');
		$newDownloadable = array(
			'product_id' => $productId,
			'number_of_downloads' => 0,
			'is_shareable' => 2,
			'link_file' => '/' . $filename,
			'link_type' => 'file',
			'price' => 0.01,
			'title' => 'Test'
		);
		$downloadableModel->setData($newDownloadable)->save();
	}
	
	public function newAuthor() {
		$authorModel = Mage::getSingleton('author/author');
		$customerId = $this->getCustomerId();
		$newAuthor = array(
			'customer_id' => $customerId,
			'username' => 'test author',
			'address' => 'test address',
			'balance' => 0
		);
		$authorModel->setData($newAuthor)->save();
	}
}