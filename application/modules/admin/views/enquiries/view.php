 <!-- Main Content -->
<div class="container-fluid">
    <div class="side-body">
		<div class="page-title"></div>
			<div class="row">
				<div class="col-xs-12">
					<div class="card custom-card">
						<div class="card-header">
							<div class="card-title">
								<div class="title"><?php echo $this->lang->line('viewenquiries');  ?></div>
							</div>
							<div class="back pull-right">
								<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/enquiries" title="Back">Back</a>
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
                            	<?php echo form_label('Enquiry Date : ','created',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<p class="form-control" id="created" style="border:none;"><?php echo date( ADMIN_DATE_FORMAT, strtotime($enquiries['created'])); ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                            	<?php echo form_label('Name : ','name',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<p class="form-control" id="name" style="border:none;"><?php echo $enquiries['first_name'].' '.$enquiries['last_name']; ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                            	<?php echo form_label('Email : ','email',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<p class="form-control" id="email" style="border:none;"><a style="text-decoration:underline" href="mailto:<?php echo $enquiries['email']; ?>?Subject=E4U-Admin Reply"><?php echo $enquiries['email']; ?></a></p>
                                </div>
                            </div>
                            <div class="form-group">
                            	<?php echo form_label('Phone : ','phone',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-4">
									<p class="form-control" id="phone" style="border:none;"><?php echo $enquiries['phone']; ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                            	<?php echo form_label('Comments : ','comments',array('class'=>'col-sm-2 control-label')); ?>
                                <div class="col-sm-10">
												<p class="form-control" id="comments" style="   border: medium none;height: auto;">
												<?php echo nl2br($enquiries['message']); ?></p><br>
                                </div>
                            </div>
                            
						<?php echo form_close();  ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


