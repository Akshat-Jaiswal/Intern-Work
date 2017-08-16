<?php
	require_once("../configurations/dbConfig.php");
	class ConnectionManager{
		private $con;
		private $error;
		public function connect(){
			$url=DataBaseConfig::URL;
			$pass=DataBaseConfig::PASSWORD;
			$user=DataBaseConfig::USERNAME;
			$db=DataBaseConfig::DATABASE;
			$con=mysqli_connect($url,$user,$pass,$db);
			if(!$con){
				$this->error=mysqli_connect_error();
			}
			else 
			$this->con=$con;
		}
		public function __construct(){
			$this->connect();
		}
		public function getConnection(){
			return $this->con;
		}
		public function getError(){
			return $this->error;
		}
		public function close(){
			mysqli_close($this->con);
		}

	}
?>