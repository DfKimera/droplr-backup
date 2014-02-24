<?php
$dropIDs = array(); // <<< REPLACE *ALL* OF THIS LINE WITH THE OUTPUT FROM scrapper.js >>>
// ^^^^^ [ [ REPLACE THE LINE ABOVE WITH THE OUTPUT FROM scrapper.js! ] ] ^^^^^

$baseDropURL = "http://d.pr/i/";
$targetFolder = "downloaded";

function httpGET($url) {
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

	$data = curl_exec($ch);
	curl_close($ch);

	return $data;
}

function httpDownload($url, $targetPath) {

	$ch = curl_init();

	$fp = fopen($targetPath, "w+");

	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

	curl_exec($ch);
	curl_close($ch);

	fclose($fp);
}

function getDropImageMeta($dropID) {

	global $baseDropURL;

	$dropHTML = httpGET($baseDropURL . $dropID);

	$doc = new DOMDocument();
	$doc->loadHTML($dropHTML);

	$elmContainer = $doc->getElementById('main-img');

	if(!$elmContainer) {
		throw new Exception("Failed to find image container 'main-img', dropID={$dropID}");
	}

	$imgElement = $elmContainer->lastChild;

	if(!$imgElement) {
		throw new Exception("Failed to find image element within container, dropID={$dropID}");
	}

	return array($imgElement->getAttribute('src'), $imgElement->getAttribute('alt'));
}

function fetchDrop($dropID) {

	global $targetFolder;

	list($imgURL, $imgName) = getDropImageMeta($dropID);

	httpDownload($imgURL, $targetFolder . "/" . $dropID . "_" . basename($imgName));

}

function trace($msg) {
	echo "\n<".date("Y-m-d\TH:i:s")."> {$msg}";
}

function ok() {
	echo " ... OK!";
}

function line() {
	trace("----------------------------");
}

trace("DfKimera's Droplr Backup Script");
trace("Enjoy and share! - http://github.com/DfKimera/droplr-backup");
line();

trace("Setting up...");

error_reporting(E_ERROR);
set_time_limit(0);
ini_set('memory_limit', '128M');

$numDrops = 0;
$totalDrops = sizeof($dropIDs);

ok();

if(is_dir($targetFolder)) {
	trace("[!] Directory '{$targetFolder}' does not exist, creating...");
	mkdir($targetFolder);
	ok();
}

trace("Fetching drops...");

foreach($dropIDs as $dropID) {

	$numRemaining = $totalDrops - $numDrops;

	trace("Fetching {$dropID} ({$numRemaining} remaining)...");

	try {
		fetchDrop($dropID);
		$numDrops++;
	} catch (Exception $ex) {
		echo " ... ERROR! {$ex->getMessage()}\n\n";
	}

	ok();

}

line();
trace("Finished! {$numDrops} out of {$totalDrops} downloaded.");
line();

exit();
