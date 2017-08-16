<?php
	class Post {
		private $from;
		private $decscription;
		private $timestamp;
		public function __construct($frm,$desc,$tm){
			$this->from=$frm;
			$this->decscription=$desc;
			$this->timestamp=$tm;
		}
		public function setFrom($frm){
			$this->from=$frm;
		}
		public function setDescription($desc){
			$this->decscription=$desc;
		}
		public function getFrom(){
			return $this->from;
		}
		public function getDescription(){
			return $this->decscription;
		}
		public function getTimeStamp(){
			return $this->timestamp;
		}
	}
?>
