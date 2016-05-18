<?php
echo "testing db<br />";

class studentDB{
    private $db;
    private $salt;

    public function __construct(){
	    $this->db = new mysqli("sql2.njit.edu", "jkv5", "buddhist6", "jkv5");
	    $this->salt = "7hjk5235h234l5h3ijfqw9fjwapnfpq49fh34qbf3y48gtoi";

	    if ($this->db->connect_errno > 0 ){
        echo __FILE__.__LINE__."failed to connect to database re: ".$this->db->connect_error;
      	exit(0);
      	}
    }

    public function __destruct(){
	     $this->db->close();
    }

    public function getStudentUCID($name){
	    $query = "select ucid from login where ucid = '$name';";
	    $results = $this->db->query($query);
      if (!$results){
	       echo "error with results: ".$this->db->error;
	       return 0;
	    }
      $login = $results->fetch_assoc();
	    if (isset($login['ucid'])){
	       return $login['ucid'];
	      }
	       return 0;
       }


    private function saltPassword($password){
	     return $this->db->real_escape_string(sha1($password.$this->salt));
    }

    public function validateStudent($name,$password){
	     if ($this->getStudentUCID($name) == 0) {
         return false;
       }
	    $query = "select * from login where ucid = '$name';";
      $results = $this->db->query($query);
      if (!$results){
	       return false;
      }
      $login = $results->fetch_assoc();{
	    if ($this->saltPassword($login['pass']) == $this->saltPassword($password)){
          echo "Successfull<br />";
		      return true;
        }
      }else {
        echo "Fail<br />";
        return false;
      }
    }

}

?>
