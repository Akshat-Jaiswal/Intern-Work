<?php
	class InputCleaner{
		public function getCleanInput($input){
			if($_SERVER['REQUEST_METHOD']=='POST')
				return strip_tags($_POST[$input]);
			if($_SERVER['REQUEST_METHOD']=='GET')
				return strip_tags($_GET[$input]);
		}
		public function cleanSqlInput($con,$input){
			return mysqli_real_escape_string($con,$input);
		}
	}
?>