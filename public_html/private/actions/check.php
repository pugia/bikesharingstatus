<?php

$serial = $_REQUEST['matricola'];

$city = new city($db);
$id_bike = $city->getBikeId(1, $serial);

$data = array();

if (!$id_bike) {
	$data['status'] = false;
} else {
	$data['status'] = $city->getBikeStatus($id_bike);
	$data['issues'] = $city->getBikeIssues($id_bike);
}

/*
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
*/	header('Content-type: application/json');

echo json_encode($data);

