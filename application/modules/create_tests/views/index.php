<?php 
        $course_id = $course_arr['id'];
        $class_id = $class_id;
?>
<section class="create_test"> 
      <div class="container create_test_cols">
        <div class="text-center top_content">
          <h2>Create Test </h2>
          <p>Select a Minimum of 1 and Maximum of 3 Subjects for the Practice Test </p>
        </div>
  		   <div class="tabs">
          <div class="tab-button-outer subjects-selection">
          <div class="owl-slider">
            <div id="tab-button">

            <div id="subjects_carousel" class="owl-carousel">
              <?php foreach($subjects as $key => $value){ ?>
                <div class="item subjects <?php if($key==$d_subject_id){ echo "subj_selected";}?>" >
                   <input class="styled-checkbox" name="subjects_list[]" id="styled-checkbox-<?php echo "subject".$key;?>" type="checkbox" value="<?php echo $key;?>"  <?php if($key==$d_subject_id){ echo "checked";}?>>
                     <label for="styled-checkbox-<?php echo "subject".$key;?>" class="<?php echo "subject".$key;?> all-subjects" ><?php echo $value;?> 
                       <?php if($key==$d_subject_id){?> <i class="fa fa-check" aria-hidden="true"></i> <?php } else{ ?>
                        <i class="fa fa-plus" aria-hidden="true"></i>
                       <?php } ?>
                      </label>

                  </div>
              <?php } ?>

              </div>
            </div>
            </div> 
          </div>
         <div class="tab-select-outer">
            <select id="tab-select" class="">
              <?php foreach($subjects as $key => $value){ ?>
                <option value="#tab05"><?php echo $value; ?> </option>
              <?php } ?>
            </select>
          </div> 
          <div id="tab01" class="tab-contents">
            <div class="row chapters_list">
               <?php $this->load->view('create_tests/chapters_list');?>
            </div>  
            <div class="submit_btn test_2">
               <button type="button" id="tab_submit" class="btn btn-outline-warning create_test_2">Submit</button>
            </div>
            <div class="submit_btn test_1" style="display: none;">
               <button type="button" id="tab_submit" class="btn btn-outline-warning create_test_1">Back</button>
            </div>

          </div>
         
          <div class="login-btn proceed">
               <button type="button" id="start_test" class="btn btn-success btn-block"><span class=""></span>Proceed<img src="<?php echo base_url().'assets/site/images/arrow.png';?>"></button>
          </div>      
        </div>
        </div> 
  			<!---end of dashboard-->
   </section> 
   <!-----------Modal-------------------->
   <div class="modal fade show create-alertbox" id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true" style="display:none;">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <button type="button" class="close frgt-close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><img src="http://dev3.blazedream.in/e4u-new/assets/site/images/close-cross.png"></span>
            </button>        
            <p>You can select maximum of 3 subjects only.</p>
          </div>
       </div>
     </div>
  </div>
  <!-----------Modal-------------------->
      <script>
$('.tab-carousel').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:5
        }
    }
})
$('#standard-carousel').owlCarousel({
    loop:true,
    margin:30,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:4
        }
    }
})
</script>
<script type="text/javascript">
      $(function() {
        var $tabButtonItem = $('#tab-button li'),
            $tabSelect = $('#tab-select'),
            $tabContents = $('.tab-contents'),
            activeClass = 'is-active';

        $tabButtonItem.first().addClass(activeClass);
        $tabContents.not(':first').hide();

        $tabButtonItem.find('a').on('click', function(e) {
          var target = $(this).attr('href');

          $tabButtonItem.removeClass(activeClass);
          $(this).parent().addClass(activeClass);
          $tabSelect.val(target);
          $tabContents.hide();
          $(target).show();
          e.preventDefault();
        });
        $tabSelect.on('change', function() {
          var target = $(this).val(),
             targetSelectNum = $(this).prop('selectedIndex');

          $tabButtonItem.removeClass(activeClass);
          $tabButtonItem.eq(targetSelectNum).addClass(activeClass);
          $tabContents.hide();
          $(target).show();
        });
   
});
    $(document).ready(function(){
        $(".subjects input:checkbox").change(function() {
          var chapters_list = [];
              $.each($("input[name='chapters_list[]']:checked"), function(){
                    chapters_list.push($(this).val());
              });
         var ischecked = $(this).is(':checked');
         var subjects_list = [];
          if(ischecked){
           
           $.each($("input[name='subjects_list[]']:checked"), function(){
              var key = $(this).val();
              if(subjects_list.length < 3){
                subjects_list.push($(this).val());
                 $(this).parent().addClass('subj_selected');
                $('.subject'+key).find('.fa-plus').removeClass("fa-plus").addClass("fa-check");
              }
              else{
                 
                // alert(ischecked);
                alert('You can select maximum of 3 subjects only.');
                 // $(this).prop("checked", false);
                //  $(this).attr('checked', false);
              return false();
                // return false();
                // $(this).prop( "checked", false );
                // $('.subject'+key).find('.fa-check').removeClass("fa-check").addClass("fa-plus");
              }
            });
            //ajax to get chapters start
                  var url = base_url + "create_tests/request";
                  $("#preloader1").show();
                  setTimeout(function () {
                  $.ajax({
                        type: "POST",
                        url: url,
                        data: "course_id=" + "<?php echo $course_id;?>" +"&class_id=" + "<?php echo $class_id;?>" + "&subject_id=" + subjects_list + "&chapter_id=" + chapters_list,
                        success: function (result) { 
                           $("#preloader1").hide();
                            if(result != ''){
                              $('.chapters_list').html($.trim(result)); 
                            }
                        }
                    });
                }, 500);
            //ajax to get chapters end
          }else{
             $(this).parent().removeClass('subj_selected');
            var key = $(this).val();
            $('.subject'+key).find('.fa-check').removeClass("fa-check").addClass("fa-plus");
                $.each($("input[name='subjects_list[]']:checked"), function(){
                  subjects_list.push($(this).val());
                });
                if(subjects_list.length != 0){
            //ajax to get chapters start
                  var url = base_url + "create_tests/request";
                  $("#preloader1").show();
                  setTimeout(function () {
                  $.ajax({
                        type: "POST",
                        url: url,
                        data: "course_id=" + "<?php echo $course_id;?>" +"&class_id=" + "<?php echo $class_id;?>" + "&subject_id=" + subjects_list + "&chapter_id=" + chapters_list,
                        success: function (result) { 
                           $("#preloader1").hide();
                            if(result != ''){
                              $('.chapters_list').html($.trim(result)); 
                            }
                        }
                    });
                 }, 500);
            //ajax to get chapters end
          }else{
            $('.chapters_list').html("Please select atleast 1 subject."); 
            
          }
          
        }
    });
         $(document).on('click','.create_test_2',function(){
             var numberOfChecked = $('input[name="chapters_list[]"]:checked').length;
             if(numberOfChecked > 0){
              var chapters_list = [];
             $.each($("input[name='chapters_list[]']:checked"), function(){
                    var key = $(this).val();
                    $('.chapter'+key).parent().addClass('test_edit_content');
                    $('.chapter'+key).find('.sub_remove').css('display','inline-block');
                    chapters_list.push($(this).val());
             });
             $.each($("input[name='chapters_list[]']:not(:checked)"), function(){
                 $(this).parent().css('display','none');
             });
             $('.test_2').hide();
             $('.test_1').css('display','block');
           }else{
            alert('Please select atleast 1 chapter.')
           }
         });
          $(document).on('click','.create_test_1',function(){

            var chapters_list = [];
             $.each($("input[name='chapters_list[]']:checked"), function(){
                    var key = $(this).val();
                    $('.chapter'+key).parent().css('display','block');
                    $('.chapter'+key).parent().removeClass('test_edit_content');
                    $('.chapter'+key).find('.sub_remove').css('display','none');
                    chapters_list.push($(this).val());
             });
             $.each($("input[name='chapters_list[]']:not(:checked)"), function(){
                 $(this).parent().css('display','block');
             });
             $('.test_1').hide();
             $('.test_2').css('display','block');
         });
          $(document).on('click','.sub_remove',function(){
            var chapter_id = $(this).data('chapter_id');
            $('.chapter'+chapter_id).parent().css('display','none');
            $('.chapter'+chapter_id).parent().removeClass('test_edit_content');
            $('.chapter'+chapter_id).find('.sub_remove').css('display','none');
            $(".checkbox-chapter"+chapter_id).attr("checked", false);
         });
          $('#start_test').click(function(){
            var numberOfChecked = $('input[name="chapters_list[]"]:checked').length;
             if(numberOfChecked > 0){
              var chapters_list = [];
              $.each($("input[name='chapters_list[]']:checked"), function(){
                var subject_id = $(this).data('subject_id');
                var chapter_id = $(this).val();
                var obj = {};
                obj[subject_id] = chapter_id;
                chapters_list.push(obj); 
              });
            }else{
              alert('Please select atleast 1 chapter.');
              return false();
            }
            var url = base_url + "tests/start_progress_test";
              $.ajax({
                        type: "POST",
                        url: url,
                        data: "chapters_list=" + JSON.stringify(chapters_list),
                        success: function (result) { 
                          result = $.trim(result);
                          var res = $.parseJSON(result);
                          // alert(res.exam_code);
                          location.replace(base_url+ 'tests/progress_detail/'+res.exam_code);
                        }
                    });
          });
    });
</script>

<script>
  jQuery("#subjects_carousel").owlCarousel({
  autoplay: false,
  lazyLoad: true,
  loop: false,
  margin: 20,
   /*
  animateOut: 'fadeOut',
  animateIn: 'fadeIn',
  */
  responsiveClass: true,
  autoHeight: true,
  autoplayTimeout: 7000,
  smartSpeed: 800,
  nav: true,
  navText:["<div class='nav-btn prev-slide'><</div>","<div class='nav-btn next-slide'>></div>"],
  responsive: {
    0: {
      items: 1
    },

    600: {
      items: 3
    },

    1024: {
      items: 4
    },

    1366: {
      items: 5
    }
  }
});
</script>
