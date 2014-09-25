<?php
/*
 * minimicrochat.php - the simplest chat server I could write in two hours
 */
$db = createdb();
if ( ! empty($_POST['yo'])) { sendmessage($_POST['yo']); }
?><!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>yo</title></head>
<body onload="document.yo.yo.focus();" style="font-size: 12px; font-family: helvetica, sans-serif;">
<ul>
<?php foreach (getmessages(25) as $msg) { ?>
<li>
	<span style="color: rgb(<?php print($msg['rgb']); ?>);">Yo: </span>
	<?php print(htmlspecialchars($msg['message'])) ?>
</li>
<?php } ?> 
</ul>
<form method="post" name="yo">
<input style="width: 80%;" type="text" autocomplete="off" name="yo" />
<button type="submit">yo</button>
</form></body></html>
<?php

function db() {
	static $db;
	$db = $db ?: (new PDO('sqlite:yo.sqlite3', 0, 0, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)));
	return $db;
}

function query($sql, $params = NULL) {
	$s = db()->prepare($sql);
	$s->execute(array_values((array) $params));
	return $s;
}

function createdb() {
	$dayhash = md5(date('Ymd'));
	db()->exec("CREATE TABLE IF NOT EXISTS messages_$dayhash (
					id INTEGER PRIMARY KEY,
					rgb TEXT, 
					message TEXT)");
}

function sendmessage($msg) {
	$dayhash = md5(date('Ymd'));
	query("INSERT INTO messages_$dayhash (rgb, message) 
				VALUES (?, ?)", array(rgbfromip(), $msg));
}

function getmessages($db, $num=25) {
	$dayhash = md5(date('Ymd'));
	return query("SELECT * FROM messages_$dayhash ORDER BY id DESC LIMIT :num", array($num));
}

function rgbfromip() {
	$h = array_map('ord', str_split(md5($_SERVER['REMOTE_ADDR'], true)));
	return "$h[0],$h[1],$h[2]";
}
