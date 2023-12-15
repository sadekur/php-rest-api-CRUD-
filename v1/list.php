<?php
/*Include Header*/
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset: UFT-8");
header("Access-Control-Allow-Methods: GET");

/*Include files*/
include_once( '../config/database.php' );
include_once( '../classes/student.php' );

$db = new Database();
$connection = $db->connects();

$student = new Student( $connection );

if ( $_SERVER[ 'REQUEST_METHOD' ] === 'GET' ) {
	$data = $student->get_all_data();
	if ( $data->num_rows > 0 ) {
		$students['records'] = array();
		while ( $row = $data->fetch_assoc() ) {
			array_push( $students['records'], array(
				'id' 		=> $row['id'],
			    'name' 		=> $row['name'],
			    'email' 	=> $row['email'],
			    'mobile' 	=> $row['mobile'],
			    'status' 	=> $row['status'],
			  // 'create_at'	=> date("Y-m-d", strtotime( $row['create_at'] ) ),
			   'create_at' => isset( $row['create_at'] ) ? date( "Y-m-d", strtotime( $row['create_at'] ) ) : null,
			) );
		}
		http_response_code( 200 );
		echo json_encode( array(
			"status" 	=> 1,
			"data" 	=> $students['records']
		) );
	}
}else{
	http_response_code( 503 );
	echo json_encode( array(
		"status" 	=> 0,
		"message" 	=> "Access Denied",
	) );
}
