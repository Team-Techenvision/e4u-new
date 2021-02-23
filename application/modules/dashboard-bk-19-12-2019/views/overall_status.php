<div class="overall-stats">
	<div class="wrapper">		
		<?php if($recive_course==""&& $page=="index"): ?>
		<div class="dashboard-course-list ">
			<h2>
				<div class="dashboard-course-menu">
					<div class="menu-icon collapse"> <span class="bar child1"></span> <span class="bar child2"></span> <span class="bar child3"></span> </div>
					<label>
					<?php if(count($data_course["course_arr"])>=2){
								foreach($data_course["course_arr"] as $id=>$name){
									if($id!=""){
										echo $name." Course";
										break;
									}
								}
							}						
					?>
					</label>
				</div>
			</h2>
			<ul id="course">

			<?php 	$i=0;
						foreach($data_course["course_arr"] as $id=>$name){
						if($id!="" and $i==1 ){ ?>
							<li id="<?php echo $id; ?>"><a class="active" href="<?php echo base_url()."dashboard/overall_status/".$id; ?>"><?php echo $name; ?> Course </a></li>
			<?php		}elseif($id !=""){ ?>
						<li id="<?php echo $id; ?>"><a href="<?php echo base_url()."dashboard/overall_status/".$id; ?>"><?php echo $name; ?> Course </a></li>
			<?php		} $i++;
					} ?>
			</ul>			
		</div>
		<?php endif; ?>
	</div>
</div>
<div class="overall">
<!--added-->
<div class="wrapper">
	<div class="overall-stats">
		<div class="overall-performance-content">
			<div class="overall-state-inner">
				<div class="overall-inner-selectbox select-box">
					<?php	$option = array(); 
							foreach($data_course["class_arr"] as $id=>$name){ 
								$option[$id] = $name;
							} ?>
					<?php echo form_dropdown("class",$option,$filter_type,"id='class'");?>
					<?php $url = base_url()."dashboard/overall_status/";?>
				</div>
				<div class="questioans-attemped">		
					<?php 
							$total_answer_count = 0;
							$total_question_count = 0;
							$answer = array();
							$question = array();
							foreach($answer_list as $ans){
								$answer[$ans["subject_name"]] = $ans["answer_count"];
								$total_answer_count +=	$ans["answer_count"];								
							}
							foreach($question_list as $ques){
								$question[$ques["subject_name"]] = $ques["question_count"];
								$total_question_count +=	$ques["question_count"];
							}	
 							
					?>							
					<h3>Questions Performance</h3>
					<ul>
						<?php foreach($answer as $key=>$value){?>
						<li>
							<h4>Overall Marks Stats <span><?php echo $key; ?></span></h4>
							<label><?php echo floor(($answer[$key]/$question[$key])*100);?></label>
						</li>	
						<?php }	?>												
					</ul>
				</div>
				<div class="marks-percentage">
					<div class="percentage-div accuracy">
					<?php $accuracy= floor(($total_answer_count/$total_question_count)*100);?>
						<h4><?php echo $accuracy ?><small>%</small></h4>
						<span>Accuracy</span>
						<div class="percentage"><div class="percentage-obtained" style="width:<?php echo $accuracy ?>%;"></div></div>
					</div>
					<?php $question_count = 0;
								$seconds_count = 0;								
								foreach($question_list as $ques){
									$question_count += $ques["question_count"];
									$seconds_count += $ques["diff"];
								} 								
								$minutes = $seconds_count/60;
								if($minutes>60){
									$hrs = $minutes/60;
								}else{
									$hrs = 1;
								}								
								$average_speed = $question_count/$hrs;
						?>
					<div class="percentage-div avg-speed">						
						<h4><?php echo $act_speed=$average_speed*60/100; ?><small>%</small></h4>
						<span>Average Speed</span>
						<div class="percentage"><div class="percentage-obtained" style="width:<?php echo $act_speed ?>%;"></div></div>
					</div>
					<div class="percentage-div goal-cleared">		
						<h4><?php echo $goals_cleared=floor(($completed_chapters[0]["completed_chapters"]/$total_chapters[0]["total_chapters"])*100);?><small>%</small></h4>
						<span>Goals Cleared</span>
						<div class="percentage"><div class="percentage-obtained" style="width:<?php echo $goals_cleared ?>%;"></div></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="test-result-section clearfix">
	<div class="wrapper">
		<div class="test-type-section clearfix">
			<ul class="test-list">
				<li id="pt"><a href="javascript:void(0)" title="Practice Test" class="active">Practice Test</a></li>
				<li id="pgt"><a href="javascript:void(0)" title="Progress Test">Progress Test</a></li>				
			</ul>
			<div class="subject-selectbox">							
				<span class="subject-dropdown"><span><?php echo $subjects[0]['name']; ?></span></span>
				<ul class="subject-dropdown-list">
					<?php $i=1; foreach($subjects as $subject){ ?>
						<li><a class="<?php echo ($i==1?"active":""); ?>" href="<?php echo $subject['id'];?>" title="<?php echo $subject['name'];?>"><span><?php echo $subject['name'];?></span></a></li>
					<?php $i++;	} ?>
					 
				</ul>
			</div>
		</div>
		
		<div class="dashboard-result-graph">
	<div id="preloader2" class="pre-loader"></div>
	<?php			
		$data["chart"]=$chart;
		$data["levels"]=$levels;
		$this->load->view('dashboard/performance_graph',$data);								
	?>
 </div>
