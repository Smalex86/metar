<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
	<meta name="rights" content="">
	<meta name="author" content="Smirnov Alexander">
	
	<link rel="shortcut icon" href="templates/favicon.ico">  
	<title><?php echo $sitename ?></title>

    <!-- Bootstrap core CSS -->
    <link href="templates/css/bootstrap-yeti.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <!--<link href="templates/css/bootstrap-theme.min.css" rel="stylesheet">-->
	<!--<link href="templates/css/adverts.css" rel="stylesheet">-->
	

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->	
	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="templates/js/bootstrap.js"></script>
	
  </head>

  <body>

    <div class="navbar navbar-default" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Навигация</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php" title="">Погода</a>
        </div>
      </div>
    </div>

    <div class="container theme-showcase" role="main" id="pageBody">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<?php print_r($currentTempBlock); ?>
				<br />
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<?php print_r($chartDay); ?>
				<br />
			</div>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<?php echo $resizeBlockH1 ?>
				<br />
			</div>
			<div class="col-md-4 col-sm-6 col-xs-12">
				<?php print_r($resizeBlock); ?>
			</div>
			<div class="col-md-8 col-sm-6 col-xs-12">
				<?php print_r($resizeBlock2); ?>
				<br />
				<br />
			</div>
		</div>
	</div> <!-- /container -->		
	<div class="footer" id="footer"><!-- Подвал -->
		<div class="container theme-showcase" role="main">
			<div class="row"> 
				<div class="col-xs-10">
					<center><p class="small text-muted">2017 | &copy; <?php echo $sitename; echo ' - ' . $dataFromSite; ?></p></center>
				</div>
				<div class="col-xs-2">
				
				</div>
			</div>
		</div>
	<!-- </div>  -->	<!-- Подвал -->	 		
	
	<script type='text/javascript'>
		
	</script>
  </body>
</html>
