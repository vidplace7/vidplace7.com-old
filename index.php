<!DOCTYPE html>
<?
	Error_Reporting( E_ALL | E_STRICT );
	Ini_Set( 'display_errors', true );
	$start = microtime(true);
	
	include("assets/php/service.class.php");
	include("assets/php/link.class.php");
	include("assets/php/serverstats.php");
	
	$services = array(
		new service("Website Http", 80, "http://www.dries007.net"),
		new service("MySQL", 3306),
		new service("SSH", 22),
		new service("Webmin", 81, "http://webmin.dries007.net"),
		new service("Jenkins", 8080, "http://jenkins.dries007.net"),
		new service("Transmission", 9091, "http://transmission.dries007.net")
	);
	
	$links = array(
		"Online profiles" => array(
			new link("Home", "http://www.dries007.net", "globe"),
			new link("Github", "http://github.com/dries007", "github"),
			new link("Bitbucket", "http://bitbucket.com/dries007", "bitbucket"),
			new link("Youtube", "http://www.youtube.com/user/driesk007", "youtube-play"),
			new link("Twitter", "http://twitter.com/driesk007", "twitter"),
			new link("Email", "#contactModal", "envelope", "data-toggle=\"modal\"")
		),
		"Links" => array(
			new link("dtools.net", "http://dtools.net", "wrench"),
			new link("Downloads", "/downloads", "download-alt", ""),
			new link("Minecraft Capes", "/capes", "bookmark", ""),
			new link("The Hacker Manifesto", "/manifesto", "quote-left", ""),
			new link("Function plotter", "/graph", "bar-chart", "")
		)
	);
	
	if (strstr($_SERVER["HTTP_HOST"], "driesgames.game-server.cc"))
	{
		$rem = strtotime("August 24, 2013 00:00") - time();
		$days = floor($rem / 86400);
		$msg =
		"<div class=\"alert alert-block\">
			<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
			<h4>Warning!</h4>
				You are using my old domain.<br>
				This domain will expire in ~$days days.
		</div>";
	}
	else
	{
		$msg =
		"<div class=\"alert alert-info\">
			<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
			You can now use the root domain, thanks to CloudFlare.<br>
		</div>";
	}
?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Dries007.net</title>
		<meta name="author" content="Dries007">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Le styles -->
		<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.0/css/font-awesome.css" rel="stylesheet">
		<style type="text/css">
			/* Custom container */
			.container-narrow {
			margin: 0 auto;
			max-width: 600px;
			}
			.container-narrow > hr {
			margin: 30px 0;
			}
			
			table {
			table-layout: fixed;
			}
			
			table th, table td {
			overflow: hidden; 
			}
			
			  /* Sticky footer styles
			  -------------------------------------------------- */

			  html,
			  body {
				height: 100%;
				text-align: center;
				/* The html and body elements cannot have any padding or margin. */
			  }

			  /* Wrapper for page content to push down footer */
			  #wrap {
				min-height: 100%;
				height: auto !important;
				height: 100%;
				/* Negative indent footer by it's height */
				margin: 0 auto -60px;
			  }

			  /* Set the fixed height of the footer here */
			  #push,
			  #footer {
				height: 30px;
			  }
			  #footer {
				background-color: #f5f5f5;
			  }

			  /* Lastly, apply responsive CSS fixes as necessary */
			  @media (max-width: 767px) {
				#footer {
				  margin-left: -20px;
				  margin-right: -20px;
				  padding-left: 20px;
				  padding-right: 20px;
				}
			  }
		</style>
		<link rel="shortcut icon" href="assets/ico/favicon.ico">
	</head>
	<body>
		<? include_once("assets/php/analyticstracking.php") ?>
		<div class="container-fluid" id="wrap">
			<div class="row-fluid" style="padding-top: 30px;">
				<!-- Nav sidebar -->
				<div class="span3 offset1 well sidebar-nav">
					<img src="http://www.gravatar.com/avatar/0777ff2884805dd73363621faf56d1b9" class="img-rounded" />
					<hr>
					<ul class="nav nav-list">
					  <? foreach ($links as $catName => $cat)
						{
							echo "<li class=\"nav-header\">$catName</li>";
							foreach ($cat as $link)
							{
								$link->makeLink();
							}
						}
					  ?>
					</ul>
				</div>
				<!-- Services -->
				<div class="span3">
					<? if (isset($msg)) echo $msg;?>
					<table class="table table-hover table-condensed">
						<thead>
							<th style="text-align: right;width: 45%">Service</td>
							<th style="text-align: left;">Status</td>
						</thead>
						<? foreach($services as $service){ ?>
						<tr>
							<td style="text-align: right;"><? echo $service->name; ?></td>
							<td style="text-align: left;"><? echo $service->makeButton(); ?></td>
						</tr>
						<?}?>
					</table>
				</div>
				<!-- Server stats -->
				<div class="span3 well">
					<!-- System Load -->
					<p><b>System load</b></p>
					<? makeLoadBars(); ?>
					<hr>
					<!-- RAM Usage -->
					<p><b>RAM Usage</b></p>
					<? makeRAMBars(); ?>
					<hr>
					<!-- Disk Space -->
					<p><b>Disk space</b></p>
					<? makeDiskBars(); ?>
				</div>
			</div>
		</div>
		<!-- Footer -->
		<div id="footer">
			<div class="container">
				<p class="muted credit">
					<a href="http://www.dries007.net">&copy; Dries007</a> <? echo date("Y")?>. Website source available <a href="http://github.com/dries007/">here.</a><br>
					Build with <a href="http://twitter.github.io/bootstrap/"><i class="icon-github"></i> Bootstrap</a> & <a href="http://fortawesome.github.io/Font-Awesome/"><i class="icon-flag"></i> Font Awesome</a> in <? $end = microtime(true); echo round(($end - $start), 4);?> sec.
				</p>
			  </div>
		</div>
		<!-- Contact modal -->
		<div id="contactModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel">Contact info</h3>
			</div>
			<div class="modal-body">
				<p>I prefer to be contacted through project related channels but, if its really necessary, you can mail me at the address below.<p>
				<img src="/contact.png" style="width: 150px;"/>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			</div>
		</div>
		<!-- End Contact modal -->
		<script src="http://code.jquery.com/jquery.js"></script>
		<script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
	</body>
</html>