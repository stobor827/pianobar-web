<?php

$res = fopen( "/home/steve/.config/pianobar/ctl", 'r+' );

if( !$res ){
  die( "Unable to open control fifo" );
}

$page = "nowPlaying";

if( isset($_GET["action"]) ){
	switch( $_GET["action"] ){
	  case "next":
		fprintf( $res, "n\n" );
	  break;
	  case "pause":
		fprintf( $res, "p\n" );
	  break;
	  case "changeStation":
		$a = $_GET["station"];
		fprintf( $res, "s$a\n" );
	  break;
	  case "stations":
		$page = "stations";
	  break;
	  default:
	}
}

fclose( $res );
print "<!DOCTYPE html>\n";
print "<HTML>\n";
print "\t<HEAD>\n";
print "\t\t<TITLE>PianoBar Web</TITLE>\n";
print "\n";
print "\n";
/*

\t\t<!-- iOS Device Startup Images -->
\t\t<!-- copied from http://stackoverflow.com/questions/3707509/startup-image-in-webapp-for-retina-display -->
\t\t<!-- iPhone/iPod Touch Portrait – 320 x 460 (standard resolution) -->
\t\t<link rel="apple-touch-startup-image" href="splash-screen-320x460.png" media="screen and (max-device-width: 320px)" />
\t\t<!-- iPhone/iPod Touch Portrait – 640 x 920 pixels (high-resolution) -->
\t\t<link rel="apple-touch-startup-image" media="(max-device-width: 480px) and (-webkit-min-device-pixel-ratio: 2)" href="splash-screen-640x920.png" />
\t\t<!-- For iPad Landscape 1024x748 -->
\t\t<!-- Note: iPad landscape startup image has to be exactly 748x1024 pixels (portrait, with contents rotated).-->
\t\t<link rel="apple-touch-startup-image" sizes="1024x748" href="splash-screen-1024x748.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)" />
\t\t<!-- For iPad Portrait 768x1004 -->
\t\t<link rel="apple-touch-startup-image" sizes="768x1004" href="splash-screen-768x1004.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)"/>


*/
echo '<link rel="manifest" href="manifest.json">';
echo <<<ios
<link rel="manifest" href="/manifest.json">
<!--
Icons from: http://www.flaticon.com/packs/line-icon-set
Icans used under CC By 3
-->


\t\t<!-- IOS-specific meta tags for standalone web app -->
\t\t<meta name="viewport" content="width=device-width, maximum-scale=1, minimum-scale=1, initial-scale=1.0"><!-- important for NOT zooming the window-->
\t\t<meta name="apple-mobile-web-app-capable" content="yes" />
\t\t<meta name="apple-mobile-web-app-status-bar-style" content="black">
\t\t<link rel="apple-touch-icon-precomposed" href="touch-icon-iphone.png"/>
\t\t<link rel="apple-touch-icon-precomposed" sizes="72x72" href="touch-icon-ipad.png"/>
\t\t<link rel="apple-touch-icon-precomposed" sizes="114x114" href="touch-icon-iphone-retina.png"/>
\t\t<link rel="apple-touch-icon-precomposed" sizes="144x144" href="touch-icon-ipad-retina.png"/>


\t\t<!-- iPhone -->
\t\t<link href="apple-touch-startup-image-320x460.png" media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 1)" rel="apple-touch-startup-image">
\t\t<!-- iPhone (Retina) -->
\t\t<link href="apple-touch-startup-image-640x920.png" media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image">
\t\t<!-- iPhone 5 -->
\t\t<link href="apple-touch-startup-image-640x1096.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image">
\t\t<!-- iPad (portrait) -->
\t\t<link href="apple-touch-startup-image-768x1004.png"  media="(device-width: 768px) and (device-height: 1024px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 1)" rel="apple-touch-startup-image">
\t\t<!-- iPad (landscape) -->
\t\t<link href="apple-touch-startup-image-748x1024.png" media="(device-width: 768px) and (device-height: 1024px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 1)" rel="apple-touch-startup-image">
\t\t<!-- iPad (Retina, portrait) -->
\t\t<link href="apple-touch-startup-image-1536x2008.png" media="(device-width: 768px) and (device-height: 1024px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image">
\t\t<!-- iPad (Retina, landscape) -->
\t\t<link href="apple-touch-startup-image-1496x2048.png" media="(device-width: 768px) and (device-height: 1024px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image">




ios;

print "\t\t<META HTTP-EQUIV=\"Pragma\" CONTENT=\"no-cache\"><!-- prevent caching of page info.  -->\n";
print "\t\t<link href=\"style.css\" rel=\"stylesheet\" media=\"screen\" type=\"text/css\" />\n\n";

echo <<<script
\t\t<!-- these 2 script sections handle the async js with node.js for updating the currently playing info -->
\t\t<script src="https://thestobor.net/pbNodeProxy/socket.io/socket.io.js"></script>
\t\t<script>
\t\t\tvar socket = io.connect( "https://thestobor.net/", {path:'/pbNodeProxy/socket.io'} );
\t\t\tfunction handleNewTrack( data ){
\t\t\t\tdocument.getElementById( 'currentlyPlaying' ).innerHTML = data.date;
\t\t\t}
\t\t\tsocket.on( 'date', handleNewTrack );
\t\t</script>
\t\t<script src="iosScroll.js"></script>
script;





print "\t</HEAD>\n";
print "\t<BODY bgcolor=\"#3D3C47\" style=\"color:#DDDDDD\">\n";


if( $page == "stations" ){
	print "\t\t<div class=\"scrollable\" id=\"pblist\">\n";
	//print "<iframe src=\"pblist.html\"></iframe>";
	print "\n<center><!-- begin include of pblist.html -->\n"; 
	include ( "pblist.html" );
	//print "</iframe>";
	print "<!-- end include of pblist.html --></center>\n\n"; 
	print "\t\t</div>\n";
}else{
	print "\t\t<div class=\"album\" id=\"currentlyPlaying\">\n";
	print "\n<!-- begin include of pb.html -->\n";
	include( "pb.html" );
	print "<!-- end include of pb.html -->\n\n";
	print "\t\t</div>\n";
	print "<span id='info'></span>\n";
}

print "\t\t<div class=\"nav\">\n";
print "\t\t\t<table width=\"100%\">\n";
print "\t\t\t\t<TR>\n";
print "\t\t\t\t\t<TD height=\"1\" colspan=\"6\"><center><hr></td>\n";
print "\t\t\t\t</tr>\n";
print "\t\t\t\t<tr height=\"1\" valign=\"center\">\n";
print "\t\t\t\t\t<td width=15></td>\n";
print "\t\t\t\t\t<td><a onclick=\"window.location='pianobar.php'\"><img src=\"curve19.png\" style=\"vertical-align:middle\" border=\"none\" width=\"100%\"></a></td>\n";
print "\t\t\t\t\t<td><a onclick=\"window.location='pianobar.php?action=pause'\"><img src=\"round31.png\" style=\"vertical-align:middle\" border=\"none\" width=\"100%\"></a></td>\n";
print "\t\t\t\t\t<td><a onclick=\"window.location='pianobar.php?action=next'\"><img src=\"fast10.png\" style=\"vertical-align:middle\" border=\"none\" width=\"100%\"></a></td>\n";
print "\t\t\t\t\t<td><a onclick=\"window.location='pianobar.php?action=stations'\"><img src=\"cogwheel8.png\" style=\"vertical-align:middle\" border=\"none\" width=\"100%\"></a></td>\n";
/*
print "\t\t\t\t\t<td><a onclick=\"window.location='pianobar.php'\"><img src=\"reload1.png\" style=\"vertical-align:middle\" border=\"none\" width=\"100%\"></a></td>\n";
print "\t\t\t\t\t<td><a onclick=\"window.location='pianobar.php?action=pause'\"><img src=\"http://thestobor.net/ipodmp/images/play.gif\" style=\"vertical-align:middle\" border=\"none\" width=\"100%\"></a></td>\n";
print "\t\t\t\t\t<td><a onclick=\"window.location='pianobar.php?action=next'\"><img src=\"http://thestobor.net/ipodmp/images/ff.gif\" style=\"vertical-align:middle\" border=\"none\" width=\"100%\"></a></td>\n";
print "\t\t\t\t\t<td><a onclick=\"window.location='pianobar.php?action=stations'\"><img src=\"http://thestobor.net/ipodmp/images/options.gif\" style=\"vertical-align:middle\" border=\"none\" width=\"100%\"></a></td>\n";
*/

print "\t\t\t\t\t<td width=15></TD>\n";

print "\t\t\t\t</tr>\n";
print "\t\t\t</TABLE>\n";

print "\t\t</div>\n";


print "\t</BODY>\n";
print "</HTML>\n";


?>