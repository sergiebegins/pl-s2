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
		$this->teams['sum'] = array_sum($this->teams['force']);
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

		$this->getWeek( intval($params));

		$this->load->view('week',$this->teams);
	}

	private function getWeek($params=''){
		$this->teams['week'] = intval($params);

		if(!empty($_SESSION['score'])){
			$this->teams['score'] = $_SESSION['score'][$this->teams['week']];
		}else{
			$this->load->library('LeagueProcess');
			$mylib= new LeagueProcess();
			$score = $mylib->playMatches($this->teams);
			$_SESSION['score'] = $score;
			$this->teams['score'] = $_SESSION['score'][$this->teams['week']];
		}
	}

	public function fullWeek(){

		if($_SESSION['score']){
			$this->teams['score'] = $_SESSION['score'];

			$this->load->view('fullWeek',$this->teams);
		}else{
			redirect('http://localhost/pl-simulator/index.php');
		}

	}

	public function play(){
		if($_SESSION['score']){
			$this->load->library('LeagueProcess');
			$mylib= new LeagueProcess();
			$score = $mylib->playMatches($this->teams);
			$_SESSION['score'] = $score;
		}

		redirect('http://localhost/pl-simulator/index.php/PL/fullWeek');
	}

	public function delete(){
		$this->session->sess_destroy();

		redirect('http://localhost/pl-simulator/index.php');
	}
}
