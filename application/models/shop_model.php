<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shop_Model extends CI_Model {
    /**********************/
    /*Donat Gorbachev 2013*/
    /**********************/
    /*******************/
    /*GLOBAL CLASS VARS*/
    /*******************/
    /*Some tables*/
    var $PRODUCT_TABLE = 'products';
    var $ORDER_TABLE = 'orders';
    var $SETTINGS_TABLE = 'settings';
    var $FILTERS_TABLE = 'filters';
    var $CONTACTS_TABLE = 'contacts';
    var $CATEGORY_TABLE = 'category';
    var $CAPTCHA_TABLE = 'captcha';
    /*Some error*/
    var $ERROR_PRODUCT = array('Вы заполнили не все поля.', 'Цена представляет из себя целое число.', 'Не удалось загрузить изображение.');
    var $ERROR_CATEGORY = array('Вы заполнили не все поля.');
    var $MIN_SALE = '500';
    var $SALE_DEVIDE = array(
            '500'=>10,
            '1000'=>20,
            '1500'=>30,
            '2000000'=>99
        );
    //var $CAPTCHA_PATH = './captcha/';
    //var $CAPTCHA_URL = 'captcha/';
    /***************/
    /*API FUNCTIONS*/
    /***************/

    public function captcha_create()
    {
        $this->load->library('recaptcha');
        return $this->recaptcha->recaptcha_get_html();
    }

    public function captcha_valid($challenge, $response)//($text)
    {
        $this->load->library('recaptcha');
        $this->recaptcha->recaptcha_check_answer($_SERVER['REMOTE_ADDR'], $challenge, $response);
        return $this->recaptcha->getIsValid();
    }
    /*return all products with gets category*/
    public function get_products_by_category($name)
    {
        $query = $this->db->get_where($this->PRODUCT_TABLE, array('category'=>$name));
        $ar = $query->result_array();
        foreach ($ar as $key => $v) {
            $ar[$key]['img_high_url'] = $this->upload_model->get_full_high_uri($v['img']);
            $ar[$key]['img_medium_url'] = $this->upload_model->get_full_medium_uri($v['img']);
            $ar[$key]['img_little_url'] = $this->upload_model->get_full_little_uri($v['img']);
        }
        return $ar;
    }
    public function get_settings()
    {
        $this->load->database();
        $query = $this->db->get($this->SETTINGS_TABLE)->result_array();
        foreach ($query as $row => $val) {
            $data[$val['parameter']] = $val;
        }
        return $data;
    }
    public function update_settings($ar)
    {
        $this->load->database();
        foreach ($ar as $key => $value) {
            $this->db->where('parameter', $key);
            $this->db->update($this->SETTINGS_TABLE, array('value'=>$value));
        }
    }
    public function get_filters()
    {
        $this->load->database();
        $data = [];
        $query = $this->db->get_where($this->FILTERS_TABLE)->result_array();
        foreach ($query as $row => $val) {
            $data[$val['parameter']] = $val;
        }
        return $data;
    }
    public function get_cat_filters($cat,$filter_name){
        $this->load->database();
        $query = $this->db->get_where($this->PRODUCTS_TABLE,array('category'=>$cat))->result_array();
    }
    public function create_filter($name,$atr)
    {
        $this->load->database();
        $data = array(
            'name'=>$name,
            'parameter'=>$this->getintranslit($name),
            'atr'=>$atr
        );
        $query = $this->db->get_where($this->FILTERS_TABLE,array('name'=>$name),'1')->result_array();
        if(count($query)==0)
        {
            $this->db->insert($this->FILTERS_TABLE,$data);
            /**/
            $this->load->dbforge();
            $fields = array(
                $data['parameter'] => array(
                    'type' => 'TEXT'
                )
            );
            $this->dbforge->add_column($this->PRODUCT_TABLE, $fields);
            return true;
        }else{
            return false;
        }
    }
    public function update_filter($id,$name,$atr)
    {
        $this->load->database();
        $query = $this->db->get_where($this->FILTERS_TABLE,array('id'=>$id),'1')->result_array();
        $data = array(
            'name'=>$name,
            'parameter'=>$this->getintranslit($name),
            'atr'=>$atr
        );
        if(count($query)!=0)
        {
            $this->db->where('id',$id);
            $this->db->update($this->FILTERS_TABLE,$data);
            $this->load->dbforge();
            $fields = array(
                $query[0]['parameter'] => array(
                    'name' => $this->getintranslit($name),
                    'type' => 'TEXT'
                ),
            );
            $this->dbforge->modify_column($this->PRODUCT_TABLE, $fields);
            return true;
        }else{
            return false;
        }
    }
    public function delete_filter($id)
    {
        $this->load->database();
        $filter = $this->db->get_where($this->FILTERS_TABLE,array('id'=>$id))->result_array();
        if(count($filter)!=0)
        {
            $this->db->delete($this->FILTERS_TABLE,array('id'=>$id));
            /**/
            $cats = $this->db->get_where($this->CATEGORY_TABLE)->result_array();
            foreach ($cats as $cat => $value) {
                $filterz = explode(',',$value['filters']);
                if(($key = array_search($id, $filterz)) !== false) {
                    unset($filterz[$key]);
                    $this->db->update($this->CATEGORY_TABLE,array('filters'=>implode(',',$filterz)));
                }
            }
            /**/
            $this->load->dbforge();
            $this->dbforge->drop_column($this->PRODUCT_TABLE, $filter[0]['parameter']);
            return true;
        }else{
            return false;
        }
    }
    /*return product with gets id*/
    public function get_product($id)
    {
        $id = (string)$id;
        if(strrpos($id, '_'))
        {
            $id = (float)substr($id, 0, strrpos($id, '_'));
        }
        $this->load->database();
        $query = $this->db->get_where($this->PRODUCT_TABLE, array('id'=>$id), '1');
        if(count($query->result_array()) > 0)
        {
            $obj = $query->result_array(); $obj = $obj[0];
            $cat = $this->db->get_where($this->CATEGORY_TABLE, array('name'=>$obj['category']), '1');
            $cat = $cat->result_array(); $cat = $cat[0];
            return array_merge($obj, array('category_subname'=>$cat['subname'], 'img_high_url'=>$this->upload_model->get_full_high_uri($obj['img']), 'img_medium_url'=>$this->upload_model->get_full_medium_uri($obj['img']), 'img_little_url'=>$this->upload_model->get_full_little_uri($obj['img'])));
        }
        return Null;
    }
    /*return all orders*/
    public function get_all_orders()
    {
        $this->load->database();
        $this->db->from($this->ORDER_TABLE);
        $this->db->order_by("id", "desc");
        //$this->db->not_like("operator", "");
        $query = $this->db->get();
        return $query->result_array();
    }
    /*return all products*/
    public function get_all_products()
    {
        $this->load->database();
        $this->db->from($this->PRODUCT_TABLE);
        $this->db->order_by("id", "desc"); 
        $query = $this->db->get();
        return $query->result_array();
    }
    /*return all category*/
    public function get_all_category()
    {
        $this->load->database();
        $query = $this->db->get($this->CATEGORY_TABLE);
        return $query->result_array();
    }
    /*******************/
    /*NON-API FUNCTIONS*/
    /*******************/
    /*NON-API FUNCTIONS*/
    /*******************/
    /*NON-API FUNCTIONS*/
    /*******************/
    /*NON-API FUNCTIONS*/
    /*******************/
    /*NON-API FUNCTIONS*/
    /*******************/
    /*NON-API FUNCTIONS*/
    /*******************/
    function __construct()
    {
        parent::__construct();
    }

    public function get_contacts()
    {
        $this->db->order_by("id", "desc");
        return $this->db->get($this->CONTACTS_TABLE)->result_array();
    }

    public function get_contact_by_id($id)
    {
        $a = $this->db->get_where($this->CONTACTS_TABLE, array('id'=>$id), '1')->result_array();
        if(count($a)==0)
            return '';
        return $a[0];
    }

    public function answerEnquiry($id,$text)
    {
        session_start();
        $data = array(
            'answer' => $text,
            'aname' => $_SESSION['username']
        );
        $this->db->where('id', $id);
        $this->db->update($this->CONTACTS_TABLE, $data);
    }

    public function real_del_order($id)
    {
        $id = (float)$id;
        $this->load->database();
        $query = $this->db->get_where($this->ORDER_TABLE, array('id'=>$id), '1');
        if(count($query->result_array())==0)
            return false;
        $this->db->where('id', $id);
        $this->db->delete($this->ORDER_TABLE);
        return true;
    }

    public function get_product_nondb($id)
    {
        $id = (string)$id;
        if(strrpos($id, '_'))
        {
            $id = (float)substr($id, 0, strrpos($id, '_'));
        }
        $query = $this->db->get_where($this->PRODUCT_TABLE, array('id'=>$id), '1');
        if(count($query->result_array()) > 0)
        {
            $obj = $query->result_array(); $obj = $obj[0];
            $cat = $this->db->get_where($this->CATEGORY_TABLE, array('name'=>$obj['category']), '1');
            $cat = $cat->result_array(); $cat = $cat[0];
            return array_merge($obj, array('category_subname'=>$cat['subname'], 'img_high_url'=>$this->upload_model->get_full_high_uri($obj['img']), 'img_medium_url'=>$this->upload_model->get_full_medium_uri($obj['img']), 'img_little_url'=>$this->upload_model->get_full_little_uri($obj['img'])));
        }
        return Null;
    }

    public function get_parents_by_id($id,$text)
    {
        $id = (int)$id;
        $query = $this->db->get_where($this->CATEGORY_TABLE, array('id'=>$id), '1')->result_array();
        if(count($query) > 0)
        {
            $query = $query[0];
            if($id!=0){
                if($query['parent_id']!=0)
                    $text = $this->get_parents_by_id($query['parent_id'],$text).' > '.$query['name'];
                else
                    $text = $query['name'];
            }
            return $text;
        }
        return '';
    }

    public function get_all_category_nondb()
    {
        $this->load->database();
        $this->db->from($this->CATEGORY_TABLE);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_multilevel_menu()
    {
        $this->load->database();
        $query = $this->db->get_where($this->CATEGORY_TABLE)->result_array();
        foreach($query as $row => $value)
        {
            $data[$value['id']] = $value;
        }
        $tree = array();
        foreach ($data as $id=>&$node) {
            if (!$node['parent_id']) {
                $tree[$id] = &$node;
            }
            else {
                $data[$node['parent_id']]['childs'][$id] = &$node;
            }
        }
        return $tree;
    }

    public function get_first_category()
    {
        $this->load->database();
        $this->db->from($this->CATEGORY_TABLE);
        $query = $this->db->get();
        $ar = $query->result_array();
        if(count($ar)==0)
            return Null;
        $ar = $ar[0];
        $data = array(
            'category'=>$ar,
            'result'=>'success'
            );
        $query = $this->db->get_where($this->PRODUCT_TABLE, array('category'=>$ar['name']));
        $data['products'] = $this->get_imgs($query->result_array());
        return $data;
    }

    public function check_category($name)
    {
        $this->load->database();
        $query = $this->db->get_where($this->CATEGORY_TABLE, array('subname'=>$name), '1');
        $ar = $query->result_array();
        if(count($ar)==0)
            return Null;
        $ar = $ar[0];
        $data = array(
            'category'=>$ar,
            'result'=>'success'
            );
        $query = $this->db->get_where($this->PRODUCT_TABLE, array('category'=>$ar['name']));
        $data['products'] = $this->get_imgs($query->result_array());
        return $data;
    }

    public function get_category_name_by_id($id)
    {
        $a = $this->db->get_where($this->CATEGORY_TABLE, array('id'=>$id), '1')->result_array();
        if(count($a)==0)
            return '';
        return $a[0]['name'];
    }

    public function get_category_by_id($id)
    {
        $this->load->database();
        $a = $this->db->get_where($this->CATEGORY_TABLE, array('id'=>$id), '1')->result_array();
        if(count($a)==0)
            return '';
        return $a[0];
    }

    public function get_imgs($ar)
    {
        foreach ($ar as $key => $v) {
            $ar[$key]['img_high_url'] = $this->upload_model->get_full_high_uri($v['img']);
            $ar[$key]['img_medium_url'] = $this->upload_model->get_full_medium_uri($v['img']);
            $ar[$key]['img_little_url'] = $this->upload_model->get_full_little_uri($v['img']);
        }
        return $ar;
    }

    public function category_change_used($id)
    {
        $this->load->database();
        $id = (float)$id;
        $cats_for_change = array();$active=1;
        $ar = $this->db->get_where($this->CATEGORY_TABLE, array('id'=>$id), '1')->result_array();
        $cats_for_change = $this->get_chained_category($id,$cats_for_change);
        $cats_for_change[] = $id;
        if($ar[0]['active']==1)
        {
            $active=0;
        }
        if(count($cats_for_change)!=0)
        {
            foreach ($cats_for_change as $cat => $value) {
                $this->db->where('id', $value);
                $this->db->update($this->CATEGORY_TABLE, array('active'=>$active));
            }
            return true;
        }
        return false;
    }

    public function clear_string($str)
    {
        $str = mb_strtolower($str);
        $str = str_replace(array("~", ";", "/", "|", "+", "-", "=", "?", "%", "^", "<", ">", "&", "*", "(", ")", "[", "]", "{", "}", "@", "#", ".", ":", "!", "\"", "'", "\\", ",", " "), array("", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", ""), $str);
        return $str;
    }

    public function add_category($name, $subname, $parent_id,$filters)
    {
        $subname = $this->clear_string($subname);
        $ar = $this->db->get_where($this->CATEGORY_TABLE, array('name'=>$name), '1')->result_array();
        $ar1 = $this->db->get_where($this->CATEGORY_TABLE, array('subname'=>$subname), '1')->result_array();
        if(count($ar)==0&&count($ar1)==0)
        {
            if($_SESSION['rank']<1)
                return 1;
            $data = array(
                'name' => $name,
                'subname' => $subname,
                'parent_id' => $parent_id,
                'filters' => $filters,
                'active' => 1
            );
            $this->db->insert($this->CATEGORY_TABLE, $data);
            return 2;
        }
        return 3;
    }

    public function update_category($id, $ar)
    {
        $id = (float)$id;
        $arz = $this->db->get_where($this->CATEGORY_TABLE, array('id != ' => $id, 'name'=>$ar['name']), '1')->result_array();
        $arz1 = $this->db->get_where($this->CATEGORY_TABLE, array('id != ' => $id, 'subname'=>$ar['subname']), '1')->result_array();
        if(count($arz)==0&&count($arz1)==0)
        {
            if($_SESSION['rank']<1)
                return 1;
            $query = $this->db->get_where($this->CATEGORY_TABLE, array('id'=>$id), '1');
            $obj = $query->result_array(); $obj = $obj[0];
            $data = array(
                    'name' => htmlspecialchars($ar['name']),
                    'subname' => htmlspecialchars($ar['subname']),
                    'parent_id' =>(int)$ar['parent_id'],
                    'filters' =>$ar['filters']
                );
            $this->load->database();
            $this->db->where('id', $id);
            $this->db->update($this->CATEGORY_TABLE, $data);
            $for_products = array(
                'category' => htmlspecialchars($ar['name'])
                );
            $this->db->where('category', $obj['name']);
            $this->db->update($this->PRODUCT_TABLE, $for_products);
            return 2;
        }
        return 3;
    }

    public function getintranslit($string) {
        $replace=array(
            "'"=>"","`"=>"",
            "1"=>"1","2"=>"2",
            "3"=>"3","4"=>"4",
            "5"=>"5","6"=>"6",
            "7"=>"7","8"=>"8",
            "9"=>"9","0"=>"0",
            "а"=>"a","А"=>"a",
            "б"=>"b","Б"=>"b",
            "в"=>"v","В"=>"v",
            "г"=>"g","Г"=>"g",
            "д"=>"d","Д"=>"d",
            "е"=>"e","Е"=>"e",
            "ж"=>"zh","Ж"=>"zh",
            "з"=>"z","З"=>"z",
            "и"=>"i","И"=>"i",
            "й"=>"y","Й"=>"y",
            "к"=>"k","К"=>"k",
            "л"=>"l","Л"=>"l",
            "м"=>"m","М"=>"m",
            "н"=>"n","Н"=>"n",
            "о"=>"o","О"=>"o",
            "п"=>"p","П"=>"p",
            "р"=>"r","Р"=>"r",
            "с"=>"s","С"=>"s",
            "т"=>"t","Т"=>"t",
            "у"=>"u","У"=>"u",
            "ф"=>"f","Ф"=>"f",
            "х"=>"h","Х"=>"h",
            "ц"=>"c","Ц"=>"c",
            "ч"=>"ch","Ч"=>"ch",
            "ш"=>"sh","Ш"=>"sh",
            "щ"=>"sch","Щ"=>"sch",
            "ъ"=>"","Ъ"=>"",
            "ы"=>"y","Ы"=>"y",
            "ь"=>"j","Ь"=>"j",
            "э"=>"e","Э"=>"e",
            "ю"=>"yu","Ю"=>"yu",
            "я"=>"ya","Я"=>"ya",
            "і"=>"i","І"=>"i",
            "ї"=>"yi","Ї"=>"yi",
            "є"=>"e","Є"=>"e",
            " "=>"_"
        );
        $str=iconv("UTF-8","UTF-8//IGNORE",strtr($string,$replace));
        return $str;
    }

    public function del_category($id)
    {
        $this->load->database();
        $id = (float)$id;
        $cats_for_delete = array();
        $ar = $this->db->get_where($this->CATEGORY_TABLE, array('id'=>$id), '1')->result_array();
        $cats_for_delete = $this->get_chained_category($id,$cats_for_delete);
        $cats_for_delete[] = $id;
        if(count($cats_for_delete)!=0)
        {
            foreach ($cats_for_delete as $cat => $value) {
                $this->db->where('category', (string)$this->get_category_name_by_id($value));
                $this->db->delete($this->PRODUCT_TABLE);
                $this->db->where('id', $value);
                $this->db->delete($this->CATEGORY_TABLE);
            }
            return true;
        }
        return false;
    }

    public function get_chained_category($parent_id,$cats){
        $query = $this->db->get_where($this->CATEGORY_TABLE, array('parent_id'=>$parent_id))->result_array();
        foreach ($query as $key => $value) {
            if(!array_key_exists( $value['id'] , $cats )){
                $cats[] = $value['id'];
            }
            $cats = $this->get_chained_category($value['id'],$cats);
        }
        return $cats;
    }

    public function check_act()
    {
    	session_start();
    	if(isset($_GET['DATA']))
    	{
    		if(!isset($_SESSION['BAG']))
    		{
    			$_SESSION['BAG'] = array();
    		}
            return true;
    	}else
    		return false;
    }

    public function del_order($id)
    {
        $this->load->database();
        $id = (float)$id;
        $query = $this->db->get_where($this->ORDER_TABLE, array('id' => $id));
        $ar = $query->result_array();
        if(count($ar)>0)
        {
            $data = array('operator' => $_SESSION['username'].' ***CANCELED!!!');
            $this->db->where('id', $id);
            $this->db->update($this->ORDER_TABLE, $data);
            //$this->db->delete($this->ORDER_TABLE);
            if($ar[0]['code']!='')
            {
                $query = $this->db->get_where($this->CODE_TABLE, array('code' => $ar[0]['code']));
                $ar1 = $query->result_array();
                if(count($ar1)>0)
                {
                    $this->db->where('code', $ar[0]['code']);
                    $this->db->delete($this->CODE_TABLE);
                }
            }
            return true;
        }
        return false;
    }

    public function create_order($name, $phone, $address, $info, $text, $price)
    {
        $a = date("YmdHis", time());
        $data = array(
            'text' => $text,
            'price' => $price,
            'phone' => htmlspecialchars(substr(str_replace(array('(', ')', '-'), array('', '', ''), $phone), 0, 12)),
            'info' => htmlspecialchars(substr($info, 0, 2000)),
            'address' => htmlspecialchars(substr($address, 0, 750)),
            'name' => htmlspecialchars(substr($name, 0, 350)),
            'datestamp' => $a,
            'ip' => $this->input->ip_address()
        );
        $this->db->insert($this->ORDER_TABLE, $data);
    }

    public function go_error($e)
    {
        return (string)$e;
    }

    public function validate_edit_product($name, $info, $category, $price, $img, $new)
    {
        $data = array('error'=>'','name'=>'','info'=>'','category'=>'','price'=>'','img'=>'');
        if(!($name&&$info&&$category))
            $data['error'] = $this->ERROR_PRODUCT[0];
        if($name)
            $data['name'] = $name;
        if($info)
            $data['info'] = $info;
        if($category)
            $data['category'] = $category;
        if($img)
        {
            if(!$this->upload_model->check_img($img)&&$new)
                $data['error'] = $this->ERROR_PRODUCT[2];
            $data['img'] = $img;
        }
        if($price)
        {
            if(!is_int((int)$price))
                $data['error'] = $this->ERROR_PRODUCT[1];
            $data['price'] = $price;
        }
        if($img=='stay'&&$new)
            $data['error'] = $this->ERROR_PRODUCT[0];
        return $data;
    }

    public function validate_edit_category($name, $subname, $parent_id, $new)
    {
        $data = array('error'=>'','name'=>'','parent_id'=>'');
        if(!($name&&$subname))
            $data['error'] = $this->ERROR_CATEGORY[0];
        if($name)
            $data['name'] = $name;
        if($subname)
            $data['subname'] = $subname;
        if($parent_id)
            $data['parent_id'] = $parent_id;
        return $data;
    }

    public function create_new_product($ar)
    {
        $data = array(
                'name' => htmlspecialchars($ar['name']),
                'price' => (int)$ar['price'],
                'category' => htmlspecialchars($ar['category']),
                'img' => $ar['img']
            );
        $this->load->database();
        $filters = $this->db->get($this->FILTERS_TABLE)->result_array();
        foreach ($filters as $filter => $value) {
                $data[$value['parameter']] = htmlspecialchars($ar[$value['parameter']]);
            }
        //if($this->add_category(htmlspecialchars($ar['category']), 1)!=1)
        //{
        $this->upload_model->attach_img($ar['img']);
        $this->db->insert($this->PRODUCT_TABLE, $data);
        //}
    }

    public function update_product($id, $ar)
    {
        $id = (float)$id;
        $filters = $this->db->get($this->FILTERS_TABLE)->result_array();
        $query = $this->db->get_where($this->PRODUCT_TABLE, array('id'=>$id), '1');
        $obj = $query->result_array(); $obj = $obj[0];
        $data = array(
                'name' => htmlspecialchars($ar['name']),
                'price' => (int)$ar['price'],
                'category' => htmlspecialchars($ar['category']),
            );
        foreach ($filters as $filter => $value) {
                $data[$value['parameter']] = htmlspecialchars($ar[$value['parameter']]);
            }
        if($ar['img']!='stay')
        {
            $data['img'] = $ar['img'];
            $this->upload_model->del_img($obj['img']);
            $this->upload_model->attach_img($data['img']);
        }else
            $this->upload_model->del_img($ar['img']);
        $this->load->database();
        //if($this->add_category(htmlspecialchars($ar['category']), 1)!=1)
        //{
        $this->db->where('id', $id);
        $this->db->update($this->PRODUCT_TABLE, $data);
        //}
    }

    public function html_sp_ch($ar)
    {
        $r = array();
        foreach ($ar as $key => $value) {
            $r[$key] = htmlspecialchars($value);
        }
        return $r;
    }

    public function delete_product($id)
    {
        $id = (float)$id;
        $this->db->from($this->PRODUCT_TABLE);
        $this->db->where('id', $id);
        $query = $this->db->get()->result_array();
        $this->upload_model->del_img($query[0]['img']);
        $this->db->where('id', $id);
        $this->db->delete($this->PRODUCT_TABLE);
    }
}