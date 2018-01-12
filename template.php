<!DOCTYPE html>
<html lang="en">

<head>
    
        <?php require_once('head_include.php'); ?>
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
						<li><i class="fa fa-home"></i><a href="#"> Home</a></li>
						<li class="active">Dashboard</li>
					</ul>
            </div>
            <div class="col-md-8">
            <ul class="list-inline pull-right mini-stat">
							<li>
								<h5>LIKES <span class="stat-value color-blue"><i class="fa fa-plus-circle"></i> 81,450</span></h5>
								
							</li>
							<li>
								<h5>SUBSCRIBERS <span class="stat-value color-green"><i class="fa fa-plus-circle"></i> 150,743</span></h5>
								
							</li>
							<li>
								<h5>CUSTOMERS <span class="stat-value color-orang"><i class="fa fa-plus-circle"></i> 43,748</span></h5>
								
							</li>
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