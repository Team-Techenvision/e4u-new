 <!-- Main Content -->
<div class="container-fluid">
    <div class="side-body">
		<div class="page-title"></div>
			<div class="row">
				<div class="col-xs-12">
					<div class="card custom-card">
						<div class="card-header">
							<div class="card-title">
								<div class="title"><?php echo $this->lang->line('editusers');  ?></div>
							</div>
							<div class="back pull-right">
								<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/users" title="Back">Back</a>
							</div>
						</div>
                    	<div class="card-body">
                    		<!-- Flash Message -->
							<?php if($this->session->flashdata('flash_failure_message')){ ?>
							 <div class="alert alert-danger" role="alert">
								 <strong>Warning!</strong> <?php echo $this->session->flashdata('flash_failure_message'); ?>
								 <?php $this->session->unmark_flash('flash_failure_message'); ?>
							</div> 
							<?php } if($this->session->flashdata('flash_success_message')){ ?>
							 <div class="alert alert-success" role="alert">
								 <strong>Done!</strong> <?php echo $this->session->flashdata('flash_success_message'); ?>
								 <?php $this->session->unmark_flash('flash_success_message'); ?>
							</div> 
							<?php } ?>
                    		<?php  $attributes = array('class' => 'form-horizontal','id' => 'map_teacher_form');				
							echo form_open('', $attributes); ?>
                      		<div class="form-group">
                            	<?php echo form_label('First Name <span class="required">*</span>','fname',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<?php echo form_input('fname',isset($_POST['fname'])?$_POST['fname']: (isset($users['first_name']) ? $users['first_name'] : ''),'placeholder= "First Name" class="form-control" id="fname"'); 
                   					if(form_error('fname')) echo form_label(form_error('fname'), 'fname', array("id"=>"fname-error" , "class"=>"error")); ?>
                                </div>
							</div>
							<div class="form-group">
                            	<?php echo form_label('Last Name <span class="required">*</span>','lname',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<?php echo form_input('lname',isset($_POST['lname'])?$_POST['lname']: (isset($users['last_name']) ? $users['last_name'] : ''),'placeholder= "Last Name" class="form-control" id="lname"');
									if(form_error('lname')) echo form_label(form_error('lname'), 'lname', array("id"=>"lname-error" , "class"=>"error")); ?>
                                </div>
							</div>
							<div class="form-group">
                            	<?php echo form_label('Email ID <span class="required">*</span>','email',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<?php echo form_input('email',isset($_POST['email'])?$_POST['email']: (isset($users['email']) ? $users['email'] : ''),'placeholder= "example@gmail.com" class="form-control" id="email"'); 
                   					if(form_error('email')) echo form_label(form_error('email'), 'email', array("id"=>"email-error" , "class"=>"error")); ?>
                                </div>
							</div>

              <div class="form-group">
                        <?php echo form_label('Gender <span class="required">*</span>','',array('class'=>'col-sm-2 control-label')); ?>
                        <div class="col-sm-10 topspace">
                        <?php 
                          $m = isset($_POST["gender"])?(($_POST["gender"]=="1")?'TRUE':''):(isset($users['gender']) && ($users["gender"]=="1") )?'TRUE':'';
                          $fm = isset($_POST["gender"])?(($_POST["gender"]=="2")?'TRUE':''):(isset($users['gender']) && ($users["gender"]=="2") )?'TRUE':'';
                        ?>
                          <?php echo form_radio('gender', '1',$m,'class="align_radio" id="male"'); ?> 
                  <?php echo form_label('Male','male',array('class'=>'align_label')); ?>
                  <?php echo form_radio('gender', '2',$fm,'class="align_radio" id="female"'); ?> 
                  <?php echo form_label('Female','female',array('class'=>'align_label')); ?>
                </div>
                     </div>

                     
							<div class="form-group">
                            	<?php echo form_label('Date of Birth <span class="required">*</span>','dob',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-1">
									<?php $date_class[''] = "Date";
									 $selected_date = isset($_POST['dob_date'])?$_POST['dob_date']: (isset($users['dob_date']) ? $users['dob_date'] : '');
									echo form_dropdown('dob_date',$date_class, '' ,'id="days"  class="form-control" ');
											if(form_error('dob_date')) echo form_label(form_error('dob_date'), 'dob_date', array("id"=>"dob_date-error" , "class"=>"error")); ?>
                                </div>
                                <div class="col-sm-1">
									<?php $month[''] = "Month";
									$selected_month = isset($_POST['dob_month'])?$_POST['dob_month']: (isset($users['dob_month']) ? $users['dob_month'] : '');
									echo form_dropdown('dob_month',$month,'','id="months" class="form-control" ');
											if(form_error('dob_month')) echo form_label(form_error('dob_month'), 'dob_month', array("id"=>"dob_month-error" , "class"=>"error")); ?>
                                </div>
                                <div class="col-sm-1">
									<?php $year[''] = "Year";
									$selected_year = isset($_POST['dob_year'])?$_POST['dob_year']: (isset($users['dob_year']) ? $users['dob_year'] : '');
									echo form_dropdown('dob_year',$year, '','id="years" class="form-control"');
											if(form_error('dob_year')) echo form_label(form_error('dob_year'), 'dob_year', array("id"=>"dob_year-error" , "class"=>"error")); ?>
                                </div>

                             <!-- 
                                 <select class="form-control" id="days"></select>
                                 <select class="form-control" id="months"></select>
                                 <select class="form-control" id="years"></select>
                           		<script>
						         in index.js
						      	</script>
 								-->

							</div>


							<div class="form-group">
                            	<?php echo form_label('Class Studying <span class="required">*</span>','class_studying_id',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<?php $set_class = isset($_POST['class_studying_id'])?$_POST['class_studying_id']: (isset($users['class_id']) ? $users['class_id'] : '');
									echo form_dropdown('class_studying_id',$get_class,$set_class,'id="class_studying_id" class="form-control"'); 
									if(form_error('class_studying_id')) echo form_label(form_error('class_studying_id'), 'class_studying_id', array("id"=>"class_studying_id-error" , "class"=>"error"));?>
                                </div>
							</div>
						<!-- 	<div class="form-group">
                            	<?php //echo form_label('Medium <span class="required">*</span>','medium',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
                                	 <?php //$set_medium = isset($_POST['medium'])?$_POST['medium']: (isset($users['medium_id']) ? $users['medium_id'] : '');
									// echo form_dropdown('medium',$get_medium,$set_medium,'id="medium" class="form-control"'); 
                   					//if(form_error('medium')) echo form_label(form_error('medium'), 'medium', array("id"=>"medium-error" , "class"=>"error")); ?>
                                </div>
							</div>
							<div class="form-group">
                            	<?php //echo form_label('Study Board <span class="required">*</span>','board',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<?php //$set_board = isset($_POST['board'])?$_POST['board']: (isset($users['board']) ? $users['board'] : '');
									//echo form_dropdown('board',$get_board,$set_board,'id="board" class="form-control"');
									//if(form_error('board')) echo form_label(form_error('board'), 'board', array("id"=>"board-error" , "class"=>"error")); ?>
                                </div>
							</div> -->
							<div class="form-group">
                            	<?php echo form_label('Phone Number <span class="required">*</span>','phone',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<?php echo form_input('phone',isset($_POST['phone'])?$_POST['phone']: (isset($users['phone']) ? $users['phone'] : ''),'placeholder= "Phone Number" class="form-control" id="phone"'); 
                   					if(form_error('phone')) echo form_label(form_error('phone'), 'phone', array("id"=>"phone-error" , "class"=>"error")); ?>
                                </div>
							</div>
							<div class="form-group">
                            	<?php echo form_label('Address <span class="required">*</span>','address',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<?php echo form_textarea('address',isset($_POST['address'])?$_POST['address']: (isset($users['address']) ? $users['address'] : ''),'class="form-control" id="address"'); 
                   					if(form_error('address')) echo form_label(form_error('address'), 'address', array("id"=>"address-error" , "class"=>"error")); ?>
                                </div>
							</div>
						<!-- 	<div class="form-group">
                      	<?php //echo form_label('Gender <span class="required">*</span>','',array('class'=>'col-sm-2 control-label')); ?>
                        <div class="col-sm-10 topspace">
                        <?php 
                        	//$m = isset($_POST["gender"])?(($_POST["gender"]=="1")?'TRUE':''):(isset($users['gender']) && ($users["gender"]=="1") )?'TRUE':'';
                        	//$fm = isset($_POST["gender"])?(($_POST["gender"]=="2")?'TRUE':''):(isset($users['gender']) && ($users["gender"]=="2") )?'TRUE':'';
                        ?>
                        	<?php //echo form_radio('gender', '1',$m,'class="align_radio" id="male"'); ?> 
									<?php //echo form_label('Male','male',array('class'=>'align_label')); ?>
									<?php //echo form_radio('gender', '2',$fm,'class="align_radio" id="female"'); ?> 
									<?php //echo form_label('Female','female',array('class'=>'align_label')); ?>
								</div>
                     </div> -->
			 				<div class="form-group">
                            	<?php echo form_label('Status <span class="required">*</span>','',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-10 topspace">
		                            <?php if($users['status'] ==1){?>
										<?php echo form_radio('status', '1',TRUE,'class="align_radio" id="active"'); ?> 
										<?php echo form_label('Active','active',array('class'=>'align_label')); ?>
										<?php echo form_radio('status', '0','','class="align_radio" id="inactive"'); ?> 
										<?php echo form_label('Inactive','inactive',array('class'=>'align_label')); ?>
									<?php }else{?>
									<?php echo form_radio('status', '1','','class="align_radio" id="active"'); ?> 
										<?php echo form_label('Active','active',array('class'=>'align_label')); ?>
										<?php echo form_radio('status', '0',TRUE,'class="align_radio" id="inactive"'); ?> 
										<?php echo form_label('Inactive','inactive',array('class'=>'align_label')); ?>
									<?php } ?>
                                 </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-default" title="Save">Save</button>
                                </div>
                            </div>
						<?php echo form_close();  ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url().'assets/themes/js/jquery.min.js'; ?>"></script>
<script type="text/javascript">
/* Data od Birth Script starts here */
           var monthNames = [ "January", "February", "March", "April", "May", "June",
           "July", "August", "September", "October", "November", "December" ];
         
         for (i = new Date().getFullYear(); i > 1900; i--){
           $('#years').append($('<option />').val(i).html(i));
         }
           
         for (i = 1; i < 13; i++){
           $('#months').append($('<option />').val(i).html(i));
         }
         updateNumberOfDays(); 
           
         $('#years, #months').on("change", function(){
           //updateNumberOfDays(); 
         });
         function updateNumberOfDays(){
           month=$('#months').val();
           year=$('#years').val();
           days=daysInMonth(month, year);
         
           for(i=1; i < days+1 ; i++){
                   $('#days').append($('<option />').val(i).html(i));
           }
           $('#message').html(monthNames[month-1]+" in the year "+year+" has <b>"+days+"</b> days");
         }
         
         function daysInMonth(month, year) {
           return new Date(year, month, 0).getDate();
         }
         /* End of Date of Birth */
          var date = <?php echo $selected_date;?> ;
          var month = <?php echo $selected_month;?> ;
          var year = <?php echo $selected_year;?> ;
          $('#days').val(date)
          $('#months').val(month)
          $('#years').val(year)

               
</script>

