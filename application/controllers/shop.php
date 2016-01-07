<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shop extends CI_Controller {

	var $ORDER_DEVIDER = '*** ';
	var $ORDER_DEV_OPEN = '**: ';
	var $ORDER_DEV_CLOSE = ':** ';
	var $MONEY_TYPE = 'руб.';
	var $MAX_PRODUCT_COUNT = 100;
	var $MIN_PRICE = 250;

	public function index()
	{
		session_start();
		if(!isset($_SESSION['BAG'])){
			$_SESSION['BAG'] = array();
			$_SESSION['last'] = array();
			$_SESSION['total']['counts'] = 0;
			$_SESSION['total']['price'] = 0;
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($_SESSION['BAG']));
	}

	public function get_order()
	{
		$temp = $this->shop_model->get_order_info($_GET['id']);
		echo json_encode($temp);
	}

	public function load_streets()
	{
		$this->load->database();
		$data['list'] = $this->db->order_by('name','ASC')->get_where('streets')->result_array();
		echo json_encode($data['list']);
	}

	public function add_job()
	{
		if(isset($_GET['name'])&&isset($_GET['tel'])&&isset($_GET['job']))
		{
			$this->shop_model->check_ip();
			if(!$this->shop_model->captcha_valid($this->input->get('recaptcha_challenge_field'), $this->input->get('recaptcha_response_field')))
				return $this->output->set_content_type('application/json')->set_output(json_encode(array('result'=>'fail', 'captcha_error'=>$this->recaptcha->getError())));
			$job_name = $this->shop_model->get_job_name($_GET['job']);
			if($job_name=='')
				return $this->output->set_content_type('application/json')->set_output(json_encode(array('result'=>'fail')));
			$info = '';
			if(isset($_GET['info']))
				$info = $_GET['info'];
			$this->db->insert($this->shop_model->JOBSPERSONS_TABLE, array(
				'name' => htmlspecialchars(substr($_GET['name'], 0, 250)),
				'tel' => htmlspecialchars(substr(str_replace(array('(', ')', '-'), array('', '', ''), $_GET['tel']), 0, 12)),
				'info' => htmlspecialchars(substr($info, 0, 1000)),
				'job' => $job_name,
				'ip' => $this->input->ip_address()
			));
			return $this->output->set_content_type('application/json')->set_output(json_encode(array('result'=>'success')));
		}
		return $this->output->set_content_type('application/json')->set_output(json_encode(array('result'=>'fail')));
	}

	public function add_contact()
	{
		if(isset($_GET['name'])&&isset($_GET['enquiry']))
		{
			$this->shop_model->check_ip();
			if(!$this->shop_model->captcha_valid($this->input->get('recaptcha_challenge_field'), $this->input->get('recaptcha_response_field')))
				return $this->output->set_content_type('application/json')->set_output(json_encode(array('result'=>'fail', 'captcha_error'=>$this->recaptcha->getError())));
			$this->db->insert($this->shop_model->CONTACTS_TABLE, array(
				'name' => htmlspecialchars(substr($_GET['name'], 0, 250)),
				'email' => htmlspecialchars(substr(str_replace(array('(', ')', '-'), array('', '', ''), $_GET['email']), 0, 12)),
				'enquiry' => htmlspecialchars(substr($_GET['enquiry'], 0, 2000)),
				'date' => date('d.m.Y H:i')
			));
			return $this->output->set_content_type('application/json')->set_output(json_encode(array('result'=>'success')));
		}
		return $this->output->set_content_type('application/json')->set_output(json_encode(array('result'=>'fail')));
	}

	public function add_product()
	{
		if($this->shop_model->check_act())
		{
			$result = 'fail';
			$id = $_GET['DATA'];
			$cnt = (int)$_GET['cnt'];
			foreach ($id as $product)
			{
				$obj = $this->shop_model->get_product($product);
				if(!empty($obj))
				{
					if(!isset($_SESSION['BAG'][(string)$product]))
					{
						$_SESSION['BAG'][(string)$product]['count'] = $cnt;
					}else
					{
						$_SESSION['BAG'][(string)$product]['count'] += $cnt;
					}
					$_SESSION['BAG'][(string)$product]['price'] = $obj['price']*$_SESSION['BAG'][(string)$product]['count'];
					$_SESSION['BAG'][(string)$product]['cost'] = $obj['price'];
					$_SESSION['BAG'][(string)$product]['name'] = $obj['name'];
					$_SESSION['BAG'][(string)$product]['id'] = $obj['id'];
					$_SESSION['BAG'][(string)$product]['img_little_url'] = $obj['img_little_url'];
					/**/
					$counts = 0;
					$price = 0;
					foreach ($_SESSION['BAG'] as $key => $value) {
						$counts += $_SESSION['BAG'][$key]['count'];
						$price += $_SESSION['BAG'][$key]['count']*$_SESSION['BAG'][$key]['cost'];
					}
					$_SESSION['total']['counts'] = $counts;
					$_SESSION['total']['price'] = $price;
					/**/
					$_SESSION['last']['name'] = $obj['name'];
					$_SESSION['last']['img'] = $obj['img_little_url'];
					$result = 'success';
				}
			}
			$timepoint = date("YmdHis", time()).'';
			$_SESSION['timepoint'] = $timepoint;
			$this->output->set_content_type('application/json')->set_output( json_encode( array('BAG' => $_SESSION['BAG'], 'last'=>$_SESSION['last'], 'total'=>$_SESSION['total'], 'result' => $result ) ) );
		}else
			show_404();
	}

	public function rem_product()
	{
		if($this->shop_model->check_act())
		{
			$result = 'fail';
			$data = $_GET['DATA'];
			foreach ($data as $product)
			{
				$obj = $this->shop_model->get_product($product);
				if(!empty($obj))
				{
					if(isset($_SESSION['BAG'][(string)$product]))
					{
						$_SESSION['BAG'][(string)$product]['count']--;
						$_SESSION['BAG'][(string)$product]['price'] = $obj['price']*$_SESSION['BAG'][(string)$product]['count'];
						if((int)$_SESSION['BAG'][(string)$product]['count'] < 1)
						{
							unset($_SESSION['BAG'][(string)$product]);
						}
					}
					/**/
					$counts = 0;
					$price = 0;
					foreach ($_SESSION['BAG'] as $key => $value) {
						$counts += $_SESSION['BAG'][$key]['count'];
						$price += $_SESSION['BAG'][$key]['count']*$_SESSION['BAG'][$key]['cost'];
					}
					$_SESSION['total']['counts'] = $counts;
					$_SESSION['total']['price'] = $price;
					/**/
					$_SESSION['last']['name'] = $obj['name'];
					$_SESSION['last']['img'] = $obj['img_little_url'];
					$result = 'success';
				}
			}
			$timepoint = date("YmdHis", time()).'';
			$_SESSION['timepoint'] = $timepoint;
			$this->output->set_content_type('application/json')->set_output( json_encode( array('BAG' => $_SESSION['BAG'], 'last'=>$_SESSION['last'], 'total'=>$_SESSION['total'], 'result' => $result ) ) );
		}else
			show_404();
	}

	public function del_product()
	{
		if($this->shop_model->check_act())
		{
			$result = 'fail';
			$data = $_GET['DATA'];
			foreach ($data as $product)
			{
				$obj = $this->shop_model->get_product($product);
				if(!empty($obj))
				{
					unset($_SESSION['BAG'][(string)$product]);
					/**/
					$counts = 0;
					$price = 0;
					foreach ($_SESSION['BAG'] as $key => $value) {
						$counts += $_SESSION['BAG'][$key]['count'];
						$price += $_SESSION['BAG'][$key]['count']*$_SESSION['BAG'][$key]['cost'];
					}
					$_SESSION['total']['counts'] = $counts;
					$_SESSION['total']['price'] = $price;
					/**/
					$_SESSION['last']['name'] = $obj['name'];
					$_SESSION['last']['img'] = $obj['img_little_url'];
					$result = 'success';
				}
			}
			$timepoint = date("YmdHis", time()).'';
			$_SESSION['timepoint'] = $timepoint;
			$this->output->set_content_type('application/json')->set_output( json_encode( array('BAG' => $_SESSION['BAG'], 'last'=>$_SESSION['last'], 'total'=>$_SESSION['total'], 'result' => $result ) ) );
		}else
			show_404();
	}

	public function clear_cart()
	{
		if(!isset($_SESSION)){
			session_start();
		}
		unset($_SESSION['BAG']);
		unset($_SESSION['total']);
		$_SESSION['BAG'] = array();
		$_SESSION['last'] = array();
		$_SESSION['total']['counts'] = 0;
		$_SESSION['total']['price'] = 0;
		$result = 'success';
		$this->output->set_content_type('application/json')->set_output( json_encode( array('BAG' => $_SESSION['BAG'], 'last'=>$_SESSION['last'], 'total'=>$_SESSION['total'], 'result' => $result ) ) );
	}

	public function add_sauce($id1, $id2)
	{
		session_start();
		if($this->shop_model->is_transformer_id($id1))
			return show_404();
		$obj = $this->shop_model->get_product($id1);
		$sau = $this->shop_model->get_sauce($id2);
		if(!empty($obj)&&!empty($sau))
		{
			if(isset($_SESSION['BAG'][(string)$id1])&&$obj['sauces']!='')
			{
				if(in_array($id2, explode(" ", $obj['sauces'])))
				{
					$r = 0;
					$m = 0;
					foreach($_SESSION['BAG'][(string)$id1]['sauces'] as $i=>$o)
					{
						if(isset($_SESSION['BAG'][(string)$id1]['sauces'][(string)$i]['category']))
						{
							if((string)$sau['category']==(string)$o['category'])
							{
								$r++;
								$m = $i;
							}
						}
					}
					if($sau['maxcount']<=$r)
					{
						unset($_SESSION['BAG'][(string)$id1]['sauces'][(string)$m]);
					}
					array_push($_SESSION['BAG'][(string)$id1]['sauces'], array('id'=>$sau['id'], 'name'=>$sau['name'], 'img_little_url'=>$this->upload_model->get_full_little_uri($sau['img']), 'img_high_url'=>$this->upload_model->get_full_high_uri($sau['img']), 'img'=>$sau['img'], 'title'=>$sau['title'], 'category'=>$sau['category'], 'price'=>$sau['price']));
				}
			}
			$timepoint = date("YmdHis", time()).'';
			$_SESSION['timepoint'] = $timepoint;
			$this->output->set_content_type('application/json')->set_output(json_encode($_SESSION['BAG']));
		}else
			show_404();
	}

	public function rem_sauce($id1, $id2)
	{
		if($this->shop_model->is_transformer_id($id1))
			return show_404();
		session_start();
		$obj = $this->shop_model->get_product($id1);
		$sau = $this->shop_model->get_sauce($id2);
		if(!empty($obj)&&!empty($sau))
		{
			if(isset($_SESSION['BAG'][(string)$id1])&&$obj['sauces']!='')
			{
				$b = false;
				$t = 0;
				foreach ($_SESSION['BAG'][(string)$id1]['sauces'] as $i=>$o) {
					if($o['id']==$id2)
					{
						$t = $i;
						$b = true;
					}
				}
				if($b)
				{
					unset($_SESSION['BAG'][(string)$id1]['sauces'][$t]);
				}
			}
			$timepoint = date("YmdHis", time()).'';
			$_SESSION['timepoint'] = $timepoint;
			$this->output->set_content_type('application/json')->set_output(json_encode($_SESSION['BAG']));
		}else
			show_404();
	}

	public function create_order()
	{
		session_start();
		if(isset($_SESSION['BAG'])&&isset($_GET['firstname'])&&isset($_GET['telephone'])&&isset($_GET['street'])&&isset($_GET['house'])&&isset($_GET['apartment']))
		{
			if($_SESSION['BAG']!=array())
			{
				if(count($_SESSION['BAG'])>0)
				{
					$price = 0;
					$text = '';
					foreach ($_SESSION['BAG'] as $key => $value)
					{
						$obj = $this->shop_model->get_product($key);
						if(!empty($obj))
						{
							$price += $obj['price'] * $value['count'];
							$otherTx = $obj['name'].' ('.($value['count']*$obj['price']).$this->MONEY_TYPE.')';
							$otherTx = str_replace($this->ORDER_DEV_OPEN, '', $otherTx);
							$otherTx = str_replace($this->ORDER_DEV_CLOSE, '', $otherTx);
							$text .= str_replace($this->ORDER_DEVIDER, '', $this->ORDER_DEV_OPEN.$value['count'].'x '.$this->ORDER_DEV_CLOSE.$otherTx).$this->ORDER_DEVIDER;
						}
					}
					$text = str_replace(" + )", ")", $text);
					$text = str_replace(", )", ")", $text);
					$text = str_replace($this->ORDER_DEV_OPEN."1x ".$this->ORDER_DEV_CLOSE, "", $text);
					$text = htmlspecialchars($text);
					//$text = str_replace($this->ORDER_DEV_OPEN, '<i class=\"order_counter\">', $text);
					//$text = str_replace($this->ORDER_DEV_CLOSE, '</i>', $text);
					$_SESSION['timepoint'] = date("YmdHis", time()).'';
					$name = $_GET['firstname'];
					if(isset($_GET['lastname']))
						$name .=' '.$_GET['lastname'];
					$address = $_GET['street'].' д.'.$_GET['house'].' кв/оф'.$_GET['apartment'];

					$this->shop_model->create_order(htmlspecialchars($name), htmlspecialchars($_GET['telephone']), htmlspecialchars($address), htmlspecialchars($_GET['comment']), $text, $price);
					
					$settings = $this->shop_model->get_settings();

					$text = str_replace($this->ORDER_DEV_OPEN, '<b>', $text);
					$text = str_replace($this->ORDER_DEV_CLOSE, '</b>', $text);
					$text = str_replace($this->ORDER_DEVIDER, '<br>', $text);

					$send_to  = $settings['storeemail']['value'];
					$subject = "Новый заказ";
					$headers  = "Content-type: text/html; charset=utf-8 \r\n";
					$headers .= "From: ".$settings['storename']['value']." <".$settings['storeemail']['value'].">";
					$message = 
'<!DOCTYPE html>
    <html lang="ru">
    <head>
      <meta charset="UTF-8">
      <title>Новый заказ</title>
    </head>
    <body style="min-width:500px;height:225px;width:100%;background:#DDD;padding-top:50px;">
      <div style="font-size:14px;font-family: sans-serif;padding:10px 25px 30px 25px;width:400px;margin:0px auto;border-radius:3px;background:#FFF;">
        <h3 style="font-size:16px;margin-bottom:-7px;">Новый заказ</h3>
        <p style="margin-bottom:5px;">'.$text.' на сумму '.$price.' руб.</p>
        <h3 style="font-size:16px;margin-bottom:-7px;">От</h3>
        <p>'.$_GET['firstname'].', '.$_GET['telephone'].', '.$_GET['street'].' д.'.$_GET['house'].' кв/оф.'.$_GET['apartment'].'</p>
        <p>'.$_GET['comment'].'</p>
      </div>
    </body>
</html>'; 
					mail($send_to, $subject, $message, $headers);
					$this->output->set_content_type('application/json')->set_output(json_encode(array('result'=>'success')));
				}else{
					$this->output->set_content_type('application/json')->set_output(json_encode(array('result'=>'fail')));
				}
			}else
				$this->output->set_content_type('application/json')->set_output(json_encode(array('result'=>'fail')));
		}else
			$this->output->set_content_type('application/json')->set_output(json_encode(array('result'=>'fail','into'=>$_POST)));
	}
}
