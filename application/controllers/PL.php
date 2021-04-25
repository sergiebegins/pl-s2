<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class PL extends CI_Controller {
	private $teams;
	private $league;

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->teams['list'] = ['Manchester City','Chelsea','Everton','Arsenal'];
		$this->teams['force'] = [4,3,1,2];

		if(empty($_SESSION['fixture'])){
			$this->load->library('LeagueProcess');
			$mylib= new LeagueProcess();
			$fixture = $mylib->createFixture();
			$_SESSION['fixture'] = $fixture;
			$this->teams['fixture']= $_SESSION['fixture']['week'];
		}else{
			$this->teams['fixture'] = $_SESSION['fixture']['week'];
		}
	}

	public function index()
	{
		//$this->session->sess_destroy();

		$sum = array_sum($this->teams['force']);
			foreach ($this->teams['force'] as $k=>$v){
				$this->teams['yuzde'][$k] = ($v*100)/$sum;
			}
		$this->teams['week'] = 1;


		$this->load->view('index',$this->teams);
	}
	public function week($params=''){

		$this->teams['sum'] = array_sum($this->teams['force']);


		$this->teams['week'] = intval($params);

		if(!empty($_SESSION['score'])){
			$this->teams['score'] = $_SESSION['score'][$this->teams['week']];
		}



		$this->load->view('week',$this->teams);
	}
	public function play(){
		$this->load->library('LeagueProcess');
		$mylib= new LeagueProcess();
		$score = $mylib->playMatches($this->teams);
		$_SESSION['score'] = $score;
		redirect('http://localhost/pl-simulator/index.php/PL/week/1');
	}


}
