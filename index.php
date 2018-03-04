<?php
   if ($_POST) {
       $url = "https://apiheaven.com/ethereum/?genpair=1&key=YOURKEY"; // GENERATE THE ADDRESS
       $fgc = json_decode(file_get_contents($url));
       $results = $fgc->pairs;
       foreach ($results as $item) {
           $next = $item->address; // GET THE ADDRESS
       }
       $total = '90'; // USD CURRENCY
       $conversione = "https://apiv2.bitcoinaverage.com/convert/global?from=USD&to=ETH&amount=" . $total; // GET LIVE ETHER VALUE
       $mostra_conv = json_decode(file_get_contents($conversione), true);
       $satoshiuff = $mostra_conv["price"];
       echo '<script>
   
   
    setInterval(function checkBal(address) {
       var postdata = "add="+"' . $next . '"+"&s="+"' . $satoshiuff . '";
      $.ajax({
   	type: "post",
   	url: "ether.php",
           data: postdata,
           success: function(html){
   			 if (html.msg ==  "true") {
                   
                   }else{
                         document.getElementById("paid").innerHTML = html;
   		 $(".ciao").css("display", "inline");
                   }
   			
   			
   		
   	}
   	});
       },1000);
   
   </script>';
   }
   ?>
<html>
   <head>
      <title>TEST</title>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
   </head>
   <body>
      <div id="paid">
      </div>
      <div style="display:none;text-align:center;" class="card ciao">
         <center>  <button class="eth-address sis btn btn-default btn-sm" style="vertical-align:top;">Copy Ethereum Address </button></center>
      </div>
      <form style="text-align:center;" class="si" id="form-validation" method="post" enctype="multipart/form-data"  novalidate="novalidate">
         <br>
         <button type="submit" class="btn btn-default" name="s" id="s">Pay </button>
      </form>
      <script>
         var ethaddr = document.querySelector('.eth-address');
         
         ethaddr .addEventListener('click', function(event) {
             var copyarea = document.querySelector('.add');
             copyarea.select();
         
             try {
                 var successful = document.execCommand('copy');
             } catch (err) {
                 console.log('Oops, unable to copy');
             }
         });
      </script>
   </body>
</html>