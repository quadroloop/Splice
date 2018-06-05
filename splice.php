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
   //init (file heirarchy)
  if(file_exists('index.html')){$init_file="index.html";}else if (file_exists('index.php')){$init_file="index.php";}else if (file_exists('index.js')){$init_file="index.js";}

  // init generate file tree mapper file in case it doesnt exist;
  if(!file_exists('splice_dir_mapper.php')){
$tree_base_code =  "#lt#?php class treeview {private #var#files#semi#private #var#folder#semi#function __construct( #var#path ) {#var#files = array()#semi#if( file_exists( #var#path)) {if( #var#path[ strlen( #var#path ) - 1 ] == #apos#/#apos# )#var#this-#gt#folder = #var#path#semi#else#var#this-#gt#folder = #var#path . #apos#/#apos##semi##var#this-#gt#dir = opendir( #var#path )#semi#while(( #var#file = readdir( #var#this-#gt#dir ) ) != false )#var#this-#gt#files[] = #var#file#semi#closedir( #var#this-#gt#dir )#semi#}}function create_tree( ) {if( count( #var#this-#gt#files ) #gt# 2 ) {natcasesort( #var#this-#gt#files )#semi##var#list = #apos##lt#ul class=#quot#filetree#quot# style=#quot#display: none#semi##quot##gt##apos##semi#foreach( #var#this-#gt#files as #var#file ) {if( file_exists( #var#this-#gt#folder . #var#file ) && #var#file != #apos#.#apos# && #var#file != #apos#..#apos# && is_dir( #var#this-#gt#folder . #var#file )) {#var#list .= #apos##lt#li class=#quot#folder collapsed#quot##gt##lt#a href=#quot###quot# rel=#quot##apos# . htmlentities( #var#this-#gt#folder . #var#file ) . #apos#/#quot##gt##apos# . htmlentities( #var#file ) . #apos##lt#/a#gt##lt#/li#gt##apos##semi#}}foreach( #var#this-#gt#files as #var#file ) {if( file_exists( #var#this-#gt#folder . #var#file ) && #var#file != #apos#.#apos# && #var#file != #apos#..#apos# && !is_dir( #var#this-#gt#folder . #var#file )) {#var#ext = preg_replace(#apos#/^.*\./#apos#, #apos##apos#, #var#file)#semi##var#list .= #apos##lt#li class=#quot#file ext#quot##gt##lt#a href=#quot###quot# rel=#quot##apos# . htmlentities( #var#this-#gt#folder . #var#file ) . #apos##quot##gt##apos# . htmlentities( #var#file ) . #apos##lt#/a#gt##lt#/li#gt##apos##semi#}}#var#list .= #apos##lt#/ul#gt##apos##semi#return #var#list#semi#}}}#var#path = urldecode( #var#_REQUEST[#apos#dir#apos#] )#semi##var#tree = new treeview( #var#path )#semi#echo #var#tree-#gt#create_tree()#semi#?#gt#";
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

 // deleting a file
 if(isset($_POST["delete"])) {
  if(!empty($_POST["delete"])){
  $fdelete = $_POST["delete"];
   unlink($fdelete);
 }
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
<?php echo '<script>var cfile="'.@$init_file.'";var fsnippet;</script>'; ?>
        <style type="text/css">

        /*!
Split Pane v0.9.4
Copyright (c) 2014 - 2016 Simon Hagström
Released under the MIT license
https://raw.github.com/shagstrom/split-pane/master/LICENSE
*/
/*file tree.css*/
#container{ width: 100%; margin: 0 auto; height: 100%; overflow: scroll;}UL.filetree{ font-family: Verdana, sans-serif; font-size: 11px; line-height: 20px; padding: 0px; margin: 0px;}UL.filetree LI{ list-style: none; padding: 0px 0px 0px 20px; margin: 0px 0px 0px 10px; white-space: nowrap;}UL.filetree A{ color: #fff; text-decoration: none; display: block; padding: 0px 2px 0px 5px; margin-left: 15px;}UL.filetree A:hover{ background: black;}/*folder styles*/.filetree LI.folder{ background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAAPCAYAAAA71pVKAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAAZdEVYdFNvZnR3YXJlAHBhaW50Lm5ldCA0LjAuMTM0A1t6AAAAZElEQVQ4T2OgCOTn/1cozv2nBcOF6f+koVKEQX7O378Fuf//w3B+zr9vubm/LKDS+AGyRiQDXhbm/QsEYi9cOD/rnx1WzcTiUc0k4gHV/O8PNgnC+N8fjLRNLAbpgyZScgADAwAFpd6LN3O5AQAAAABJRU5ErkJggg==); background-repeat: no-repeat; background-position: left top; }.filetree LI.expanded{ background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAALGPC/xhBQAAAAlwSFlzAAALEQAACxEBf2RfkQAAABl0RVh0U29mdHdhcmUAcGFpbnQubmV0IDQuMC4xMzQDW3oAAAFJSURBVDhPndO/SsNQFAbw46KCoOIDOBQfQBBcnXwBQXEVnOJNcxFLiCBJHEQUJweHUvAPolWKVJSCTg7iaxQKDrbQwZIEm3uO54J20BCaXvjBgZzvCzcQACIoEI24RJO/nA6OF5o4Cv0c77M77Qdo+BHVekJ88AN16AXxvNtVunTsL5toeJloSBfMcUFxNyLqCVFxSZ1d+hEecOnef7jqhZiDnXq84H6oktemViZNPHcbahHsm3jJeVbF7Td6zcJ5UiW7HK+AlFiRm9iRWxRlojMS70AKfJQm0UAE1nRBNfFhPwTegyXwlqnEhTSc4VwF8hvqgococSkFZ74soa51wSkPQdJSGs6E7IyvoI65rZW0lIYzbc6e6G+wzxpJS2k4886O+Aq4xsOVJeglGyznTVwHw6AJ06CcZdBsFvziGdPEqZ9/ctAD8A1tUYBdUbvVXwAAAABJRU5ErkJggg==); background-repeat: no-repeat; background-position: left top; }.filetree LI.wait{ background: url(images/spinner.gif) no-repeat left top;}.ext{ background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAACxIAAAsSAdLdfvwAAAAZdEVYdFNvZnR3YXJlAHBhaW50Lm5ldCA0LjAuMTM0A1t6AAAA2UlEQVQ4T2OAAeewf6bO4X+3uoT/240NO4X9S4cqxQ5Aml3D/lnbR/4XQcdAA8qBFnx0Cf+TA1WOCUC2gBRDuSgAKJcDxCVAQ3biNISQAc7h/1dBDfmI1Tv4DHAL+acCMgSKy0FqoVIIgM8AZAANE9wG1P//z9L66Z8oNgySI2hA8/d/bk0//u3Bhhu//3MlaACUixMQ4wJloE1Z2DBIjvYGQLk4AUEDGr/9swbathkrBsoRNAAYVUxAzIMDM+E0AF9mQsYgNSC1UG0IQCg7wzBIDUgtRBcDAwB8ek9Q1lZCqQAAAABJRU5ErkJggg==); background-repeat: no-repeat; background-position: left top; }}.filetree UL{ border-left: 1px solid #D9DADB; padding-left: 10px;}.filetree LI UL LI:before{ margin-left: -33px; content: "\2014"; position: absolute;}.filetree LI UL LI{ position: relative;}
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
        width: 50%;
        height: 100%;
        background-color:#272822;
      }
      #divider {
        left: 50%; /* Same as left component width */
        width: 150px;
        background-color: transparent;
        transition: 0.6s;
      }

       #divider:hover {
       background-color: rgba(8, 125, 149, 0.54);
       }

      #right-component {
        left: 50%;  /* Same as left component width */
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
                overflow: auto;
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

 .current_file {
    font-size: 13px;
    margin: 10px !important;
    padding: 3px;
    border-radius: 4px;
    float: left;
    border:1px solid #3A3A3A!important;
 }

 #delta {
   margin: 5px;
   float: left;
   width: 350px;
 }

 #splash {
  width:100%;
  height: 100%;
  background: linear-gradient(rgb(36, 40, 45),rgba(20, 27, 35, 0.94), rgba(0, 0, 0, 0.94)), url('https://s-media-cache-ak0.pinimg.com/originals/25/cc/3e/25cc3e1a7cda177625f2ba7d577bfc97.gif') fixed center center;
    background-size: cover;
    padding: 80px 0 60px 0;
    position: absolute;
}
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
  catch_mode();
     $( "#code_base" ).load("splice.php?file_edit="+encodeURIComponent(abs_path), function() {
         var data = document.getElementById("code_base").value;
         editor.setValue(data,-1);
     });
    code_editor();
}

            // loading a file from searched tree.
function loadfile_search() {
  var file_path = document.getElementById("sfile").innerHTML;
  var fname = document.getElementById("cfile").value = file_path;
  catch_mode();
     $( "#code_base" ).load("splice.php?file_edit="+encodeURIComponent(file_path), function() {
         var data = document.getElementById("code_base").value;
         editor.setValue(data,-1);
     });
    code_editor();
}
        </script>
    </head>
    <body id="app-body">
    <!--code holder-->
    <textarea id="code_holder">
      <?php @readfile($init_file);?>
    </textarea>
         <!--editor panel-->
        <div class="split-pane fixed-left" style="display:block;" id="editor_panel">
            <div class="split-pane-component w3-animate-left code-editor" id="left-component">
            <!--nav bar-->
            <div class="w3-bar top-bar dark-border-bottom">
                <a class="w3-text-white w3-bar-item dark-border-right"><img alt="splice-logo" src="data:image/png;base64,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" style="width:20px;"></a>
                <!--current file edited-->
                 <a class="w3-bar-item"><input class="w3-small dark-border w3-round search w3-text-blue" id="cfile" type="text" placeholder="File name here.." title="Current file edited.."></a>
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
                <div title="Looad a file" class="current_file"><a id="selected_file"></a></div>
                 <a class="dark-border w3-round w3-padding-small w3-text-white w3-indigo w3-btn tool_state" onclick="loadfile();"><i class="fa fa-upload w3-text-white"></i> Load File</a>
                 <a title="Delete Selected file." class="dark-border w3-round w3-padding-small w3-text-white w3-red w3-btn tool_state" onclick="delete_file();"><i class="fa fa-trash w3-text-white"></i> Delete</a>
                 <a title="Add Folder" class="dark-border w3-round w3-padding-small w3-text-white w3-blue w3-btn tool_state" onclick="add_fm();"><i class="fa fa-plus w3-text-white"></i></a>


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
          <a onclick="new_file();" class="w3-bar-item w3-button w3-text-grey"><i class="fa fa-plus w3-text-blue"></i> New File</a>
          <a onclick="upload();" class="w3-bar-item w3-button w3-text-grey" onclick="upload();"><i class="fa fa-file-text-o w3-text-blue"></i> Open File</a>
          <a onclick="filemanager();" class="w3-bar-item w3-button w3-text-grey"><i class="fa fa-folder w3-text-amber"></i> File Manager</a>
          <a onclick="minify();" class="w3-bar-item w3-button w3-text-grey"><i class="fa fa-circle w3-text-pink"></i> MINIFY Code</a>
          <a class="dark-border w3-round w3-padding-small w3-text-grey tool_state"><i class="fa fa-wrench w3-text-grey"></i> TOOLS</a>
          <a href="#" class="w3-bar-item w3-button w3-text-grey w3-hover-black"><i class="fa fa-sitemap w3-text-blue"></i> Test URL Parameters</a>
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
          <div class="w3-bar dark-border-bottom">
           <a class="dark-border w3-round w3-padding-small w3-text-grey tool_state"><i class="fa fa-sitemap w3-text-grey"></i> FILE SEARCH</a>
            <div class="current_file w3-text-grey"><a id="sfile"></a></div>
                 <a class="dark-border w3-round w3-padding-small w3-text-white w3-indigo w3-btn tool_state" onclick="loadfile_search();"><i class="fa fa-upload w3-text-white"></i> Load File</a>
           </div>
              <ul id="thread" style="display: block;z-index: 1000;">
              <?php
$it = new RecursiveTreeIterator(new RecursiveDirectoryIterator("./", RecursiveDirectoryIterator::SKIP_DOTS));
foreach($it as $path) {
  echo '<li class="w3-text-blue w3-hover-black" style="cursor:pointer" onclick="fsnippet=this.innerHTML;file_bind();"><a>'.$path.'</a></li>';
}
?>
         <li id="no_matches"><a class="dark-border w3-round w3-padding-small w3-text-grey tool_state"><i class="fa fa-warning w3-text-amber"></i> END OF RESULTS</a></li>
              </ul>
          </div>

             <!--dock-->
                <div class="w3-bar bottom-bar dark-border-top dark-border-bottom" style="bottom:0px;">
                    <a class="w3-bar-item w3-btn" onclick="upload();"><i class="fa fa-upload w3-text-white"></i></a>
                    <a class="w3-bar-item w3-btn" onclick="filemanager();" title="Open File manager"><i class="fa fa-folder w3-text-white" id="f-icon"></i></a>
                    <a class=""><input class="w3-small dark-border w3-round search" id="delta" type="text" placeholder="File Search.." title="Search a file.." onkeyup="search_file();"></a>
               </div>
            </div>
            <!--right panel-->
            <div class="split-pane-divider" id="divider" onmouseover="this.style.width='20%'" onmouseleave="this.style.width='30px'"></div>
            <div class="split-pane-component" id="right-component">
            <!-- splash screen-->
             <div id="splash">
               <center>
                 <img alt="splice-logo" style="max-width: 50%;margin:80px;" src="data:image/png;base64,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">
                 <br>
                 <p class="w3-text-blue">A simple browser-based code Editor for Web Apps & more.</p>
                 <a href="https://github.com/quadroloop/Splice" class="w3-btn w3-indigo w3-round">View on Github</a>
               </center>
             </div>
             <!--iframe output-->
              <iframe id="frame_data" src="<?php echo $init_file; ?>" style="width:100%;height:100%;border:0;display: none;"></iframe>
            </div>
        </div>
        <!--Data Elements-->
        <div style="display: none">
           <input type="file" id="file_holder">
            <textarea id="code_base"></textarea>
        </div>



    </body>

    <!--all the javascript-->
    <!--scroll bar-->
    <script src="https://rawgit.com/utatti/perfect-scrollbar/master/dist/perfect-scrollbar.js"></script>
    <link rel="stylesheet" href="https://rawgit.com/utatti/perfect-scrollbar/master/css/perfect-scrollbar.css">
    <script>
    var ps = new PerfectScrollbar('#left-component');
    var ps_r = new PerfectScrollbar('#right-component');
    var ps1 = new PerfectScrollbar('#results');
    var fscroll = new PerfectScrollbar('#file_manager');
    var ftscroll = new PerfectScrollbar('#container');
    var menuscroll = new PerfectScrollbar('#menu');
    var settingscroll = new PerfectScrollbar('#settings');
    $( document ).ready(function() {
      var editorscroll = new PerfectScrollbar('.ace_scrollbar');
      var editorscroll_h = new PerfectScrollbar('.ace_scrollbar-h');

    });




   </script>
    <!-- end of scroll bar js-->
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
  ui_count = 1;
  ui_switch();
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
    var endres = document.getElementById("no_matches");
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
          endres.style.display = "";
        } else {
            li[i].style.display = "none";
           endres.style.display = "block"
        }
    }

}

// new file
function new_file() {
  swal.setDefaults({
  input: 'text',
  confirmButtonText: 'Next &rarr;',
  showCancelButton: true,
  progressSteps: ['#']
})

var steps = [
  {
    title: 'New file!',
    text: 'Enter a file name to continue'
  },
]

swal.queue(steps).then((result) => {
  swal.resetDefaults()

  if (result.value) {
   document.getElementById("cfile").value = result.value;
   code_editor();
  } // file name bind function..
})
}

  // change editor mode depending to file type:
function catch_mode() {
   var path = document.getElementById("cfile").value;
   var web_iterate = path.split(".");
   var file_ext = web_iterate.slice(-1)[0].toUpperCase();;
   var langs = {PHP:"php",JS:"javascript",HTML:"html",CSS:"css"};
    // reconfigure ace editor
 editor.setOptions({
   useWrapMode: true,
   highlightActiveLine: true,
   showPrintMargin: false,
   mode: 'ace/mode/'+ langs[file_ext]
})

}

// Minify code!
function minify() {
  var code = editor.getValue();
  var x1 = code.split("\n");
  var x2 = x1.join("");
  var x3 = x2.replace(/\s+/g,' ').trim();
  editor.setValue(x3,-1);
  code_editor();
}

 // process searched file
function file_bind() {
  var s1 = fsnippet.replace("<a>","");
  var s2 = s1.replace("</a>","");
  var path_file = s2.split("-");
  document.getElementById("sfile").innerHTML = path_file[1];
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
       x.src = y+"?"+urx.value;
    }
      }
    });

 // UI for esc key, window switching..
 var ui_count = 0;
 var output_frame = document.getElementById("right-component");
 var code_panel = document.getElementById("left-component");
 var slice = document.getElementById("divider");
 var UI = document.getElementById("app-body");
    UI.addEventListener("keydown", function (e) {
      if (e.keyCode === 27) {
        ui_count ++;
       ui_switch();
      }
    });

function ui_switch() {
  if(ui_count == 1) {
     // close editor
    slice.style.left = "0px";
    code_panel.style.width = "0px";
    output_frame.style.left = "0px";
  }
  if(ui_count == 2) {
    // open editor
    slice.style.left = "100%";
    code_panel.style.width = "100%";
    output_frame.style.left = "100%";
    ui_count = 0;
  }
}

// output control
/*
var save_status = 0;
localStorage.setItem('save_data',save_status);
*/

function delete_file() {

 var file_path = document.getElementById("selected_file").innerHTML;
  var abs_path = file_path.replace("File:  ","");
  if(abs_path == [ ]) {
    swal({
      type: 'error',
      showConfirmButton: false,
      timer: 1000,
      title: "Error",
      text: "No file selected!"

    })
  }else{
 var http = new XMLHttpRequest();
    http.open("POST", "splice.php", true);
    http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    var delf = "delete="+abs_path;
    http.send(delf);
     swal({
      type: 'success',
      showConfirmButton: false,
      timer: 1000,
      title: "Success",
      text: "you have deleted a file"

    })
 }
}

// Saving a file

function savefile() {
   var file_name_to_save = document.getElementById("cfile").value;
   if(file_name_to_save == [ ]){swal({timer: 900, showConfirmButton: false, title:'Error!',text:'No file name!',type:'error'})}else{
	 var http = new XMLHttpRequest();
    http.open("POST", "splice.php", true);
    http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    var file = "filename="+file_name_to_save+"&file_content="+encodeURIComponent(editor.getValue());
    http.send(file);
    swal({
      timer: 900,
      type: 'success',
      showConfirmButton: false,
      title: 'Success!',
      text: 'your file is saved successfully!'
    });
  }
}

function refresh_output() {
     var file_name_to_save = document.getElementById("cfile").value;
     var web_iterate = file_name_to_save.split(".");
     var file_item = web_iterate.slice(-1)[0];
     var allowed_src = ["html","php"];
     if(allowed_src.indexOf(file_item) > -1) {
      document.getElementById("splash").style.display = "none";
      document.getElementById("frame_data").style.display = "block";
     document.getElementById("frame_data").src=file_name_to_save;
   }
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


// window close

window.addEventListener('beforeunload', function(event) {
  alert("fuck cuz i can!");
}, false);

</script>
</html>
