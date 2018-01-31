<!DOCTYPE html>
<html lang="en">

<head>
    
	<?php require_once('head_include.php'); ?>
	<link href='css//fullcalendar.min.css' rel='stylesheet' />
	<link href='css//fullcalendar.print.min.css' rel='stylesheet' media='print' />  
	<style>

		  body {
		    margin: 0;
		    padding: 0;
		    font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		    font-size: 14px;
		  }

		  #script-warning {
		    display: none;
		    background: #eee;
		    border-bottom: 1px solid #ddd;
		    padding: 0 10px;
		    line-height: 40px;
		    text-align: center;
		    font-weight: bold;
		    font-size: 12px;
		    color: red;
		  }

		  #loading {
		    display: none;
		    position: absolute;
		    top: 10px;
		    right: 10px;
		  }

		  #calendar {
		    max-width: 900px;
		    margin: 40px auto;
		    padding: 0 10px;
		  }
 
	</style>
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
						<li class="active">Calander</li>
					</ul>
            </div>
            <div class="col-md-8">
            <ul class="list-inline pull-right mini-stat">
							<li>
								<h5>BARN <span class="stat-value color-blue"><i class="fa fa-plus-circle"></i> 81,450</span></h5>
								
							</li>
							<li>
								<h5>FLOOR <span class="stat-value color-green"><i class="fa fa-plus-circle"></i> 150,743</span></h5>
								
							</li>
							<li>
								<h5>EXHIBIT <span class="stat-value color-orang"><i class="fa fa-plus-circle"></i> 43,748</span></h5>
								
							</li>
						</ul>
            </div>
            </div>
            
            <div class="row">
			<div class="col-md-12">
				<div class="main-header">
					<h2>Calander</h2>
					<em>the first priority information</em>
				</div>
			</div>
		</div>
            <div class="row padding-top">
			<div id='script-warning'>
			    <code>Server must be running.</code>
			  </div>

			  <div id='loading'>loading...</div>

			  <div id='calendar'></div>
		</div>
        </div>
    </div>
  </div>
  
</body>
  
        <?php require_once('javascript_include.php'); ?>
	<script src='js/moment.min.js'></script>
<script src='js/jquery.min.js'></script>
<script src='js/fullcalendar.min.js'></script>
<script>
<?php 
	include_once('Cls_CommonFunction.php');
	$Obj_Commonfunction=new CommonFunctions();
?>
console.log(URL);
$(document).ready(function() 
{
	URL=<?php echo "'".$Obj_Commonfunction->config("APIURL")."/shchedule'"; ?>
	
	$('#calendar').fullCalendar({
      header: {left: 'prev,next today', center: 'title',right: 'month,agendaWeek,agendaDay,listWeek'},
      defaultDate: $.now(),
      editable: false,
	 displayEventEnd:true,
      navLinks: true, // can click day/week names to navigate views
      eventLimit: true, // allow "more" link when too many events
      
	events: {url: URL,error: function() { $('#script-warning').show(); }},
      loading: function(bool) {  $('#loading').toggle(bool); }
    });
});
</script>  
</html>