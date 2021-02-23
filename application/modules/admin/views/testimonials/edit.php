 <!-- Main Content -->
<div class="container-fluid">
    <div class="side-body">
		<div class="page-title"></div>
			<div class="row">
				<div class="col-xs-12">
					<div class="card custom-card">
						<div class="card-header">
							<div class="card-title">
								<div class="title"><?php echo $this->lang->line('edittestimonials');  ?></div>
							</div>
							<div class="back pull-right">
								<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/testimonials" title="Back">Back</a>
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
                    		<?php  $attributes = array('class' => 'form-horizontal','id' => 'map_faq_form');				
							echo form_open_multipart('', $attributes); ?>
                            <div class="form-group">
                            	<?php echo form_label('Client Name <span class="required">*</span>','name',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-8">
									<?php echo form_input('name', isset($_POST['name'])?$_POST['name']: (isset($testimonials['user_name']) ? $testimonials['user_name'] : '')  ,'placeholder= "Name" class="form-control" id="name"'); 
		               				if(form_error('name')) echo form_label(form_error('name'), 'name', array("id"=>"name-error" , "class"=>"error")); ?>
                                </div>
                            </div>
                             <div class="form-group">
                            	<?php echo form_label('About Client <span class="required">*</span>','name',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-8">
									<?php echo form_input('about_client', isset($_POST['about_client'])?$_POST['about_client']: (isset($testimonials['about_client']) ? $testimonials['about_client'] : '')  ,'placeholder= "About client" class="form-control" id="about_client"'); 
		               				if(form_error('about_client')) echo form_label(form_error('about_client'), 'about_client', array("id"=>"about_client-error" , "class"=>"error")); ?>
                                </div>
                            </div>

                             <div class="form-group">
                            	<?php echo form_label('Testimonial <span class="required">*</span>','description',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-8">
                                	<?php $description =" ";
                                	if(isset($_POST['description'])) { $description = htmlspecialchars_decode($_POST['description']); }
                                	      if(isset($testimonials['user_description'])) { $description = htmlspecialchars_decode($testimonials['user_description']);} ?>
													<?php
														$data = array(
															'name'        => 'description',
															'id'          => 'description',
															'value'       => $description,
															// 'rows'        => '3',
															'placeholder' => "Testimonial",
															'class'       => 'form-control'
														);
														echo form_textarea($data);
													?>


									<?php //echo form_textarea('description', isset($_POST['description'])?htmlspecialchars_decode($_POST['description']): (isset($testimonials['user_description']) ? htmlspecialchars_decode($testimonials['user_description']) : '')  ,'placeholder= "Description" class="form-control" id="description"'); 
		               				if(form_error('description')) echo form_label(form_error('description'), 'description', array("id"=>"description-error" , "class"=>"error")); ?>
                                </div>
                            </div>
                            <input type="hidden" value="<?php echo $testimonials['user_image']; ?>" name="testi_image_hidden"/>
							<div class="form-group">
                            	<?php echo form_label('Image <span class="required">*</span>','testi_image',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<?php 
									echo form_upload(array('id' => 'testi_image', 'name' => 'testi_image', 'class' => 'testi-image-upload')); ?><small style="display:block">Allowed Types: gif,jpg,jpeg,png | Min:70*70 px|Max:100*100 px</small> 
									<?php
                   					if(form_error('testi_image')) echo form_label(form_error('testi_image'), 'testi_image', array("id"=>"testi-image-error" , "class"=>"error")); ?>
                   					<?php if(isset($upload_error['error'])) { echo  form_label($upload_error['error'],'upload-error',array('class'=>'error'));  } ?>
                   					<?php 
									
                                    if($testimonials['user_image'] != ''){
										$img_src = thumb($this->config->item('testi_img') .$testimonials['user_image'] ,'75', '75', 'thumb_testi_img',$maintain_ratio = TRUE);
		                                $img_prp = array('style'=>'clear: left;float: left;margin-top: 10px;', 'src' => base_url() . 'appdata/testimonials/thumb_testi_img/'.$img_src, 'alt' => $testimonials['user_image'], 'title' => $testimonials['user_image']);
                                     	echo img($img_prp);
                                     }else{
                                     	$no_img = array('style'=>'clear: left;float: left;margin-top: 10px;', 'src' => base_url() . 'appdata/thumb/student_avatar/100x100/no-image.png', 'alt' => "No Image", 'title' => "No Image");
                                        echo img($no_img);
                                     }
								    ?>
                                </div>
							</div>
			 				<div class="form-group">
                            	<?php echo form_label('Status <span class="required">*</span>','',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-8 topspace">
		                            <?php if($testimonials['status'] ==1){?>
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


