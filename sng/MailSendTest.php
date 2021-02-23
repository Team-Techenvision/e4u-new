<?php
         $to = "blazedreamhost@gmail.com";
         $subject = "Mail connectivity check from E4U-Live Server";
         
         $message = "<b>Mail connectivity check from E4U-Live Server</b>";
         $message .= "<h1>Mail connectivity check from E4U-Live Server.</h1>";
         
         $header = "From:admin@blazedream.com \r\n";
         $header .= "Cc:arivarasu@blazedream.com \r\n";
         $header .= "MIME-Version: 1.0\r\n";
         $header .= "Content-type: text/html\r\n";
         
         $retval = mail ($to,$subject,$message,$header);
         
         if( $retval == true ) {
            echo "Message sent successfully...";
         }else {
            echo "Message could not be sent...";
         }
      ?>