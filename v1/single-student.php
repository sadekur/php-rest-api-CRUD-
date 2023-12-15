<?php
//ini_set("display_errors", 1);
/*Include Header*/
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset: UFT-8");
header("Access-Control-Allow-Methods: POST");

/*Include files*/
include_once( '../config/database.php' );
include_once( '../classes/student.php' );

$db = new Database();
$connection = $db->connects();

$student = new Student( $connection );

if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' ) {
	$parm = json_decode( file_get_contents( "php://input" ) );
	if ( !empty( $parm->id ) ) {
		$student->id = $parm->id;
		$student_data = $student->single_student();

		if ( !empty( $student_data ) ) {
			http_response_code( 200 );
			echo json_encode( array(
				"status" 	=> 1,
				"data" 	=> $student_data
			) );
		}else{
			http_response_code( 404 );
			echo json_encode( array(
				"status" 	=> 0,
				"message" 	=> "Student not found"
			) );
		}
	}

}else{
	http_response_code( 503 );
	echo json_encode( array(
		"status" 	=> 0,
		"message" 	=> "Access Denied",
	) );
}