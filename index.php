<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/Autoloader.php');

$validation = [];
$order_status = '';
if ($_POST) {
	$iv = new InventoryManager();
	if (!is_numeric($_POST['productid']) || !(int)$_POST['productid'] > 0) {
		$validation[] = 'Product ID not valid';
	}
	if (!is_numeric($_POST['quantity']) || !(int)$_POST['quantity'] > 0) {
		$validation[] = 'Quantity not valid';
	}

	if (!$validation) {
		$order_status = $iv->processOrder((int)$_POST['productid'], (int)$_POST['quantity']);
	}
}

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ShopRight</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
		  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container">
	<h1>ShopRight</h1>
	<div id="alerts">
		<?php
		if ($order_status) {
			echo <<<HTML
					<div class="alert alert-primary" role="alert">
						$order_status
					</div>
				HTML;
		}
		if ($validation) {
			foreach ($validation as $notification) {
				echo <<<HTML
						<div class="alert alert-danger" role="alert">
							$notification
						</div>
					HTML;
			}
		}
		?>
		<div id="notifications"></div>
	</div>
	<div>
		<h2>Products</h2>
		<table class="table">
			<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col">Name</th>
				<th scope="col">Quantity</th>
				<th scope="col">Price</th>
			</tr>
			</thead>
			<tbody>
			<?php

			foreach ((new Database('products.json'))->all() as $product) {
				echo <<<HTML
				<tr>
					<th scope="row">{$product['id']}</th>
					<td>{$product['name']}</td>
					<td>{$product['stock']}</td>
					<td>£{$product['price']}</td>
				</tr>
				HTML;
			}

			?>
			</tbody>
		</table>
	</div>

	<h2>Order</h2>
	<div class="card">
		<div class="card-body">
			<form method="POST">
				<div class="mb-3">
					<label for="productid" class="form-label">Product ID</label>
					<input type="number" class="form-control" id="productid" name="productid">
				</div>
				<div class="mb-3">
					<label for="quantity" class="form-label">Quantity</label>
					<input type="number" class="form-control" id="quantity" name="quantity">
				</div>
				<button type="submit" class="btn btn-primary">Order</button>
			</form>
		</div>
	</div>

	<div>
		<h2>Orders</h2>
		<table class="table">
			<thead>
			<tr>
				<th scope="col">Time</th>
				<th scope="col">Name</th>
				<th scope="col">Quantity</th>
				<th scope="col">Price</th>
			</tr>
			</thead>
			<tbody>
			<?php

			foreach ((new Database('orders.json'))->all() as $order) {
				$product_db = new Database('products.json');
				$product = $product_db->find($order['product_id']);
				$order_amount = $product['price'] * $order['quantity']; // This will be incorrect if the product price changes in future
				$time_str = date('Y-m-d H:i:s', $order['timestamp']);
				echo <<<HTML
				<tr>
					<th scope="row">{$time_str}</th>
					<td>{$product['name']}</td>
					<td>{$order['quantity']}</td>
					<td>£{$order_amount}</td>
				</tr>
				HTML;
			}

			?>
			</tbody>
		</table>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
		crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
		integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="js/js.js"></script>
</body>
</html>
