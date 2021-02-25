<section class="meeting-part">
  <div class="container">
    <style type="text/css">
      .courses .courses-details span {
        font-size: 16px !important;
      }
      a.morelink {
      text-decoration:none;
      outline: none;
    }
    .morecontent span {
      display: none;
    }
    .mh-200{
      min-height: 100px;
    }
</style>
    <h2>Meeting</h2>
    <!-- <div class="row owl-carousel owl-theme" id="meeting-carousel"> -->
    <div class="row"> 
    <?php 
    // echo "<pre>";
    // print_r($meeting);
    $i = 1;

     if(count($meeting) > 0 ) {
      foreach ($meeting as $key => $value) {
        $dbDate = $value['meeting_date'];	
        $hf = $value['hours_from'];
        $mf = $value['mins_from'];
        $ht = $value['hours_to'];
        $mt = $value['mins_to'];
        $from = "$dbDate  $hf:$mf:00";
        $to = "$dbDate  $ht:$mt:00";
        $fDate = date("g:i a", strtotime($from)); 
        $tDate = date("g:i a", strtotime($to)); 
        //if (new DateTime() <= new DateTime("$to")) {
          $description = strip_tags($value['description']);
          if (strlen($description) > 250) {
          
              // truncate string
              $stringCut = substr($description, 0, 250);
              $endPoint = strrpos($stringCut, ' ');
          
              //if the string doesn't contain any space then it will cut without word basis.
              $description = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
              $description .= '...';
          }
      ?>
      <div class="col-md-4 col-sm-12" style="padding-bottom: 25px;">
        <div class="meet-in-sec">
          <h3><?php echo $value['meeting_topic']?></h3>
          <p class="annual-conf comment more mh-200">
          <?php echo  " $description "; ?>
          </p>
          <div class="met-whole-sec">
            <div class="lft-met-sec">
              <p class="conduct-on">Conducted on
                <span>
                  <?php
                  $date=date_create($value['meeting_date']);
                  echo date_format($date,"D j, Y");
                  $date1   =  date('Y-m-d');
                  $date2   =   $value['meeting_date'];
                 
                  ?>
                </span>
              </p>
            </div>
            <div class="ryt-met-sec">
              <p class="time-on">Timing
                <span><?php echo "$fDate to $tDate"; ?></span>
              </p>
            </div>
          </div>
          <?php if($date1 == $date2){ ?>
             <div class="meet-enter-btn"> <a href="<?php echo $value['url'] ?>" target="_blank"  >Enter to the meeting</a>
          </div>
        <?php } else{?>
          <div class="meet-enter-btn"> <a href="<?php echo $value['url'] ?>" target="_blank" style="pointer-events: none;" >Enter to the meeting</a>
          </div>
        <?php } ?>
        </div>
      </div>
      <?php } } 
        //} 
        else {
      ?>
         <body>
</body>
</html>
      <?php }?>
    </div>
  </div>
</section>

<?php
$this->load->view('home/login');
?>

<!-- read more script  start-->

<script type="text/javascript">
 $(document).ready(function() {
  var showChar = 50;
  var ellipsestext = "";
  var moretext = "View More";
  var lesstext = "Less";
  $('.more').each(function() {
    var content = $(this).html();

    if(content.length > showChar) {

      var c = content.substr(0, showChar);
      var h = content.substr(showChar-0, content.length - showChar);

      var html = c + '<span class="moreelipses"></span>&nbsp;<span class="morecontent "><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">'+moretext+'</a></span>';

      $(this).html(html);
    }

  });

  $(".morelink").click(function(){
    
    if($(this).hasClass("less")) {
    $(".std-inner-first").removeClass("height-auto");
      $(this).removeClass("less");
      $(this).html(moretext);
    } else {
      $(this).addClass("less");
      $(this).html(lesstext);
      $(".std-inner-first").addClass("height-auto");
    }
    $(this).parent().prev().toggle();
    $(this).prev().toggle();
    return false;
  });
});
</script> 