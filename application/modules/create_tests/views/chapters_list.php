<div class="col-md-6">
  <ul class="unstyled centered">
   <?php foreach($chapters as $subject_key => $first_array){ 
    // print_r($chapters);die;
   	?>
   	
   	<b><?php echo $subjects[$subject_key];?></b>
      <?php foreach($first_array as $key => $value){ 
   	?>
    <li class="chapters">
      <input class="styled-checkbox checkbox-<?php echo "chapter".$key;?>" id="styled-checkbox-<?php echo "chapter".$key;?>" type="checkbox"  name="chapters_list[]"  value="<?php echo $key;?>"  <?php if(in_array($key, $sel_chapters)){ echo "checked";}?> data-subject_id="<?php echo $subject_key;?>">
      <label for="styled-checkbox-<?php echo "chapter".$key;?>" class="<?php echo "chapter".$key;?>"><?php echo $value;?> <i class="fa fa-close sub_remove" data-chapter_id="<?php echo $key;?>"></i> </label>
    </li>
 <?php } ?>

   <?php } ?>
  </ul>  
</div>