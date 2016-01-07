<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_Model extends CI_Model {

    var $KEY = 'APANtByIGI1BpVXZTJgcsAG8GZl8pdwwa84';
    var $USERS_TABLE = 'users';
    var $CREATE_ERROR = array('Вы заполнили не все поля.', 'Пользователь с таким именем уже существует.', 'Введенные пароли не совпадают.');

    function __construct()
    {
        parent::__construct();
    }

    function get_user($username, $password)
    {
        $this->load->database();
        //$this->load->library('encrypt');
        $this->load->helper('security');
        $query = $this->db->get_where($this->USERS_TABLE, array('username'=>mb_strtolower($username), 'password'=>do_hash($password, 'md5')), '1');
        //$query = $this->db->get_where($this->USERS_TABLE, array('username'=>$username, 'password'=>$this->encrypt->encode($password, $this->KEY)), '1');
        if(count($query->result_array())>0)
        {
        	$q = $query->result_array();
            return  $q[0];
        }
        return Null;
    }

    function get_user_by_id($id)
    {
        $this->load->database();
        $query = $this->db->get_where($this->USERS_TABLE, array('id' => $id), '1');
        if(count($query->result_array()) > 0)
        {
            $q = $query->result_array();
            return  $q[0];
        }
        else
            return Null;
    }

    function get_all_users()
    {
        $this->load->database();
        $this->db->where('rank <', 3);
        $query = $this->db->get($this->USERS_TABLE);
        return $query->result_array();
    }

    function islog()
    {
        if(isset($_SESSION['username']))
            return true;
        else
            return false;
    }

    function create_new_user($username, $password, $password2, $rank)
    {
        if($username&&$password&&$password2)
        {
            $this->load->database();
            $query = $this->db->get_where($this->USERS_TABLE, array('username' => mb_strtolower($username)), '1');
            if(count($query->result_array())>0)
                return $this->CREATE_ERROR[1];
            if($password!=$password2)
                return $this->CREATE_ERROR[2];
            if((int)$rank>2)
                $rank = 2;
            $this->load->helper('security');
            $this->db->insert($this->USERS_TABLE, array('rank' => (int)$rank, 'username' => mb_strtolower($username), 'password' => do_hash($password, 'md5')));
            return '';
        }else
            return $this->CREATE_ERROR[0];
    }

    function update_user($id, $y_rank, $username, $password, $password2, $rank)
    {
        if(!$username)
            return $this->CREATE_ERROR[0];
        $this->load->database();
        $query = $this->db->get_where($this->USERS_TABLE, array('username' => mb_strtolower($username)));
        foreach ($query->result_array() as $key => $v) {
            if($v['id']!=$id)
                return $this->CREATE_ERROR[1];
        }
        if($password!=$password2)
            return $this->CREATE_ERROR[2];
        if((int)$rank>2)
            $rank = 2;
        if((int)$rank<0)
            $rank = 0;
        if((int)$rank>1&&(int)$y_rank<3)
            $rank = 1;
        $this->load->helper('security');
        $data = array('username' => mb_strtolower($username), 'password' => do_hash($password, 'md5'), 'rank' => (int)$rank);
        if($password=='')
            unset($data['password']);
        $this->db->where('id', $id);
        $this->db->update($this->USERS_TABLE, $data);
        return '';
    }

    function del_user($id)
    {
        $this->load->database();
        $this->db->where('id', $id);
        $this->db->delete($this->USERS_TABLE);
    }
}
