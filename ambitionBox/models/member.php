<?php
	class Member {
		private $id;
		private $name;
		private $password;
		public function __construct($nm,$pass){
			$this->name=$nm;
			$this->password=$pass;
		}
		public function getName(){
			return $this->name;
		}
		public function getPassword(){
			return $this->password;
		}
		public function setName($nm){
			$this->name=$nm;
		}
		public function setPassword($pass){
			$this->password=$pass;
		}
		public function setId($id){
			$this->id=$id;
		}
		public function getId(){
			return $this->id;
		}
	}
?>