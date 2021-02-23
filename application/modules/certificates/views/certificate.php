<!doctype html>
<html lang="en">
 <head>
  <title>e4u - Certificate</title>
  <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'> 
 </head>
 <body>
	<table cellpadding="0" cellspacing="0" border="0" width="100%" align="">
		<tr>
			<td align="">
				<table cellpadding="0" cellspacing="0" border="0" style="width:100%;background:url(<?php echo base_url().'assets/site/images/certificate-watermark.png' ?>) no-repeat;background-size:100% 100%; background-position:center;padding:105px 56px 76px;">
					<tr>
						<td align="center" style="padding:75px 0 40px;" valign="top">
							<h2 style="font:40px 'Montserrat',arial;font-family:Montserrat-Regular;color:#293e60;margin:0;">e4u Certification</h2>
						</td>
					</tr>
					<?php if($certificate_details['gender'] == 2){
						$title = "Ms/Mrs. ";
					}else{
						$title = "Mr. ";
					}
					?>
					<?php if($certificate_details['test_type'] == 1){ 
						$bold = $certificate_details['chapter_name']." - ".$certificate_details['subject_name'];
						$extra = "You are now through to the next level.";
						$test_name = $certificate_details['level_name']." progress test";
					} else {
						$bold = $certificate_details['course_name'];
						$test_name = "surprise test dated ".date('d-m-Y',strtotime($certificate_details['end_date']));
						$extra = "";
					}?>
					<tr>
						<td align="center" style="padding-bottom:80px;" valign="top">
							<p style="font:18px/24px 'Montserrat',arial;font-family:Montserrat-Regular;color:#303030;margin:0;line-height:24px;width:870px;">This is to certify <b><?php echo $title;?> <?php echo $certificate_details['first_name']." ".$certificate_details['last_name']; ?></b> for successfully completing the <?php echo $test_name;?> in the <?php echo $certificate_details['course_name'];?> course held at e4u with a score of <?php echo round($certificate_details['user_percent']);?>%.<?php echo $extra;?>
							</p>
						</td>
					</tr>
					<tr>
						<td align="center" style="padding-bottom:95px;" valign="top">
							<h4 style="font:28px 'Montserrat',arial;font-family:Montserrat-Regular;color:#2d2d2c;margin:0;">"<?php echo $bold;?>"</h4>
						</td>
					</tr>
					<tr>
						<td align="center" style="padding-bottom:95px;" valign="top">
							<p style="font:18px/24px 'Montserrat',arial;font-family:Montserrat-Regular;color:#2d2d2c;margin:0;">Best Wishes from e4u</p>
						</td>
					</tr>
					<tr>
						<td valign="top">
							<table cellpadding="0" cellspacing="0" border="0" width="100%" style="width:100%;">
								<tr>
									<td align="left" style="padding-left:80px;">
										<p style="font:18px 'Montserrat',arial;font-family:Montserrat-Regular;color:#293e60;margin:0 0 5px;">Issued On:</p>
										<?php $date = date('F dS, Y',strtotime($certificate_details['end_date']));?>
										<p style="font:24px 'Pacifico',arial;font-family:pacifico-regular;color:#313131;margin:0;"><?php echo $date;?></p>
									</td>
									<td align="left">
										<p style="font:18px 'Montserrat',arial;font-family:Montserrat-Regular;color:#293e60;margin:0 0 5px;">Certificate Number:</p>
										<p style="font:24px 'Montserrat',arial;font-family:Montserrat-Regular;color:#2d2d2c;margin:0;">WD-<?php echo $certificate_details['exam_code'];?></p>
									</td>
									<td align="center">
										<p style="font:30px 'Pacifico',arial;font-family:pacifico-regular;color:#209045;margin:0 0 5px;">Chairman</p>
										<p style="font:18px 'Montserrat',arial;font-family:Montserrat-Regular;color:#313131;margin:0;">Director, e4u Academy</p>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
 </body>
</html>
