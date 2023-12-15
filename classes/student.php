<?php

class Student {
	public $name;
	public $email;
	public $mobile;
	public $id;

	private $connect;
	private $tbl_name;

	public function __construct($db) {
		$this->connect = $db;
		$this->tbl_name = 'student';
	}

	/*from create.php*/
	public function create_data() {
		// Use a prepared statement with placeholders
		$query = "INSERT INTO " . $this->tbl_name . " (name, email, mobile) VALUES (?, ?, ?)";
		$obj = $this->connect->prepare($query);

		// Make sure to sanitize the input
		$this->name     = htmlspecialchars(strip_tags($this->name));
		$this->email    = htmlspecialchars(strip_tags($this->email));
		$this->mobile   = htmlspecialchars(strip_tags($this->mobile));

		// Bind parameters
		$obj->bind_param( "sss", $this->name, $this->email, $this->mobile );

		if ( $obj->execute() ) {
			return true;
		}
		return false;
	}

	/*from list.php*/
	public function get_all_data(){
		$sql_query  = "SELECT * FROM " . $this->tbl_name;
		$std_obj    = $this->connect->prepare( $sql_query );

		$std_obj->execute();
		return $std_obj->get_result();
	}

	/*from single.php*/
	public function single_student(){
		$sql_query = "SELECT * FROM " . $this->tbl_name . " WHERE id = ?";
		$query_obj = $this->connect->prepare( $sql_query );
		
		$obj->bind_param("i", $this->id);
		$obj->execute();
		$data = $obj->get_result();
		return $data->fetch_assoc();

	}
	
	// update
	public function update_student(){
		$update_query = "UPDATE " . $this->tbl_name . " SET name = ?, email = ?, mobile = ? WHERE id = ? ";
		$obj = $this->connect->prepare($update_query);

		$this->name     = htmlspecialchars(strip_tags($this->name));
		$this->email    = htmlspecialchars(strip_tags($this->email));
		$this->mobile   = htmlspecialchars(strip_tags($this->mobile));
		$this->id       = htmlspecialchars(strip_tags($this->id));

		$obj->bind_param("sssi", $this->name, $this->email, $this->mobile, $this->id);
		if ($obj->execute()) {
			return true;
		}
		return false;
	}

	 // update
	public function delete_student(){
		$delete_query = "DELETE FROM " . $this->tbl_name . " WHERE id = ?";
		$obj = $this->connect->prepare($delete_query);

		$this->id       = htmlspecialchars(strip_tags($this->id));

		$obj->bind_param("i", $this->id);
		if ($obj->execute()) {
			return true;
		}
		return false;
	}
}

