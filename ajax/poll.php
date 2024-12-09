<?php

session_start();

$notification_string = '';

if ($_SESSION['notifications'] ?? false) {
	foreach ($_SESSION['notifications'] as $notification) {
		$notification_string .= <<<HTML
				<div class="alert alert-warning" role="alert">
					$notification
				</div>
			HTML;
	}
}

echo $notification_string;