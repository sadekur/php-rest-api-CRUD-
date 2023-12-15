<?php
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset: UFT-8");
header("Access-Control-Allow-Methods: POST");

/* Include files */
include_once('../config/database.php');
include_once('../classes/student.php');

$db = new Database();
$connection = $db->connects();

$student = new Student($connection);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->name) && !empty($data->email) && !empty($data->mobile) && !empty($data->id)) {
        $student->name   = $data->name;
        $student->email  = $data->email;
        $student->mobile = $data->mobile;
        $student->id 	 = $data->id;

        if ($student->update_student()) {
            http_response_code(200);
            echo json_encode(array(
                "status" => 1,
                "message" => "Student has been updated"
            ));
        } else {
            http_response_code(500);
            echo json_encode(array(
                "status" => 0,
                "message" => "Failed to update Student"
            ));
        }
    } else {
        http_response_code(404);
        echo json_encode(array(
            "status" => 0,
            "message" => "All data is needed"
        ));
    }
} else {
    http_response_code(503);
    echo json_encode(array(
        "status" => 0,
        "message" => "Access Denied",
    ));
}
