<section class="meeting-part">
  <div class="container">
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
          <p class="annual-conf">
          <?php echo  " $description "; ?>
          </p>
          <div class="met-whole-sec">
            <div class="lft-met-sec">
              <p class="conduct-on">Conducted on
                <span>
                  <?php
                  $date=date_create($value['meeting_date']);
                  echo date_format($date,"D j, Y");
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
          <div class="meet-enter-btn"> <a href="<?php echo $value['url'] ?>" target="_blank" >Enter to the meeting</a>
          </div>
        </div>
      </div>
      <?php } } 
        //} 
        else {
      ?>
         <body>


<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus imperdiet, nulla et dictum interdum, nisi lorem egestas vitae scel<span id="dots">...</span><span id="more">erisque enim ligula venenatis dolor. Maecenas nisl est, ultrices nec congue eget, auctor vitae massa. Fusce luctus vestibulum augue ut aliquet. Nunc sagittis dictum nisi, sed ullamcorper ipsum dignissim ac. In at libero sed nunc venenatis imperdiet sed ornare turpis. Donec vitae dui eget tellus gravida venenatis. Integer fringilla congue eros non fermentum. Sed dapibus pulvinar nibh tempor porta.</span></p>
<button onclick="myFunction()" id="myBtn">Read more</button>

<script>
function myFunction() {
  var dots = document.getElementById("dots");
  var moreText = document.getElementById("more");
  var btnText = document.getElementById("myBtn");

  if (dots.style.display === "none") {
    dots.style.display = "inline";
    btnText.innerHTML = "Read more"; 
    moreText.style.display = "none";
  } else {
    dots.style.display = "none";
    btnText.innerHTML = "Read less"; 
    moreText.style.display = "inline";
  }
}
</script>

</body>
</html>
      <?php }?>
    </div>
  </div>
</section>

<?php
$this->load->view('home/login');
?>