<?php

Class LeagueProcess{

	public function createFixture(){
		$lig=[];
		$week=[];

		$draw =$this->draw();
		$takimlar = array(0,1,2,3);
		for ($i=1;$i<4;$i++){

			$lig[0][$i] =$draw[$i-1];
			$lig[$draw[$i-1]][$i] =0;
			$flag =array_values(array_diff( $takimlar, [0,$draw[$i-1]] )) ;
			$lig[$flag[0]][$i] =$flag[1];
			$lig[$flag[1]][$i] =$flag[0];

			$week[$i][0] = $draw[$i-1];



			$week[$i][$flag[0]] =$flag[1];

		}

		$draw =$this->draw();
		for ($i=4;$i<7;$i++){
			$lig[0][$i] =$draw[$i-4];
			$lig[$draw[$i-4]][$i] =0;
			$flag =array_values(array_diff( $takimlar, [0,$draw[$i-4]] )) ;
			$lig[$flag[0]][$i] =$flag[1];
			$lig[$flag[1]][$i] =$flag[0];

			$week[$i][$draw[$i-4]] = 0 ;

			$week[$i][$flag[1]] =$flag[0];

		}


		return array('lig'=>$lig,'week'=>$week);
	}

	public function playMatches($teams){


		$score = [];
		$win = $lose=$draw = [0,0,0,0];
		$winRate = [];

		foreach ($teams["fixture"] as $k=>$v){

			foreach ($v as $k2=>$v2){
				//ev sahibi avantajlı
				$p1 = round($teams["force"][$k2]+1*rand(1, 2)/rand(1, 2));
				$p2 = round($teams["force"][$v2]*rand(1, 2)/rand(1, 2));
				$score[$k]['result']['score'][] =array($p1,$p2);

				if(empty($score[$k]['result']['avg'][$k2])){
					$score[$k]['result']['avg'][$k2] =$p1-$p2;
				}
				if(empty($score[$k]['result']['avg'][$v2])){
					$score[$k]['result']['avg'][$v2] =$p2-$p1;
				}

				if($p1>$p2){
					$win[$k2] += 1;
					$lose[$v2] += 1;

				}elseif ($p2<$p1){
					$win[$v2] += 1;
					$lose[$k2] += 1;
				}
				else{
					$draw[$v2] += 1;
					$draw[$k2] += 1;
				}

				$score[$k]['result']['week'] = [$win,$lose,$draw];


			}
		}

		return $score;
	}

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
