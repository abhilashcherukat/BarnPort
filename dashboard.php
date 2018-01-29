<!DOCTYPE html>
<html lang="en">

<head>
	<?php 
	
		require_once('head_include.php'); 
		include_once('Cls_CommonFunction.php');
		$Obj_Commonfunction=new CommonFunctions();
		$URL=$Obj_Commonfunction->config("APIURL");
	?>
</head>

<body>

  
        <?php require_once('navbar_include.php'); ?>
  <div class="wrapper" id="wrapper">
    <div class="left-container" id="left-container">
      <!-- begin SIDE NAV USER PANEL -->
      <?php require_once('sidebar_include.php'); ?>
      <!-- END SIDE NAV USER PANEL -->
    </div>
    <div class="right-container" id="right-container">
        <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
            <ul class="breadcrumb">
						<li><i class="fa fa-home"></i><a href="/"> Home</a></li>
						<li class="active">Dashboard</li>
					</ul>
            </div>
		<?php
			$params=[];
			$post_url = $URL."/counts";
			//echo $post_url;
			$post_response=json_decode($Obj_Commonfunction->CurlSendGetRequest($post_url,$params)) ;
			//print_r($post_response);
		?>
            <div class="col-md-8">
            <ul class="list-inline pull-right mini-stat">
							<li>
								<h5>USERS<span class="stat-value color-blue"><i class="fa fa-user-circle"></i> <?php echo $post_response->data->user; ?></span></h5>
								
							</li>
							<li>
								<h5>ORGANISERS <span class="stat-value color-green"><i class="fa fa-user-circle"></i>  <?php echo $post_response->data->organiser; ?></span></h5>
								
							</li>
							<!--li>
								<h5>CUSTOMERS <span class="stat-value color-orang"><i class="fa fa-plus-circle"></i> 43,748</span></h5>
								
							</li-->
						</ul>
            </div>
            </div>
            
            <div class="row">
            <div class="col-md-12">
                <div class="main-header">
					<h2>DASHBOARD</h2>
					<em>the first priority information</em>
				</div>
                </div>
                </div>
            
                <div class="row padding-top">
                <div class="col-md-6"><img src="https://www.amcharts.com/wp-content/uploads/2016/03/demo_6559_light-1.jpg" class="img-responsive"></div>
                <div class="col-md-6"><img src="https://www.amcharts.com/wp-content/uploads/2013/12/demo_7404_light.jpg" class="img-responsive"></div>              
                </div>
            
             <div class="row padding-top">
                <div class="col-md-6"><img src="https://www.amcharts.com/wp-content/uploads/2013/12/demo_7406_light.jpg" class="img-responsive"></div>
                <div class="col-md-6"><img src="https://www.amcharts.com/wp-content/uploads/2013/12/demo_7403_light.jpg" class="img-responsive"></div>              
                </div>
        </div>
    </div>
  </div>
  
</body>
  
        <?php require_once('javascript_include.php'); ?>
</html>