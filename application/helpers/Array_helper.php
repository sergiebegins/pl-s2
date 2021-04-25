<?php

class Array_helper{

	public function draw(){
		$done = false;
		while(!$done){
			$numbers = range(1, 3);
			shuffle($numbers);
			$done = true;
			foreach($numbers as $key => $val){
				if($key == $val){
					$done = false;
					break;
				}
			}
		}
		return $numbers;
	}


}
