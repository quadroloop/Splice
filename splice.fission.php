<?php
// hot reload for splice
@$delta = $_GET['data'];
if(isset($delta)){
  $delta2 = rand();
  file_put_contents('./splice-src/fission.io',$delta2);
  exit();
}
?>
<html>
<head>
    <title>Splice: Hotreload</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0">

</head>	
<body>
	<style>
	  html, body {
        padding: 0px;
        margin: 0px;
	  }
	  #bolt {
	    width: 100%;
	    height: 100%;
	  	right: 0px;
	  	border: 0;
	  }
	  .loader {
  position: fixed;
  left: 0px;
  top: 0;
  width: 100%;
  height: 100%;
  z-index: 9999;
  background-color: #3A3A3A;
}
 

  #splash {
  	 position: absolute;
   top: 50%;
   left: 50%;
   width: 800px;
   height: 700px;
   margin-top: -350px; /* Half the height */
   margin-left: -400px; /* Half the width */
  }
    </style>
    <div class="loader">
    	<center>
    	   <img src="./splice-src/img/bolt1.gif" id="splash">
       </center>
    </div>
	<iframe id="bolt" src="delta.html"></iframe>	
</body>
   <script src="./splice-src/js/jquery3.js"></script>
<script>
	window.onload = function() {
	     $(".loader").fadeOut("slow");
	}
	var socket = "0";
	  setInterval(()=>{
	  	$.get( "./splice-src/fission.io", function( data ) {
            if(data != socket) {
               document.getElementById('bolt').src =  document.getElementById('bolt').src;
               socket = data;
            }
        });
	  },200);
</script>	
</html>

