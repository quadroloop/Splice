<?php
  $get = $_GET['data'];
  echo $get;
?>
<html>
    <style>
        #window {
            width: 100%;
            height: 100%;
            border: 0;
        }
    </style>
    <body>
        <iframe id="window" src="https://wikipedia.org"></iframe>
    </body>
</html>