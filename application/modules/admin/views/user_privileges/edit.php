 <!-- Main Content -->
<div class="container-fluid">
    <div class="side-body">
		<div class="page-title"></div>
			<div class="row">
				<div class="col-xs-12">
					<div class="card custom-card">
						<div class="card-header">
							<div class="card-title">
								<div class="title"><?php echo $this->lang->line('edituserprivileges');  ?></div>
							</div>
							<div class="back pull-right">
								<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/user_privileges" title="Back">Back</a>
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
								<?php echo form_label('Display Name <span class="required">*</span>','dname',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
								<?php echo form_input('dname', isset($_POST['dname'])?$_POST['dname']: (isset($users['display_name']) ? $users['display_name'] : '') ,'placeholder="Display Name" class="form-control" id="dname"'); 
								if(form_error('dname')) echo form_label(form_error('dname'), 'dname', array("id"=>"dname-error" , "class"=>"error")); ?>
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
                            	<?php echo form_label('Phone Number <span class="required">*</span>','phone',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<?php echo form_input('phone',isset($_POST['phone'])?$_POST['phone']: (isset($users['phone_number']) ? $users['phone_number'] : ''),'placeholder= "Phone Number" class="form-control" id="phone"'); 
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
							<div class="form-group">
                            	<?php echo form_label('User Name <span class="required">*</span>','uname',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<?php echo form_input('uname',isset($_POST['uname'])?$_POST['uname']: (isset($users['username']) ? $users['username'] : ''),'placeholder= "User Name" class="form-control" id="fname"'); 
                   					if(form_error('uname')) echo form_label(form_error('uname'), 'uname', array("id"=>"uname-error" , "class"=>"error")); ?>
                                </div>
							</div>
							<div class="form-group">
								<?php echo form_label('Password','password',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php echo form_password('password', set_value('password') ,'placeholder="Password" class="form-control" id="password"'); 
									if(form_error('password')) echo form_label(form_error('password'), 'password', array("id"=>"password-error" , "class"=>"error")); ?>
								</div>
							</div>
							<div class="form-group">
								<?php echo form_label('Confirm Password','confirm_password',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php echo form_password('confirm_password', set_value('confirm_password'),'placeholder="Confirm Password" class="form-control" id="confirm_password"');
									if(form_error('confirm_password')) echo form_label(form_error('confirm_password'), 'confirm_password', array("id"=>"confirm_password-error" , "class"=>"error"));  ?>
								</div>
							</div>
							<legend><?php echo form_label('Privileges','name');?></legend>
							<!--<?php if($users['privileges'] == "")
							{
								$all_checked = "";
							}
							else
							{
								$all_checked = "checked";
							}?>
							<?php echo form_checkbox(array('id'=>'privil_all','name'=>'privil_all','checked'=>$all_checked,'value'=>'all')); ?>
							<?php echo form_label('All Privileges','name');?>-->
							<div class="form-group">
								<div class="col-sm-4">	
								<?php //print_r(explode(",",$users['privileges']));?>
									<?php 
										$i=0;
										$j = 1;
										$len = count($modules)/2;
										$user_ex_priv=explode(",",$users['privileges']);
										foreach($modules as $key => $value){ ?>
										<?php if(in_array($value['id'],$user_ex_priv))
										{
											$main_checked = count($_POST)>0?set_checkbox('main_all', $value['id']):TRUE;
										}
										else
										{
											$main_checked = count($_POST)>0?set_checkbox('main_all', $value['id']):FALSE;
										}
										?>
										<!--<?php echo form_checkbox(array('id'=>'parent','class'=>'js-privil-all parent','name'=>'main_all[]','checked'=>$main_checked,'value'=>$value['id'])); ?>-->
										
										<?php echo form_checkbox("main_all[]",$value['id'],$main_checked,"id='parent' class='js-privil-all parent'");?>
										
										<!--<?php echo form_checkbox("main_all[]",$value['id'],$main_checked,"id='parent' class='js-privil-all parent'");?>-->
										<?php echo form_label($value['page_name']);?>
										<ul class="sub_modules" style="list-style:none;">
											<?php 
											foreach($sub_modules[$i] as $keys => $values){ ?>
											<?php if(in_array($values['id'],$user_ex_priv))
										{
											$sub_checked = count($_POST)>0?set_checkbox('main_all', $values['id']):TRUE;
										}
										else
										{
											$sub_checked = count($_POST)>0?set_checkbox('main_all', $values['id']):FALSE;
										}?>
											<li>
											<!--<?php echo form_checkbox(array('id'=>'sub_all','name'=>'main_all[]','checked'=>$sub_checked,'value'=>$values['id'],'class'=>'js-privil-all js_sub_all_'.$value['id'])); ?>-->
											<?php echo form_checkbox("main_all[]",$values['id'],$sub_checked,"id='sub_all' class='js-privil-all js_sub_all_".$value['id']."'");?>
											<label style="font-weight:500!important;"><?php echo $values['page_name'];?></label>
											<li>
											<?php } ?>
										</ul>
										<?php if($j == round($len)){?>
									</div>
									<div class="col-sm-2"></div>
									<div class="col-sm-4">
									<?php } ?>
									<?php $i++;$j++; } ?>
								</div>
							</div>
							<input type="hidden" name="checkbox_error" id="checkbox_error" value=""/>
							<?php if(form_error('checkbox_error')) echo form_label(form_error('checkbox_error'), 'checkbox_error', array("id"=>"checkbox_error-error" , "class"=>"error"));  ?>
							<legend></legend>
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


