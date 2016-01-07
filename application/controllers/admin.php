<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	/**********************/
	/*Donat Gorbachev 2013*/
	/**********************/

	var $PRODUCT_UPDATE_SUCCESS = 'Информация о продукте успешно обновлена.';
	var $PRODUCT_DELETE_SUCCESS = 'Продукт успешно удален.';
	var $PRODUCT_CREATE_SUCCESS = 'Продукт успешно добавлен.';
	var $USER_CREATE_SUCCESS = 'Пользователь успешно создан.';
	var $USER_UPDATE_SUCCESS = 'Информация о пользователе успешно обновлена.';
	var $USER_DELETE_SUCCESS = 'Пользователь успешно удален.';
	var $USER_CANT_UPDATE = 'Недостаточно прав для редактирования данного пользователя.';
	var $USER_CANT_DELETE = 'Недостаточно прав для удаления данного пользователя.';
	var $ORDER_CHECKED_BEFORE = 'Заказ уже был оформлен другим оператором.';
	var $ORDER_REAL_DELETED = 'Заказ успешно удален.';
	var $ORDER_REAL_DELETED_ERROR = 'Заказ не найден.';
	var $CATEGORY_CREATE_SUCCESS = 'Категория успешно создана.';
	var $CATEGORY_CREATE_ERROR = 'Подобная категория уже существует.';
	var $CATEGORY_UPDATE_SUCCESS = 'Категория успешно обновлена.';
	var $CATEGORY_UPDATE_ERROR = 'Подобная категория уже существует.';
	var $CATEGORY_DELETE_SUCCESS = 'Категория успешно удалена.';
	var $CATEGORY_FIND_ERROR = 'Категория не найдена.';
	var $CATEGORY_CREATE_ERROR2 = 'Вы заполнили не все поля.';
	var $CATEGORY_SUBNAME_EXISTS = 'Категория с такой ссылкой уже существует.';
	var $SETTINGS_UPDATE_SUCCESS = 'Информация о магазине успешно обновлена.';
	var $FILTER_CREATE_SUCCESS = 'Фильтр успешно создан.';
	var $FILTER_UPDATE_SUCCESS = 'Фильтры успешно обновлены.';
	var $FILTER_DELETE_SUCCESS = 'Фильтр успешно удален.';
	var $FILTER_CREATE_ERROR = 'Ошибка создания фильтра.';
	var $FILTER_UPDATE_ERROR = 'Ошибка обновления фильтра.';
	var $FILTER_DELETE_ERROR = 'Ошибка удаления фильтра.';

	public function index()
	{
		session_start();
		if(!$this->auth_model->islog())
			return header('Location: '.$this->config->site_url().'auth');
		$data = array(
				'rank' => $_SESSION['rank'],
				'content' => 'orders',
				'data' => $this->shop_model->get_all_orders(),
				'warning' => array('text'=>'','type'=>''),
				'settings' => $this->shop_model->get_settings()
			);
		if(isset($_SESSION['warning']['text']))
		{
			$data['warning']['text'] = $_SESSION['warning']['text'];$data['warning']['type'] = $_SESSION['warning']['type'];
			unset($_SESSION['warning']['text']);unset($_SESSION['warning']['type']);
		}
		$this->load->view('admin/adminpanel', $data);
	}

	public function orders()
	{
		session_start();
		if(!$this->auth_model->islog())
			return header('Location: '.$this->config->site_url().'auth');
		if($_SESSION['rank']<2)
			return show_404();
		$data = array(
				'rank' => $_SESSION['rank'],
				'content' => 'orders',
				'data' => $this->shop_model->get_all_orders(),
				'warning' => array('text'=>'','type'=>''),
				'settings' => $this->shop_model->get_settings()
			);
		if(isset($_SESSION['warning']['text']))
		{
			$data['warning']['text'] = $_SESSION['warning']['text'];$data['warning']['type'] = $_SESSION['warning']['type'];
			unset($_SESSION['warning']['text']);unset($_SESSION['warning']['type']);
		}
		$this->load->view('admin/adminpanel', $data);
	}

	public function products()
	{
		session_start();
		if(!$this->auth_model->islog())
			return header('Location: '.$this->config->site_url().'auth');
		if($_SESSION['rank']<1)
			return show_404();
		$products = $this->shop_model->get_all_products();
		$data = array(
				'rank' => $_SESSION['rank'],
				'content' => 'products',
				'data' => $products,
				'warning' => array('text'=>'','type'=>''),
				'settings' => $this->shop_model->get_settings(),
				'filters' => $this->shop_model->get_filters()
			);
		if(isset($_SESSION['warning']['text']))
		{
			$data['warning']['text'] = $_SESSION['warning']['text'];$data['warning']['type'] = $_SESSION['warning']['type'];
			unset($_SESSION['warning']['text']);unset($_SESSION['warning']['type']);
		}
		$this->load->view('admin/adminpanel', $data);
	}

	public function category()
	{
		session_start();
		if(!$this->auth_model->islog())
			return header('Location: '.$this->config->site_url().'auth');
		if($_SESSION['rank']<1)
			return show_404();
		$data = array(
				'rank' => $_SESSION['rank'],
				'content' => 'category',
				'data' => $this->shop_model->get_multilevel_menu(),
				'warning' => array('text'=>'','type'=>''),
				'settings' => $this->shop_model->get_settings()
			);
		if(isset($_SESSION['warning']['text']))
		{
			$data['warning']['text'] = $_SESSION['warning']['text'];$data['warning']['type'] = $_SESSION['warning']['type'];
			unset($_SESSION['warning']['text']);unset($_SESSION['warning']['type']);
		}
		$this->load->view('admin/adminpanel', $data);
	}

	public function users()
	{
		session_start();
		if(!$this->auth_model->islog())
			return header('Location: '.$this->config->site_url().'auth');
		if($_SESSION['rank']<2)
			return show_404();
		$users = $this->auth_model->get_all_users();
		$data = array(
				'rank' => $_SESSION['rank'],
				'content' => 'users',
				'data' => $users,
				'warning' => array('text'=>'','type'=>''),
				'settings' => $this->shop_model->get_settings()
			);
		if(isset($_SESSION['warning']['text']))
		{
			$data['warning']['text'] = $_SESSION['warning']['text'];$data['warning']['type'] = $_SESSION['warning']['type'];
			unset($_SESSION['warning']['text']);unset($_SESSION['warning']['type']);
		}
		$this->load->view('admin/adminpanel', $data);
	}

	public function settings()
	{
		session_start();
		if(!$this->auth_model->islog())
			return header('Location: '.$this->config->site_url().'auth');
		if($_SESSION['rank']<2)
			return show_404();
		if(!isset($_POST['act']))
		{
			$data = array(
				'rank' => $_SESSION['rank'],
				'content' => 'settings',
				'data' => $this->shop_model->get_settings(),
				'warning' => array('text'=>'','type'=>''),
				'settings' => $this->shop_model->get_settings(),
				'filters' => $this->shop_model->get_filters()
			);
			if(isset($_SESSION['warning']['text']))
			{
				$data['warning']['text'] = $_SESSION['warning']['text'];$data['warning']['type'] = $_SESSION['warning']['type'];
				unset($_SESSION['warning']['text']);unset($_SESSION['warning']['type']);
			}
			return $this->load->view('admin/adminpanel', $data);
		}
		$data = array(
			'storename' => $this->input->post('storename'),
			'storeaddress' => $this->input->post('storeaddress'),
			'storeemail' => $this->input->post('storeemail'),
			'storephone' => $this->input->post('storephone')
		);
		$this->shop_model->update_settings($data);
		$_SESSION['warning']['text'] = $this->SETTINGS_UPDATE_SUCCESS;
		$_SESSION['warning']['type'] = 'success';
		return header('Location: '.$this->config->site_url().'admin/settings');
	}

	public function create_filter()
	{
		session_start();
		if(!$this->auth_model->islog())
			return header('Location: '.$this->config->site_url().'auth');
		if($_SESSION['rank']<2)
			return show_404();
		if(isset($_GET['name']))
		{
			if($this->shop_model->create_filter($_GET['name']))
			{
				$_SESSION['warning']['text'] = $this->FILTER_CREATE_SUCCESS;
				$_SESSION['warning']['type'] = 'success';
				return header('Location: '.$this->config->site_url().'admin/settings?f');
			}
			$_SESSION['warning']['text'] = $this->FILTER_CREATE_ERROR;
			$_SESSION['warning']['type'] = 'danger';
			return header('Location: '.$this->config->site_url().'admin/settings?f');
		}else{
			return header('Location: '.$this->config->site_url().'admin/settings?f');
		}
	}

	public function update_filter()
	{
		session_start();
		if(!$this->auth_model->islog())
			return header('Location: '.$this->config->site_url().'auth');
		if($_SESSION['rank']<2)
			return show_404();
		if(isset($_GET['name'])&&isset($_GET['id']))
		{
			if($this->shop_model->update_filter($_GET['id'],$_GET['name']))
			{
				$_SESSION['warning']['text'] = $this->FILTER_UPDATE_SUCCESS;
				$_SESSION['warning']['type'] = 'success';
				return header('Location: '.$this->config->site_url().'admin/settings?f');
			}
		}
		$_SESSION['warning']['text'] = $this->FILTER_UPDATE_ERROR;
		$_SESSION['warning']['type'] = 'danger';
		return header('Location: '.$this->config->site_url().'admin/settings?f');
	}

	public function delete_filter($id)
	{
		session_start();
		if(!$this->auth_model->islog())
			return header('Location: '.$this->config->site_url().'auth');
		if($_SESSION['rank']<2)
			return show_404();
		if($this->shop_model->delete_filter($id))
		{
			$_SESSION['warning']['text'] = $this->FILTER_DELETE_SUCCESS;
			$_SESSION['warning']['type'] = 'success';
			return header('Location: '.$this->config->site_url().'admin/settings?f');
		}
		$_SESSION['warning']['text'] = $this->FILTER_DELETE_ERROR;
		$_SESSION['warning']['type'] = 'danger';
		return header('Location: '.$this->config->site_url().'admin/settings?f');
	}

	public function real_del_order($id)
	{
		session_start();
		if(!$this->auth_model->islog())
			return header('Location: '.$this->config->site_url().'auth');
		if($_SESSION['rank']<2)
			return show_404();
		if($this->shop_model->real_del_order($id))
		{
			$_SESSION['warning']['text'] = $this->ORDER_REAL_DELETED;
			$_SESSION['warning']['type'] = 'success';
			return header('Location: '.$this->config->site_url().'admin/ordersall');
		}
		$_SESSION['warning']['text'] = $this->ORDER_REAL_DELETED_ERROR;
		$_SESSION['warning']['type'] = 'danger';
		return header('Location: '.$this->config->site_url().'admin/ordersall');
	}

	public function category_change_used($id)
	{
		session_start();
		if(!$this->auth_model->islog())
			return header('Location: '.$this->config->site_url().'auth');
		if($_SESSION['rank']<1)
			return show_404();
		#echo $this->shop_model->category_change_used($id);
		if($this->shop_model->category_change_used($id))
		{
			$_SESSION['warning']['text'] = $this->CATEGORY_CHANGED_SUCCESS;
			return header('Location: '.$this->config->site_url().'admin/category');
		}
		$_SESSION['warning']['text'] = $this->CATEGORY_FIND_ERROR;
		return header('Location: '.$this->config->site_url().'admin/category');
	}

	public function delete_category($id)
	{
		session_start();
		if(!$this->auth_model->islog())
			return header('Location: '.$this->config->site_url().'auth');
		if($_SESSION['rank']<1)
			return show_404();
		$this->load->database();
		#echo $this->shop_model->del_category($id);
		if($this->shop_model->del_category($id))
		{
			$_SESSION['warning']['text'] = $this->CATEGORY_DELETE_SUCCESS;
			$_SESSION['warning']['type'] = 'success';
			return header('Location: '.$this->config->site_url().'admin/category');
		}
		$_SESSION['warning']['text'] = $this->CATEGORY_FIND_ERROR;
		$_SESSION['warning']['type'] = 'danger';
		return header('Location: '.$this->config->site_url().'admin/category');
	}

	public function del_order($id)
	{
		session_start();
		if(!$this->auth_model->islog())
			return header('Location: '.$this->config->site_url().'auth');
		if($this->shop_model->del_order($id))
		{
			$_SESSION['warning']['text'] = $this->ORDER_DELETED;
			$_SESSION['warning']['type'] = 'success';
			return header('Location: '.$this->config->site_url().'admin/orders');
		}
		return show_404();

	}

	public function get_active()
	{
		session_start();
		if(!$this->auth_model->islog())
			return header('Location: '.$this->config->site_url().'auth');
		$this->load->view('admin/orders', array('data'=>$this->shop_model->get_active_orders()));
	}

	public function check_order($id)
	{
		session_start();
		if(!$this->auth_model->islog())
			return header('Location: '.$this->config->site_url().'auth');
		$data = $this->shop_model->check_order($id, $_SESSION["username"]);
		if($data["success"]=="error")
		{
			if($data["code"]=='0')
				return show_404();
			$_SESSION['warning']['text'] = $this->ORDER_CHECKED_BEFORE;
			$_SESSION['warning']['type'] = 'danger';
			return header('Location: '.$this->config->site_url().'admin/orders');
		}
		$this->load->view("admin/checkorder", $data["order"]);
	}

	public function create_category()
	{
		session_start();
		$this->load->database();
		if(!$this->auth_model->islog())
			return header('Location: '.$this->config->site_url().'auth');
		if($_SESSION['rank']<1)
			return show_404();
		if(!isset($_POST['act']))
		{
			$data = array(
					'id'=>'',
					'name'=>'',
					'parent_id'=>0,
					'error'=>'',
					'allcategory'=>$this->shop_model->get_multilevel_menu(),
					'forfilters'=>$this->shop_model->get_filters(),
					'filters'=>'',
					'new'=>true
				);
			return $this->load->view('admin/createcategory', $data);
		}
		$val = $this->shop_model->validate_edit_category($this->input->post('name'), $this->shop_model->getintranslit($this->input->post('name')), true);
		if($val['error'] == '')
		{
			$res = $this->shop_model->add_category($this->input->post('name'),$this->shop_model->getintranslit($this->input->post('name')),$this->input->post('parent_id'),$this->input->post('filters'));
			if($res == 2)
			{
				$_SESSION['warning']['text'] = $this->CATEGORY_CREATE_SUCCESS;
				$_SESSION['warning']['type'] = 'success';
				return header('Location: '.$this->config->site_url().'admin/category');
			}
			$_SESSION['warning']['text'] = $this->CATEGORY_CREATE_ERROR;
			$_SESSION['warning']['type'] = 'danger';
			return header('Location: '.$this->config->site_url().'admin/category');
		}
		$data = array(
				'name'=>$this->input->post('name'),
				'parent_id'=>$this->input->post('parent_id'),
				'error'=>$val['error'],
				'id'=>'',
				'allcategory'=>$this->shop_model->get_multilevel_menu(),
				'forfilters'=>$this->shop_model->get_filters(),
				'filters'=>$this->input->post('filters'),
				'new'=>true
			);
		return $this->load->view('admin/createcategory', $data);
	}


	public function edit_category($id)
	{
		session_start();
		if(!$this->auth_model->islog())
			return header('Location: '.$this->config->site_url().'auth');
		if($_SESSION['rank']<1)
			return show_404();
		$obj = $this->shop_model->get_category_by_id($id);
		if(empty($obj))
			return show_404();
		if(!isset($_POST['act']))
			return $this->load->view('admin/createcategory', array_merge($obj, array('error'=>'','new'=>false,'allcategory'=>$this->shop_model->get_multilevel_menu(),'forfilters'=>$this->shop_model->get_filters())));
		$val = $this->shop_model->validate_edit_category($this->input->post('name'), $this->shop_model->getintranslit($this->input->post('name')), $this->input->post('parent_id'), false);
		if($val['error'] == '')
		{
			$ar = array(
	                'name' => htmlspecialchars($this->input->post('name')),
	                'subname' => $this->shop_model->getintranslit($this->input->post('name')),
	                'parent_id'=>$this->input->post('parent_id'),
	                'filters'=>$this->input->post('filters')
	            );
			$res = $this->shop_model->update_category($id, $ar);
			if($res == 2)
			{
				$_SESSION['warning']['text'] = $this->CATEGORY_UPDATE_SUCCESS;
				$_SESSION['warning']['type'] = 'success';
				return header('Location: '.$this->config->site_url().'admin/category');
			}
			$_SESSION['warning']['text'] = $this->CATEGORY_UPDATE_ERROR;
			$_SESSION['warning']['type'] = 'danger';
			return header('Location: '.$this->config->site_url().'admin/category');
		}
		$data = array(
				'name'=>$this->input->post('name'),
				'parent_id'=>$this->input->post('parent_id'),
				'error'=>$val['error'],
				'id'=>$id,
				'allcategory'=>$this->shop_model->get_multilevel_menu(),
				'forfilters'=>$this->shop_model->get_filters(),
				'new'=>false
			);
		return $this->load->view('admin/editproducts', $data);
	}

	public function create_product()
	{
		session_start();
		if(!$this->auth_model->islog())
			return header('Location: '.$this->config->site_url().'auth');
		if($_SESSION['rank']<1)
			return show_404();
		$filters = $this->shop_model->get_filters();
		if(!isset($_POST['act']))
		{
			$data = array(
					'id'=>'',
					'name'=>'',
					'category'=>'',
					'price'=>'',
					'error'=>'',
					'img'=>'stay',
					'allcategory'=>$this->shop_model->get_multilevel_menu(),
					'forfilters'=>$this->shop_model->get_filters(),
					'new'=>true
				);
			foreach ($filters as $filter => $value) {
				$data[$value['parameter']] = '';
			}
			return $this->load->view('admin/editproducts', $data);
		}
		$val = $this->shop_model->validate_edit_product($this->input->post('name'), $this->input->post('category'), $this->input->post('price'), $this->input->post('img'), true);
		if($val['error'] == '')
		{
			$ar = array(
	                'name' => htmlspecialchars($this->input->post('name')),
	                'price' => (int)$this->input->post('price'),
	                'category' => htmlspecialchars($this->input->post('category')),
	                'img' => $this->input->post('img'),
	            );
			foreach ($filters as $filter => $value) {
				$ar[$value['parameter']] = htmlspecialchars($this->input->post($value['parameter']));
			}
			$this->shop_model->create_new_product($ar);
			$_SESSION['warning']['text'] = $this->PRODUCT_CREATE_SUCCESS;
			$_SESSION['warning']['type'] = 'success';
			return header('Location: '.$this->config->site_url().'admin/products');
		}
		$data = array(
				'name'=>$this->input->post('name'),
				'category'=>$this->input->post('category'),
				'price'=>$this->input->post('price'),
				'error'=>$val['error'],
				'id'=>'',
				'img'=>$this->input->post('img'),
				'allcategory'=>$this->shop_model->get_multilevel_menu(),
				'forfilters'=>$this->shop_model->get_filters(),
				'new'=>true
			);
		foreach ($filters as $filter => $value) {
				$data[$value['parameter']] = $this->input->post($value['parameter']);
			}
		return $this->load->view('admin/editproducts', $data);
	}

	public function edit_product($id)
	{
		session_start();
		if(!$this->auth_model->islog())
			return header('Location: '.$this->config->site_url().'auth');
		if($_SESSION['rank']<1)
			return show_404();
		$obj = $this->shop_model->get_product($id);
		if(empty($obj))
			return show_404();
		$filters = $this->shop_model->get_filters();
		if(!isset($_POST['act']))
			return $this->load->view('admin/editproducts', array_merge($obj, array('error'=>'','new'=>false,'allcategory'=>$this->shop_model->get_multilevel_menu(),'forfilters'=>$filters)));
		$val = $this->shop_model->validate_edit_product($this->input->post('name'), $this->input->post('category'), $this->input->post('price'), $this->input->post('img'), false);
		if($val['error'] == '')
		{
			$ar = array(
	                'name' => htmlspecialchars($this->input->post('name')),
	                'price' => (int)$this->input->post('price'),
	                'category' => htmlspecialchars($this->input->post('category')),
	                'img' => $this->input->post('img')
	            );
			foreach ($filters as $filter => $value) {
				$ar[$value['parameter']] = htmlspecialchars($this->input->post($value['parameter']));
			}
			$this->shop_model->update_product($id, $ar);
			$_SESSION['warning']['text'] = $this->PRODUCT_UPDATE_SUCCESS;
			$_SESSION['warning']['type'] = 'success';
			return header('Location: '.$this->config->site_url().'admin/products');
		}
		$img_t = $obj['img'];
		if($this->input->post('img')!='stay')
			$img_t = $this->input->post('img');
		$data = array(
				'name'=>$this->input->post('name'),
				'category'=>$this->input->post('category'),
				'price'=>$this->input->post('price'),
				'error'=>$val['error'],
				'id'=>$id,
				'img'=>$img_t,
				'allcategory'=>$this->shop_model->get_multilevel_menu(),
				'forfilters'=>$this->shop_model->get_filters(),
				'new'=>false
			);
		foreach ($filters as $filter => $value) {
				$data[$value['parameter']] = $this->input->post($value['parameter']);
			}
		return $this->load->view('admin/editproducts', $data);
	}

	public function delete_product($id)
	{
		session_start();
		if(!$this->auth_model->islog())
			return header('Location: '.$this->config->site_url().'auth');
		if($_SESSION['rank']<1)
			return show_404();
		$obj = $this->shop_model->get_product($id);
		if(empty($obj))
			return show_404();
		$this->shop_model->delete_product($id);
		$_SESSION['warning']['text'] = $this->PRODUCT_DELETE_SUCCESS;
		$_SESSION['warning']['type'] = 'success';
		return header('Location: '.$this->config->site_url().'admin/products');
	}

	public function create_user()
	{
		session_start();
		if(!$this->auth_model->islog())
			return header('Location: '.$this->config->site_url().'auth');
		if($_SESSION['rank']<2)
			return show_404();
		if(isset($_POST['act']))
		{
			$v = $this->auth_model->create_new_user($this->input->post('username'), $this->input->post('password'), $this->input->post('password2'), $this->input->post('rank'));
			if($v == '')
			{
				$_SESSION['warning']['text'] = $this->USER_CREATE_SUCCESS;
				$_SESSION['warning']['type'] = 'success';
				return header('Location: '.$this->config->site_url().'admin/users');
			}
			$data = array(
					'id'=>'',
					'username'=>$this->input->post('username'),
					'password'=>$this->input->post('password'),
					'archpassword'=>'',
					'new'=>true,
					'error'=>$v,
					'rank'=>$this->input->post('rank')
				);
			return $this->load->view('admin/editusers', $data);
		}
		$data = array(
				'id'=>'',
				'username'=>'',
				'password'=>'',
				'archpassword'=>'',
				'new'=>true,
				'error'=>'',
				'rank'=>''
			);
		return $this->load->view('admin/editusers', $data);
	}

	public function edit_user($id)
	{
		session_start();
		if(!$this->auth_model->islog())
			return header('Location: '.$this->config->site_url().'auth');
		if($_SESSION['rank']<2)
			return show_404();
		$user = $this->auth_model->get_user_by_id($id);
		if(empty($user))
			return show_404();
		if($user['rank']>2)
			return show_404();
		if($user['rank']==2&&$_SESSION['rank']==2&&$user['id']!=$_SESSION['id'])
		{
			$_SESSION['warning']['text'] = $this->USER_CANT_UPDATE;
			$_SESSION['warning']['type'] = 'warning';
			return header('Location: '.$this->config->site_url().'admin/users');
		}
		if(isset($_POST['act']))
		{
			$v = $this->auth_model->update_user($id, $_SESSION['rank'], $this->input->post('username'), $this->input->post('password'), $this->input->post('password2'), $this->input->post('rank'));
			if($v == '')
			{
				$_SESSION['warning']['text'] = $this->USER_UPDATE_SUCCESS;
				$_SESSION['warning']['type'] = 'success';
				return header('Location: '.$this->config->site_url().'admin/users');
			}
			$data = array(
				'id'=>$id,
				'username'=>$this->input->post('username'),
				'password'=>$this->input->post('password'),
				'archpassword'=>$user['password'],
				'new'=>false,
				'error'=>$v,
				'rank'=>$this->input->post('rank')
			);
			return $this->load->view('admin/editusers', $data);
		}
		$data = array(
			'id'=>$id,
			'username'=>$user['username'],
			'password'=>'',
			'archpassword'=>$user['password'],
			'new'=>false,
			'error'=>'',
			'rank'=>$user['rank']
		);
		return $this->load->view('admin/editusers', $data);
	}

	public function delete_user($id)
	{
		session_start();
		if(!$this->auth_model->islog())
			return header('Location: '.$this->config->site_url().'auth');
		if($_SESSION['rank']<2)
			return show_404();
		$user = $this->auth_model->get_user_by_id($id);
		if(empty($user))
			return show_404();
		if($user['rank']>2)
			return show_404();
		if($user['rank']==2&&$_SESSION['rank']==2&&$user['id']!=$_SESSION['id'])
		{
			$_SESSION['warning']['text'] = $this->USER_CANT_DELETE;
			$_SESSION['warning']['type'] = 'danger';
			return header('Location: '.$this->config->site_url().'admin/users');
		}
		$this->auth_model->del_user($id);
		if($id==$_SESSION['id'])
			return header('Location: '.$this->config->site_url().'auth/logout');
		$_SESSION['warning']['text'] = $this->USER_DELETE_SUCCESS;
		$_SESSION['warning']['type'] = 'success';
		return header('Location: '.$this->config->site_url().'admin/users');
	}
}