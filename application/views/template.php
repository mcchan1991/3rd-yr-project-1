<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?= $title ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?= $meta_description ?>">
		<meta name="author" content="<?= $meta_author ?>">

		<!-- Le styles -->
		<link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>assets/css/bootstrap-responsive.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>assets/css/redmond/jquery-ui-1.10.0.custom.css" rel="stylesheet">
		
		<link href="<?php echo base_url(); ?>assets/css/jasny-bootstrap-responsive.min.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>assets/css/jasny-bootstrap.min.css" rel="stylesheet">

		<style> div { border:0px solid; } </style>
		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	<body>
		<script src="<?php echo base_url(); ?>assets/js/jquery-latest.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/jquery-ui-1.10.0.custom.js"></script>
		<div class="container-fluid">
			
			<div class="row-fluid" style="margin-bottom:10px; margin-top:5px">
				
				<div class="span10 offset1">
					<img src="<?php echo base_url(); ?>/assets/img/logo.png" width="125px" height="125px" />
					<!-- <img src="<?php echo base_url(); ?>/assets/img/wattball.jpg" /> -->
				</div>	
			</div>

			<div class="row-fluid">
				<div class="span10 offset1">
					<div class="navbar" >
						<div class="navbar-inner">
						<?php print $nav_top ?>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row-fluid">
				<div class="span2 offset1 well" style="padding: 8px 0;">
					<ul class="nav nav-list">
					      <?php print $nav_side ?>
					</ul>
				</div>
				<div class="span8 well" >
				<?php print $content ?>
 				</div>
			</div>
		<div class="row-fluid">
				<div class="span10 offset1">
					<hr>
		      		<footer>
		        		<p>Copyright &copy; 2013-2014 Riccarton Sports Centre</p>
		      		</footer>
					</div>
			</div>
		</div>

	    <!-- Le javascript
	    ================================================== -->
	    <!-- Placed at the end of the document so the pages load faster -->
		<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/bootstrap-rowlink.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/nicEdit-latest.js" type="text/javascript"></script>
		<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
	</body>
</html>
