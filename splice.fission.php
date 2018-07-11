<?php
// hot reload for splice
?>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
</head>	
<body>
	<style>
	  html, body {
        padding: 0px;
        margin: 0px;
	  }
	  #bolt {
	  	width:100%;
	  	height:100%;
	  	border: 0px;
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
	<iframe id="bolt" src="https://centerforpositivefutures.github.io/cpf2"></iframe>	
</body>
   <script src="./splice-src/js/jquery3.js"></script>
<script>
	window.onload = function() {
	     $(".loader").fadeOut("slow");
	}

	
</script>	
</html>