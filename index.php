<?php
/*
 * minimicrochat.php - the simplest chat server I could write in two hours
 */
$db = createdb();
if ($_POST['yo']) { sendmessage($db,$_POST['yo']); }
$res = getmessages($db, 25);
$msgs = $res->fetchAll();
?><!doctype html>
<html lang="en">
<head><meta charset="utf-8"><title>yo</title></head>
<body onload="document.yo.yo.focus();" style="font-size: 12px; font-family: helvetica, sans-serif;">
<ul>
<?php if (count($msgs)) { foreach ($msgs as $msg) { ?>
<li>
    <span style="color: rgb(<?php print($msg['rgb']); ?>);">Yo: </span>
    <?php print(htmlspecialchars($msg['message'])) ?>
</li>
<?php }} ?> 
</ul>
<form method="post" name="yo">
<input style="width: 80%;" type="text" autocomplete="off" name="yo" />
<button type="submit">yo</button>
</form></body></html>
<?php
// lib
function createdb() {
    $db = new PDO('sqlite:yo.sqlite3');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("CREATE TABLE IF NOT EXISTS messages (
                    Ymd INTEGER,
                    id INTEGER PRIMARY KEY,
                    rgb TEXT, 
                    message TEXT)");
    $db->exec("CREATE INDEX IF NOT EXISTS messages_index ON messages 
              (Ymd,id)");
    return $db;
}
function sendmessage($db, $msg) {
    $day = intval(date('Ymd'));
    $insert = "INSERT INTO messages (day, rgb, message) 
                VALUES (:day, :rgb, :message)";
    $stmt = $db->prepare($insert);
    $stmt->bindParam(':day', $day);
    $stmt->bindParam(':message', $msg);
    $rgb = rgbfromip();
    $stmt->bindParam(':rgb', $rgb);
    $stmt->execute();
}
function getmessages($db, $num=25) {
    $day = intval(date('Ymd'));
    $stmt = $db->prepare("SELECT * FROM messages where day = :day 
                           ORDER BY id DESC LIMIT :num");
    $stmt->bindParam(':day', $day);
    $stmt->bindParam(':num', $num);
    $res = $stmt->execute();
    return $res;
}
function rgbfromip() {
    $h = array_map('ord', str_split(md5($_SERVER['REMOTE_ADDR'], true)));
    return "$h[0],$h[1],$h[2]";    
} 
