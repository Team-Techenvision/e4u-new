<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Copycontent_model extends CI_Model {
  /**
    * Responsable for auto load the database
    * @return void
    */
   public function __construct()
   {
   	$this->load->database();
   }		
		
	public function getClasses($course_id){
		$this->db->select("cl.id, cl.name");
	  	$this->db->from("relevant_classes as rc");
	  	$this->db->join("classes as cl","rc.class_id = cl.id");
	  	$this->db->where("rc.course_id", $course_id);
	  	$this->db->where('cl.status','1');
	  	$this->db->order_by("cl.name", "asc");
	  	$result = $this->db->get();
		return $result->result_array();
	}
	
	public function getSubjects($course_id, $class_id){				
		$this->db->select("rs.id, s.name");
	  	$this->db->from("relevant_subjects as rs");
	  	$this->db->join("subjects as s","rs.subject_id = s.id");
	  	$this->db->join("classes as c","rs.class_id = c.id");
	  	$this->db->where("rs.course_id", $course_id);
	  	if($class_id!="all"){
	  		$this->db->where("rs.class_id", $class_id);
	  	}	  	
	  	$this->db->where('s.status','1');
	  	$this->db->order_by("rs.class_id", "asc");
	  	$result = $this->db->get();	  	  		  	
		return $result->result_array();
	}
	
	public function getChapters($course_id, $class_id, $subject_id){		
		if($subject_id!="all"){
			$this->db->select("rs.subject_id");
		  	$this->db->from("relevant_subjects as rs");
		  	$this->db->where("rs.id", $subject_id);
			$result1 = $this->db->get();	
			$data1 = $result1->row_array();		
			$subject_id = $data1["subject_id"];
		}
		
		$this->db->select("c.id, c.name");
	  	$this->db->from("chapters as c");
	  	$this->db->where("c.course_id", $course_id);
	  	if($class_id!="all"){
	  		$this->db->where("c.class_id", $class_id);
	  	}
	  	if($subject_id!="all"){
	  		$this->db->where("c.subject_id", $subject_id);	
	  	}	  	
	  	$this->db->where('c.status','1');
	  	$this->db->order_by("c.subject_id", "asc");
	  	$result = $this->db->get();	  		  	
		return $result->result_array();
	}
	
	public function getLevels($course_id, $class_id, $subject_id, $chapter_id){
		if($subject_id!="all"){
			$this->db->select("rs.subject_id");
		  	$this->db->from("relevant_subjects as rs");
		  	$this->db->where("rs.id", $subject_id);
			$result1 = $this->db->get();	
			$data1 = $result1->row_array();		
			$subject_id = $data1["subject_id"];
		}
	
		$this->db->select("l.id, l.name");
	  	$this->db->from("levels as l");
	  	$this->db->where("l.course_id", $course_id);
	  	if($class_id!="all"){
		  	$this->db->where("l.class_id", $class_id);
		}
		if($subject_id!="all"){
			$this->db->where("l.subject_id", $subject_id);
		}	  	
		if($chapter_id!="all"){
			$this->db->where("l.chapter_id", $chapter_id);
		}	  	
	  	$this->db->where('l.status','1');
	  	//$this->db->order_by("l.name", "asc");
	  	$this->db->order_by("l.chapter_id", "asc");
	  	$result = $this->db->get();
		return $result->result_array();
	}
	
	
	public function getSets($course_id, $class_id, $subject_id, $chapter_id, $level_id){
		if($subject_id!="all"){
			$this->db->select("rs.subject_id");
		  	$this->db->from("relevant_subjects as rs");
		  	$this->db->where("rs.id", $subject_id);
			$result1 = $this->db->get();	
			$data1 = $result1->row_array();		
			$subject_id = $data1["subject_id"];
		}
		$this->db->select("s.id, s.name");
	  	$this->db->from("sets as s");
	  	$this->db->where("s.course_id", $course_id);
	  	if($class_id!="all"){
	  		$this->db->where("s.class_id", $class_id);
	  	}
	  	if($subject_id!="all"){
	  		$this->db->where("s.subject_id", $subject_id);
	  	}
	  	if($chapter_id!="all"){
	  		$this->db->where("s.chapter_id", $chapter_id);
	  	}
	  	if($level_id!="all"){
	  		$this->db->where("s.level_id", $level_id);
	  	}
	  	$this->db->where('s.status','1');
	  	//$this->db->order_by("s.name", "asc");
	  	$this->db->order_by("s.level_id", "asc");
	  	$result = $this->db->get();	  	  		  	
		return $result->result_array();
	}
	
	
	// modified for copy content
	public function getCount($table_name, $course_id, $class_id, $subject_id, $chapter_id, $level_id="", $set_id=""){
		if($subject_id!="all"){
			$this->db->select("rs.subject_id");
		  	$this->db->from("relevant_subjects as rs");
		  	$this->db->where("rs.id", $subject_id);
			$result1 = $this->db->get();	
			$data1 = $result1->row_array();		
			$subject_id = $data1["subject_id"];
		}
		$this->db->select("id");
	  	$this->db->from($table_name);
	  	$this->db->where("course_id", $course_id);
	  	if($class_id!="all"){
	  		$this->db->where("class_id", $class_id);
	  	}
	  	if($subject_id!="all"){
	  		$this->db->where("subject_id", $subject_id);
	  	}
	  	if($chapter_id!="all"){	  	
	  		$this->db->where("chapter_id", $chapter_id);
	  	}
	  	if($table_name!="subjective_questions"){
	  		if($level_id!="all"){
	  			$this->db->where("level_id", $level_id);
	  		}
	  		if($set_id!="all"){
	  			$this->db->where("set_id", $set_id);
	  		}
	  	}	  		  	
	  	$result = $this->db->get();
		return $result->num_rows();
	}
	
	function getSelectList($table, $where = array(), $default = array(), $fields = 'id,name', $order="")
   {    	    	
        $data  = array();
        $field = explode(',', $fields);
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->where('status', '1');
        if($order==""){
        	  $this->db->order_by($field[1], 'asc');
        }else{
        		$this->db->order_by($order, 'asc');
        }
        
        if (is_array($where))
            $this->db->where($where);
        $query = $this->db->get();
        if (!empty($default)) {
            $data = $default;
        }
        $data[''] = 'Select';
        $i = 0;
        foreach ($query->result_array() as $row) {
        		if($i==0){
        			$data["all"] = "";
        		}
            $data[$row[$field[0]]] = ucfirst($row[$field[1]]);
            $i++;
        }               
        return $data;
    }
    
    
    public function getmaterials($course_id="", $class_id="", $subject_id=""){    	
		if($subject_id!="all" and $subject_id!=""){
			$this->db->select("rs.subject_id");
		  	$this->db->from("relevant_subjects as rs");
		  	$this->db->where("rs.id", $subject_id);
			$result1 = $this->db->get();	
			$data1 = $result1->row_array();		
			$subject_id = $data1["subject_id"];
		}		
		$this->db->select("id, download_name");
	  	$this->db->from("downloads");
	  	$this->db->where("course_id", $course_id);
	  	if($class_id!="all" and $class_id!=""){
	  		$this->db->where("class_id", $class_id);
	  	}
	  	if($subject_id!="all" and $subject_id!=""){
	  		$this->db->where("subject_id", $subject_id);
	  	}  
	  	$this->db->where('status','1');	  	
	  	$this->db->order_by("id", "asc");
	  	$result = $this->db->get();		  	
		//$data[''] = 'Select Material';
      $i = 0;
      foreach ($result->result_array() as $row) {			
			if($i==0){
		  		//$data["all"] = "All materials";
		  	}
		   	$data[$row["id"]] = ucfirst($row["download_name"]);
		      $i++;
		}  
	   return $data;
	}
	
	public function copy_questions(){
   	$date = date('Y-m-d H:i:s');
		$course_list_from = $this->input->post('course_list');				
		$class_list_from = $this->input->post('class_list');
		$subject_list_from = $this->input->post('subject_list');
		$chapter_list_from = $this->input->post('chapter_list');
		$level_list_from = $this->input->post('level_list');
		$set_list_from = $this->input->post('set_list');
		$subjective_question = ($this->input->post('subjective_question'))?$this->input->post('subjective_question'):"";
		$objective_question = ($this->input->post('objective_question'))?$this->input->post('objective_question'):"";
		$materials = $this->input->post('materials');	
		if($this->input->post('status')){
			$status = $this->input->post('status');		
		}	// 1 - overwrite and 2 - duplicate
		
		if($subject_list_from!="all" and $subject_list_from!=""){
	      $this->db->select("rs.subject_id");
        	$this->db->from("relevant_subjects as rs");
        	$this->db->where("rs.id", $subject_list_from);
	      $result1 = $this->db->get();	
	      $data1 = $result1->row_array();		
	      $subject_list_from = $data1["subject_id"];
      }
		
		$course_list_to = $this->input->post('course_list_to');				
		$class_list_to = $this->input->post('class_list_to');
		$subject_list_to = $this->input->post('subject_list_to');
		$chapter_list_to = $this->input->post('chapter_list_to');
		$level_list_to = $this->input->post('level_list_to');
		$set_list_to = $this->input->post('set_list_to');
		if($subject_list_to!="all" and $subject_list_to!=""){
	      $this->db->select("rs.subject_id");
        	$this->db->from("relevant_subjects as rs");
        	$this->db->where("rs.id", $subject_list_to);
	      $result1 = $this->db->get();	
	      $data1 = $result1->row_array();		
	      $subject_list_to = $data1["subject_id"];
      }
      
      
      //copy class	
      if(!(($class_list_from!="" or $class_list_from!="all") and $class_list_to!="")){
			$where = array();  
		  	$fields = 'created, modified, course_id, class_id, status'; 
		  	$where[] = array( TRUE, 'course_id', $course_list_from);				  		
		  	if($class_list_from!="" and $class_list_from!="all"){
		  	   $where[] = array( TRUE, 'class_id', $class_list_from);	
		  	}				  	
		  	$class_list = $this->base_model->get_advance_list('relevant_classes', '', $fields, $where, '', 'id', 'asc');		  					  	
			if($status=="1"){ 			  				
	  		   $del_cond = array();	
	  		   $del_cond["course_id"] = $course_list_to;	 	  				
  				$this->base_model->delete('relevant_classes',$del_cond);
  				//echo $this->db->last_query(); 
  				//echo "<br>";	  				
  			}	//if status is overwrite, delete all records
		  	if(count($class_list)){  		
		  		foreach($class_list as $class){
		  			$availability = 0;
		  			if($status=="2"){							  				
					  	$is_available = $this->base_model->getCount('relevant_classes',array('course_id' => $course_list_to, 'class_id' => $class["class_id"]));
					  	if($is_available>0){				  				
			  				$availability = 1;
			  			}
		  			}							
					if($availability!=1){						
						$class["created"] = $date;
			  			$class["modified"] = $date;			  			
			  			$class["course_id"] = $course_list_to;	
			  			$this->db->insert('relevant_classes',$class);					  				
					}									  							  			
		  		} // for loop end
		  	}
		}
      $message = "";   
      if(!is_null($class_list)){
      	if(count($class_list)){
      		$message = "class";
      	}
      }
           
      
      //copy subjects		
		if(!(($subject_list_from!="" or $subject_list_from!="all") and $subject_list_to!="")){
			$where = array();  
		  	$fields = 'created, modified, course_id, class_id, subject_id, status'; 
		  	$where[] = array( TRUE, 'course_id', $course_list_from);	
		  	if($class_list_from!="" and $class_list_from!="all"){
		      $where[] = array( TRUE, 'class_id', $class_list_from);	
		   }			  		 
		   if($subject_list_from!="" and $subject_list_from!="all"){
		      $where[] = array( TRUE, 'subject_id', $subject_list_from);	
		   }
		  	$subject_list = $this->base_model->get_advance_list('relevant_subjects', '', $fields, $where, '', 'id', 'asc');				  	
		  	if($status=="1"){ 		  			
	  		  	$del_cond = array();	
	  		   $del_cond["course_id"] = $course_list_to;	 	
	  		   if($class_list_to!=""){
	  		   	$del_cond["class_id"] = $class_list_to;	
	  		   }	  		   		  						  			
  				$this->base_model->delete('relevant_subjects',$del_cond);		
  				//echo $this->db->last_query(); 
  				//echo "<br>";	  				
  			}	//if status is overwrite, delete all records	
		  	if(count($subject_list)){		  							  	
		  		foreach($subject_list as $subject){	
		  			$availability = 0;
		  			if($status=="2"){				  				
					  	$is_available = $this->base_model->getCount('relevant_subjects',array('course_id' => $course_list_to, 'class_id' => $subject["class_id"], 'subject_id' => $subject["subject_id"]));
					  	if($is_available>0){				  				
			  				$availability = 1;
			  			}
		  			}	
		  			if($availability!=1){								
			  			$subject["created"] = $date;
			  			$subject["modified"] = $date;			  			
			  			$subject["course_id"] = $course_list_to;						  							  			
			  			$this->db->insert('relevant_subjects',$subject);
					}		  							  			
		  		}  // for loop end
		  	}			
		}
		if(!is_null($subject_list)){
			if(count($subject_list)){
				$message = "subject";
			}
      }	  	
		 	 
      //die;
      //copy chapters		
		if(!(($chapter_list_from!="" or $chapter_list_from!="all") and $chapter_list_to!="")){
			$where = array();  
		  	$fields = 'id, created, modified, course_id, class_id, subject_id, order, name, description, status,order'; 
		  	$where[] = array( TRUE, 'course_id', $course_list_from);			
		  	if($class_list_from!="" and $class_list_from!="all"){
            $where[] = array( TRUE, 'class_id', $class_list_from);	
         }			  		 
         if($subject_list_from!="" and $subject_list_from!="all"){
            $where[] = array( TRUE, 'subject_id', $subject_list_from);	
         }	  	
         if($chapter_list_from!="" and $chapter_list_from!="all"){
            $where[] = array( TRUE, 'id', $chapter_list_from);	
         }	  	
		  	$chapter_list = $this->base_model->get_advance_list('chapters', '', $fields, $where, '', 'id', 'asc');		  
		  	$chapter_query = $this->db->last_query();		  
		  	if($status=="1"){		  		 	
	  			$del_cond = array();	
	  		   $del_cond["course_id"] = $course_list_to;
	  		   if($class_list_to!=""){
	  		   	$del_cond["class_id"] = $class_list_to;	
	  		   }	
	  		   if($subject_list_to!=""){
	  		   	$del_cond["subject_id"] = $subject_list_to;	
	  		   }	  		   		  							  			
  				$this->base_model->delete('chapters', $del_cond);		
  				//echo $this->db->last_query(); 
  				//echo "<br>";	  				
  			}	//if status is overwrite, delete all records
		  	if(count($chapter_list)){		  					  		
				$chapter_ids = array();	  			
		  		foreach($chapter_list as $chapter){	
		  			$temp_chapter_id = $chapter["id"];	
		  			unset($chapter["id"]);
		  			$chapter["created"] = $date;
		  			$chapter["modified"] = $date;			  			
		  			$chapter["course_id"] = $course_list_to;	
		  			if($class_list_to!=""){
		  				$chapter["class_id"] = $class_list_to;
		  			}
		  			if($subject_list_to!=""){
		  				$chapter["subject_id"] = $subject_list_to;
		  			}	
					$exist_rec=$this->check_name_duplicate($chapter["course_id"],$chapter["class_id"],$chapter["subject_id"],'','','',$chapter['name']);
					if($exist_rec!=0){
						$chapter['name']=$chapter['name'].'-copy';
					}					
		  			$this->db->insert('chapters',$chapter);		
		  			$chapter_ids[$temp_chapter_id] = $this->db->insert_id();								  							  			
		  		}	// for loop end 
		  	}
      }		  	
		if(!is_null($chapter_list)){
			if(count($chapter_list)){
				$message = "chapter";
			}
      }
		//copy levels	
		if(!(($level_list_from!="" or $level_list_from!="all") and $level_list_to!="")){
			$where = array();  
		  	$fields = 'id, created, modified, course_id, class_id, subject_id, chapter_id, name, description, status,order'; 
		  	$where[] = array( TRUE, 'course_id', $course_list_from);	
		  	if($class_list_from!="" and $class_list_from!="all"){
            $where[] = array( TRUE, 'class_id', $class_list_from);	
         }			  		 
         if($subject_list_from!="" and $subject_list_from!="all"){
            $where[] = array( TRUE, 'subject_id', $subject_list_from);	
         }		
         if($chapter_list_from!="" and $chapter_list_from!="all"){
            $where[] = array( TRUE, 'chapter_id', $chapter_list_from);	
         }	
         if($level_list_from!="" and $level_list_from!="all"){
            $where[] = array( TRUE, 'id', $level_list_from);	
         }	  		  	
		  	$level_list = $this->base_model->get_advance_list('levels', '', $fields, $where, '', 'id', 'asc');		  	
		  	if($status=="1"){ 
	  			$del_cond = array();	
	  		   $del_cond["course_id"] = $course_list_to;		
	  		   if($class_list_to!=""){
	  		   	$del_cond["class_id"] = $class_list_to;	
	  		   }	
	  		   if($subject_list_to!=""){
	  		   	$del_cond["subject_id"] = $subject_list_to;	
	  		   }  	
	  		   if($chapter_list_to!=""){
	  		   	$del_cond["chapter_id"] = $chapter_list_to;	
	  		   }	   			  							  			
  				$this->base_model->delete('levels', $del_cond);		
  				//echo $this->db->last_query(); 
  				//echo "<br>";	  				
  			}	//if status is overwrite, delete all records	
		  	if(count($level_list)){		  		
	  			$level_ids = array();
		  		foreach($level_list as $level){  
		  			if(!is_null($chapter_ids)){
		  				if(array_key_exists($level["chapter_id"],$chapter_ids)){
			  				$level["chapter_id"] = $chapter_ids[$level["chapter_id"]];	
	  					}
		  			}else if($chapter_list_to!=""){
		  				$level["chapter_id"] = $chapter_list_to;
		  			}
		  			$temp_level_id = $level["id"];	
	  				unset($level["id"]);						
	  				$level["created"] = $date;
	  				$level["modified"] = $date;			  			
	  				$level["course_id"] = $course_list_to;
	  				if($class_list_to!=""){
	  					$level["class_id"] = $class_list_to;	
	  				}	  		
	  				if($subject_list_to!=""){
	  					$level["subject_id"] = $subject_list_to;
	  				}	
					$exist_rec=$this->check_name_duplicate($level["course_id"],$level["class_id"],$level["subject_id"],$level["chapter_id"],'','',$level['name']);
					if($exist_rec!=0){
						$level['name']=$level['name'].'-copy';
					} 					
	  				$this->db->insert('levels',$level);					  						
	  				$level_ids[$temp_level_id] = $this->db->insert_id();					  			  		  											  							  			
		  		}   // for loop end
		  	}
      } 		
		if(!is_null($level_list)){
			if(count($level_list)){
				$message = "level";
			}
      }
			  	
		//copy sets  	
		if(!(($set_list_from!="" or $set_list_from!="all") and $set_list_to!="")){
			$where = array();  
		  	$fields = 'id, created, modified, course_id, class_id, subject_id, chapter_id, level_id, name, description, status,order'; 
		  	$where[] = array( TRUE, 'course_id', $course_list_from);			
		  	if($class_list_from!="" and $class_list_from!="all"){
            $where[] = array( TRUE, 'class_id', $class_list_from);	
         }			  		 
         if($subject_list_from!="" and $subject_list_from!="all"){
            $where[] = array( TRUE, 'subject_id', $subject_list_from);	
         }		
         if($chapter_list_from!="" and $chapter_list_from!="all"){
            $where[] = array( TRUE, 'chapter_id', $chapter_list_from);	
         }	  
         if($level_list_from!="" and $level_list_from!="all"){
            $where[] = array( TRUE, 'level_id', $level_list_from);	
         }	
         if($set_list_from!="" and $set_list_from!="all"){
				$where[] = array( TRUE, 'id', $set_list_from);	
			}		  	
		  	$set_list = $this->base_model->get_advance_list('sets', '', $fields, $where, '', 'id', 'asc');
		  	if($status=="1"){ 			  		
	  	   	$del_cond = array();	
	  		   $del_cond["course_id"] = $course_list_to;		 
	  		   if($class_list_to!=""){
	  		   	$del_cond["class_id"] = $class_list_to;	
	  		   }	
	  		   if($subject_list_to!=""){
	  		   	$del_cond["subject_id"] = $subject_list_to;	
	  		   }  	
	  		   if($chapter_list_to!=""){
	  		   	$del_cond["chapter_id"] = $chapter_list_to;	
	  		   }
	  		   if($level_list_to!=""){
	  		   	$del_cond["level_id"] = $level_list_to;	
	  		   }	 		    							  			
  				$this->base_model->delete('sets', $del_cond);	
  				//echo $this->db->last_query(); 
  				//echo "<br>";			  	   			  				
  			}				  	
		  	if(count($set_list)){		  				  	   
	  			$set_ids = array();
		  		foreach($set_list as $set){
		  			  		   	
		  			if(!is_null($chapter_ids)){
		  				if(array_key_exists($set["chapter_id"],$chapter_ids)){
			  				$set["chapter_id"] = $chapter_ids[$set["chapter_id"]];	
	  					}
		  			}else if($chapter_list_to!=""){
		  				$set["chapter_id"] = $chapter_list_to;
		  			}
		  			if(!is_null($level_ids)){
		  				if(array_key_exists($set["level_id"],$level_ids)){
			  				$set["level_id"] = $level_ids[$set["level_id"]];	
	  					}
		  			}else if($level_list_to!=""){
		  				$set["level_id"] = $level_list_to;
		  			}
		  			$temp_set_id = $set["id"];	
		  			unset($set["id"]);		  		   					  			  				
	  				$set["created"] = $date;
		  			$set["modified"] = $date;	
		  			$set["course_id"] = $course_list_to;	
		  			if($class_list_to!=""){
	  					$set["class_id"] = $class_list_to;	
	  				}	  		
	  				if($subject_list_to!=""){
	  					$set["subject_id"] = $subject_list_to;
	  				}	
					$exist_rec=$this->check_name_duplicate($set["course_id"],$set["class_id"],$set["subject_id"],$set["chapter_id"],$set["level_id"],'',$set['name']); 
					if($exist_rec!=0){
					$set['name']=$set['name'].'-copy';		
					}
	  				$this->db->insert('sets',$set); 
		  			$set_ids[$temp_set_id] = $this->db->insert_id();				  							  			
		  		}
		  	}		
      }  		 		
		if(!is_null($set_list)){
			if(count($set_list)){
				$message = "set";
			}
      } 
		  	//die;
	  	//copy objective questions		
		if($status=="1"){ 		  		   		  		
  	   	$del_cond = array();	
			$del_cond["course_id"] = $course_list_to;	 
			if($class_list_to!=""){
  		   	$del_cond["class_id"] = $class_list_to;	
  		   }	
  		   if($subject_list_to!=""){
  		   	$del_cond["subject_id"] = $subject_list_to;	
  		   }  	
  		   if($chapter_list_to!=""){
  		   	$del_cond["chapter_id"] = $chapter_list_to;	
  		   }
  		   if($level_list_to!=""){
  		   	$del_cond["level_id"] = $level_list_to;	
  		   }	
  		   if($set_list_to!=""){
  		   	$del_cond["set_id"] = $set_list_to;	
  		   }																		  			
			$this->base_model->delete('questions', $del_cond);
			//echo $this->db->last_query(); 
			//echo "<br>";
		}	  		
	  	if($objective_question!=""){
			$where = array();  
		  	$fields = 'created, modified, course_id, class_id, subject_id, chapter_id, level_id, set_id, question_type, 
		  	answer_type, choice_count, question, choices, correct_answer, explanation_type, explanation, severity, status'; 
		  	$where[] = array( TRUE, 'course_id', $course_list_from);	
		  	if($class_list_from!="" and $class_list_from!="all"){
				$where[] = array( TRUE, 'class_id', $class_list_from);	
			}			  		 
			if($subject_list_from!="" and $subject_list_from!="all"){
				$where[] = array( TRUE, 'subject_id', $subject_list_from);	
			}		
			if($chapter_list_from!="" and $chapter_list_from!="all"){
				$where[] = array( TRUE, 'chapter_id', $chapter_list_from);	
			}	  
			if($level_list_from!="" and $level_list_from!="all"){
				$where[] = array( TRUE, 'level_id', $level_list_from);	
			}	
			if($set_list_from!="" and $set_list_from!="all"){
				$where[] = array( TRUE, 'set_id', $set_list_from);	
			}		  		  	
		  	$question_list = $this->base_model->get_advance_list('questions', '', $fields, $where, '', 'id', 'asc');	
		  				  	
		  	if(count($question_list)){			  				  	   
		  		foreach($question_list as $question){		  						  				
  		  			$question["created"] = $date;
			  		$question["modified"] = $date;			  			
			  		$question["course_id"] = $course_list_to;
			  		if($class_list_to!=""){
	  					$question["class_id"] = $class_list_to;	
	  				}	  		
	  				if($subject_list_to!=""){
	  					$question["subject_id"] = $subject_list_to;
	  				}
			  		if(!is_null($chapter_ids)){
		  				if(array_key_exists($question["chapter_id"],$chapter_ids)){
			  				$question["chapter_id"] = $chapter_ids[$question["chapter_id"]];	
	  					}
		  			}else if($chapter_list_to!=""){
		  				$question["chapter_id"] = $chapter_list_to;
		  			}	  				
			  		if(!is_null($level_ids)){
		  				if(array_key_exists($question["level_id"],$level_ids)){
			  				$question["level_id"] = $level_ids[$question["level_id"]];	
	  					}
		  			}else if($level_list_to!=""){
		  				$question["level_id"] = $level_list_to;
		  			}		
		  			
		  			if(!is_null($set_ids)){
		  				if(array_key_exists($question["set_id"],$set_ids)){
			  				$question["set_id"] = $set_ids[$question["set_id"]];	
	  					}
		  			}else if($set_list_to!=""){
		  				$question["set_id"] = $set_list_to;
		  			}	  				
										  			
			  		$this->db->insert('questions',$question);				
		  		}
		  	}
		} 
		
		if(!is_null($question_list)){
			if(count($question_list)){
				$message = "objective questions";
			}
      }	
				
			//copy subjective questions		
			
			if($status=="1"){ 
	  	   	$del_cond = array();	
				$del_cond["course_id"] = $course_list_to;		
				if($class_list_to!=""){
	  		   	$del_cond["class_id"] = $class_list_to;	
	  		   }	
	  		   if($subject_list_to!=""){
	  		   	$del_cond["subject_id"] = $subject_list_to;	
	  		   }  	
	  		   if($chapter_list_to!=""){
	  		   	$del_cond["chapter_id"] = $chapter_list_to;	
	  		   }				  			
				$this->base_model->delete('subjective_questions', $del_cond);		  
				//echo $this->db->last_query(); 
  				//echo "<br>";				
			} 	
		  	if($subjective_question!=""){
				$where = array();  
			  	$fields = 'created, modified, course_id, class_id, subject_id, chapter_id, sub_category_id, question_type, 
			  	question, explanation_type, explanation, severity, status'; 
			  	$where[] = array( TRUE, 'course_id', $course_list_from);	
			  	if($class_list_from!="" and $class_list_from!="all"){
					$where[] = array( TRUE, 'class_id', $class_list_from);	
				}			  		 
				if($subject_list_from!="" and $subject_list_from!="all"){
					$where[] = array( TRUE, 'subject_id', $subject_list_from);	
				}		
				if($chapter_list_from!="" and $chapter_list_from!="all"){
					$where[] = array( TRUE, 'chapter_id', $chapter_list_from);	
				}			  		  	
			  	$subjective_question_list = $this->base_model->get_advance_list('subjective_questions', '', $fields, $where, '', 'id', 'asc');				  	
			  	
			  	if(count($subjective_question_list)){			  					  	  
			  		foreach($subjective_question_list as $subjective_question){			  			
						$subjective_question["created"] = $date;
			  			$subjective_question["modified"] = $date;			  			
			  			$subjective_question["course_id"] = $course_list_to;			  			
		  				if($class_list_to!=""){
		  					$subjective_question["class_id"] = $class_list_to;	
		  				}	  		
		  				if($subject_list_to!=""){
		  					$subjective_question["subject_id"] = $subject_list_to;
		  				}
		  				if(!is_null($chapter_ids)){
			  				if(array_key_exists($subjective_question["chapter_id"],$chapter_ids)){
				  				$subjective_question["chapter_id"] = $chapter_ids[$subjective_question["chapter_id"]];	
		  					}
			  			}else if($chapter_list_to!=""){
			  				$subjective_question["chapter_id"] = $chapter_list_to;
			  			}		  								
			  				  					  			
			  			$this->db->insert('subjective_questions',$subjective_question);				  						  							  			
			  		}
			  	}
			}	
			if(!is_null($subjective_question_list)){
				if(count($subjective_question_list)){
					$message = "subjective questions";
				}
		   }
			
			//copy downloads		
				  	
		  	$where = array();  
		  	$fields = 'created, modified, course_id, class_id, subject_id, attachment, uploaded_by, download_name, comments, user_id, status'; 
		  	$where[] = array( TRUE, 'course_id', $course_list_from);		
		  	if($class_list_from!="" and $class_list_from!="all"){
            $where[] = array( TRUE, 'class_id', $class_list_from);	
         }			  		 
         if($subject_list_from!="" and $subject_list_from!="all"){
            $where[] = array( TRUE, 'subject_id', $subject_list_from);	
         }	
         if($materials!="" and $materials!="all"){
            $where[] = array( TRUE, 'id', $materials);	
         }	  		  	
		  	$download_list = $this->base_model->get_advance_list('downloads', '', $fields, $where, '', 'id', 'asc');			  			  	
		  	if($status=="1"){ 						  	   	
	  	   	$del_cond = array();	
				$del_cond["course_id"] = $course_list_to;	 	
				if($class_list_to!=""){
	  		   	$del_cond["class_id"] = $class_list_to;	
	  		   }	
	  		   if($subject_list_to!=""){
	  		   	$del_cond["subject_id"] = $subject_list_to;	
	  		   } 												
				$this->base_model->delete('downloads', $del_cond);	
				//echo $this->db->last_query(); 
  				//echo "<br>";				  	   		  							  			
  			}
		  	if(count($download_list)){			  			  	  
		  		foreach($download_list as $download){			  								
	  				$download["created"] = $date;
		  			$download["modified"] = $date;			  			
		  			$download["course_id"] = $course_list_to;	
		  			if($class_list_to!=""){
	  					$download["class_id"] = $class_list_to;	
	  				}	
		  			if($subject_list_to!=""){
	  					$download["subject_id"] = $subject_list_to;
	  				}
		  			$download["uploaded_by"] = 0;
		  			$download["user_id"] = 0;	  					  			
		  			$this->db->insert('downloads',$download);
		  		}
		  	}	
		  	
		  	if(!is_null($download_list)){
				if(count($download_list)){
					$download_message = "download";
				}
		   }
      	if($message==""){
      		$return_message = "There is nothing to copy in selected course.";
      		$this->session->set_flashdata('flash_failure_message', $return_message);
      	}else if($message=="subjective questions" or $message=="objective questions"){
      		if($status=="1"){
      			$return_message = "Overwrited successfully";
      		}else{
      			$return_message = "Copied successfully";
      		}      		
      		$this->session->set_flashdata('flash_success_message', $return_message);
      	}else{
      		if($status=="1"){
      			$return_message = "Overwrited till ".$message.".";
      		}else{
      			$return_message = "Copied till ".$message.".";
      		}      		
      		$this->session->set_flashdata('flash_success_message', $return_message);
      	}      	
      	
				
      
   }
   /*for checking name exist or not --Simiyon--*/
   public function check_name_duplicate($course,$class,$subject,$chapter='',$level='',$set='',$name=''){
	   //where array
	   $where=array('course_id'=>$course,'class_id'=>$class,'subject_id'=>$subject,'name'=>$name); 
	   $this->db->select('id');
	   if($chapter==''){
		 // $where['chapter_id']= $chapter;
			$this->db->from('chapters');
	   } else if($level==''){ 
			$where['chapter_id']= $chapter;
			//print_r($where);
			$this->db->from('levels');
	   } else if($set==''){ 
			$where['chapter_id']= $chapter;
			$where['level_id']= $level;
			$this->db->from('sets');
	   }
	   $this->db->where($where);
	   $res=$this->db->get(); 
	   return $res->num_rows();
		   
	    
	   
   }
	
}

