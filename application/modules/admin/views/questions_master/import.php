 <!-- Main Content -->
<div class="container-fluid">
    <div class="side-body">
        <div class="page-title">
            <!--<span class="title">Sections</span>
            <div class="description">with jquery Datatable for display data with most usage functional. such as search, ajax loading, pagination, etc.</div> -->
        </div>
         <div class="row">
            <div class="col-xs-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            <div class="title">Import</div>
                        </div>
                        <div class="back pull-right">
							<a href="<?php echo SITE_URL().SITE_ADMIN_URI;?>/questions" title="Back">Back</a>
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
								 <div class="back pull-right">
							<a href="<?php echo base_url(); ?>appdata/csv/import_questions_format.csv" title="Download Format">Download Format</a>
						</div>
                    		<?php  $attributes = array('class' => 'form-horizontal','id' => 'questions_form');				
								echo form_open_multipart('', $attributes); ?>
                            
							<div class="form-group">
								<?php echo form_label('Course <span class="required">*</span>','',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<?php
									
									$js = 'id="course_list" class="form-control"';
									echo form_dropdown('course_list', $course_list, set_value('course_list'), $js);
									if(form_error('course_list')) echo form_label(form_error('course_list'), 'course_list', array("id"=>"course_list-error" , "class"=>"error")); ?>
								</div>
							</div>
							<div class="form-group">
								<?php echo form_label('Import Csv File <span class="required">*</span>','',array('class'=>'col-sm-2 control-label')); ?>
								<div class="col-sm-4">
									<input class="form-control" id="exampleInputFile" name="questions_csv" type="file">
								</div>
							</div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-default" title="Import">Import</button>
                                </div>
                            </div>
								<?php echo form_close();  ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


