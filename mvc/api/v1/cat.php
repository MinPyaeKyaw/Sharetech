<?php 

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

	$arr = array();
	$arr['cats'] = array();

	foreach ($this->cats as $value) {
		$project = array(
			'id' => $value['category_id'],
			'category' => $value['category']
		);

		array_push($arr['cats'], $project);
	}

	echo json_encode($arr);

}else {
	http_response_code(404);
	echo json_encode(array(
		"status" => 0,
		"message" => "No projects found."
	));
}

 ?>