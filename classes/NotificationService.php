<?php

class NotificationService
{
	public static function sendLowStockAlert(int $productId): void
	{
		$db = new Database('products.json');
		$product = $db->find($productId);
		$_SESSION['notifications'][] = "Only {$product['stock']} left of {$product['name']}";
	}
}