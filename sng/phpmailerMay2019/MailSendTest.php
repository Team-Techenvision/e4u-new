<?php
         $to = "blazedreamhost@gmail.com";
         $subject = "Mail connectivity check from Dev2-Blazedream";
         
         $message = "<b>Mail connectivity check from Dev2-Blazedream</b>";
         $message .= "<h1>This is headline.</h1>";
         
         $header = "From:arivarasu@blazedream.com \r\n";
         $header .= "Cc:arivarasunadesan@gmail.com \r\n";
         $header .= "MIME-Version: 1.0\r\n";
         $header .= "Content-type: text/html\r\n";
         
         $retval = mail ($to,$subject,$message,$header);
         
         if( $retval == true ) {
            echo "Message sent successfully...";
         }else {
            echo "Message could not be sent...";
         }
      ?>