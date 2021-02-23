 <!-- Main Content -->
<div class="container-fluid">
    <div class="side-body">
		<div class="page-title"></div>
			<div class="row">
				<div class="col-xs-12">
					<div class="card custom-card">
						<div class="card-header">
							<div class="card-title">
								<div class="title"><?php echo $this->lang->line('viewpurchasereports'); ?></div>
							</div>
							<div class="back pull-right">
								<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/purchase_reports" title="Back">Back</a>
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
                            	<?php echo form_label('Purchased Date : ','created',array('class'=>'col-sm-3 control-label')); ?>
                                <div class="col-sm-4">
									<p class="form-control" id="created" style="border:none;"><?php echo date( ADMIN_DATE_FORMAT, strtotime($purchase_reports['purchased_date'])); ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                            	<?php echo form_label('Course Expiry Date : ','expiry',array('class'=>'col-sm-3 control-label')); ?>
                                <div class="col-sm-4">
									<p class="form-control" id="expiry" style="border:none;"><?php echo date( ADMIN_DATE_FORMAT, strtotime($purchase_reports['course_expiry_date'])); ?></p>
                                </div>
                            </div>
                            <?php if(isset($purchase_reports['course_name'])){ ?>
                            <div class="form-group">
                            	<?php $js = 'id="course_list" class="form-control"';
									$set_course = isset($_POST['course_list'])?$_POST['course_list']: (isset($purchase_reports['course_name']) ? $purchase_reports['course_name'] : '');?>
                            	<?php echo form_label('Course Plan : ','course_list',array('class'=>'col-sm-3 control-label')); ?>
                                <div class="col-sm-4">
									<p class="form-control" id="course_list" style="border:none;"><?php echo $set_course; ?></p>
                                </div>
                            </div>
                            <?php } ?>
                         	<div class="form-group">
                            	<?php $js = 'id="user_name" class="form-control"';
									$set_name = isset($_POST['user_name'])?$_POST['user_name']: (isset($purchase_reports['user_name']) ? $purchase_reports['user_name'] : '');?>
                            	<?php echo form_label('Name : ','user_name',array('class'=>'col-sm-3 control-label')); ?>
                                <div class="col-sm-4">
									<p class="form-control" id="user_name" style="border:none;"><?php echo $set_name; ?></p>
                                </div>
                            </div>
                         	<div class="form-group">
                            	<?php $js = 'id="email" class="form-control"';
									$set_email = isset($_POST['email'])?$_POST['email']: (isset($purchase_reports['email']) ? $purchase_reports['email'] : '');?>
                            	<?php echo form_label('Email : ','email',array('class'=>'col-sm-3 control-label')); ?>
                                <div class="col-sm-4">
									<p class="form-control" id="email" style="border:none;"><?php echo $set_email; ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                            	<?php $js = 'id="price" class="form-control"';
									$set_price = isset($_POST['price'])?$_POST['price']: (isset($purchase_reports['price']) ? $purchase_reports['price'] : '');?>
                            	<?php echo form_label('Price : ','price',array('class'=>'col-sm-3 control-label')); ?>
                                <div class="col-sm-4">
									<p class="form-control" id="price" style="border:none;"><?php echo $currency." ".$set_price; ?></p>
                                </div>
                            </div>
						<?php echo form_close();  ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


