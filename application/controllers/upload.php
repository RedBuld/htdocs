<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {

	var $IMAGE_TABLE = 'img';
	var $UPLOAD_PATH = './uploads/image/';
	var $UPLOAD_IMAGE_ERROR = 'Не удалось загрузить изображение.';

	public function index()
	{
		return $this->load->view('upload/upload');
	}

	/*public function upload()
	{
		return $this->load->view('upload/upload');
	}*/

	public function image()
	{
		session_start();
		if(!isset($_SESSION['username']))
			return show_404();
		if($_SESSION['rank']<1)
			return show_404();
		echo $this->input->get('ids');
		$config['upload_path'] = $this->UPLOAD_PATH.'high';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= '12288';
		$config['encrypt_name'] = true;
		$config['remove_spaces'] = true;
		//$config['max_width']  = '1024';
		//$config['max_height']  = '768';


		$this->load->library('upload', $config);
		$this->load->library('image_lib');
		if(!$this->upload->do_upload())
		{
			//echo $this->upload->display_errors();
			return $this->output->set_content_type('application/json')->set_output(json_encode(array('error'=>$this->upload->display_errors())));
		}else{
			$this->load->database();
			$img = $this->upload->data();

			$little['image_library'] = 'gd2';
			$little['source_image'] = $img['full_path']; 
			$little['new_image'] = $this->UPLOAD_PATH.'little';
			$little['create_thumb'] = FALSE;
			$little['maintain_ratio'] = TRUE;
			$little['quality'] = 100;
			$little['width'] = 400;
			$little['height'] = 300;
			$this->image_lib->initialize($little);
			$this->image_lib->resize();
		}

		$medium['image_library'] = 'gd2';
		$medium['source_image'] = $img['full_path'];
		$medium['new_image'] = $this->UPLOAD_PATH.'medium';
		$medium['create_thumb'] = FALSE;
		$medium['maintain_ratio'] = TRUE;
		$medium['quality'] = 100;
		$medium['width'] = 800;
		$medium['height'] = 600;
		$this->image_lib->clear();
		$this->image_lib->initialize($medium);
		$this->image_lib->resize();

		$high['image_library'] = 'gd2';
		$high['source_image'] = $img['full_path'];
		$high['new_image'] = $this->UPLOAD_PATH.'high';
		$high['create_thumb'] = FALSE;
		$high['maintain_ratio'] = TRUE;
		$high['overwrite'] = TRUE;
		$high['quality'] = 100;
		$high['width'] = 1330;
		$high['height'] = 1000;
		$this->image_lib->clear();
		$this->image_lib->initialize($high);
		$this->image_lib->resize();

		$data = array(
				'name' => $img['file_name'],
				'datestamp' => date("YmdHis", time())
			);
		$a = date("YmdHis", time() - 60 * 30);
		$this->db->where('datestamp <', $a);
		//$this->db->where('used', 0);
		$query = $this->db->get($this->IMAGE_TABLE);
		foreach($query->result_array() as $key => $v)
		{
			unlink('./'.$this->UPLOAD_PATH.'little/'.$v['name']);
			unlink('./'.$this->UPLOAD_PATH.'medium/'.$v['name']);
			unlink('./'.$this->UPLOAD_PATH.'high/'.$v['name']);
		}
		$this->db->where('datestamp <', $a);
		$this->db->delete($this->IMAGE_TABLE);
		$this->db->insert($this->IMAGE_TABLE, $data);
		return $this->output->set_content_type('application/json')->set_output(json_encode(array('error'=>'', 'name'=>$img['file_name'])));
	}

}

?>