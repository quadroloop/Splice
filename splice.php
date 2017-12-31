<?php
/*
====================================================================================
|#| ____        ___           |#| SPLICE | Browser Based Text Editor             |#| 
|#|/ ___| _ __ | (_) ___ ___  |#|================================================|#|
|#|\___ \| '_ \| | |/ __/ _ \ |#| Written in PHP/HTML/CSS/JS                     |#|
|#| ___) | |_) | | | (_|  __/ |#| This project is opensource, hackable. have fun |#|
|#||____/| .__/|_|_|\___\___| |#|================================================|#|
|#|      |_|                  |#| By Bryce Mercines 2017 | github.com/quadroloop |#|
====================================================================================
*/
/*
 Folder Tree with PHP and jQuery.

 R. Savoul Pelister
 http://techlister.com

*/
   //init (file heirarchy)
  if(file_exists('index.html')){$init_file="index.html";}else if (file_exists('index.php')){$init_file="index.php";}else if (file_exists('index.js')){$init_file="index.js";}
  
  // init generate file tree mapper file in case it doesnt exist;
  if(!file_exists('splice_dir_mapper.php')){
$tree_base_code =  "#lt#?php class treeview {private #var#files#semi#private #var#folder#semi#function __construct( #var#path ) {#var#files = array()#semi#if( file_exists( #var#path)) {if( #var#path[ strlen( #var#path ) - 1 ] == #apos#/#apos# )#var#this-#gt#folder = #var#path#semi#else#var#this-#gt#folder = #var#path . #apos#/#apos##semi##var#this-#gt#dir = opendir( #var#path )#semi#while(( #var#file = readdir( #var#this-#gt#dir ) ) != false )#var#this-#gt#files[] = #var#file#semi#closedir( #var#this-#gt#dir )#semi#}}function create_tree( ) {if( count( #var#this-#gt#files ) #gt# 2 ) {natcasesort( #var#this-#gt#files )#semi##var#list = #apos##lt#ul class=#quot#filetree#quot# style=#quot#display: none#semi##quot##gt##apos##semi#foreach( #var#this-#gt#files as #var#file ) {if( file_exists( #var#this-#gt#folder . #var#file ) && #var#file != #apos#.#apos# && #var#file != #apos#..#apos# && is_dir( #var#this-#gt#folder . #var#file )) {#var#list .= #apos##lt#li class=#quot#folder collapsed#quot##gt##lt#a href=#quot###quot# rel=#quot##apos# . htmlentities( #var#this-#gt#folder . #var#file ) . #apos#/#quot##gt##apos# . htmlentities( #var#file ) . #apos##lt#/a#gt##lt#/li#gt##apos##semi#}}foreach( #var#this-#gt#files as #var#file ) {if( file_exists( #var#this-#gt#folder . #var#file ) && #var#file != #apos#.#apos# && #var#file != #apos#..#apos# && !is_dir( #var#this-#gt#folder . #var#file )) {#var#ext = preg_replace(#apos#/^.*\./#apos#, #apos##apos#, #var#file)#semi##var#list .= #apos##lt#li class=#quot#file ext_#apos# . #var#ext . #apos##quot##gt##lt#a href=#quot###quot# rel=#quot##apos# . htmlentities( #var#this-#gt#folder . #var#file ) . #apos##quot##gt##apos# . htmlentities( #var#file ) . #apos##lt#/a#gt##lt#/li#gt##apos##semi#}}#var#list .= #apos##lt#/ul#gt##apos##semi#return #var#list#semi#}}}#var#path = urldecode( #var#_REQUEST[#apos#dir#apos#] )#semi##var#tree = new treeview( #var#path )#semi#echo #var#tree-#gt#create_tree()#semi#?#gt#";
$tree_base_code = str_replace("#var#","$",$tree_base_code);
$tree_base_code = str_replace("#lt#","<",$tree_base_code);
$tree_base_code = str_replace("#gt#",">",$tree_base_code);
$tree_base_code = str_replace("#apos#","'",$tree_base_code);
$tree_base_code = str_replace('#quot#','"',$tree_base_code);
$tree_base_code = str_replace("#semi#",";",$tree_base_code);
file_put_contents("splice_dir_mapper.php",$tree_base_code);
  }

  // for uninstall request
  if(isset($_GET["uninstall"])){
    echo "uninstall requested!";
  }

  // File Saving
  if(isset($_POST['file_content'])&&isset($_POST['filename'])){
   $file_contents = $_POST['file_content'];
   $filename = $_POST['filename'];
  file_put_contents($filename,$file_contents); 
 }

 // loading a file
 if(isset($_GET['file_edit'])) {
    echo htmlspecialchars(file_get_contents($_GET['file_edit']));
    exit();
 }

?>
<!DOCTYPE html>
<html>
  <head>
        <title>Splice</title>
        <meta charset="utf-8">
        <script src="https://code.jquery.com/jquery-3.1.0.js"></script>
         <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> 
         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
         <link rel="icon" href="data:image/png;base64,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">
         <script type="text/javascript">/*!Split Pane v0.9.4Copyright (c) 2014 - 2016 Simon HagströmReleased under the MIT licensehttps://raw.github.com/shagstrom/split-pane/master/LICENSE*/
!function(t){"use strict";function e(){var e=t(this),i=g(e);e.is(".fixed-top, .fixed-bottom, .horizontal-percent")?e.css("min-height",c(i.first)+c(i.last)+t(i.divider).height()+"px"):e.css("min-width",m(i.first)+m(i.last)+t(i.divider).width()+"px")}function i(e){e.preventDefault();var i=t(this),n=i.parent();i.addClass("dragged"),e.type.match(/^touch/)&&i.addClass("touch");var f=r(n,v(e),u(e));t(document).on("touchmove mousemove",f),t(document).one("touchend mouseup",function(e){t(document).off("touchmove mousemove",f),i.removeClass("dragged touch"),n.trigger("dividerdragend",[s(n)])}),n.trigger("dividerdragstart",[s(n)])}function s(t){var e=t.is(".fixed-top, .fixed-bottom, .horizontal-percent")?"height":"width";return{firstComponentSize:parseInt(t.find(".split-pane-component:first").css(e),10),lastComponentSize:parseInt(t.find(".split-pane-component:last").css(e),10)}}function n(){var e=t(this),i=f(e),s=e.parent().closest(".split-pane")[0]||window;t(s).on(s===window?"resize":"splitpaneresize",function(t){(t.target===document?window:t.target)===s&&i(t)})}function f(t){var e=g(t);return t.is(".fixed-top")?function(i){var n=c(e.last),f=e.splitPane.offsetHeight-n-e.divider.offsetHeight;e.first.offsetHeight>f&&H(e,f+"px"),t.trigger("splitpaneresize",[s(t)])}:t.is(".fixed-bottom")?function(i){var n=c(e.first),f=e.splitPane.offsetHeight-n-e.divider.offsetHeight;e.last.offsetHeight>f&&W(e,f+"px"),t.trigger("splitpaneresize",[s(t)])}:t.is(".horizontal-percent")?function(i){var n=c(e.last),f=c(e.first),r=e.splitPane.offsetHeight-f-e.divider.offsetHeight;e.last.offsetHeight>r?W(e,r/e.splitPane.offsetHeight*100+"%"):e.splitPane.offsetHeight-e.first.offsetHeight-e.divider.offsetHeight<n&&W(e,n/e.splitPane.offsetHeight*100+"%"),t.trigger("splitpaneresize",[s(t)])}:t.is(".fixed-left")?function(i){var n=m(e.last),f=e.splitPane.offsetWidth-n-e.divider.offsetWidth;e.first.offsetWidth>f&&z(e,f+"px"),t.trigger("splitpaneresize",[s(t)])}:t.is(".fixed-right")?function(i){var n=m(e.first),f=e.splitPane.offsetWidth-n-e.divider.offsetWidth;e.last.offsetWidth>f&&w(e,f+"px"),t.trigger("splitpaneresize",[s(t)])}:t.is(".vertical-percent")?function(i){var n=m(e.last),f=m(e.first),r=e.splitPane.offsetWidth-f-e.divider.offsetWidth;e.last.offsetWidth>r?w(e,r/e.splitPane.offsetWidth*100+"%"):e.splitPane.offsetWidth-e.first.offsetWidth-e.divider.offsetWidth<n&&w(e,n/e.splitPane.offsetWidth*100+"%"),t.trigger("splitpaneresize",[s(t)])}:void 0}function r(t,e,i){var s=g(t);return t.is(".fixed-top")?a(s,i):t.is(".fixed-bottom")?o(s,i):t.is(".horizontal-percent")?d(s,i):t.is(".fixed-left")?p(s,e):t.is(".fixed-right")?l(s,e):t.is(".vertical-percent")?h(s,e):void 0}function a(e,i){var n=c(e.first),f=e.splitPane.offsetHeight-c(e.last)-e.divider.offsetHeight,r=e.divider.offsetTop-i;return function(i){i.preventDefault&&i.preventDefault();var a=P(n,f,r+u(i));H(e,a+"px"),t(e.splitPane).trigger("splitpaneresize",[s(t(e.splitPane))])}}function o(e,i){var n=c(e.last),f=e.splitPane.offsetHeight-c(e.first)-e.divider.offsetHeight,r=e.last.offsetHeight+i;return function(i){i.preventDefault&&i.preventDefault();var a=Math.min(Math.max(n,r-u(i)),f);W(e,a+"px"),t(e.splitPane).trigger("splitpaneresize",[s(t(e.splitPane))])}}function d(e,i){var n=e.splitPane.offsetHeight,f=c(e.last),r=n-c(e.first)-e.divider.offsetHeight,a=e.last.offsetHeight+i;return function(i){i.preventDefault&&i.preventDefault();var o=Math.min(Math.max(f,a-u(i)),r);W(e,o/n*100+"%"),t(e.splitPane).trigger("splitpaneresize",[s(t(e.splitPane))])}}function p(e,i){var n=m(e.first),f=e.splitPane.offsetWidth-m(e.last)-e.divider.offsetWidth,r=e.divider.offsetLeft-i;return function(i){i.preventDefault&&i.preventDefault();var a=x(n,f,r+v(i));z(e,a+"px"),t(e.splitPane).trigger("splitpaneresize",[s(t(e.splitPane))])}}function l(e,i){var n=m(e.last),f=e.splitPane.offsetWidth-m(e.first)-e.divider.offsetWidth,r=e.last.offsetWidth+i;return function(i){i.preventDefault&&i.preventDefault();var a=Math.min(Math.max(n,r-v(i)),f);w(e,a+"px"),t(e.splitPane).trigger("splitpaneresize",[s(t(e.splitPane))])}}function h(e,i){var n=e.splitPane.offsetWidth,f=m(e.last),r=n-m(e.first)-e.divider.offsetWidth,a=e.last.offsetWidth+i;return function(i){i.preventDefault&&i.preventDefault();var o=Math.min(Math.max(f,a-v(i)),r);w(e,o/n*100+"%"),t(e.splitPane).trigger("splitpaneresize",[s(t(e.splitPane))])}}function g(t){return{splitPane:t[0],first:t.children(".split-pane-component:first")[0],divider:t.children(".split-pane-divider")[0],last:t.children(".split-pane-component:last")[0]}}function v(t){return void 0!==t.pageX?t.pageX:void 0!==t.originalEvent.pageX?t.originalEvent.pageX:t.originalEvent.touches?t.originalEvent.touches[0].pageX:void 0}function u(t){return void 0!==t.pageY?t.pageY:void 0!==t.originalEvent.pageY?t.originalEvent.pageY:t.originalEvent.touches?t.originalEvent.touches[0].pageY:void 0}function c(e){return parseInt(t(e).css("min-height"),10)||0}function m(e){return parseInt(t(e).css("min-width"),10)||0}function P(t,e,i){return Math.min(Math.max(t,i),e)}function x(t,e,i){return Math.min(Math.max(t,i),e)}function H(t,e){t.first.style.height=e,t.divider.style.top=e,t.last.style.top=e}function W(t,e){t.first.style.bottom=e,t.divider.style.bottom=e,t.last.style.height=e}function z(t,e){t.first.style.width=e,t.divider.style.left=e,t.last.style.left=e}function w(t,e){t.first.style.right=e,t.divider.style.right=e,t.last.style.width=e}var y={};y.init=function(){var s=this;s.each(e),s.children(".split-pane-divider").html('<div class="split-pane-divider-inner"></div>'),s.children(".split-pane-divider").on("touchstart mousedown",i),setTimeout(function(){s.each(n),t(window).trigger("resize")},100)},y.firstComponentSize=function(e){this.each(function(){var i=t(this),s=g(i);i.is(".fixed-top")?a(s,s.divider.offsetTop)({pageY:e}):i.is(".fixed-bottom")?(e=s.splitPane.offsetHeight-s.divider.offsetHeight-e,o(s,-s.last.offsetHeight)({pageY:-e})):i.is(".horizontal-percent")?(e=s.splitPane.offsetHeight-s.divider.offsetHeight-e,d(s,-s.last.offsetHeight)({pageY:-e})):i.is(".fixed-left")?p(s,s.divider.offsetLeft)({pageX:e}):i.is(".fixed-right")?(e=s.splitPane.offsetWidth-s.divider.offsetWidth-e,l(s,-s.last.offsetWidth)({pageX:-e})):i.is(".vertical-percent")&&(e=s.splitPane.offsetWidth-s.divider.offsetWidth-e,h(s,-s.last.offsetWidth)({pageX:-e}))})},y.lastComponentSize=function(e){this.each(function(){var i=t(this),s=g(i);i.is(".fixed-top")?(e=s.splitPane.offsetHeight-s.divider.offsetHeight-e,a(s,s.divider.offsetTop)({pageY:e})):i.is(".fixed-bottom")?o(s,-s.last.offsetHeight)({pageY:-e}):i.is(".horizontal-percent")?d(s,-s.last.offsetHeight)({pageY:-e}):i.is(".fixed-left")?(e=s.splitPane.offsetWidth-s.divider.offsetWidth-e,p(s,s.divider.offsetLeft)({pageX:e})):i.is(".fixed-right")?l(s,-s.last.offsetWidth)({pageX:-e}):i.is(".vertical-percent")&&h(s,-s.last.offsetWidth)({pageX:-e})})},t.fn.splitPane=function(e){y[e||"init"].apply(this,t.grep(arguments,function(t,e){return e>0}))}}(jQuery);</script>
        <link rel="stylesheet" href="./css/filetree.css">
<?php echo '<script>var cfile="'.$init_file.'";var fsnippet;</script>'; ?>
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
        overflow: hidden !important;
      }
      .split-pane-divider {
        background: #aaa;
      }
      #left-component {
        width: 20em;
        height: 100%;
        background-color:#272822;
      }
      #divider {
        left: 20em; /* Same as left component width */
        width: 120px;
        background-color: transparent;
      }
      #right-component {
        left: 20em;  /* Same as left component width */
        height: 100%;
        overflow: hidden;
      }

    /*splice css*/

    input{
      padding: 3px;
    }

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
                overflow-y: auto;
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

      #results {
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
 .github-icon {
  font-size: 1.5em;
 }   

 #code_holder {
   display: none;
 }

 #current_file {
    font-size: 13px;
    margin: 10px !important;
    padding: 3px;
    border-radius: 4px;
    float: left;
    border:1px solid #3A3A3A!important;
 }

 #delta {
   width: 100% !important;
   max-width: 350px;
   margin: 5px;
   float: left;
 }
        </style>
        <script>
            $(function() {
                $('div.split-pane').splitPane();
            });

            // loading a file
function loadfile() {
  var file_path = document.getElementById("selected_file").innerHTML;
  var abs_path = file_path.replace("File:  ","");
  var fname = document.getElementById("cfile").value = abs_path;
     $( "#code_base" ).load("splice.php?file_edit="+encodeURIComponent(abs_path), function() {
         var data = document.getElementById("code_base").value;
         editor.setValue(data,-1);
     });
    code_editor(); 
}
        </script>
    </head>
    <body>
    <!--code holder-->
    <textarea id="code_holder">
      <?php readfile($init_file);?>
    </textarea>
         <!--editor panel-->   
        <div class="split-pane fixed-left" style="display:block;" id="editor_panel">
            <div class="split-pane-component w3-animate-left code-editor" id="left-component">
            <!--nav bar-->
            <div class="w3-bar top-bar dark-border-bottom">
                <a class="w3-text-white w3-bar-item dark-border-right"><img alt="splice-logo" src="data:image/png;base64,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" style="width:20px;"></a>
                <!--current file edited-->
                 <a class="w3-bar-item"><input class="w3-small dark-border w3-round search w3-text-blue" id="cfile" type="text" placeholder="File Here.." title="Current file edited.."></a>
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
                <div id="current_file"><a id="selected_file"></a></div>
                 <a class="dark-border w3-round w3-padding-small w3-text-white w3-indigo w3-btn tool_state" onclick="loadfile();"><i class="fa fa-upload w3-text-white"></i> Load File</a>
                 </div>
                 <div id="container" class="w3-text-grey w3-small"> </div>
               </div>    
              <!--menu-->
               <div id="menu" class="w3-animate-left w3-small w3-bar-block">
                <div class="w3-bar w3-small w3-text-grey dark-border-bottom">
                <a class="dark-border w3-round w3-padding-small w3-text-grey tool_state"><i class="fa fa-map-o w3-text-grey"></i> MENU</a>
                <a id="selected_file" class="w3-text-blue w3-bar-item w3-small"></a>
                 </div>
          <a class="dark-border w3-round w3-padding-small w3-text-grey tool_state"><i class="fa fa-terminal w3-text-grey"></i> CODE &amp; EDITOR</a> 
          <a href="#" class="w3-bar-item w3-button w3-text-grey"><i class="fa fa-plus w3-text-blue"></i> New File</a>
          <a href="#" class="w3-bar-item w3-button w3-text-grey" onclick="upload();"><i class="fa fa-file-text-o w3-text-blue"></i> Open File</a>
          <a onclick="filemanager();" class="w3-bar-item w3-button w3-text-grey"><i class="fa fa-folder w3-text-amber"></i> File Manager</a>
          <a class="w3-bar-item w3-button w3-text-grey"><i class="fa fa-circle w3-text-pink"></i> MINIFY Code</a>
          <a href="#" class="w3-bar-item w3-button w3-text-grey w3-hover-black"><i class="fa fa-user-times w3-text-blue"></i> Log Out</a>
          <a class="dark-border w3-round w3-padding-small w3-text-grey tool_state"><i class="fa fa-wrench w3-text-grey"></i> TOOLS</a>
          <a href="#" class="w3-bar-item w3-button w3-text-grey w3-hover-black"><i class="fa fa-cube w3-text-blue"></i> JS Console</a>
          <a class="w3-bar-item"><input class="w3-small dark-border w3-round search" id="url" type="text" placeholder="URL Parameters.." title="Input URL test parameters here, and press enter to test it."></a>




      </div> 
              <!--setting-->
              <div id="settings" class="w3-animate-left w3-small w3-bar-block">
                <div class="w3-bar w3-small w3-text-grey dark-border-bottom">
                <a class="dark-border w3-round w3-padding-small w3-text-grey tool_state"><i class="fa fa-gear w3-text-grey"></i> SETTINGS</a>

                 </div>
          <a href="#" class="w3-bar-item w3-button w3-text-grey w3-hover-black"><i class="fa fa-code-fork w3-text-blue"></i> View Source Logs</a>
          <a class="dark-border w3-round w3-padding-small w3-text-grey tool_state"><i class="fa fa-terminal w3-text-grey"></i> CODE &amp; EDITOR</a>
          <a class="w3-bar-item w3-button w3-hover-black w3-text-grey" onclick="set_editor();"><i class="fa fa-cube w3-text-blue"></i> Change Editor Preferences</a>
          <a class="dark-border w3-round w3-padding-small w3-text-grey tool_state"><i class="fa fa-hashtag w3-text-grey"></i> ABOUT</a>
          <a href="#" class="w3-bar-item w3-button w3-text-grey w3-hover-black"><i class="fa fa-folder-open w3-text-amber"></i> Docs</a>
          <a href="https://github.com/quadroloop/Splice" class="w3-bar-item w3-button w3-text-grey w3-hover-black"><i class="fa fa-github w3-text-white github-icon"></i> View or Fork on Github</a>
          <a class="dark-border w3-round w3-padding-small w3-text-grey tool_state"><i class="fa fa-warning w3-text-grey"></i> DANGER ZONE!</a>
          <div class="w3-bar-item w3-button w3-small w3-hover-black" onclick="uninstall();"><a class="w3-red w3-round w3-text-white w3-btn">Uninstall</a></div>
      </div> 

        <!--search results-->
          <div id="results" class="w3-animate-left w3-small">
              <ul id="thread" style="display: block;z-index: 1000;">
              <?php
$it = new RecursiveTreeIterator(new RecursiveDirectoryIterator("./", RecursiveDirectoryIterator::SKIP_DOTS));
foreach($it as $path) {
  echo '<li class="w3-text-blue w3-hover-black" style="cursor:pointer" onclick="fsnippet=this.innerHTML;file_bind();"><a>'.$path.'</a></li>';
}
?>
              </ul>
          </div>

             <!--dock-->  
                <div class="w3-bar bottom-bar dark-border-top" style="bottom:0px;">
                   <a class="w3-bar-item w3-btn" onclick="upload();"><i class="fa fa-upload w3-text-white"></i></a>
                   <a class="w3-bar-item w3-btn" onclick="filemanager();" title="Open File manager"><i class="fa fa-folder w3-text-white" id="f-icon"></i></a>
                   <a class=""><input class="w3-small dark-border w3-round search" id="delta" type="text" placeholder="File Search.." title="Search a file.." onkeyup="search_file();"></a>
               </div>
            </div>
            <!--right panel-->
            <div class="split-pane-divider" id="divider"></div>
            <div class="split-pane-component" id="right-component">
              <iframe id="frame_data" src="<?php echo $init_file; ?>" style="width:100%;height:100%;border:0"></iframe>
            </div>
        </div>
        <!--Data Elements-->
        <div style="display: none">
           <input type="file" id="file_holder">
            <textarea id="code_base"></textarea>
        </div>



    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.9/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
    var capp = "editor";
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.getSession().setMode("ace/mode/javascript");
    window.onload = function() {
      editor.setValue(document.getElementById("code_holder").value,-1);
    }
</script>

<script>
$(window).bind('keydown', function(event) {
   if (event.ctrlKey || event.metaKey) {
       switch (String.fromCharCode(event.which).toLowerCase()) {
       case 's':
           event.preventDefault();
           savefile();
           setTimeout("refresh_output()",200);
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

function uninstall() {
  swal({
  title: 'Are you sure?',
  text: "Are you sure you want to uninstall Splice Editor?",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Proceed',
  cancelButtonText: 'Cancel',
  confirmButtonClass: 'w3-btn w3-round w3-green w3-margin',
  cancelButtonClass: 'w3-btn w3-round w3-red w3-margin',
  buttonsStyling: false,
  reverseButtons: true
}).then((result) => {
  if (result.value) {
    uninstall_options();
  } else if (result.dismiss === 'cancel') {
    swal({
     showConfirmButton: false, 
     timer: 1500, 
     title: 'Cancelled',
     text: 'you have canceled the unistallation.',
     type: 'success'
    })
  }
})
}


function uninstall_options() {
  swal({
  title: 'Choose your uninstallation method.',
  text: "You can choose to restore defaults or, COMPLETE UNINSTALL. (this will delete the editor.) this cannot be undone.",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Complete uninstall',
  cancelButtonText: 'Restore Defaults',
  confirmButtonClass: 'w3-btn w3-round w3-green w3-margin',
  cancelButtonClass: 'w3-btn w3-round w3-indigo w3-margin',
  buttonsStyling: false,
  reverseButtons: true
}).then((result) => {
  if (result.value) {
   swal("Success!","Uninstall Complete!, thank you for using Splice Editor.","success")
   location.href = "splice.php?uninstall";
  } else if (result.dismiss === 'cancel') {
    swal({
     title: 'Restored Defaults',
     text: 'you have restored your defaults',
     type: 'success'
    })
  }
})
}

// file search
function search_file() {
     var input, filter, ul, li, a, i;
        input = document.getElementById("delta"); 
    var threader = document.getElementById("results");
    if(input.value == [ ] ) {
       document.getElementById(capp).style.display = "block";
      threader.style.display = "none";
    }else{
       document.getElementById(capp).style.display = "none";
      threader.style.display = "block";
    }
    filter = input.value.toUpperCase();
    ul = document.getElementById("thread");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";

        }
    }

}

 // process searched file
function file_bind() {
  alert(fsnippet);
}


// URL Parameter Tester
var urx = document.getElementById("url");
     urx.addEventListener("keydown", function (e) {
      if (e.keyCode === 13) { 
        if ( urx.value == [     ] ) {
          swal({type: "error", showConfirmButton: false, timer: 1500, title: "Error!",text: "empty parameters!"})
        }else{
       var y =document.getElementById("cfile").value;   
       var x = document.getElementById("frame_data");
       x.src = "?"+y+urx.value;
    }
      }
    });


// Saving a file

function savefile() {
   var file_name_to_save = document.getElementById("cfile").value;
   if(file_name_to_save == [ ]){swal('Error!','No file name!','error')}else{
	 var http = new XMLHttpRequest();
    http.open("POST", "splice.php", true);
    http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    var file = "filename="+file_name_to_save+"&file_content="+editor.getValue();
    http.send(file);
  }
}

function refresh_output() {
     var file_name_to_save = document.getElementById("cfile").value;
      document.getElementById("frame_data").src=file_name_to_save;
}
/*file script tree*/
$(document).ready( function() {

    $( '#container' ).html( '<ul class="filetree start"><li class="wait">' + 'Generating Tree...' + '<li></ul>' );
    
    getfilelist( $('#container') , './' );
    
    function getfilelist( cont, root ) {
    
        $( cont ).addClass( 'wait' );
            
        $.post( 'splice_dir_mapper.php', { dir: root }, function( data ) {
    
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

/*limonte-sweet-alert2.min/js*/
!function(n,t){"object"==typeof exports&&"undefined"!=typeof module?module.exports=t():"function"==typeof define&&define.amd?define(t):n.Sweetalert2=t()}(this,function(){"use strict";var n={title:"",titleText:"",text:"",html:"",type:null,toast:!1,customClass:"",target:"body",backdrop:!0,animation:!0,allowOutsideClick:!0,allowEscapeKey:!0,allowEnterKey:!0,showConfirmButton:!0,showCancelButton:!1,preConfirm:null,confirmButtonText:"OK",confirmButtonAriaLabel:"",confirmButtonColor:"#3085d6",confirmButtonClass:null,cancelButtonText:"Cancel",cancelButtonAriaLabel:"",cancelButtonColor:"#aaa",cancelButtonClass:null,buttonsStyling:!0,reverseButtons:!1,focusConfirm:!0,focusCancel:!1,showCloseButton:!1,closeButtonAriaLabel:"Close this dialog",showLoaderOnConfirm:!1,imageUrl:null,imageWidth:null,imageHeight:null,imageAlt:"",imageClass:null,timer:null,width:500,padding:20,background:"#fff",input:null,inputPlaceholder:"",inputValue:"",inputOptions:{},inputAutoTrim:!0,inputClass:null,inputAttributes:{},inputValidator:null,grow:!1,position:"center",progressSteps:[],currentProgressStep:null,progressStepsDistance:"40px",onBeforeOpen:null,onOpen:null,onClose:null,useRejections:!1,expectRejections:!1},t=["useRejections","expectRejections"],e=function(n){var t={};for(var e in n)t[n[e]]="swal2-"+n[e];return t},o=e(["container","shown","iosfix","popup","modal","no-backdrop","toast","toast-shown","overlay","fade","show","hide","noanimation","close","title","content","contentwrapper","buttonswrapper","confirm","cancel","icon","image","input","has-input","file","range","select","radio","checkbox","textarea","inputerror","validationerror","progresssteps","activeprogressstep","progresscircle","progressline","loading","styled","top","top-left","top-right","center","center-left","center-right","bottom","bottom-left","bottom-right","grow-row","grow-column","grow-fullscreen"]),a=e(["success","warning","info","question","error"]),s=function(n,t){(n=String(n).replace(/[^0-9a-f]/gi,"")).length<6&&(n=n[0]+n[0]+n[1]+n[1]+n[2]+n[2]),t=t||0;for(var e="#",o=0;o<3;o++){var a=parseInt(n.substr(2*o,2),16);e+=("00"+(a=Math.round(Math.min(Math.max(0,a+a*t),255)).toString(16))).substr(a.length)}return e},r=function(n){console.warn("SweetAlert2: "+n)},i=function(n){console.error("SweetAlert2: "+n)},l=[],c=function(n){-1===l.indexOf(n)&&(l.push(n),r(n))},p="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(n){return typeof n}:function(n){return n&&"function"==typeof Symbol&&n.constructor===Symbol&&n!==Symbol.prototype?"symbol":typeof n},u=Object.assign||function(n){for(var t=1;t<arguments.length;t++){var e=arguments[t];for(var o in e)Object.prototype.hasOwnProperty.call(e,o)&&(n[o]=e[o])}return n},d=u({},n),w=[],f=void 0,m=void 0;"undefined"==typeof Promise&&i("This package requires a Promise library, please include a shim to enable it in this browser (See: https://github.com/limonte/sweetalert2/wiki/Migration-from-SweetAlert-to-SweetAlert2#1-ie-support)");var b=function(n){for(var t in n)k.isValidParameter(t)||r('Unknown parameter "'+t+'"'),k.isDeprecatedParameter(t)&&c('The parameter "'+t+'" is deprecated and will be removed in the next major release.')},g=function(t){("string"==typeof t.target&&!document.querySelector(t.target)||"string"!=typeof t.target&&!t.target.appendChild)&&(r('Target parameter is not valid, defaulting to "body"'),t.target="body");var e=void 0,s=B(),l="string"==typeof t.target?document.querySelector(t.target):t.target;e=s&&l&&s.parentNode!==l.parentNode?C(t):s||C(t);var c=t.width===n.width&&t.toast?"auto":t.width;e.style.width="number"==typeof c?c+"px":c;var u=t.padding===n.padding&&t.toast?"inherit":t.padding;e.style.padding="number"==typeof u?u+"px":u,e.style.background=t.background;for(var d=e.querySelectorAll("[class^=swal2-success-circular-line], .swal2-success-fix"),w=0;w<d.length;w++)d[w].style.background=t.background;var f=A(),m=L(),b=T(),g=N(),x=O(),h=V(),y=Y();if(t.titleText?m.innerText=t.titleText:m.innerHTML=t.title.split("\n").join("<br />"),t.backdrop||D([document.documentElement,document.body],o["no-backdrop"]),t.text||t.html){if("object"===p(t.html))if(b.innerHTML="",0 in t.html)for(var v=0;v in t.html;v++)b.appendChild(t.html[v].cloneNode(!0));else b.appendChild(t.html.cloneNode(!0));else t.html?b.innerHTML=t.html:t.text&&(b.textContent=t.text);W(b)}else K(b);if(t.position in o&&D(f,o[t.position]),t.grow&&"string"==typeof t.grow){var S="grow-"+t.grow;S in o&&D(f,o[S])}t.showCloseButton?(y.setAttribute("aria-label",t.closeButtonAriaLabel),W(y)):K(y),e.className=o.popup,t.toast?(D([document.documentElement,document.body],o["toast-shown"]),D(e,o.toast)):D(e,o.modal),t.customClass&&D(e,t.customClass);var E=q(),j=parseInt(null===t.currentProgressStep?k.getQueueStep():t.currentProgressStep,10);t.progressSteps.length?(W(E),_(E),j>=t.progressSteps.length&&r("Invalid currentProgressStep parameter, it should be less than progressSteps.length (currentProgressStep like JS arrays starts from 0)"),t.progressSteps.forEach(function(n,e){var a=document.createElement("li");if(D(a,o.progresscircle),a.innerHTML=n,e===j&&D(a,o.activeprogressstep),E.appendChild(a),e!==t.progressSteps.length-1){var s=document.createElement("li");D(s,o.progressline),s.style.width=t.progressStepsDistance,E.appendChild(s)}})):K(E);for(var H=P(),Z=0;Z<H.length;Z++)K(H[Z]);if(t.type){var M=!1;for(var R in a)if(t.type===R){M=!0;break}if(!M)return i("Unknown alert type: "+t.type),!1;var I=e.querySelector("."+o.icon+"."+a[t.type]);if(W(I),t.animation)switch(t.type){case"success":D(I,"swal2-animate-success-icon"),D(I.querySelector(".swal2-success-line-tip"),"swal2-animate-success-line-tip"),D(I.querySelector(".swal2-success-line-long"),"swal2-animate-success-line-long");break;case"error":D(I,"swal2-animate-error-icon"),D(I.querySelector(".swal2-x-mark"),"swal2-animate-x-mark")}}var X=z();t.imageUrl?(X.setAttribute("src",t.imageUrl),X.setAttribute("alt",t.imageAlt),W(X),t.imageWidth?X.setAttribute("width",t.imageWidth):X.removeAttribute("width"),t.imageHeight?X.setAttribute("height",t.imageHeight):X.removeAttribute("height"),X.className=o.image,t.imageClass&&D(X,t.imageClass)):K(X),t.showCancelButton?h.style.display="inline-block":K(h),t.showConfirmButton?J(x,"display"):K(x),t.showConfirmButton||t.showCancelButton?W(g):K(g),x.innerHTML=t.confirmButtonText,h.innerHTML=t.cancelButtonText,x.setAttribute("aria-label",t.confirmButtonAriaLabel),h.setAttribute("aria-label",t.cancelButtonAriaLabel),t.buttonsStyling&&(x.style.backgroundColor=t.confirmButtonColor,h.style.backgroundColor=t.cancelButtonColor),x.className=o.confirm,D(x,t.confirmButtonClass),h.className=o.cancel,D(h,t.cancelButtonClass),t.buttonsStyling?D([x,h],o.styled):($([x,h],o.styled),x.style.backgroundColor=x.style.borderLeftColor=x.style.borderRightColor="",h.style.backgroundColor=h.style.borderLeftColor=h.style.borderRightColor=""),!0===t.animation?$(e,o.noanimation):D(e,o.noanimation),t.showLoaderOnConfirm&&!t.preConfirm&&r("showLoaderOnConfirm is set to true, but preConfirm is not defined.\nshowLoaderOnConfirm should be used together with preConfirm, see usage example:\nhttps://limonte.github.io/sweetalert2/#ajax-request")},x=function(){null===y.previousBodyPadding&&document.body.scrollHeight>window.innerHeight&&(y.previousBodyPadding=document.body.style.paddingRight,document.body.style.paddingRight=nn()+"px")},h=function(){if(/iPad|iPhone|iPod/.test(navigator.userAgent)&&!window.MSStream&&!R(document.body,o.iosfix)){var n=document.body.scrollTop;document.body.style.top=-1*n+"px",D(document.body,o.iosfix)}},k=function n(){for(var t=arguments.length,e=Array(t),a=0;a<t;a++)e[a]=arguments[a];if("undefined"!=typeof window){if(void 0===e[0])return i("SweetAlert2 expects at least 1 attribute!"),!1;var r=u({},d);switch(p(e[0])){case"string":r.title=e[0],r.html=e[1],r.type=e[2];break;case"object":if(b(e[0]),u(r,e[0]),r.extraParams=e[0].extraParams,"email"===r.input&&null===r.inputValidator){var l=function(n){return new Promise(function(t,e){/^[a-zA-Z0-9.+_-]+@[a-zA-Z0-9.-]+\.[a-zA-Z0-9-]{2,24}$/.test(n)?t():e("Invalid email address")})};r.inputValidator=r.expectRejections?l:n.adaptInputValidator(l)}if("url"===r.input&&null===r.inputValidator){var c=function(n){return new Promise(function(t,e){/^https?:\/\/(www\.)?[-a-zA-Z0-9@:%._+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_+.~#?&//=]*)$/.test(n)?t():e("Invalid URL")})};r.inputValidator=r.expectRejections?c:n.adaptInputValidator(c)}break;default:return i('Unexpected type of argument! Expected "string" or "object", got '+p(e[0])),!1}g(r);var w=A(),k=B();return new Promise(function(t,e){var a=function(e){n.closePopup(r.onClose),t(r.useRejections?e:{value:e})},l=function(o){n.closePopup(r.onClose),r.useRejections?e(o):t({dismiss:o})},c=function(t){n.closePopup(r.onClose),e(t)};r.timer&&(k.timeout=setTimeout(function(){return l("timer")},r.timer));var u=function(n){if(!(n=n||r.input))return null;switch(n){case"select":case"textarea":case"file":return U(k,o[n]);case"checkbox":return k.querySelector("."+o.checkbox+" input");case"radio":return k.querySelector("."+o.radio+" input:checked")||k.querySelector("."+o.radio+" input:first-child");case"range":return k.querySelector("."+o.range+" input");default:return U(k,o.input)}};r.input&&setTimeout(function(){var n=u();n&&I(n)},0);for(var d=function(t){if(r.showLoaderOnConfirm&&n.showLoading(),r.preConfirm){n.resetValidationError();var e=Promise.resolve().then(function(){return r.preConfirm(t,r.extraParams)});r.expectRejections?e.then(function(n){return a(n||t)},function(t){n.hideLoading(),t&&n.showValidationError(t)}):e.then(function(e){Q(j())?n.hideLoading():a(e||t)},function(n){return c(n)})}else a(t)},b=function(t){var e=t||window.event,o=e.target||e.srcElement,a=O(),i=V(),p=a&&(a===o||a.contains(o)),w=i&&(i===o||i.contains(o));switch(e.type){case"mouseover":case"mouseup":r.buttonsStyling&&(p?a.style.backgroundColor=s(r.confirmButtonColor,-.1):w&&(i.style.backgroundColor=s(r.cancelButtonColor,-.1)));break;case"mouseout":r.buttonsStyling&&(p?a.style.backgroundColor=r.confirmButtonColor:w&&(i.style.backgroundColor=r.cancelButtonColor));break;case"mousedown":r.buttonsStyling&&(p?a.style.backgroundColor=s(r.confirmButtonColor,-.2):w&&(i.style.backgroundColor=s(r.cancelButtonColor,-.2)));break;case"click":if(p&&n.isVisible())if(n.disableButtons(),r.input){var f=function(){var n=u();if(!n)return null;switch(r.input){case"checkbox":return n.checked?1:0;case"radio":return n.checked?n.value:null;case"file":return n.files.length?n.files[0]:null;default:return r.inputAutoTrim?n.value.trim():n.value}}();if(r.inputValidator){n.disableInput();var m=Promise.resolve().then(function(){return r.inputValidator(f,r.extraParams)});r.expectRejections?m.then(function(){n.enableButtons(),n.enableInput(),d(f)},function(t){n.enableButtons(),n.enableInput(),t&&n.showValidationError(t)}):m.then(function(t){n.enableButtons(),n.enableInput(),t?n.showValidationError(t):d(f)},function(n){return c(n)})}else d(f)}else d(!0);else w&&n.isVisible()&&(n.disableButtons(),l("cancel"))}},v=k.querySelectorAll("button"),C=0;C<v.length;C++)v[C].onclick=b,v[C].onmouseover=b,v[C].onmouseout=b,v[C].onmousedown=b;if(Y().onclick=function(){l("close")},r.toast)k.onclick=function(t){t.target!==k||r.showConfirmButton||r.showCancelButton||r.allowOutsideClick&&(n.closePopup(r.onClose),l("overlay"))};else{var S=!1;k.onmousedown=function(){w.onmouseup=function(n){w.onmouseup=void 0,n.target===w&&(S=!0)}},w.onmousedown=function(){k.onmouseup=function(n){k.onmouseup=void 0,(n.target===k||k.contains(n.target))&&(S=!0)}},w.onclick=function(n){S?S=!1:n.target===w&&r.allowOutsideClick&&l("overlay")}}var P=N(),E=O(),M=V();r.reverseButtons?E.parentNode.insertBefore(M,E):E.parentNode.insertBefore(E,M);var X=function(n,t){for(var e=H(r.focusCancel),o=0;o<e.length;o++){(n+=t)===e.length?n=0:-1===n&&(n=e.length-1);var a=e[n];if(Q(a))return a.focus()}};r.toast&&m&&(window.onkeydown=f,m=!1),r.toast||m||(f=window.onkeydown,m=!0,window.onkeydown=function(t){var e=t||window.event;if("Enter"!==e.key||e.isComposing)if("Tab"===e.key){for(var o=e.target||e.srcElement,a=H(r.focusCancel),s=-1,i=0;i<a.length;i++)if(o===a[i]){s=i;break}e.shiftKey?X(s,-1):X(s,1),e.stopPropagation(),e.preventDefault()}else-1!==["ArrowLeft","ArrowRight","ArrowUp","ArrowDown","Left","Right","Up","Down"].indexOf(e.key)?document.activeElement===E&&Q(M)?M.focus():document.activeElement===M&&Q(E)&&E.focus():"Escape"!==e.key&&"Esc"!==e.key||!0!==r.allowEscapeKey||l("esc");else if(e.target===u()){if("textarea"===e.target.tagName.toLowerCase())return;n.clickConfirm(),e.preventDefault()}}),r.buttonsStyling&&(E.style.borderLeftColor=r.confirmButtonColor,E.style.borderRightColor=r.confirmButtonColor),n.hideLoading=n.disableLoading=function(){r.showConfirmButton||(K(E),r.showCancelButton||K(N())),$([k,P],o.loading),k.removeAttribute("aria-busy"),E.disabled=!1,M.disabled=!1},n.getTitle=function(){return L()},n.getContent=function(){return T()},n.getInput=function(){return u()},n.getImage=function(){return z()},n.getButtonsWrapper=function(){return N()},n.getConfirmButton=function(){return O()},n.getCancelButton=function(){return V()},n.enableButtons=function(){E.disabled=!1,M.disabled=!1},n.disableButtons=function(){E.disabled=!0,M.disabled=!0},n.enableConfirmButton=function(){E.disabled=!1},n.disableConfirmButton=function(){E.disabled=!0},n.enableInput=function(){var n=u();if(!n)return!1;if("radio"===n.type)for(var t=n.parentNode.parentNode.querySelectorAll("input"),e=0;e<t.length;e++)t[e].disabled=!1;else n.disabled=!1},n.disableInput=function(){var n=u();if(!n)return!1;if(n&&"radio"===n.type)for(var t=n.parentNode.parentNode.querySelectorAll("input"),e=0;e<t.length;e++)t[e].disabled=!0;else n.disabled=!0},n.showValidationError=function(n){var t=j();t.innerHTML=n,W(t);var e=u();e&&(e.setAttribute("aria-invalid",!0),e.setAttribute("aria-describedBy",o.validationerror),I(e),D(e,o.inputerror))},n.resetValidationError=function(){var n=j();K(n);var t=u();t&&(t.removeAttribute("aria-invalid"),t.removeAttribute("aria-describedBy"),$(t,o.inputerror))},n.getProgressSteps=function(){return r.progressSteps},n.setProgressSteps=function(n){r.progressSteps=n,g(r)},n.showProgressSteps=function(){W(q())},n.hideProgressSteps=function(){K(q())},n.enableButtons(),n.hideLoading(),n.resetValidationError(),r.input&&D(document.body,o["has-input"]);for(var _=["input","file","range","select","radio","checkbox","textarea"],J=void 0,G=0;G<_.length;G++){var nn=o[_[G]],tn=U(k,nn);if(J=u(_[G])){for(var en in J.attributes)if(J.attributes.hasOwnProperty(en)){var on=J.attributes[en].name;"type"!==on&&"value"!==on&&J.removeAttribute(on)}for(var an in r.inputAttributes)J.setAttribute(an,r.inputAttributes[an])}tn.className=nn,r.inputClass&&D(tn,r.inputClass),K(tn)}var sn=void 0;switch(r.input){case"text":case"email":case"password":case"number":case"tel":case"url":(J=U(k,o.input)).value=r.inputValue,J.placeholder=r.inputPlaceholder,J.type=r.input,W(J);break;case"file":(J=U(k,o.file)).placeholder=r.inputPlaceholder,J.type=r.input,W(J);break;case"range":var rn=U(k,o.range),ln=rn.querySelector("input"),cn=rn.querySelector("output");ln.value=r.inputValue,ln.type=r.input,cn.value=r.inputValue,W(rn);break;case"select":var pn=U(k,o.select);if(pn.innerHTML="",r.inputPlaceholder){var un=document.createElement("option");un.innerHTML=r.inputPlaceholder,un.value="",un.disabled=!0,un.selected=!0,pn.appendChild(un)}sn=function(n){for(var t in n){var e=document.createElement("option");e.value=t,e.innerHTML=n[t],r.inputValue.toString()===t&&(e.selected=!0),pn.appendChild(e)}W(pn),pn.focus()};break;case"radio":var dn=U(k,o.radio);dn.innerHTML="",sn=function(n){for(var t in n){var e=document.createElement("input"),a=document.createElement("label"),s=document.createElement("span");e.type="radio",e.name=o.radio,e.value=t,r.inputValue.toString()===t&&(e.checked=!0),s.innerHTML=n[t],a.appendChild(e),a.appendChild(s),a.for=e.id,dn.appendChild(a)}W(dn);var i=dn.querySelectorAll("input");i.length&&i[0].focus()};break;case"checkbox":var wn=U(k,o.checkbox),fn=u("checkbox");fn.type="checkbox",fn.value=1,fn.id=o.checkbox,fn.checked=Boolean(r.inputValue);var mn=wn.getElementsByTagName("span");mn.length&&wn.removeChild(mn[0]),(mn=document.createElement("span")).innerHTML=r.inputPlaceholder,wn.appendChild(mn),W(wn);break;case"textarea":var bn=U(k,o.textarea);bn.value=r.inputValue,bn.placeholder=r.inputPlaceholder,W(bn);break;case null:break;default:i('Unexpected type of input! Expected "text", "email", "password", "number", "tel", "select", "radio", "checkbox", "textarea", "file" or "url", got "'+r.input+'"')}"select"!==r.input&&"radio"!==r.input||(r.inputOptions instanceof Promise?(n.showLoading(),r.inputOptions.then(function(t){n.hideLoading(),sn(t)})):"object"===p(r.inputOptions)?sn(r.inputOptions):i("Unexpected type of inputOptions! Expected object or Promise, got "+p(r.inputOptions))),function(n,t,e){var a=A(),s=B();null!==t&&"function"==typeof t&&t(s),n?(D(s,o.show),D(a,o.fade),$(s,o.hide)):$(s,o.fade),W(s),a.style.overflowY="hidden",F&&!R(s,o.noanimation)?s.addEventListener(F,function n(){s.removeEventListener(F,n),a.style.overflowY="auto"}):a.style.overflowY="auto",D([document.documentElement,document.body,a],o.shown),Z()&&(x(),h()),y.previousActiveElement=document.activeElement,null!==e&&"function"==typeof e&&setTimeout(function(){e(s)})}(r.animation,r.onBeforeOpen,r.onOpen),r.toast||(r.allowEnterKey?r.focusCancel&&Q(M)?M.focus():r.focusConfirm&&Q(E)?E.focus():X(-1,1):document.activeElement&&document.activeElement.blur()),A().scrollTop=0})}};k.isVisible=function(){return!!B()},k.queue=function(n){w=n;var t=function(){w=[],document.body.removeAttribute("data-swal2-queue-step")},e=[];return new Promise(function(n,o){!function o(a,s){a<w.length?(document.body.setAttribute("data-swal2-queue-step",a),k(w[a]).then(function(r){void 0!==r.value?(e.push(r.value),o(a+1,s)):(t(),n({dismiss:r.dismiss}))})):(t(),n({value:e}))}(0)})},k.getQueueStep=function(){return document.body.getAttribute("data-swal2-queue-step")},k.insertQueueStep=function(n,t){return t&&t<w.length?w.splice(t,0,n):w.push(n)},k.deleteQueueStep=function(n){void 0!==w[n]&&w.splice(n,1)},k.close=k.closePopup=k.closeModal=k.closeToast=function(n){var t=A(),e=B();if(e){$(e,o.show),D(e,o.hide),clearTimeout(e.timeout),M()||(G(),window.onkeydown=f,m=!1);var a=function(){t.parentNode&&t.parentNode.removeChild(t),$([document.documentElement,document.body],[o.shown,o["no-backdrop"],o["has-input"],o["toast-shown"]]),Z()&&(null!==y.previousBodyPadding&&(document.body.style.paddingRight=y.previousBodyPadding,y.previousBodyPadding=null),function(){if(R(document.body,o.iosfix)){var n=parseInt(document.body.style.top,10);$(document.body,o.iosfix),document.body.style.top="",document.body.scrollTop=-1*n}}())};F&&!R(e,o.noanimation)?e.addEventListener(F,function n(){e.removeEventListener(F,n),R(e,o.hide)&&a()}):a(),null!==n&&"function"==typeof n&&setTimeout(function(){n(e)})}},k.clickConfirm=function(){return O().click()},k.clickCancel=function(){return V().click()},k.showLoading=k.enableLoading=function(){var n=B();n||k(""),n=B();var t=N(),e=O(),a=V();W(t),W(e,"inline-block"),D([n,t],o.loading),e.disabled=!0,a.disabled=!0,n.setAttribute("aria-busy",!0),n.focus()},k.isValidParameter=function(t){return n.hasOwnProperty(t)||"extraParams"===t},k.isDeprecatedParameter=function(n){return-1!==t.indexOf(n)},k.setDefaults=function(n){if(!n||"object"!==(void 0===n?"undefined":p(n)))return i("the argument for setDefaults() is required and has to be a object");b(n);for(var t in n)k.isValidParameter(t)&&(d[t]=n[t])},k.resetDefaults=function(){d=u({},n)},k.adaptInputValidator=function(n){return function(t,e){return n.call(this,t,e).then(function(){},function(n){return n})}},k.noop=function(){},k.version="7.1.3",k.default=k,"undefined"!=typeof window&&"object"===p(window._swalDefaults)&&k.setDefaults(window._swalDefaults);var y={previousActiveElement:null,previousBodyPadding:null},v=function(){return"undefined"==typeof window||"undefined"==typeof document},C=function(n){var t=A();t&&(t.parentNode.removeChild(t),$([document.documentElement,document.body],[o["no-backdrop"],o["has-input"],o["toast-shown"]]));{if(!v()){var e=document.createElement("div");e.className=o.container,e.innerHTML=S;("string"==typeof n.target?document.querySelector(n.target):n.target).appendChild(e);var a=B(),s=U(a,o.input),r=U(a,o.file),l=a.querySelector("."+o.range+" input"),c=a.querySelector("."+o.range+" output"),p=U(a,o.select),u=a.querySelector("."+o.checkbox+" input"),d=U(a,o.textarea);a.setAttribute("aria-live",n.toast?"polite":"assertive");var w=function(){k.isVisible()&&k.resetValidationError()};return s.oninput=w,r.onchange=w,p.onchange=w,u.onchange=w,d.oninput=w,l.oninput=function(){w(),c.value=l.value},l.onchange=function(){w(),l.previousSibling.value=l.value},a}i("SweetAlert2 requires document to initialize")}},S=('\n <div role="dialog" aria-modal="true" aria-labelledby="'+o.title+'" aria-describedby="'+o.content+'" class="'+o.popup+'" tabindex="-1">\n   <ul class="'+o.progresssteps+'"></ul>\n   <div class="'+o.icon+" "+a.error+'">\n     <span class="swal2-x-mark"><span class="swal2-x-mark-line-left"></span><span class="swal2-x-mark-line-right"></span></span>\n   </div>\n   <div class="'+o.icon+" "+a.question+'">?</div>\n   <div class="'+o.icon+" "+a.warning+'">!</div>\n   <div class="'+o.icon+" "+a.info+'">i</div>\n   <div class="'+o.icon+" "+a.success+'">\n     <div class="swal2-success-circular-line-left"></div>\n     <span class="swal2-success-line-tip"></span> <span class="swal2-success-line-long"></span>\n     <div class="swal2-success-ring"></div> <div class="swal2-success-fix"></div>\n     <div class="swal2-success-circular-line-right"></div>\n   </div>\n   <img class="'+o.image+'" />\n   <div class="'+o.contentwrapper+'">\n   <h2 class="'+o.title+'" id="'+o.title+'"></h2>\n   <div id="'+o.content+'" class="'+o.content+'"></div>\n   </div>\n   <input class="'+o.input+'" />\n   <input type="file" class="'+o.file+'" />\n   <div class="'+o.range+'">\n     <output></output>\n     <input type="range" />\n   </div>\n   <select class="'+o.select+'"></select>\n   <div class="'+o.radio+'"></div>\n   <label for="'+o.checkbox+'" class="'+o.checkbox+'">\n     <input type="checkbox" />\n   </label>\n   <textarea class="'+o.textarea+'"></textarea>\n   <div class="'+o.validationerror+'" id="'+o.validationerror+'"></div>\n   <div class="'+o.buttonswrapper+'">\n     <button type="button" class="'+o.confirm+'">OK</button>\n     <button type="button" class="'+o.cancel+'">Cancel</button>\n   </div>\n   <button type="button" class="'+o.close+'">×</button>\n </div>\n').replace(/(^|\n)\s*/g,""),A=function(){return document.body.querySelector("."+o.container)},B=function(){return A()?A().querySelector("."+o.popup):null},P=function(){return B().querySelectorAll("."+o.icon)},E=function(n){return A()?A().querySelector("."+n):null},L=function(){return E(o.title)},T=function(){return E(o.content)},z=function(){return E(o.image)},q=function(){return E(o.progresssteps)},j=function(){return E(o.validationerror)},O=function(){return E(o.confirm)},V=function(){return E(o.cancel)},N=function(){return E(o.buttonswrapper)},Y=function(){return E(o.close)},H=function(){var n=Array.from(B().querySelectorAll('[tabindex]:not([tabindex="-1"]):not([tabindex="0"])')).sort(function(n,t){return n=parseInt(n.getAttribute("tabindex")),t=parseInt(t.getAttribute("tabindex")),n>t?1:n<t?-1:0}),t=Array.prototype.slice.call(B().querySelectorAll('button, input:not([type=hidden]), textarea, select, a, [tabindex="0"]'));return function(n){var t=[];for(var e in n)-1===t.indexOf(n[e])&&t.push(n[e]);return t}(n.concat(t))},Z=function(){return!document.body.classList.contains(o["toast-shown"])},M=function(){return document.body.classList.contains(o["toast-shown"])},R=function(n,t){return!!n.classList&&n.classList.contains(t)},I=function(n){if(n.focus(),"file"!==n.type){var t=n.value;n.value="",n.value=t}},X=function(n,t,e){n&&t&&("string"==typeof t&&(t=t.split(/\s+/).filter(Boolean)),t.forEach(function(t){n.forEach?n.forEach(function(n){e?n.classList.add(t):n.classList.remove(t)}):e?n.classList.add(t):n.classList.remove(t)}))},D=function(n,t){X(n,t,!0)},$=function(n,t){X(n,t,!1)},U=function(n,t){for(var e=0;e<n.childNodes.length;e++)if(R(n.childNodes[e],t))return n.childNodes[e]},W=function(n,t){t||(t=n===B()||n===N()?"flex":"block"),n.style.opacity="",n.style.display=t},K=function(n){n.style.opacity="",n.style.display="none"},_=function(n){for(;n.firstChild;)n.removeChild(n.firstChild)},Q=function(n){return n.offsetWidth||n.offsetHeight||n.getClientRects().length},J=function(n,t){n.style.removeProperty?n.style.removeProperty(t):n.style.removeAttribute(t)},F=function(){if(v())return!1;var n=document.createElement("div"),t={WebkitAnimation:"webkitAnimationEnd",OAnimation:"oAnimationEnd oanimationend",animation:"animationend"};for(var e in t)if(t.hasOwnProperty(e)&&void 0!==n.style[e])return t[e];return!1}(),G=function(){if(y.previousActiveElement&&y.previousActiveElement.focus){var n=window.scrollX,t=window.scrollY;y.previousActiveElement.focus(),void 0!==n&&void 0!==t&&window.scrollTo(n,t)}},nn=function(){if("ontouchstart"in window||navigator.msMaxTouchPoints)return 0;var n=document.createElement("div");n.style.width="50px",n.style.height="50px",n.style.overflow="scroll",document.body.appendChild(n);var t=n.offsetWidth-n.clientWidth;return document.body.removeChild(n),t};return function(){var n=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"";if(v())return!1;var t=document.head||document.getElementsByTagName("head")[0],e=document.createElement("style");e.type="text/css",t.appendChild(e),e.styleSheet?e.styleSheet.cssText=n:e.appendChild(document.createTextNode(n))}("html.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown),\nbody.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown) {\n  overflow-y: hidden; }\n\nbody.swal2-toast-shown.swal2-has-input > .swal2-container > .swal2-toast {\n  -webkit-box-orient: vertical;\n  -webkit-box-direction: normal;\n      -ms-flex-direction: column;\n          flex-direction: column; }\n  body.swal2-toast-shown.swal2-has-input > .swal2-container > .swal2-toast .swal2-icon {\n    margin: 0 0 15px; }\n  body.swal2-toast-shown.swal2-has-input > .swal2-container > .swal2-toast .swal2-buttonswrapper {\n    -webkit-box-flex: 1;\n        -ms-flex: 1;\n            flex: 1;\n    -ms-flex-item-align: stretch;\n        align-self: stretch;\n    -webkit-box-pack: end;\n        -ms-flex-pack: end;\n            justify-content: flex-end; }\n  body.swal2-toast-shown.swal2-has-input > .swal2-container > .swal2-toast .swal2-loading {\n    -webkit-box-pack: center;\n        -ms-flex-pack: center;\n            justify-content: center; }\n  body.swal2-toast-shown.swal2-has-input > .swal2-container > .swal2-toast .swal2-input {\n    height: 32px;\n    font-size: 14px;\n    margin: 5px auto; }\n\nbody.swal2-toast-shown > .swal2-container {\n  position: fixed;\n  background-color: transparent; }\n  body.swal2-toast-shown > .swal2-container.swal2-shown {\n    background-color: transparent; }\n  body.swal2-toast-shown > .swal2-container.swal2-top {\n    top: 0;\n    left: 50%;\n    bottom: auto;\n    right: auto;\n    -webkit-transform: translateX(-50%);\n            transform: translateX(-50%); }\n  body.swal2-toast-shown > .swal2-container.swal2-top-right {\n    top: 0;\n    left: auto;\n    bottom: auto;\n    right: 0; }\n  body.swal2-toast-shown > .swal2-container.swal2-top-left {\n    top: 0;\n    left: 0;\n    bottom: auto;\n    right: auto; }\n  body.swal2-toast-shown > .swal2-container.swal2-center-left {\n    top: 50%;\n    left: 0;\n    bottom: auto;\n    right: auto;\n    -webkit-transform: translateY(-50%);\n            transform: translateY(-50%); }\n  body.swal2-toast-shown > .swal2-container.swal2-center {\n    top: 50%;\n    left: 50%;\n    bottom: auto;\n    right: auto;\n    -webkit-transform: translate(-50%, -50%);\n            transform: translate(-50%, -50%); }\n  body.swal2-toast-shown > .swal2-container.swal2-center-right {\n    top: 50%;\n    left: auto;\n    bottom: auto;\n    right: 0;\n    -webkit-transform: translateY(-50%);\n            transform: translateY(-50%); }\n  body.swal2-toast-shown > .swal2-container.swal2-bottom-left {\n    top: auto;\n    left: 0;\n    bottom: 0;\n    right: auto; }\n  body.swal2-toast-shown > .swal2-container.swal2-bottom {\n    top: auto;\n    left: 50%;\n    bottom: 0;\n    right: auto;\n    -webkit-transform: translateX(-50%);\n            transform: translateX(-50%); }\n  body.swal2-toast-shown > .swal2-container.swal2-bottom-right {\n    top: auto;\n    left: auto;\n    bottom: 0;\n    right: 0; }\n\nbody.swal2-iosfix {\n  position: fixed;\n  left: 0;\n  right: 0; }\n\nbody.swal2-no-backdrop > .swal2-shown {\n  top: auto;\n  bottom: auto;\n  left: auto;\n  right: auto;\n  background-color: transparent; }\n  body.swal2-no-backdrop > .swal2-shown > .swal2-modal {\n    -webkit-box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);\n            box-shadow: 0 0 10px rgba(0, 0, 0, 0.4); }\n  body.swal2-no-backdrop > .swal2-shown.swal2-top {\n    top: 0;\n    left: 50%;\n    -webkit-transform: translateX(-50%);\n            transform: translateX(-50%); }\n  body.swal2-no-backdrop > .swal2-shown.swal2-top-left {\n    top: 0;\n    left: 0; }\n  body.swal2-no-backdrop > .swal2-shown.swal2-top-right {\n    top: 0;\n    right: 0; }\n  body.swal2-no-backdrop > .swal2-shown.swal2-center {\n    top: 50%;\n    left: 50%;\n    -webkit-transform: translate(-50%, -50%);\n            transform: translate(-50%, -50%); }\n  body.swal2-no-backdrop > .swal2-shown.swal2-center-left {\n    top: 50%;\n    left: 0;\n    -webkit-transform: translateY(-50%);\n            transform: translateY(-50%); }\n  body.swal2-no-backdrop > .swal2-shown.swal2-center-right {\n    top: 50%;\n    right: 0;\n    -webkit-transform: translateY(-50%);\n            transform: translateY(-50%); }\n  body.swal2-no-backdrop > .swal2-shown.swal2-bottom {\n    bottom: 0;\n    left: 50%;\n    -webkit-transform: translateX(-50%);\n            transform: translateX(-50%); }\n  body.swal2-no-backdrop > .swal2-shown.swal2-bottom-left {\n    bottom: 0;\n    left: 0; }\n  body.swal2-no-backdrop > .swal2-shown.swal2-bottom-right {\n    bottom: 0;\n    right: 0; }\n\n.swal2-container {\n  display: -webkit-box;\n  display: -ms-flexbox;\n  display: flex;\n  -webkit-box-orient: horizontal;\n  -webkit-box-direction: normal;\n      -ms-flex-direction: row;\n          flex-direction: row;\n  -webkit-box-align: center;\n      -ms-flex-align: center;\n          align-items: center;\n  -webkit-box-pack: center;\n      -ms-flex-pack: center;\n          justify-content: center;\n  position: fixed;\n  padding: 10px;\n  top: 0;\n  left: 0;\n  right: 0;\n  bottom: 0;\n  background-color: transparent;\n  z-index: 1060; }\n  .swal2-container.swal2-top {\n    -webkit-box-align: start;\n        -ms-flex-align: start;\n            align-items: flex-start; }\n  .swal2-container.swal2-top-left {\n    -webkit-box-align: start;\n        -ms-flex-align: start;\n            align-items: flex-start;\n    -webkit-box-pack: start;\n        -ms-flex-pack: start;\n            justify-content: flex-start; }\n  .swal2-container.swal2-top-right {\n    -webkit-box-align: start;\n        -ms-flex-align: start;\n            align-items: flex-start;\n    -webkit-box-pack: end;\n        -ms-flex-pack: end;\n            justify-content: flex-end; }\n  .swal2-container.swal2-center {\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center; }\n  .swal2-container.swal2-center-left {\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n    -webkit-box-pack: start;\n        -ms-flex-pack: start;\n            justify-content: flex-start; }\n  .swal2-container.swal2-center-right {\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n    -webkit-box-pack: end;\n        -ms-flex-pack: end;\n            justify-content: flex-end; }\n  .swal2-container.swal2-bottom {\n    -webkit-box-align: end;\n        -ms-flex-align: end;\n            align-items: flex-end; }\n  .swal2-container.swal2-bottom-left {\n    -webkit-box-align: end;\n        -ms-flex-align: end;\n            align-items: flex-end;\n    -webkit-box-pack: start;\n        -ms-flex-pack: start;\n            justify-content: flex-start; }\n  .swal2-container.swal2-bottom-right {\n    -webkit-box-align: end;\n        -ms-flex-align: end;\n            align-items: flex-end;\n    -webkit-box-pack: end;\n        -ms-flex-pack: end;\n            justify-content: flex-end; }\n  .swal2-container.swal2-grow-fullscreen > .swal2-modal {\n    display: -webkit-box !important;\n    display: -ms-flexbox !important;\n    display: flex !important;\n    -webkit-box-flex: 1;\n        -ms-flex: 1;\n            flex: 1;\n    -ms-flex-item-align: stretch;\n        align-self: stretch;\n    -webkit-box-pack: center;\n        -ms-flex-pack: center;\n            justify-content: center; }\n  .swal2-container.swal2-grow-row > .swal2-modal {\n    display: -webkit-box !important;\n    display: -ms-flexbox !important;\n    display: flex !important;\n    -webkit-box-flex: 1;\n        -ms-flex: 1;\n            flex: 1;\n    -ms-flex-line-pack: center;\n        align-content: center;\n    -webkit-box-pack: center;\n        -ms-flex-pack: center;\n            justify-content: center; }\n  .swal2-container.swal2-grow-column {\n    -webkit-box-flex: 1;\n        -ms-flex: 1;\n            flex: 1;\n    -webkit-box-orient: vertical;\n    -webkit-box-direction: normal;\n        -ms-flex-direction: column;\n            flex-direction: column; }\n    .swal2-container.swal2-grow-column.swal2-top, .swal2-container.swal2-grow-column.swal2-center, .swal2-container.swal2-grow-column.swal2-bottom {\n      -webkit-box-align: center;\n          -ms-flex-align: center;\n              align-items: center; }\n    .swal2-container.swal2-grow-column.swal2-top-left, .swal2-container.swal2-grow-column.swal2-center-left, .swal2-container.swal2-grow-column.swal2-bottom-left {\n      -webkit-box-align: start;\n          -ms-flex-align: start;\n              align-items: flex-start; }\n    .swal2-container.swal2-grow-column.swal2-top-right, .swal2-container.swal2-grow-column.swal2-center-right, .swal2-container.swal2-grow-column.swal2-bottom-right {\n      -webkit-box-align: end;\n          -ms-flex-align: end;\n              align-items: flex-end; }\n    .swal2-container.swal2-grow-column > .swal2-modal {\n      display: -webkit-box !important;\n      display: -ms-flexbox !important;\n      display: flex !important;\n      -webkit-box-flex: 1;\n          -ms-flex: 1;\n              flex: 1;\n      -ms-flex-line-pack: center;\n          align-content: center;\n      -webkit-box-pack: center;\n          -ms-flex-pack: center;\n              justify-content: center; }\n  .swal2-container:not(.swal2-top):not(.swal2-top-left):not(.swal2-top-right):not(.swal2-center-left):not(.swal2-center-right):not(.swal2-bottom):not(.swal2-bottom-left):not(.swal2-bottom-right) > .swal2-modal {\n    margin: auto; }\n  @media all and (-ms-high-contrast: none), (-ms-high-contrast: active) {\n    .swal2-container .swal2-modal {\n      margin: 0 !important; } }\n  .swal2-container.swal2-fade {\n    -webkit-transition: background-color .1s;\n    transition: background-color .1s; }\n  .swal2-container.swal2-shown {\n    background-color: rgba(0, 0, 0, 0.4); }\n\n.swal2-popup {\n  -webkit-box-orient: vertical;\n  -webkit-box-direction: normal;\n      -ms-flex-direction: column;\n          flex-direction: column;\n  background-color: #fff;\n  font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;\n  border-radius: 5px;\n  -webkit-box-sizing: border-box;\n          box-sizing: border-box;\n  text-align: center;\n  overflow-x: hidden;\n  overflow-y: auto;\n  display: none;\n  position: relative;\n  max-width: 100%; }\n  .swal2-popup.swal2-toast {\n    width: 300px;\n    padding: 0 15px;\n    -webkit-box-orient: horizontal;\n    -webkit-box-direction: normal;\n        -ms-flex-direction: row;\n            flex-direction: row;\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n    overflow-y: hidden;\n    -webkit-box-shadow: 0 0 10px #d9d9d9;\n            box-shadow: 0 0 10px #d9d9d9; }\n    .swal2-popup.swal2-toast .swal2-title {\n      max-width: 300px;\n      font-size: 16px;\n      text-align: left; }\n    .swal2-popup.swal2-toast .swal2-content {\n      font-size: 14px;\n      text-align: left; }\n    .swal2-popup.swal2-toast .swal2-icon {\n      width: 32px;\n      min-width: 32px;\n      height: 32px;\n      margin: 0 15px 0 0; }\n      .swal2-popup.swal2-toast .swal2-icon.swal2-success .swal2-success-ring {\n        width: 32px;\n        height: 32px; }\n      .swal2-popup.swal2-toast .swal2-icon.swal2-info, .swal2-popup.swal2-toast .swal2-icon.swal2-warning, .swal2-popup.swal2-toast .swal2-icon.swal2-question {\n        font-size: 26px;\n        line-height: 32px; }\n      .swal2-popup.swal2-toast .swal2-icon.swal2-error [class^='swal2-x-mark-line'] {\n        top: 14px;\n        width: 22px; }\n        .swal2-popup.swal2-toast .swal2-icon.swal2-error [class^='swal2-x-mark-line'][class$='left'] {\n          left: 5px; }\n        .swal2-popup.swal2-toast .swal2-icon.swal2-error [class^='swal2-x-mark-line'][class$='right'] {\n          right: 5px; }\n    .swal2-popup.swal2-toast .swal2-buttonswrapper {\n      margin: 0 0 0 5px; }\n    .swal2-popup.swal2-toast .swal2-styled {\n      margin: 0 0 0 5px;\n      padding: 5px 10px; }\n      .swal2-popup.swal2-toast .swal2-styled:focus {\n        -webkit-box-shadow: 0 0 0 1px #fff, 0 0 0 2px rgba(50, 100, 150, 0.4);\n                box-shadow: 0 0 0 1px #fff, 0 0 0 2px rgba(50, 100, 150, 0.4); }\n    .swal2-popup.swal2-toast .swal2-validationerror {\n      width: 100%;\n      margin: 5px -20px; }\n    .swal2-popup.swal2-toast .swal2-success {\n      border-color: #a5dc86; }\n      .swal2-popup.swal2-toast .swal2-success [class^='swal2-success-circular-line'] {\n        border-radius: 50%;\n        position: absolute;\n        width: 32px;\n        height: 64px;\n        -webkit-transform: rotate(45deg);\n                transform: rotate(45deg); }\n        .swal2-popup.swal2-toast .swal2-success [class^='swal2-success-circular-line'][class$='left'] {\n          border-radius: 64px 0 0 64px;\n          top: -4px;\n          left: -15px;\n          -webkit-transform: rotate(-45deg);\n                  transform: rotate(-45deg);\n          -webkit-transform-origin: 32px 32px;\n                  transform-origin: 32px 32px; }\n        .swal2-popup.swal2-toast .swal2-success [class^='swal2-success-circular-line'][class$='right'] {\n          border-radius: 0 64px 64px 0;\n          top: -5px;\n          left: 14px;\n          -webkit-transform-origin: 0 32px;\n                  transform-origin: 0 32px; }\n      .swal2-popup.swal2-toast .swal2-success .swal2-success-ring {\n        width: 32px;\n        height: 32px; }\n      .swal2-popup.swal2-toast .swal2-success .swal2-success-fix {\n        width: 7px;\n        height: 90px;\n        left: 28px;\n        top: 8px; }\n      .swal2-popup.swal2-toast .swal2-success [class^='swal2-success-line'] {\n        height: 5px; }\n        .swal2-popup.swal2-toast .swal2-success [class^='swal2-success-line'][class$='tip'] {\n          width: 12px;\n          left: 3px;\n          top: 18px; }\n        .swal2-popup.swal2-toast .swal2-success [class^='swal2-success-line'][class$='long'] {\n          width: 22px;\n          right: 3px;\n          top: 15px; }\n    .swal2-popup.swal2-toast .swal2-animate-success-line-tip {\n      -webkit-animation: animate-toast-success-tip .75s;\n              animation: animate-toast-success-tip .75s; }\n    .swal2-popup.swal2-toast .swal2-animate-success-line-long {\n      -webkit-animation: animate-toast-success-long .75s;\n              animation: animate-toast-success-long .75s; }\n  .swal2-popup:focus {\n    outline: none; }\n  .swal2-popup.swal2-loading {\n    overflow-y: hidden; }\n  .swal2-popup .swal2-title {\n    color: #595959;\n    font-size: 30px;\n    text-align: center;\n    font-weight: 600;\n    text-transform: none;\n    position: relative;\n    margin: 0 0 .4em;\n    padding: 0;\n    display: block;\n    word-wrap: break-word; }\n  .swal2-popup .swal2-buttonswrapper {\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n    -webkit-box-pack: center;\n        -ms-flex-pack: center;\n            justify-content: center;\n    margin-top: 15px; }\n    .swal2-popup .swal2-buttonswrapper:not(.swal2-loading) .swal2-styled[disabled] {\n      opacity: .4;\n      cursor: no-drop; }\n    .swal2-popup .swal2-buttonswrapper.swal2-loading .swal2-styled.swal2-confirm {\n      -webkit-box-sizing: border-box;\n              box-sizing: border-box;\n      border: 4px solid transparent;\n      border-color: transparent;\n      width: 40px;\n      height: 40px;\n      padding: 0;\n      margin: 7.5px;\n      vertical-align: top;\n      background-color: transparent !important;\n      color: transparent;\n      cursor: default;\n      border-radius: 100%;\n      -webkit-animation: rotate-loading 1.5s linear 0s infinite normal;\n              animation: rotate-loading 1.5s linear 0s infinite normal;\n      -webkit-user-select: none;\n         -moz-user-select: none;\n          -ms-user-select: none;\n              user-select: none; }\n    .swal2-popup .swal2-buttonswrapper.swal2-loading .swal2-styled.swal2-cancel {\n      margin-left: 30px;\n      margin-right: 30px; }\n    .swal2-popup .swal2-buttonswrapper.swal2-loading :not(.swal2-styled).swal2-confirm::after {\n      display: inline-block;\n      content: '';\n      margin-left: 5px;\n      vertical-align: -1px;\n      height: 15px;\n      width: 15px;\n      border: 3px solid #999999;\n      -webkit-box-shadow: 1px 1px 1px #fff;\n              box-shadow: 1px 1px 1px #fff;\n      border-right-color: transparent;\n      border-radius: 50%;\n      -webkit-animation: rotate-loading 1.5s linear 0s infinite normal;\n              animation: rotate-loading 1.5s linear 0s infinite normal; }\n  .swal2-popup .swal2-styled {\n    border: 0;\n    border-radius: 3px;\n    -webkit-box-shadow: none;\n            box-shadow: none;\n    color: #fff;\n    cursor: pointer;\n    font-size: 17px;\n    font-weight: 500;\n    margin: 15px 5px 0;\n    padding: 10px 32px; }\n    .swal2-popup .swal2-styled:focus {\n      outline: none;\n      -webkit-box-shadow: 0 0 0 2px #fff, 0 0 0 4px rgba(50, 100, 150, 0.4);\n              box-shadow: 0 0 0 2px #fff, 0 0 0 4px rgba(50, 100, 150, 0.4); }\n  .swal2-popup .swal2-image {\n    margin: 20px auto;\n    max-width: 100%; }\n  .swal2-popup .swal2-close {\n    background: transparent;\n    border: 0;\n    margin: 0;\n    padding: 0;\n    width: 38px;\n    height: 40px;\n    font-size: 36px;\n    line-height: 40px;\n    font-family: serif;\n    position: absolute;\n    top: 5px;\n    right: 8px;\n    cursor: pointer;\n    color: #cccccc;\n    -webkit-transition: color .1s ease;\n    transition: color .1s ease; }\n    .swal2-popup .swal2-close:hover {\n      color: #d55; }\n  .swal2-popup > .swal2-input,\n  .swal2-popup > .swal2-file,\n  .swal2-popup > .swal2-textarea,\n  .swal2-popup > .swal2-select,\n  .swal2-popup > .swal2-radio,\n  .swal2-popup > .swal2-checkbox {\n    display: none; }\n  .swal2-popup .swal2-content {\n    font-size: 18px;\n    text-align: center;\n    font-weight: 300;\n    position: relative;\n    float: none;\n    margin: 0;\n    padding: 0;\n    line-height: normal;\n    color: #545454;\n    word-wrap: break-word; }\n  .swal2-popup .swal2-input,\n  .swal2-popup .swal2-file,\n  .swal2-popup .swal2-textarea,\n  .swal2-popup .swal2-select,\n  .swal2-popup .swal2-radio,\n  .swal2-popup .swal2-checkbox {\n    margin: 20px auto; }\n  .swal2-popup .swal2-input,\n  .swal2-popup .swal2-file,\n  .swal2-popup .swal2-textarea {\n    width: 100%;\n    -webkit-box-sizing: border-box;\n            box-sizing: border-box;\n    font-size: 18px;\n    border-radius: 3px;\n    border: 1px solid #d9d9d9;\n    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.06);\n            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.06);\n    -webkit-transition: border-color .3s, -webkit-box-shadow .3s;\n    transition: border-color .3s, -webkit-box-shadow .3s;\n    transition: border-color .3s, box-shadow .3s;\n    transition: border-color .3s, box-shadow .3s, -webkit-box-shadow .3s; }\n    .swal2-popup .swal2-input.swal2-inputerror,\n    .swal2-popup .swal2-file.swal2-inputerror,\n    .swal2-popup .swal2-textarea.swal2-inputerror {\n      border-color: #f27474 !important;\n      -webkit-box-shadow: 0 0 2px #f27474 !important;\n              box-shadow: 0 0 2px #f27474 !important; }\n    .swal2-popup .swal2-input:focus,\n    .swal2-popup .swal2-file:focus,\n    .swal2-popup .swal2-textarea:focus {\n      outline: none;\n      border: 1px solid #b4dbed;\n      -webkit-box-shadow: 0 0 3px #c4e6f5;\n              box-shadow: 0 0 3px #c4e6f5; }\n    .swal2-popup .swal2-input::-webkit-input-placeholder,\n    .swal2-popup .swal2-file::-webkit-input-placeholder,\n    .swal2-popup .swal2-textarea::-webkit-input-placeholder {\n      color: #cccccc; }\n    .swal2-popup .swal2-input:-ms-input-placeholder,\n    .swal2-popup .swal2-file:-ms-input-placeholder,\n    .swal2-popup .swal2-textarea:-ms-input-placeholder {\n      color: #cccccc; }\n    .swal2-popup .swal2-input::-ms-input-placeholder,\n    .swal2-popup .swal2-file::-ms-input-placeholder,\n    .swal2-popup .swal2-textarea::-ms-input-placeholder {\n      color: #cccccc; }\n    .swal2-popup .swal2-input::placeholder,\n    .swal2-popup .swal2-file::placeholder,\n    .swal2-popup .swal2-textarea::placeholder {\n      color: #cccccc; }\n  .swal2-popup .swal2-range input {\n    float: left;\n    width: 80%; }\n  .swal2-popup .swal2-range output {\n    float: right;\n    width: 20%;\n    font-size: 20px;\n    font-weight: 600;\n    text-align: center; }\n  .swal2-popup .swal2-range input,\n  .swal2-popup .swal2-range output {\n    height: 43px;\n    line-height: 43px;\n    vertical-align: middle;\n    margin: 20px auto;\n    padding: 0; }\n  .swal2-popup .swal2-input {\n    height: 43px;\n    padding: 0 12px; }\n    .swal2-popup .swal2-input[type='number'] {\n      max-width: 150px; }\n  .swal2-popup .swal2-file {\n    font-size: 20px; }\n  .swal2-popup .swal2-textarea {\n    height: 108px;\n    padding: 12px; }\n  .swal2-popup .swal2-select {\n    color: #545454;\n    font-size: inherit;\n    padding: 5px 10px;\n    min-width: 40%;\n    max-width: 100%; }\n  .swal2-popup .swal2-radio {\n    border: 0; }\n    .swal2-popup .swal2-radio label:not(:first-child) {\n      margin-left: 20px; }\n    .swal2-popup .swal2-radio input,\n    .swal2-popup .swal2-radio span {\n      vertical-align: middle; }\n    .swal2-popup .swal2-radio input {\n      margin: 0 3px 0 0; }\n  .swal2-popup .swal2-checkbox {\n    color: #545454; }\n    .swal2-popup .swal2-checkbox input,\n    .swal2-popup .swal2-checkbox span {\n      vertical-align: middle; }\n  .swal2-popup .swal2-validationerror {\n    background-color: #f0f0f0;\n    margin: 0 -20px;\n    overflow: hidden;\n    padding: 10px;\n    color: gray;\n    font-size: 16px;\n    font-weight: 300;\n    display: none; }\n    .swal2-popup .swal2-validationerror::before {\n      content: '!';\n      display: inline-block;\n      width: 24px;\n      height: 24px;\n      border-radius: 50%;\n      background-color: #ea7d7d;\n      color: #fff;\n      line-height: 24px;\n      text-align: center;\n      margin-right: 10px; }\n\n@supports (-ms-accelerator: true) {\n  .swal2-range input {\n    width: 100% !important; }\n  .swal2-range output {\n    display: none; } }\n\n@media all and (-ms-high-contrast: none), (-ms-high-contrast: active) {\n  .swal2-range input {\n    width: 100% !important; }\n  .swal2-range output {\n    display: none; } }\n\n.swal2-icon {\n  width: 80px;\n  height: 80px;\n  border: 4px solid transparent;\n  border-radius: 50%;\n  margin: 20px auto 30px;\n  padding: 0;\n  position: relative;\n  -webkit-box-sizing: content-box;\n          box-sizing: content-box;\n  cursor: default;\n  -webkit-user-select: none;\n     -moz-user-select: none;\n      -ms-user-select: none;\n          user-select: none; }\n  .swal2-icon.swal2-error {\n    border-color: #f27474; }\n    .swal2-icon.swal2-error .swal2-x-mark {\n      position: relative;\n      display: block; }\n    .swal2-icon.swal2-error [class^='swal2-x-mark-line'] {\n      position: absolute;\n      height: 5px;\n      width: 47px;\n      background-color: #f27474;\n      display: block;\n      top: 37px;\n      border-radius: 2px; }\n      .swal2-icon.swal2-error [class^='swal2-x-mark-line'][class$='left'] {\n        -webkit-transform: rotate(45deg);\n                transform: rotate(45deg);\n        left: 17px; }\n      .swal2-icon.swal2-error [class^='swal2-x-mark-line'][class$='right'] {\n        -webkit-transform: rotate(-45deg);\n                transform: rotate(-45deg);\n        right: 16px; }\n  .swal2-icon.swal2-warning {\n    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;\n    color: #f8bb86;\n    border-color: #facea8;\n    font-size: 60px;\n    line-height: 80px;\n    text-align: center; }\n  .swal2-icon.swal2-info {\n    font-family: 'Open Sans', sans-serif;\n    color: #3fc3ee;\n    border-color: #9de0f6;\n    font-size: 60px;\n    line-height: 80px;\n    text-align: center; }\n  .swal2-icon.swal2-question {\n    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;\n    color: #87adbd;\n    border-color: #c9dae1;\n    font-size: 60px;\n    line-height: 80px;\n    text-align: center; }\n  .swal2-icon.swal2-success {\n    border-color: #a5dc86; }\n    .swal2-icon.swal2-success [class^='swal2-success-circular-line'] {\n      border-radius: 50%;\n      position: absolute;\n      width: 60px;\n      height: 120px;\n      -webkit-transform: rotate(45deg);\n              transform: rotate(45deg); }\n      .swal2-icon.swal2-success [class^='swal2-success-circular-line'][class$='left'] {\n        border-radius: 120px 0 0 120px;\n        top: -7px;\n        left: -33px;\n        -webkit-transform: rotate(-45deg);\n                transform: rotate(-45deg);\n        -webkit-transform-origin: 60px 60px;\n                transform-origin: 60px 60px; }\n      .swal2-icon.swal2-success [class^='swal2-success-circular-line'][class$='right'] {\n        border-radius: 0 120px 120px 0;\n        top: -11px;\n        left: 30px;\n        -webkit-transform: rotate(-45deg);\n                transform: rotate(-45deg);\n        -webkit-transform-origin: 0 60px;\n                transform-origin: 0 60px; }\n    .swal2-icon.swal2-success .swal2-success-ring {\n      width: 80px;\n      height: 80px;\n      border: 4px solid rgba(165, 220, 134, 0.2);\n      border-radius: 50%;\n      -webkit-box-sizing: content-box;\n              box-sizing: content-box;\n      position: absolute;\n      left: -4px;\n      top: -4px;\n      z-index: 2; }\n    .swal2-icon.swal2-success .swal2-success-fix {\n      width: 7px;\n      height: 90px;\n      position: absolute;\n      left: 28px;\n      top: 8px;\n      z-index: 1;\n      -webkit-transform: rotate(-45deg);\n              transform: rotate(-45deg); }\n    .swal2-icon.swal2-success [class^='swal2-success-line'] {\n      height: 5px;\n      background-color: #a5dc86;\n      display: block;\n      border-radius: 2px;\n      position: absolute;\n      z-index: 2; }\n      .swal2-icon.swal2-success [class^='swal2-success-line'][class$='tip'] {\n        width: 25px;\n        left: 14px;\n        top: 46px;\n        -webkit-transform: rotate(45deg);\n                transform: rotate(45deg); }\n      .swal2-icon.swal2-success [class^='swal2-success-line'][class$='long'] {\n        width: 47px;\n        right: 8px;\n        top: 38px;\n        -webkit-transform: rotate(-45deg);\n                transform: rotate(-45deg); }\n\n.swal2-progresssteps {\n  font-weight: 600;\n  margin: 0 0 20px;\n  padding: 0; }\n  .swal2-progresssteps li {\n    display: inline-block;\n    position: relative; }\n  .swal2-progresssteps .swal2-progresscircle {\n    background: #3085d6;\n    border-radius: 2em;\n    color: #fff;\n    height: 2em;\n    line-height: 2em;\n    text-align: center;\n    width: 2em;\n    z-index: 20; }\n    .swal2-progresssteps .swal2-progresscircle:first-child {\n      margin-left: 0; }\n    .swal2-progresssteps .swal2-progresscircle:last-child {\n      margin-right: 0; }\n    .swal2-progresssteps .swal2-progresscircle.swal2-activeprogressstep {\n      background: #3085d6; }\n      .swal2-progresssteps .swal2-progresscircle.swal2-activeprogressstep ~ .swal2-progresscircle {\n        background: #add8e6; }\n      .swal2-progresssteps .swal2-progresscircle.swal2-activeprogressstep ~ .swal2-progressline {\n        background: #add8e6; }\n  .swal2-progresssteps .swal2-progressline {\n    background: #3085d6;\n    height: .4em;\n    margin: 0 -1px;\n    z-index: 10; }\n\n[class^='swal2'] {\n  -webkit-tap-highlight-color: transparent; }\n\n@-webkit-keyframes showSweetToast {\n  0% {\n    -webkit-transform: translateY(-10px) rotateZ(2deg);\n            transform: translateY(-10px) rotateZ(2deg);\n    opacity: 0; }\n  33% {\n    -webkit-transform: translateY(0) rotateZ(-2deg);\n            transform: translateY(0) rotateZ(-2deg);\n    opacity: .5; }\n  66% {\n    -webkit-transform: translateY(5px) rotateZ(2deg);\n            transform: translateY(5px) rotateZ(2deg);\n    opacity: .7; }\n  100% {\n    -webkit-transform: translateY(0) rotateZ(0);\n            transform: translateY(0) rotateZ(0);\n    opacity: 1; } }\n\n@keyframes showSweetToast {\n  0% {\n    -webkit-transform: translateY(-10px) rotateZ(2deg);\n            transform: translateY(-10px) rotateZ(2deg);\n    opacity: 0; }\n  33% {\n    -webkit-transform: translateY(0) rotateZ(-2deg);\n            transform: translateY(0) rotateZ(-2deg);\n    opacity: .5; }\n  66% {\n    -webkit-transform: translateY(5px) rotateZ(2deg);\n            transform: translateY(5px) rotateZ(2deg);\n    opacity: .7; }\n  100% {\n    -webkit-transform: translateY(0) rotateZ(0);\n            transform: translateY(0) rotateZ(0);\n    opacity: 1; } }\n\n@-webkit-keyframes hideSweetToast {\n  0% {\n    opacity: 1; }\n  33% {\n    opacity: .5; }\n  100% {\n    -webkit-transform: rotateZ(1deg);\n            transform: rotateZ(1deg);\n    opacity: 0; } }\n\n@keyframes hideSweetToast {\n  0% {\n    opacity: 1; }\n  33% {\n    opacity: .5; }\n  100% {\n    -webkit-transform: rotateZ(1deg);\n            transform: rotateZ(1deg);\n    opacity: 0; } }\n\n@-webkit-keyframes showSweetAlert {\n  0% {\n    -webkit-transform: scale(0.7);\n            transform: scale(0.7); }\n  45% {\n    -webkit-transform: scale(1.05);\n            transform: scale(1.05); }\n  80% {\n    -webkit-transform: scale(0.95);\n            transform: scale(0.95); }\n  100% {\n    -webkit-transform: scale(1);\n            transform: scale(1); } }\n\n@keyframes showSweetAlert {\n  0% {\n    -webkit-transform: scale(0.7);\n            transform: scale(0.7); }\n  45% {\n    -webkit-transform: scale(1.05);\n            transform: scale(1.05); }\n  80% {\n    -webkit-transform: scale(0.95);\n            transform: scale(0.95); }\n  100% {\n    -webkit-transform: scale(1);\n            transform: scale(1); } }\n\n@-webkit-keyframes hideSweetAlert {\n  0% {\n    -webkit-transform: scale(1);\n            transform: scale(1);\n    opacity: 1; }\n  100% {\n    -webkit-transform: scale(0.5);\n            transform: scale(0.5);\n    opacity: 0; } }\n\n@keyframes hideSweetAlert {\n  0% {\n    -webkit-transform: scale(1);\n            transform: scale(1);\n    opacity: 1; }\n  100% {\n    -webkit-transform: scale(0.5);\n            transform: scale(0.5);\n    opacity: 0; } }\n\n.swal2-show {\n  -webkit-animation: showSweetAlert .3s;\n          animation: showSweetAlert .3s; }\n  .swal2-show.swal2-toast {\n    -webkit-animation: showSweetToast .5s;\n            animation: showSweetToast .5s; }\n  .swal2-show.swal2-noanimation {\n    -webkit-animation: none;\n            animation: none; }\n\n.swal2-hide {\n  -webkit-animation: hideSweetAlert .15s forwards;\n          animation: hideSweetAlert .15s forwards; }\n  .swal2-hide.swal2-toast {\n    -webkit-animation: hideSweetToast .2s forwards;\n            animation: hideSweetToast .2s forwards; }\n  .swal2-hide.swal2-noanimation {\n    -webkit-animation: none;\n            animation: none; }\n\n[dir='rtl'] .swal2-close {\n  left: 8px;\n  right: auto; }\n\n@-webkit-keyframes animate-success-tip {\n  0% {\n    width: 0;\n    left: 1px;\n    top: 19px; }\n  54% {\n    width: 0;\n    left: 1px;\n    top: 19px; }\n  70% {\n    width: 50px;\n    left: -8px;\n    top: 37px; }\n  84% {\n    width: 17px;\n    left: 21px;\n    top: 48px; }\n  100% {\n    width: 25px;\n    left: 14px;\n    top: 45px; } }\n\n@keyframes animate-success-tip {\n  0% {\n    width: 0;\n    left: 1px;\n    top: 19px; }\n  54% {\n    width: 0;\n    left: 1px;\n    top: 19px; }\n  70% {\n    width: 50px;\n    left: -8px;\n    top: 37px; }\n  84% {\n    width: 17px;\n    left: 21px;\n    top: 48px; }\n  100% {\n    width: 25px;\n    left: 14px;\n    top: 45px; } }\n\n@-webkit-keyframes animate-success-long {\n  0% {\n    width: 0;\n    right: 46px;\n    top: 54px; }\n  65% {\n    width: 0;\n    right: 46px;\n    top: 54px; }\n  84% {\n    width: 55px;\n    right: 0;\n    top: 35px; }\n  100% {\n    width: 47px;\n    right: 8px;\n    top: 38px; } }\n\n@keyframes animate-success-long {\n  0% {\n    width: 0;\n    right: 46px;\n    top: 54px; }\n  65% {\n    width: 0;\n    right: 46px;\n    top: 54px; }\n  84% {\n    width: 55px;\n    right: 0;\n    top: 35px; }\n  100% {\n    width: 47px;\n    right: 8px;\n    top: 38px; } }\n\n@-webkit-keyframes animate-toast-success-tip {\n  0% {\n    width: 0;\n    left: 1px;\n    top: 9px; }\n  54% {\n    width: 0;\n    left: 1px;\n    top: 9px; }\n  70% {\n    width: 24px;\n    left: -4px;\n    top: 17px; }\n  84% {\n    width: 8px;\n    left: 10px;\n    top: 20px; }\n  100% {\n    width: 12px;\n    left: 3px;\n    top: 18px; } }\n\n@keyframes animate-toast-success-tip {\n  0% {\n    width: 0;\n    left: 1px;\n    top: 9px; }\n  54% {\n    width: 0;\n    left: 1px;\n    top: 9px; }\n  70% {\n    width: 24px;\n    left: -4px;\n    top: 17px; }\n  84% {\n    width: 8px;\n    left: 10px;\n    top: 20px; }\n  100% {\n    width: 12px;\n    left: 3px;\n    top: 18px; } }\n\n@-webkit-keyframes animate-toast-success-long {\n  0% {\n    width: 0;\n    right: 22px;\n    top: 26px; }\n  65% {\n    width: 0;\n    right: 22px;\n    top: 26px; }\n  84% {\n    width: 26px;\n    right: 0;\n    top: 15px; }\n  100% {\n    width: 22px;\n    right: 3px;\n    top: 15px; } }\n\n@keyframes animate-toast-success-long {\n  0% {\n    width: 0;\n    right: 22px;\n    top: 26px; }\n  65% {\n    width: 0;\n    right: 22px;\n    top: 26px; }\n  84% {\n    width: 26px;\n    right: 0;\n    top: 15px; }\n  100% {\n    width: 22px;\n    right: 3px;\n    top: 15px; } }\n\n@-webkit-keyframes rotatePlaceholder {\n  0% {\n    -webkit-transform: rotate(-45deg);\n            transform: rotate(-45deg); }\n  5% {\n    -webkit-transform: rotate(-45deg);\n            transform: rotate(-45deg); }\n  12% {\n    -webkit-transform: rotate(-405deg);\n            transform: rotate(-405deg); }\n  100% {\n    -webkit-transform: rotate(-405deg);\n            transform: rotate(-405deg); } }\n\n@keyframes rotatePlaceholder {\n  0% {\n    -webkit-transform: rotate(-45deg);\n            transform: rotate(-45deg); }\n  5% {\n    -webkit-transform: rotate(-45deg);\n            transform: rotate(-45deg); }\n  12% {\n    -webkit-transform: rotate(-405deg);\n            transform: rotate(-405deg); }\n  100% {\n    -webkit-transform: rotate(-405deg);\n            transform: rotate(-405deg); } }\n\n.swal2-animate-success-line-tip {\n  -webkit-animation: animate-success-tip .75s;\n          animation: animate-success-tip .75s; }\n\n.swal2-animate-success-line-long {\n  -webkit-animation: animate-success-long .75s;\n          animation: animate-success-long .75s; }\n\n.swal2-success.swal2-animate-success-icon .swal2-success-circular-line-right {\n  -webkit-animation: rotatePlaceholder 4.25s ease-in;\n          animation: rotatePlaceholder 4.25s ease-in; }\n\n@-webkit-keyframes animate-error-icon {\n  0% {\n    -webkit-transform: rotateX(100deg);\n            transform: rotateX(100deg);\n    opacity: 0; }\n  100% {\n    -webkit-transform: rotateX(0deg);\n            transform: rotateX(0deg);\n    opacity: 1; } }\n\n@keyframes animate-error-icon {\n  0% {\n    -webkit-transform: rotateX(100deg);\n            transform: rotateX(100deg);\n    opacity: 0; }\n  100% {\n    -webkit-transform: rotateX(0deg);\n            transform: rotateX(0deg);\n    opacity: 1; } }\n\n.swal2-animate-error-icon {\n  -webkit-animation: animate-error-icon .5s;\n          animation: animate-error-icon .5s; }\n\n@-webkit-keyframes animate-x-mark {\n  0% {\n    -webkit-transform: scale(0.4);\n            transform: scale(0.4);\n    margin-top: 26px;\n    opacity: 0; }\n  50% {\n    -webkit-transform: scale(0.4);\n            transform: scale(0.4);\n    margin-top: 26px;\n    opacity: 0; }\n  80% {\n    -webkit-transform: scale(1.15);\n            transform: scale(1.15);\n    margin-top: -6px; }\n  100% {\n    -webkit-transform: scale(1);\n            transform: scale(1);\n    margin-top: 0;\n    opacity: 1; } }\n\n@keyframes animate-x-mark {\n  0% {\n    -webkit-transform: scale(0.4);\n            transform: scale(0.4);\n    margin-top: 26px;\n    opacity: 0; }\n  50% {\n    -webkit-transform: scale(0.4);\n            transform: scale(0.4);\n    margin-top: 26px;\n    opacity: 0; }\n  80% {\n    -webkit-transform: scale(1.15);\n            transform: scale(1.15);\n    margin-top: -6px; }\n  100% {\n    -webkit-transform: scale(1);\n            transform: scale(1);\n    margin-top: 0;\n    opacity: 1; } }\n\n.swal2-animate-x-mark {\n  -webkit-animation: animate-x-mark .5s;\n          animation: animate-x-mark .5s; }\n\n@-webkit-keyframes rotate-loading {\n  0% {\n    -webkit-transform: rotate(0deg);\n            transform: rotate(0deg); }\n  100% {\n    -webkit-transform: rotate(360deg);\n            transform: rotate(360deg); } }\n\n@keyframes rotate-loading {\n  0% {\n    -webkit-transform: rotate(0deg);\n            transform: rotate(0deg); }\n  100% {\n    -webkit-transform: rotate(360deg);\n            transform: rotate(360deg); } }\n"),k}),"undefined"!=typeof window&&window.Sweetalert2&&(window.sweetAlert=window.swal=window.Sweetalert2);

// Set Editor Theme...
function editor_bind_settings() {
 
 var mode = document.getElementById('language');
 var theme = document.getElementById('theme');

 

 var supportedModes = {
    ABAP:        ["abap"],
    ABC:         ["abc"],
    ActionScript:["as"],
    ADA:         ["ada|adb"],
    Apache_Conf: ["^htaccess|^htgroups|^htpasswd|^conf|htaccess|htgroups|htpasswd"],
    AsciiDoc:    ["asciidoc|adoc"],
    Assembly_x86:["asm|a"],
    AutoHotKey:  ["ahk"],
    BatchFile:   ["bat|cmd"],
    Bro:         ["bro"],
    C_Cpp:       ["cpp|c|cc|cxx|h|hh|hpp|ino"],
    C9Search:    ["c9search_results"],
    Cirru:       ["cirru|cr"],
    Clojure:     ["clj|cljs"],
    Cobol:       ["CBL|COB"],
    coffee:      ["coffee|cf|cson|^Cakefile"],
    ColdFusion:  ["cfm"],
    CSharp:      ["cs"],
    Csound_Document: ["csd"],
    Csound_Orchestra: ["orc"],
    Csound_Score: ["sco"],
    CSS:         ["css"],
    Curly:       ["curly"],
    D:           ["d|di"],
    Dart:        ["dart"],
    Diff:        ["diff|patch"],
    Dockerfile:  ["^Dockerfile"],
    Dot:         ["dot"],
    Drools:      ["drl"],
    Dummy:       ["dummy"],
    DummySyntax: ["dummy"],
    Eiffel:      ["e|ge"],
    EJS:         ["ejs"],
    Elixir:      ["ex|exs"],
    Elm:         ["elm"],
    Erlang:      ["erl|hrl"],
    Forth:       ["frt|fs|ldr|fth|4th"],
    Fortran:     ["f|f90"],
    FTL:         ["ftl"],
    Gcode:       ["gcode"],
    Gherkin:     ["feature"],
    Gitignore:   ["^.gitignore"],
    Glsl:        ["glsl|frag|vert"],
    Gobstones:   ["gbs"],
    golang:      ["go"],
    GraphQLSchema: ["gql"],
    Groovy:      ["groovy"],
    HAML:        ["haml"],
    Handlebars:  ["hbs|handlebars|tpl|mustache"],
    Haskell:     ["hs"],
    Haskell_Cabal:     ["cabal"],
    haXe:        ["hx"],
    Hjson:       ["hjson"],
    HTML:        ["html|htm|xhtml|vue|we|wpy"],
    HTML_Elixir: ["eex|html.eex"],
    HTML_Ruby:   ["erb|rhtml|html.erb"],
    INI:         ["ini|conf|cfg|prefs"],
    Io:          ["io"],
    Jack:        ["jack"],
    Jade:        ["jade|pug"],
    Java:        ["java"],
    JavaScript:  ["js|jsm|jsx"],
    JSON:        ["json"],
    JSONiq:      ["jq"],
    JSP:         ["jsp"],
    JSSM:        ["jssm|jssm_state"],
    JSX:         ["jsx"],
    Julia:       ["jl"],
    Kotlin:      ["kt|kts"],
    LaTeX:       ["tex|latex|ltx|bib"],
    LESS:        ["less"],
    Liquid:      ["liquid"],
    Lisp:        ["lisp"],
    LiveScript:  ["ls"],
    LogiQL:      ["logic|lql"],
    LSL:         ["lsl"],
    Lua:         ["lua"],
    LuaPage:     ["lp"],
    Lucene:      ["lucene"],
    Makefile:    ["^Makefile|^GNUmakefile|^makefile|^OCamlMakefile|make"],
    Markdown:    ["md|markdown"],
    Mask:        ["mask"],
    MATLAB:      ["matlab"],
    Maze:        ["mz"],
    MEL:         ["mel"],
    MUSHCode:    ["mc|mush"],
    MySQL:       ["mysql"],
    Nix:         ["nix"],
    NSIS:        ["nsi|nsh"],
    ObjectiveC:  ["m|mm"],
    OCaml:       ["ml|mli"],
    Pascal:      ["pas|p"],
    Perl:        ["pl|pm"],
    pgSQL:       ["pgsql"],
    PHP:         ["php|phtml|shtml|php3|php4|php5|phps|phpt|aw|ctp|module"],
    Pig:         ["pig"],
    Powershell:  ["ps1"],
    Praat:       ["praat|praatscript|psc|proc"],
    Prolog:      ["plg|prolog"],
    Properties:  ["properties"],
    Protobuf:    ["proto"],
    Python:      ["py"],
    R:           ["r"],
    Razor:       ["cshtml|asp"],
    RDoc:        ["Rd"],
    Red:         ["red|reds"],
    RHTML:       ["Rhtml"],
    RST:         ["rst"],
    Ruby:        ["rb|ru|gemspec|rake|^Guardfile|^Rakefile|^Gemfile"],
    Rust:        ["rs"],
    SASS:        ["sass"],
    SCAD:        ["scad"],
    Scala:       ["scala"],
    Scheme:      ["scm|sm|rkt|oak|scheme"],
    SCSS:        ["scss"],
    SH:          ["sh|bash|^.bashrc"],
    SJS:         ["sjs"],
    Smarty:      ["smarty|tpl"],
    snippets:    ["snippets"],
    Soy_Template:["soy"],
    Space:       ["space"],
    SQL:         ["sql"],
    SQLServer:   ["sqlserver"],
    Stylus:      ["styl|stylus"],
    SVG:         ["svg"],
    Swift:       ["swift"],
    Tcl:         ["tcl"],
    Tex:         ["tex"],
    Text:        ["txt"],
    Textile:     ["textile"],
    Toml:        ["toml"],
    TSX:         ["tsx"],
    Twig:        ["twig|swig"],
    Typescript:  ["ts|typescript|str"],
    Vala:        ["vala"],
    VBScript:    ["vbs|vb"],
    Velocity:    ["vm"],
    Verilog:     ["v|vh|sv|svh"],
    VHDL:        ["vhd|vhdl"],
    Wollok:      ["wlk|wpgm|wtest"],
    XML:         ["xml|rdf|rss|wsdl|xslt|atom|mathml|mml|xul|xbl|xaml"],
    XQuery:      ["xq"],
    YAML:        ["yaml|yml"],
    Django:      ["html"]
};

var themeData = {
SQL_Server:["sqlserver"],
Ambiance:["ambiance"],
Chaos:["chaos"],
Clouds_Midnight:["clouds_midnight"],
Cobalt:["cobalt"],
Gruvbox:["gruvbox"],
Green_on_Black:["gob"],
idle_Fingers:["idle_fingers"],
krTheme:["kr_theme"],
Merbivore:["merbivore"],
Merbivore_Soft:["merbivore_soft"],
Mono_Industrial:["mono_industrial"],
Monokai:["monokai"],
Pastel_on_dark:["pastel_on_dark"],
Solarized_Dark:["solarized_dark"],
Terminal:["terminal"],
Tomorrow_Night:["tomorrow_night"],
Tomorrow_Night_Blue:["tomorrow_night_blue"],
Tomorrow_Night_Bright:["tomorrow_night_bright"],
Tomorrow_Night_80s:["tomorrow_night_eighties"],
Twilight:["twilight"],
Vibrant_Ink:["vibrant_ink"]
};


 var set_mode_to_string = supportedModes[mode.value];
 var string_mode = String(set_mode_to_string);
 var set_mode = string_mode.split("|");

 var theme_selection = theme.value.split(" ").join("_");
 var selected_theme = themeData[theme_selection];

 // reconfigure ace editor
 editor.setOptions({
   useWrapMode: true,
   highlightActiveLine: true,
   showPrintMargin: false,
   theme: 'ace/theme/'+ selected_theme,
   mode: 'ace/mode/'+ set_mode[0]
})
 
}


function set_editor() {
swal({
  title: '<i class="fa fa-cog"></i> Code &amp; Editor Settings',
  html:
    '<p>set mode and editor theme..</p> <a>Language: </a><select name="dropdown" id="language"><option value="PHP" selected>PHP</option><option value="ABAP"> ABAP</option><option value="ABC"> ABC</option><option value="ActionScript"> ActionScript</option><option value="ADA"> ADA</option><option value="Apache_Conf"> Apache_Conf</option><option value="AsciiDoc"> AsciiDoc</option><option value="Assembly_x86"> Assembly_x86</option><option value="AutoHotKey"> AutoHotKey</option><option value="BatchFile"> BatchFile</option><option value="Bro"> Bro</option><option value="C_Cpp"> C_Cpp</option><option value="C9Search"> C9Search</option><option value="Cirru"> Cirru</option><option value="Clojure"> Clojure</option><option value="Cobol"> Cobol</option><option value="coffee"> coffee</option><option value="ColdFusion"> ColdFusion</option><option value="CSharp"> CSharp</option><option value="Csound_Document"> Csound_Document</option><option value="Csound_Orchestra"> Csound_Orchestra</option><option value="Csound_Score"> Csound_Score</option><option value="CSS"> CSS</option><option value="Curly"> Curly</option><option value="D"> D</option><option value="Dart"> Dart</option><option value="Diff"> Diff</option><option value="Dockerfile"> Dockerfile</option><option value="Dot"> Dot</option><option value="Drools"> Drools</option><option value="Dummy"> Dummy</option><option value="DummySyntax"> DummySyntax</option><option value="Eiffel"> Eiffel</option><option value="EJS"> EJS</option><option value="Elixir"> Elixir</option><option value="Elm"> Elm</option><option value="Erlang"> Erlang</option><option value="Forth"> Forth</option><option value="Fortran"> Fortran</option><option value="FTL"> FTL</option><option value="Gcode"> Gcode</option><option value="Gherkin"> Gherkin</option><option value="Gitignore"> Gitignore</option><option value="Glsl"> Glsl</option><option value="Gobstones"> Gobstones</option><option value="golang"> golang</option><option value="GraphQLSchema"> GraphQLSchema</option><option value="Groovy"> Groovy</option><option value="HAML"> HAML</option><option value="Handlebars"> Handlebars</option><option value="Haskell"> Haskell</option><option value="Haskell_Cabal"> Haskell_Cabal</option><option value="haXe"> haXe</option><option value="Hjson"> Hjson</option><option value="HTML"> HTML</option><option value="HTML_Elixir"> HTML_Elixir</option><option value="HTML_Ruby"> HTML_Ruby</option><option value="INI"> INI</option><option value="Io"> Io</option><option value="Jack"> Jack</option><option value="Jade"> Jade</option><option value="Java"> Java</option><option value="JavaScript"> JavaScript</option><option value="JSON"> JSON</option><option value="JSONiq"> JSONiq</option><option value="JSP"> JSP</option><option value="JSSM"> JSSM</option><option value="JSX"> JSX</option><option value="Julia"> Julia</option><option value="Kotlin"> Kotlin</option><option value="LaTeX"> LaTeX</option><option value="LESS"> LESS</option><option value="Liquid"> Liquid</option><option value="Lisp"> Lisp</option><option value="LiveScript"> LiveScript</option><option value="LogiQL"> LogiQL</option><option value="LSL"> LSL</option><option value="Lua"> Lua</option><option value="LuaPage"> LuaPage</option><option value="Lucene"> Lucene</option><option value="Makefile"> Makefile</option><option value="Markdown"> Markdown</option><option value="Mask"> Mask</option><option value="MATLAB"> MATLAB</option><option value="Maze"> Maze</option><option value="MEL"> MEL</option><option value="MUSHCode"> MUSHCode</option><option value="MySQL"> MySQL</option><option value="Nix"> Nix</option><option value="NSIS"> NSIS</option><option value="ObjectiveC"> ObjectiveC</option><option value="OCaml"> OCaml</option><option value="Pascal"> Pascal</option><option value="Perl"> Perl</option><option value="pgSQL"> pgSQL</option><option value="PHP"> PHP</option><option value="Pig"> Pig</option><option value="Powershell"> Powershell</option><option value="Praat"> Praat</option><option value="Prolog"> Prolog</option><option value="Properties"> Properties</option><option value="Protobuf"> Protobuf</option><option value="Python"> Python</option><option value="R"> R</option><option value="Razor"> Razor</option><option value="RDoc"> RDoc</option><option value="Red"> Red</option><option value="RHTML"> RHTML</option><option value="RST"> RST</option><option value="Ruby"> Ruby</option><option value="Rust"> Rust</option><option value="SASS"> SASS</option><option value="SCAD">SCAD</option><option value="Scala"> Scala</option><option value="Scheme">Scheme</option><option value="SCSS"> SCSS</option><option value="SH"> SH</option><option value="SJS"> SJS</option><option value="Smarty"> Smarty</option><option value="snippets"> snippets</option><option value="Soy_Template"> Soy_Template</option><option value="Space"> Space</option><option value="SQL"> SQL</option><option value="SQLServer"> SQLServer</option><option value="Stylus"> Stylus</option><option value="SVG"> SVG</option><option value="Swift"> Swift</option><option value="Tcl"> Tcl</option><option value="Tex"> Tex</option><option value="Text"> Text</option><option value="Textile"> Textile</option><option value="Toml"> Toml</option><option value="TSX"> TSX</option><option value="Twig"> Twig</option><option value="Typescript"> Typescript</option><option value="Vala"> Vala</option><option value="VBScript"> VBScript</option><option value="Velocity"> Velocity</option><option value="Verilog"> Verilog</option><option value="VHDL"> VHDL</option><option value="Wollok"> Wollok</option><option value="XML"> XML</option><option value="XQuery"> XQuery</option><option value="YAML"> YAML</option><option value="Django"> Django</option></select><br><br><a>Editor Theme: <select id="theme"><option value="monokai">Monokai</option><option value="SQL Server">SQL Server</option><option value="Ambiance">Ambiance</option><option value="Chaos">Chaos</option><option value="Clouds Midnight">Clouds Midnight</option><option value="Cobalt">Cobalt</option><option value="Gruvbox">Gruvbox</option><option value="Green on Black">Green on Black</option><option value="idle Fingers">idle Fingers</option><option value="krTheme">krTheme</option><option value="Merbivore">Merbivore</option><option value="Merbivore Soft">Merbivore Soft</option><option value="Mono Industrial">Mono Industrial</option><option value="Monokai">Monokai</option><option value="Pastel on dark">Pastel on dark</option><option value="Solarized Dark">Solarized Dark</option><option value="Terminal">Terminal</option><option value="Tomorrow Night">Tomorrow Night</option><option value="Tomorrow Night Blue">Tomorrow Night Blue</option><option value="Tomorrow Night Bright">Tomorrow Night Bright</option><option value="Tomorrow Night 80s">Tomorrow Night 80s</option><option value="Twilight">Twilight</option><option value="Vibrant Ink">Vibrant Ink</option></select></a>',
  showCancelButton: true,
  confirmButtonColor: 'rgb(110, 11, 172)',
  cancelButtonColor: '#d33',
  confirmButtonText: '<i class="fa fa-check"></i> Save Changes'
}).then((result) => {
  if (result.value) {
   editor_bind_settings();
  }
})
 // end option processing
}

// File functions

function file_chk() {
  if ( file_holder.value == [ ] ){
    setTimeout("file_chk();",200)
  }else{
    // do nothing
    setTimeout("upload_process();",200);
   }
}

function upload() {
  var file_holder = document.getElementById("file_holder");
  file_holder.value = "";
  file_holder.click();
  file_chk();
}

function upload_process()
{
    var fileToLoad = document.getElementById("file_holder").files[0];
    alert(document.getElementById("file_holder").value);
    var fileReader = new FileReader();
    fileReader.onload = function(fileLoadedEvent)
    {
        var textFromFileLoaded = fileLoadedEvent.target.result;
        editor.setValue(textFromFileLoaded);
        uploaded = 1;
    };
    fileReader.readAsText(fileToLoad, "UTF-8");
}



function save() {
    var editor = ace.edit("editor");  
    var script = editor.getValue();
    var textToSave = script;
    var textToSaveAsBlob = new Blob([textToSave], {type:"text/plain"});
    var textToSaveAsURL = window.URL.createObjectURL(textToSaveAsBlob);
    var fileNameToSaveAs = "crest.file";

    var downloadLink = document.createElement("a");
    downloadLink.download = fileNameToSaveAs;
    downloadLink.innerHTML = "Download File";
    downloadLink.href = textToSaveAsURL;
    downloadLink.onclick = destroyClickedElement;
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);

    downloadLink.click();
  }

  // destroy clicked element for file.js
  function destroyClickedElement(event)
{
    document.body.removeChild(event.target);
}


</script>
</html>
