 <!-- Main Content -->
<div class="container-fluid">
    <div class="side-body">
		<div class="page-title"></div>
			<div class="row">
				<div class="col-xs-12">
					<div class="card custom-card">
						<div class="card-header">
							<div class="card-title">
								<div class="title">View Material</div>
							</div>
							<div class="back pull-right">
								<a title="Back" href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/downloads">Back</a>
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
                    		<?php  $attributes = array('class' => 'form-horizontal','id' => 'map_enquiry_form');				
							echo form_open('', $attributes); ?>
							<div class="form-group">
                            	<?php echo form_label('Uploaded Date : ','created',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<p class="form-control" id="created" style="border:none;"><?php echo date( ADMIN_DATE_FORMAT, strtotime($downloads['created'])); ?></p>
                                </div>
                            </div>
                            <?php if(isset($downloads['course_name'])){ ?>
                            <div class="form-group">
                            	<?php $js = 'id="course_list" class="form-control"';
									$set_course = isset($_POST['course_list'])?$_POST['course_list']: (isset($downloads['course_name']) ? $downloads['course_name'] : '');?>
                            	<?php echo form_label('Course Name : ','course_list',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<p class="form-control" id="course_list" style="border:none;"><?php echo $set_course; ?></p>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if(isset($downloads['class_name'])){ ?>
                            <div class="form-group">
                            	<?php $js = 'id="class_list" class="form-control"';
									$set_class = isset($_POST['class_list'])?$_POST['class_list']: (isset($downloads['class_name']) ? $downloads['class_name'] : '');?>
                            	<?php echo form_label('Class Name : ','class_list',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<p class="form-control" id="class_list" style="border:none;"><?php echo $set_class; ?></p>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if(isset($downloads['subject_name'])){ ?>
                            <div class="form-group">
                            	<?php $js = 'id="subject_list" class="form-control"';
									$set_subject = isset($_POST['subject_list'])?$_POST['subject_list']: (isset($downloads['subject_name']) ? $downloads['subject_name'] : '');?>
                            	<?php echo form_label('Subject Name : ','subject_list',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<p class="form-control" id="subject_list" style="border:none;"><?php echo $set_subject; ?></p>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="form-group">
                            	<?php echo form_label('Download Name : ','name',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<p class="form-control" id="name" style="border:none;"><?php echo $downloads['download_name']; ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                            	<?php echo form_label('Attachments: ','attachment',array('class'=>'col-sm-2 control-label')); ?>
                             <div class="col-sm-4">
                                     <?php foreach($attachments as $attach) { 
                                        echo $attach->attachment_name;
                                        ?>
                                <?php $attach_src = base_url().'appdata/attachments/' .$attach->attachment; ?>
									<a href="<?php echo $attach_src; ?>" target="_blank"><p class="form-control" id="attachment" style="border:none;"><u><?php echo $attach->attachment; ?></u></p></a>
                                 <?php } ?>
                             </div>
                            </div>
                            <div class="form-group">
                            	<?php echo form_label('Status : ','status',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<p class="form-control" id="status" style="border:none;">
									<?php if(($downloads['uploaded_by'] == 0 && $downloads['status'] == 1) || ($downloads['uploaded_by'] == 1 && $downloads['status'] == 1)){
										echo "Approved "; 
									}else{
										echo "Not Approved";
									}?>
									</p>
                                </div>
                            </div>
                            <div class="form-group">
                            	<?php echo form_label('Uploaded By : ','uploaded_by',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<p class="form-control" id="uploaded_by" style="border:none;">
									<?php if($downloads['uploaded_by'] == 0){
										echo "Admin"; 
									}else{
										echo "User(<a href='".SITE_URL().SITE_ADMIN_URI."/user_reports/view/".$downloads['user_id']."' target='_blank'><u>".$downloads['username']."</u></a>)";
									}?>
									</p>
                                </div>
                            </div>
                            <?php if($uploaded_id == 1){ ?>                             
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                	<a title="Edit" href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/downloads/edit/<?php echo $downloads['id'];?>?from=view_and_approve" class="btn btn-default">Edit</a>
                                	<?php $status_name = ($downloads['status']==0) ? 'Approve' : 'Disapprove'; ?> 
                                    <a title="<?php echo $status_name;?>" href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/downloads/approve/<?php echo $downloads['id']; ?>/<?php echo $downloads['status']; ?>" class="btn btn-default"><?php echo $status_name; ?></a>
                                </div>
                            </div>
                            <?php } ?>
						<?php echo form_close();  ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


