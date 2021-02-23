<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Auth_Model extends CI_Model{

		public function authenticateLogin($username,$password, $table_name, $role_id = ''){
			if(!$table_name) return FALSE; 
			$this->db->select('username, id, email, display_name, last_login_time');
			$this->db->where("status=1 AND (email='".$username."' OR username='".$username."') AND password='".md5($password)."' AND is_deleted = 0");

			$selectResponse = $this->db->get($table_name);
			return $selectResponse->row_array(); 
		}
		
		public function check_email_in_all_user_table( $email ){
			/*'select 1 as email from (
						 select email as e from teachers
						 union all
						 select email from parents
						 union all
						 select email from students
						 union all
						 select email from admin_users
						) a
						WHERE e = ?'; */
			if(!$email) return FALSE;
			$sql = 'select 1 as email from (
						 select email as e from teachers
						 union all
						 select email from parents
						 union all
						 select email from admin_users
						) a
						WHERE e = ?'; 
			$selectResponse = $this->db->query($sql, array($email)); 
			return $selectResponse->row_array();
		}
		
	}
