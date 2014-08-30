<?php

class Bitzaar_Author_Model_Observer {
    
    public function balance(Varien_Event_Observer $observer)
    {
		$orderIds = $observer->getEvent()->getOrderIds();
		$order = Mage::getSingleton('sales/order')->load($orderIds[0]);
		
		$total = $order->getGrandTotal();
		$items = $order->getAllItems();
		foreach ($items as $item) {
			$productIds[] = ($item->getProductId());	
		}
		
		var_dump($productIds);
		
		$productModel = Mage::getSingleton('catalog/product');
		foreach($productIds as $id) {
			$prices[] = $productModel->load($id)->getPrice();
			$authorIds[] = $productModel->getUploadedBy();
		}
		
		var_dump($prices);
		var_dump($authorIds);
		
		for ($i = 0; $i < count($prices); $i++) {
			$payments[] = array($authorIds[$i], $prices[$i]);	
		}
		
		$authorModel = Mage::getSingleton('author/author');
		foreach($payments as $payment) {
			var_dump($payment);
		}
    }
}