<?php

class InventoryManager
{
	public function processOrder(int $productId, int $quantity)
	{
		$product_db = new Database('products.json');
		$product = $product_db->find($productId);
		if ($product['stock'] >= $quantity) {

			$orders_db = new Database('orders.json');
			$orders_db->add([
				"product_id" => $productId,
				"quantity" => $quantity,
				"timestamp" => time(),
			]);
			$orders_db->write();

			$product['stock'] -= $quantity;

			$product_db->set($productId, $product);
			$product_db->write();


			if ($product['stock'] < 5) {
				NotificationService::sendLowStockAlert($productId);
			}

			return 'Success';
		}

		return 'Out of stock';
	}
}