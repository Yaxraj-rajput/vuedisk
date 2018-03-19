<?php
include_once './base-dir.php';

if (!isSessionActive()) {
	echo '{"status" : "failed", "message" : "Login Required"}';
	return;
}

header("Access-Control-Allow-Methods: POST");
$data = json_decode(file_get_contents('php://input'), true);
$parentDir = htmlspecialchars(strip_tags($data['parentDir']));
$oldName = htmlspecialchars(strip_tags($data['oldName']));
$newName = htmlspecialchars(strip_tags($data['newName']));

if (strpos($parentDir, '/') != 0) {
	$parentDir =  '/' . $parentDir;
}
$parentDir = $baseDir . $parentDir;

if (strpos($parentDir, '/./') != false || strpos($parentDir, '..') != false
	|| strpos($oldName, '/./') != false || strpos($oldName, '..') != false
		|| strpos($newName, '/./') != false || strpos($newName, '..') != false) {
	return;
}

shell_exec('mv "' . $parentDir . '/' . $oldName . '" "' . $parentDir . '/' . $newName . '"');

echo 'success';
?>