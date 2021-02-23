 <!-- Main Content -->
<div class="container-fluid">
    <div class="side-body">
	<div class="page-title"></div>
		<div class="row">
			<div class="col-xs-12">
				<div class="card custom-card">
					<div class="card-header">
						<div class="card-title">
							<div class="title"><?php echo $this->lang->line('add_offline_subscription');  ?></div>
						</div>
						<div class="back pull-right">
							<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/offline_subscription" title="Back">Back</a>
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
                		<?php $attributes = array('class' => 'form-horizontal','id' => 'offline_subscription');				
						echo form_open('', $attributes); ?>
                        <div class="form-group">
                    		<?php echo form_label('User <span class="required">*</span>','name',array('class'=>'col-sm-2 control-label')); ?>
                        	<div class="col-sm-4">
                        		<input type="text" name="user_key" id="user_key" class="form-control" autocomplete="off" value="<?php echo isset($_POST['user_key'])?$_POST['user_key']:'Select';?>"/>
								<?php $js = 'id="user_name" class="form-control" style="display:none" multiple="multiple"';
								echo form_dropdown('user_name', $get_users, isset($_POST['user_name'])?$_POST['user_name']:'', $js);
								?>
								<input type="hidden" name="user_key_hidden" id="user_key_hidden"/>
								<?php
       							if(form_error('user_name')) echo form_label(form_error('user_name'), 'user_name', array("id"=>"user_name-error" , "class"=>"error")); ?>
                         	</div>
                        </div>
					<!-- 	<div class="form-group">
                    		<?php //echo form_label('Course Category <span class="required">*</span>','name',array('class'=>'col-sm-2 control-label')); ?>
                        	<div class="col-sm-4">
								<?php //$js = 'id="course_cat" class="form-control"';
								//echo form_dropdown('course_category', $course_category, isset($_POST['course_category'])?$_POST['course_category']:'', $js);
       							//if(form_error('course_category')) echo form_label(form_error('course_category'), 'course_category', array("id"=>"course_category-error" , "class"=>"error")); ?>
                         	</div>
                        </div> -->
						<div class="form-group">
                    		<?php echo form_label('Course <span class="required">*</span>','name',array('class'=>'col-sm-2 control-label')); ?>
                        	<div class="col-sm-4">
								<?php $js = 'id="course" class="form-control" style="margin-bottom:5px"';
								echo form_dropdown('course', $course, isset($_POST['course'])?$_POST['course']:'', $js);?>
								<!-- <small>Note : Purchased courses will not displayed.</small> -->
       							<?php if(form_error('course')) echo form_label(form_error('course'), 'course', array("id"=>"course-error" , "class"=>"error")); ?>
                         	</div>
                         	<div class="course_detail" style="display:none" id="course_detail">
							       	<ul style="list-style:none;" >
									   	<!--li style="float:left;margin-right:30px">
												<p id="cprice"><b>Price : </b><i class="fa fa-rupee"></i> <span></span></p>
											</li-->
											<li style="float:left;margin-right:30px">
												<p id="cduration"><b>Duration : </b><span></span> month(s)</p></li>
											<li style="float:left;margin-right:30px">
												<p id="cexpiry"><b>Expiry Date : </b><span></span></p>
											</li>
										</ul>
                         	</div>
                        </div>
                        <div class="form-group" id="price"  style="display:none">
                        	<?php echo form_label('Price <span class="required">*</span>','',array('class'=>'col-sm-2 control-label')); ?>
                           <div class="col-sm-8 topspace">
										<?php echo form_radio('price', '1','','class="align_radio" id="active"'); ?> 
										<?php echo form_label('','active',array('class'=>'align_label')); ?>
										<?php echo form_radio('price', '0','','class="align_radio" id="inactive"'); ?> 
										<?php echo form_label('','inactive',array('class'=>'align_label')); ?>
                           </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default" id="privil_btn" title="Save" style="margin-right:10px;">Save</button>
                                <a title="Cancel" href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/offline_subscription" class="btn btn-default" > Cancel</a>	
                            </div>
                        </div>
						<?php echo form_close();  ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    $( "#user_key" ).keyup(function(){
    	var keyword = $("#user_key").val();
    	alert(keyword);
       //source: base_url+"admin/offline_subscription/search",
      // minLength: 2
    });
 });
</script> 
