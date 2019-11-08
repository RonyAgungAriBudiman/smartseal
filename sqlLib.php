 	<?php 
class sqlLib
{ 
	var $srvr; 
	var $db; 
	var $usr; 
	var $psw;
	 
	function sqlLib()
	{ 
		include dirname(__FILE__)."/config.php"; 
		$this->srvr = $srvr; 
		$this->db = $db; 
		$this->usr = $usr; 
		$this->psw = $psw; 
		$this->conn =new mysqli($this->srvr, $this->usr, $this->psw,$this->db); 
		if(!$this->conn) print "Connection not establish!!!";  
	} 
	
	function antisqlinject($string) {
		$string = stripslashes($string);
		$string = strip_tags($string);
		$string = mysqli_real_escape_string($this->conn, $string);
		return $string;
	}

	function select($sql = "")
	{ 
		if(empty ($sql) || empty ($this->conn)) 
		return false; 
		$result = mysqli_query($this->conn, $sql); 
		if(empty($result))
		{ 
			return false; 
		} 
		if(!$result)
		{ 
			mysqli_free_result($result); 
			return false;; 
		} 
		$data = array(); 
		$inc = 0; 
		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){ 
			$data[$inc]=$row; 
			$inc++; 
		} 
		mysqli_free_result($result); 
		return $data; 
	} 
	
	function insert($sql = "")
	{ 
		$status = "";
		if (empty($sql))
		{ 
			return false; 
		} 
		$sql = trim($sql); 
		/*if (!eregi("^insert", $sql))
		{ 
			$status = "wrong command, it's insert command only"; 
		}*/
		$conn = $this -> conn; 
		$result = mysqli_query($this->conn, $sql) or $status = "0"; 
		
		if ($result)
		{ 
			$status = "1";
		}
		
		return $status;
	}
	
	function update($sql = "")
	{ 
		$status = "";
		if (empty($sql))
		{ 
			return false; 
		} 
		$sql = trim($sql); 
		/*
		if (!eregi("^update", $sql))
		{ 
			echo"wrong command, it's update command only"; 
		} 
		*/
		$conn = $this -> conn; 
		$result = mysqli_query($this->conn, $sql) or $status = "0"; 
		
		if ($result)
		{ 
			$status = "1";
		}
		
		return $status; 
	} 
	function delete($sql = "")
	{ 
		$status = "";
		$sql = trim($sql); 
		if (empty($sql))
		{ 
			return false; 
		} 
		/*
		if (!eregi("^delete", $sql))
		{ 
			echo"wrong command, it's delete command only"; 
			return false; 
		} */
		if (empty($this -> conn))
		{ 
			return false; 
		} 
		
		$result = mysqli_query($this->conn, $sql) or $status = "0"; 
		
		if ($result)
		{ 
			$status = "1";
		}
		
		return $status;
	}
}

error_reporting(1);