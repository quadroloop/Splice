<!--
====================================================================================
|#| ____        ___           |#| SPLICE | Browser Based Text Editor             |#| 
|#|/ ___| _ __ | (_) ___ ___  |#|================================================|#|
|#|\___ \| '_ \| | |/ __/ _ \ |#| Written in PHP/HTML/CSS/JS                     |#|
|#| ___) | |_) | | | (_|  __/ |#| This project is opensource, hackable. have fun |#|
|#||____/| .__/|_|_|\___\___| |#|================================================|#|
|#|      |_|                  |#| By Bryce Mercines 2017 | github.com/quadroloop |#|
====================================================================================
-->
<?php
   //init (file heirarchy)
  if(file_exists('index.html')){$init_file="index.html";}else if (file_exists('index.php')){$init_file="index.php";}else if (file_exists('index.js')){$init_file="index.js";}
 
  // file save
   $file_contents = $_POST['file_content'];
   $filename = $_POST['filename'];
  file_put_contents($filename,$file_contents); 
 
?>
<!DOCTYPE html>
<html>
  <head>
        <title>Splice</title>
        <meta charset="utf-8">
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
         <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> 
         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
         <link rel="icon" href="data:image/png;base64,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">
        <script src="split-pane.js"></script>
        <link rel="stylesheet" href="./css/filetree.css">

        <style type="text/css">
        /*!

Split Pane v0.9.4

Copyright (c) 2014 - 2016 Simon Hagström

Released under the MIT license
https://raw.github.com/shagstrom/split-pane/master/LICENSE

*/
.split-pane {
    position: relative;
    height: 100%;
    width: 100%;
    overflow: hidden;
    z-index: 0;
}

.split-pane.fixed-top > .split-pane-component,
.split-pane.fixed-bottom > .split-pane-component,
.split-pane.horizontal-percent > .split-pane-component {
    position: absolute;
    left: 0;
    width: 100%;
    overflow: auto;
    top: auto;
    bottom: 0;
    z-index: 1;
}

.split-pane.fixed-top > .split-pane-component:first-child,
.split-pane.fixed-bottom > .split-pane-component:first-child,
.split-pane.horizontal-percent > .split-pane-component:first-child {
    top: 0;
    bottom: auto;
}

.split-pane.fixed-top > .split-pane-divider,
.split-pane.fixed-bottom > .split-pane-divider,
.split-pane.horizontal-percent > .split-pane-divider {
    position: absolute;
    width: 100%;
    left: 0;
    cursor: row-resize;
    z-index: 2;
}

.split-pane.fixed-top > .split-pane-divider > .split-pane-divider-inner,
.split-pane.fixed-bottom > .split-pane-divider > .split-pane-divider-inner,
.split-pane.horizontal-percent > .split-pane-divider > .split-pane-divider-inner {
    position: absolute;
    top: -5px;
    left: 0;
    box-sizing: content-box;
    width: 100%;
    height: 100%;
    padding: 5px 0;
}

.split-pane.fixed-left > .split-pane-component,
.split-pane.fixed-right > .split-pane-component,
.split-pane.vertical-percent > .split-pane-component {
    position: absolute;
    top: 0;
    height: 100%;
    overflow: auto;
    left: auto;
    right: 0;
    z-index: 1;
}

.split-pane.fixed-left > .split-pane-component:first-child,
.split-pane.fixed-right > .split-pane-component:first-child,
.split-pane.vertical-percent > .split-pane-component:first-child {
    left: 0;
    right: auto;
}

.split-pane.fixed-left > .split-pane-divider,
.split-pane.fixed-right > .split-pane-divider,
.split-pane.vertical-percent > .split-pane-divider {
    position: absolute;
    height: 100%;
    top: 0;
    cursor: col-resize;
    z-index: 2;
}

.split-pane.fixed-left > .split-pane-divider > .split-pane-divider-inner,
.split-pane.fixed-right > .split-pane-divider > .split-pane-divider-inner,
.split-pane.vertical-percent > .split-pane-divider > .split-pane-divider-inner {
    position: absolute;
    top: 0;
    left: -5px;
    box-sizing: content-box;
    width: 100%;
    height: 100%;
    padding: 0 5px;
}

.split-pane-resize-shim {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 10000;
    display: none;
}

.split-pane.fixed-left > .split-pane-resize-shim,
.split-pane.fixed-right > .split-pane-resize-shim,
.split-pane.vertical-percent > .split-pane-resize-shim {
    cursor: col-resize;
}

.split-pane.fixed-top > .split-pane-resize-shim,
.split-pane.fixed-bottom > .split-pane-resize-shim,
.split-pane.horizontal-percent > .split-pane-resize-shim {
    cursor: row-resize;
}

            html, body {
                height: 100%;
                min-height: 100%;
                margin: 0;
                padding: 0;
            }
            .split-pane-divider {
                background: #aaa;
            }
            .left-component {
                background-color:#272822;
                width: 20em;
            }
            .my-divider {
                left: 20em; /* Same as left component width */
                width: 120px;
                background-color: transparent;
            }
            .right-component {
                margin-left: 5px;  /* Same as divider width */
                 bottom: 0px;
               }
            
.pretty-split-pane-frame .split-pane > .split-pane-divider.dragged.touch {
    background: blue;
    opacity: 0.25;
}

.pretty-split-pane-component-inner {
    box-sizing: border-box;
    border: 1px solid gray;
    background: white;
    width: 100%;
    height: 100%;
    padding: 0 1em;
    overflow: auto;
}

    /*splice css*/
    #editor { 
                position: relative;
                width: 100%;
                height: 80%;
                overflow: auto;
              }
     #file_manager { 
                position: relative;
                width: 100%;
                height: 80%;
                overflow: hidden;
                display: none;
                background-color:#181915;
              }
     #menu {
            position: relative;
                width: 100%;
                height: 80%;
                overflow: hidden;
                display: none;
                background-color:#181915;
     }         

     #settings {
            position: relative;
                width: 100%;
                height: 80%;
                overflow: hidden;
                display: none;
                background-color:#181915;
     }         

    .top-bar {
         background-color:#272822;
    }
    .bottom-bar {
        background-color:#272822;
    }
    .search {
       color:#fff;
        background-color:#181915;
    }
    .dark-border-0{border:0!important}.dark-border{border:1px solid #3A3A3A!important}
    .dark-border-top{border-top:1px solid #3A3A3A!important}.dark-border-bottom{border-bottom:1px solid #3A3A3A!important}
    .dark-border-left{border-left:1px solid #3A3A3A!important}.dark-border-right{border-right:1px solid #3A3A3A!important}


.tool_state {
    margin:10px;
    float: left;
    }
        </style>
        <script>
            $(function() {
                $('div.split-pane').splitPane();
            });
        </script>
    </head>
    <body>
         <!--editor panel-->   
        <div class="split-pane fixed-left" style="display:block;" id="editor_panel">
            <div class="split-pane-component w3-animate-left left-component code-editor">
            <!--nav bar-->
            <div class="w3-bar top-bar dark-border-bottom">
                <a class="w3-text-white w3-bar-item dark-border-right"><img alt="splice-logo" src="data:image/png;base64,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" style="width:20px;"></a>
                <a onclick="close_editor();" class="w3-text-white w3-bar-item w3-right w3-btn" title="close editor.."><i class="fa fa-times-rectangle w3-text-white w3-hover-text-red"></i></a>
                <a onclick="menu();" class="w3-text-white w3-bar-item w3-right w3-btn" title="open menu.."><i class="fa fa-bars w3-text-white"></i></a>
                <a onclick="settings();" class="w3-text-white w3-bar-item w3-right w3-btn" title="open settings.."><i class="fa fa-gear w3-text-white"></i></a>
                <a onclick="code_editor();" class="w3-text-white w3-bar-item w3-right w3-btn" title="open source editor.."><i class="fa fa-hashtag w3-text-white"></i></a>
            </div>
             <!--editor-->
               <div id="editor"></div>
             <!--filemanager-->
             <div id="file_manager">
                 <div class="w3-bar w3-small w3-text-grey dark-border-bottom">
                <a class="dark-border w3-round w3-padding-small w3-text-grey tool_state"><i class="fa fa-map w3-text-grey"></i> FILE MANAGER</a>
                <a id="selected_file" class="w3-text-blue w3-bar-item w3-small"></a>
                 </div>
                 <div id="container" class="w3-text-grey w3-small"> </div>
               </div>    
              <!--menu-->
               <div id="menu" class="w3-animate-left w3-small w3-bar-block">
                <div class="w3-bar w3-small w3-text-grey dark-border-bottom">
                <a class="dark-border w3-round w3-padding-small w3-text-grey tool_state"><i class="fa fa-map-o w3-text-grey"></i> MENU</a>
                <a id="selected_file" class="w3-text-blue w3-bar-item w3-small"></a>
                 </div>
          <a href="#" class="w3-bar-item w3-button w3-text-grey"><i class="fa fa-plus w3-text-blue"></i> New File</a>
          <a href="#" class="w3-bar-item w3-button w3-text-grey"><i class="fa fa-file-text-o w3-text-blue"></i> Open File</a>
          <a onclick="filemanager();" class="w3-bar-item w3-button w3-text-grey"><i class="fa fa-folder w3-text-amber"></i> File Manager</a>
          <a class="w3-bar-item w3-button w3-text-grey"><i class="fa fa-circle w3-text-pink"></i> MINIFY Code</a>
      </div> 
              <!--setting-->
              <div id="settings" class="w3-animate-left w3-small w3-bar-block">
                <div class="w3-bar w3-small w3-text-grey dark-border-bottom">
                <a class="dark-border w3-round w3-padding-small w3-text-grey tool_state"><i class="fa fa-gear w3-text-grey"></i> SETTINGS</a>
                <a id="selected_file" class="w3-text-blue w3-bar-item w3-small"></a>
                 </div>
          <a href="#" class="w3-bar-item w3-button w3-text-grey"><i class="fa fa-code-fork w3-text-blue"></i> View Source Logs</a>
          <a href="#" class="w3-bar-item w3-button w3-text-grey"><i class="fa fa-user-times w3-text-blue"></i> Log Out</a>
          <a class="dark-border w3-round w3-padding-small w3-text-grey tool_state"><i class="fa fa-terminal w3-text-grey"></i> CODE &amp; EDITOR</a>
           <a class="w3-bar-item"><input class="w3-small dark-border w3-round search" type="text" placeholder="Mode"></a>
          <a class="w3-bar-item"><input class="w3-small dark-border w3-round search" type="text" placeholder="Theme"></a>
          <a class="dark-border w3-round w3-padding-small w3-text-grey tool_state"><i class="fa fa-hashtag w3-text-grey"></i> ABOUT</a>

      </div> 
             <!--dock-->  
                <div class="w3-bar bottom-bar dark-border-top" style="bottom:120px;">
                   <a class="w3-bar-item w3-btn"><i class="fa fa-upload w3-text-white"></i></a>
                   <a class="w3-bar-item w3-btn" onclick="filemanager();" title="Open File manager"><i class="fa fa-folder w3-text-white" id="f-icon"></i></a>
                   <a class="w3-bar-item"><input class="w3-small dark-border w3-round search" type="text" placeholder="File Search.."></a>
               </div>
            </div>
            <div class="split-pane-divider my-divider"></div>
            <div class="split-pane-component" id="output">
              <iframe id="frame_data" src="<?php echo $init_file; ?>" style="width:100%;height:100%;border:0"></iframe>
            </div>
        </div>
    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.9/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
    var capp = "editor";
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.getSession().setMode("ace/mode/javascript");
</script>

<script>
$(window).bind('keydown', function(event) {
   if (event.ctrlKey || event.metaKey) {
       switch (String.fromCharCode(event.which).toLowerCase()) {
       case 's':
           event.preventDefault();
           savefile();
           break;
       case 'f':
           event.preventDefault();
           alert('ctrl-f');
           break;
       case 'g':
           event.preventDefault();
           alert('ctrl-g');
           break;
       }
   }
});

// UI JS for navbar
function filemanager() {
    document.getElementById(capp).style.display = "none";
    var file_window = document.getElementById("file_manager");
    file_window.style.display = "block";
    capp = "file_manager";
}

function settings() {
    document.getElementById(capp).style.display = "none";
    var file_window = document.getElementById("settings");
    file_window.style.display = "block";
    capp = "settings";
}

function code_editor() {
    document.getElementById(capp).style.display = "none";
    var file_window = document.getElementById("editor");
    file_window.style.display = "block";
    capp = "editor";
}

function menu() {
    document.getElementById(capp).style.display = "none";
    var file_window = document.getElementById("menu");
    file_window.style.display = "block";
    capp = "menu";
}

function close_editor() {
   document.getElementsByClassName("code-editor-left")[0].style.display = "none";
}

function savefile() {
	 var http = new XMLHttpRequest();
    http.open("POST", "splice.php", true);
    http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    var file = "filename=test.txt&file_content="+editor.getValue();
    http.send(file);
    document.getElementById("frame_data").src="test.txt"
}
/*file script tree*/
$(document).ready( function() {

    $( '#container' ).html( '<ul class="filetree start"><li class="wait">' + 'Generating Tree...' + '<li></ul>' );
    
    getfilelist( $('#container') , './' );
    
    function getfilelist( cont, root ) {
    
        $( cont ).addClass( 'wait' );
            
        $.post( 'splice_dir_tree.php', { dir: root }, function( data ) {
    
            $( cont ).find( '.start' ).html( '' );
            $( cont ).removeClass( 'wait' ).append( data );
            if( './' == root ) 
                $( cont ).find('UL:hidden').show();
            else 
                $( cont ).find('UL:hidden').slideDown({ duration: 500, easing: null });
            
        });
    }
    
    $( '#container' ).on('click', 'LI A', function() {
        var entry = $(this).parent();
        
        if( entry.hasClass('folder') ) {
            if( entry.hasClass('collapsed') ) {
                        
                entry.find('UL').remove();
                getfilelist( entry, escape( $(this).attr('rel') ));
                entry.removeClass('collapsed').addClass('expanded');
            }
            else {
                
                entry.find('UL').slideUp({ duration: 500, easing: null });
                entry.removeClass('expanded').addClass('collapsed');
            }
        } else {
            $( '#selected_file' ).text( "File:  " + $(this).attr( 'rel' ));
        }
    return false;
    });
    
});
</script>
</html>
