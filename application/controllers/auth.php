<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

	var $CANT_LOGIN = array('Не верное имя пользователя или пароль.', 'Заполнены не все поля.');
	var $NEXT_PAGE = 'admin';

	public function index()
	{
		session_start();
		if($this->auth_model->islog())
			header('Location: '.$this->config->site_url().''.$this->NEXT_PAGE);
		$data = array('error' => '', 'username' => '', 'settings' => $settings = $this->shop_model->get_settings());
		$this->load->view('auth/login', $data);
	}

	public function error()
	{
		session_start();
		if($this->auth_model->islog())
			return header('Location: '.$this->config->site_url().''.$this->NEXT_PAGE);
		$try_username = '';
		if(isset($_SESSION['try_username']))
			$try_username = $_SESSION['try_username'];
		$er = '';
		if(isset($_SESSION['try_error']))
			$er = $this->CANT_LOGIN[$_SESSION['try_error']];
		unset($_SESSION['try_error']);
		unset($_SESSION['try_username']);
		$data = array('error' => $er, 'username' => $try_username, 'settings' => $settings = $this->shop_model->get_settings());
		$this->load->view('auth/login', $data);		
	}

	public function login()
	{
		session_start();
		if(isset($_POST['username'])&&isset($_POST['password']))
		{
			if(!isset($_SESSION['username']))
			{
				$user = $this->auth_model->get_user($_POST['username'], $_POST['password']);
				if(empty($user))
				{
					$_SESSION['try_username'] = $_POST['username'];
					$_SESSION['try_error'] = 0;
 					return header('Location: '.$this->config->site_url().'auth/error');
				}else
				{
					$_SESSION['username'] = $user['username'];
					$_SESSION['id'] = $user['id'];
					$_SESSION['rank'] = $user['rank'];
					return header('Location: '.$this->config->site_url().''.$this->NEXT_PAGE);
				}
			}
			return header('Location: '.$this->config->site_url().''.$this->NEXT_PAGE);
		}
		$_SESSION['try_error'] = 1;
		return header('Location: '.$this->config->site_url().'auth/error');
	}

	public function logout()
	{
		session_start();
		unset($_SESSION['username']);
		unset($_SESSION['id']);
		unset($_SESSION['rank']);
		return header('Location: '.$this->config->site_url().'auth');
	}
}
