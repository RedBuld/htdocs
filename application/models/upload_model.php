<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload_Model extends CI_Model {

	var $IMAGE_TABLE = 'img';
	var $UPLOAD_PATH = 'uploads/image/';

	public function check_img($name)
	{
		$this->load->database();
		$a = date("YmdHis", time() - 60 * 30);
		$this->db->where('datestamp >', $a);
		$this->db->where('name', $name);
		$query = $this->db->get($this->IMAGE_TABLE);
		if(count($query->result_array())>0)
			return true;
		return false;
	}

	public function del_img($name)
	{
		//$this->load->database();
		//$this->db->where('name', $name);
		//$this->db->delete($this->IMAGE_TABLE);
		if(file_exists('./'.$this->UPLOAD_PATH.'little/'.$name)){
			unlink('./'.$this->UPLOAD_PATH.'little/'.$name);
		}
		if(file_exists('./'.$this->UPLOAD_PATH.'medium/'.$name)){
			unlink('./'.$this->UPLOAD_PATH.'medium/'.$name);
		}
		if(file_exists('./'.$this->UPLOAD_PATH.'high/'.$name)){
			unlink('./'.$this->UPLOAD_PATH.'high/'.$name);
		}
	}

	public function get_full_little_uri($name)
	{
		return 'http://'.$this->config->base_url().$this->UPLOAD_PATH.'little/'.$name;
	}

	public function get_full_medium_uri($name)
	{
		return 'http://'.$this->config->base_url().$this->UPLOAD_PATH.'medium/'.$name;
	}

	public function get_full_high_uri($name)
	{
		return 'http://'.$this->config->base_url().$this->UPLOAD_PATH.'high/'.$name;
	}

	public function attach_img($name)
	{
		$this->load->database();
		$this->db->where('name', $name);
		$this->db->delete($this->IMAGE_TABLE);
	}
}