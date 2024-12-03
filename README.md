# Project Overview
Mock an e-commerce site, that shows products, orders and allows orders to be made.

# Setup Instructions
- Download latest version of xampp
- Update the document root in httpd.conf, httpd-ssl.conf, and https-xampp.conf to point to this folder.

# Design decisions
## Running locally
I originally attempted this in Docker, as I had tried docker once before and it seemed simple though I had troubles with it, culminating in permissions errors for the .json files.
I decided to switch to xampp as at my previous role we used xampp locally, so I knew I could get it working there.

## PHP
Xampp's latest version is 8.2.12, though when I started in Docker this was 8.3.11. There were no issue swapping between the two versions.

## Order form
There was no guidance for the order form, I choose a simple form on the index page with 2 fields, the product ID and quantity.

## Styling
I used Bootstrap 5 as I have used bootstrap before (3 & 4, I believe) and I know this was listed on the job spec.

## Database
I created a class called Database, this will read and write the json files, it should be suitable for any of the 3 .json files.
The json files are in the databases folder.

## Autoloader
The autoloader allows any class in the classes folder to the be loaded.

I also stuck the error handler in here, it logs to logs.json file but also returns false so the PHP error handler gets called too and the errors were visible to me while implementing.

# Feature Summary
- products.json file for the inventory data
- InventoryManager::processOrder()
    - Check quantity
    - Deduct from stock
    - Return message
    - Save stock level
- NotificationService::sendLowStockAlert()
  - Adds to the session when the stock is less than 5
- Order logging to orders.json
- Basic frontend display
  - Stock level alert
  - Previous orders
  - Order form
- Error handler
  - Custom error handler to log to logs.json