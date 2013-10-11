<?php

$serial = $_POST['s_matricola'];

$city = new city($db);
$id_bike = $city->getBikeId(1, $serial);
if (!$id_bike) { $id_bike = $city->addBike(1, $serial); }

foreach ($_POST['issue'] as $id_issue => $status) {
	$city->addBikeIssue($id_bike, $id_issue, trim($_POST['note'][$id_issue]));
}

$city->setBikeStatus($id_bike, (bool)$_POST['status']);

unset($_SESSION['matricola']);

header("Location: /");
exit();