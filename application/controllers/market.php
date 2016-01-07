<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Market extends CI_Controller {

	public function index($category = '')
	{
		session_start();
		if(!isset($_SESSION['BAG'])){
			$_SESSION['BAG'] = array();
			$_SESSION['last'] = array();
			$_SESSION['total'] = array();
			$_SESSION['total']['counts'] = 0;
			$_SESSION['total']['price'] = 0;
		}
		if($category==''){
			$res = $this->shop_model->get_first_category();
		}else{
			$res = $this->shop_model->check_category($category);
		}
		if(empty($res))
			return show_404();
		$menu = $this->shop_model->get_multilevel_menu();
		$settings = $this->shop_model->get_settings();
		$allfilters = $this->shop_model->get_filters();
		$this->load->view('market/index', array_merge($res, array('menu'=>$menu, 'settings'=>$settings, 'allfilters'=>$allfilters)));
	}

	public function product($id)
	{
		session_start();
		if(!isset($_SESSION['BAG'])){
			$_SESSION['BAG'] = array();
			$_SESSION['last'] = array();
			$_SESSION['total'] = array();
			$_SESSION['total']['counts'] = 0;
			$_SESSION['total']['price'] = 0;
		}
		$obj = $this->shop_model->get_product($id);
		if(empty($obj))
			return show_404();
		$cat = $this->shop_model->get_multilevel_menu();
		$bag = '[]';
		if(isset($_SESSION['BAG']))
			$bag = json_encode($_SESSION['BAG']);
		$this->load->view('market/product', array_merge($obj, array('allcategory'=>$cat, 'bag'=>$bag)));
	}

	public function quick_view($id)
	{
		session_start();
		if(!isset($_SESSION['BAG'])){
			$_SESSION['BAG'] = array();
			$_SESSION['last'] = array();
			$_SESSION['total'] = array();
			$_SESSION['total']['counts'] = 0;
			$_SESSION['total']['price'] = 0;
		}
		$this->load->database();
		$obj = $this->shop_model->get_product($id);
		if(empty($obj))
			return show_404();
		$cat = $this->shop_model->get_multilevel_menu();
		$bag = '[]';
		if(isset($_SESSION['BAG']))
			$bag = json_encode($_SESSION['BAG']);
		$this->load->view('market/prd', array_merge($obj, array('allcategory'=>$cat, 'bag'=>$bag)));
	}

	public function about()
	{
		session_start();
		if(!isset($_SESSION['BAG'])){
			$_SESSION['BAG'] = array();
			$_SESSION['last'] = array();
			$_SESSION['total'] = array();
			$_SESSION['total']['counts'] = 0;
			$_SESSION['total']['price'] = 0;
		}
		$this->load->database();
		$cat = $this->shop_model->get_multilevel_menu();
		$jobs = $this->shop_model->get_jobs_names();
		$j = false;
		if(isset($_GET['tab']))
			$j = $_GET['tab'];
		$bag = '[]';
		if(isset($_SESSION['BAG']))
			$bag = json_encode($_SESSION['BAG']);
		$this->load->view('market/about', array('allcategory'=>$cat, 'bag'=>$bag, 'jobs'=>$jobs, 'tab'=>$j, 'captcha'=>$this->shop_model->captcha_create()));
	}

	/*cart*/
	public function cart()
	{
		session_start();
		if(!isset($_SESSION['BAG'])){
			$_SESSION['BAG'] = array();
			$_SESSION['last'] = array();
			$_SESSION['total'] = array();
			$_SESSION['total']['counts'] = 0;
			$_SESSION['total']['price'] = 0;
		}
		$bag = array();
		$res = array();
		$this->load->database();
		$cat = $this->shop_model->get_multilevel_menu();
		if(isset($_SESSION['BAG']))
			$bag = $_SESSION['BAG'];
		$this->load->view('market/cart', array_merge($res, array('allcategory'=>$cat, 'bag'=>$bag)));
	}
	/*qiuck access*/
	public function cart_overview(){
		session_start();
		if(!isset($_SESSION['BAG'])){
			$_SESSION['BAG'] = array();
			$_SESSION['last'] = array();
			$_SESSION['total'] = array();
			$_SESSION['total']['counts'] = 0;
			$_SESSION['total']['price'] = 0;
		}
		$bag = '[]';
		if(isset($_SESSION['BAG']))
			$bag = $_SESSION['BAG'];
		$this->load->view('market/cart_overview', array('bag' => $bag));
	}
	/*tables*/
	public function cartview($type)
	{
		session_start();
		if(!isset($_SESSION['BAG'])){
			$_SESSION['BAG'] = array();
			$_SESSION['last'] = array();
			$_SESSION['total'] = array();
			$_SESSION['total']['counts'] = 0;
			$_SESSION['total']['price'] = 0;
		}
		$bag = '[]';
		if(isset($_SESSION['BAG']))
			$bag = $_SESSION['BAG'];
		if($type==0){
			$this->load->view('market/templates/cartview', array('bag'=>$bag));
		}elseif($type==1){
			$this->load->view('market/templates/checkview', array('bag'=>$bag));
		}
	}

	public function checkout()
	{
		session_start();
		if(!isset($_SESSION['BAG'])){
			$_SESSION['BAG'] = array();
			$_SESSION['last'] = array();
			$_SESSION['total'] = array();
			$_SESSION['total']['counts'] = 0;
			$_SESSION['total']['price'] = 0;
		}
		$bag = array();
		$res = array();
		$this->load->database();
		$cat = $this->shop_model->get_multilevel_menu();
		if(isset($_SESSION['BAG']))
			$bag = $_SESSION['BAG'];
		$this->load->view('market/checkout', array_merge($res, array('allcategory'=>$cat, 'bag'=>$bag)));
	}

	public function sitemap(){
		session_start();
		if(!isset($_SESSION['BAG'])){
			$_SESSION['BAG'] = array();
			$_SESSION['last'] = array();
			$_SESSION['total'] = array();
			$_SESSION['total']['counts'] = 0;
			$_SESSION['total']['price'] = 0;
		}
		$this->load->database();
		$cat = $this->shop_model->get_multilevel_menu();
		$bag = array(); $arr = array(); $all_products = array();
		if(isset($_SESSION['BAG']))
			$bag = $_SESSION['BAG'];
		foreach ($cat as $key => $v) {
			array_push($all_products, $this->shop_model->get_products_by_category($v['name']));
		}
		$this->load->view('market/sitemap', array_merge($arr, array('allcategory'=>$cat, 'allproducts'=>$all_products, 'bag'=>$bag)));
	}

	public function contact(){
		session_start();
		if(!isset($_SESSION['BAG'])){
			$_SESSION['BAG'] = array();
			$_SESSION['last'] = array();
			$_SESSION['total'] = array();
			$_SESSION['total']['counts'] = 0;
			$_SESSION['total']['price'] = 0;
		}
		$this->load->database();
		$cat = $this->shop_model->get_multilevel_menu();
		$cont = $this->shop_model->get_contacts();
		$bag = array(); $res = array();
		if(isset($_SESSION['BAG']))
			$bag = $_SESSION['BAG'];
		$this->load->view('market/contact', array_merge($res, array('allcategory'=>$cat, 'contacts'=>$cont, 'bag'=>$bag, 'captcha'=>$this->shop_model->captcha_create())));
	}

	public function transformer()
	{
		session_start();
		echo '<meta charset="utf-8">';
		echo 'Данная функция пока не доступна';
		/*
		if($this->input->get('act')=='create')
		{
			$basis = $this->input->get('basis');
			$cheese = $this->input->get('cheese');
			$ingredients = $this->input->get('ingredients');
			if($basis&&$cheese)
			{
				if($this->shop_model->create_transformer($basis, $cheese, $ingredients))
					return $this->output->set_content_type('application/json')->set_output( json_encode( array('BAG' => $_SESSION['BAG'], 'result' => 'success' ) ) );
			}
			$bag = array();
			if(isset($_SESSION['BAG']))
				$bag = $_SESSION['BAG'];
			return $this->output->set_content_type('application/json')->set_output( json_encode( array('BAG' => $bag, 'result' => 'fail' ) ) );
		}else
		{
			$res = $this->shop_model->get_all_for_transformer();
			$cat = $this->shop_model->get_multilevel_menu();
			$bag = '[]';
			if(isset($_SESSION['BAG']))
				$bag = json_encode($_SESSION['BAG']);
			$this->load->view('market/transformer', array_merge($res, array('allcategory'=>$cat, 'bag'=>$bag)));
		}*/
	}
}