<!DOCTYPE html>
<html lang = "en">

<head>
<?php
include_once('head_include.php');
?>
<style>
	body {
			padding-top: 120px;
			padding-bottom: 40px;
			background-color:#000
		}
		.btn 
		{
		   outline:0;
		   border:none;
		   border-top:none;
		   border-bottom:none;
		   border-left:none;
		   border-right:none;
		   box-shadow:inset 2px -3px rgba(0,0,0,0.15);
		}
		.btn:focus
		{
		   outline:0;
		   -webkit-outline:0;
		   -moz-outline:0;
		}
		.form-signin {
		    max-width: 280px;
		    padding: 15px;
		    margin: 0 auto;
			margin-top:50px;
		}
		.form-signin .form-signin-heading, .form-signin {
		    margin-bottom: 10px;
		}
		.form-signin .form-control {
		    position: relative;
		    font-size: 16px;
		    height: auto;
		    padding: 10px;
		    -webkit-box-sizing: border-box;
		    -moz-box-sizing: border-box;
		    box-sizing: border-box;
		}
		.form-signin .form-control:focus {
		    z-index: 2;
		}
		.form-signin input[type="text"] {
		    margin-bottom: -1px;
		    border-bottom-left-radius: 0;
		    border-bottom-right-radius: 0;
		    border-top-style: solid;
		    border-right-style: solid;
		    border-bottom-style: none;
		    border-left-style: solid;
		    border-color: #000;
		}
		.form-signin input[type="password"] {
		    margin-bottom: 10px;
		    border-top-left-radius: 0;
		    border-top-right-radius: 0;
		    border-top-style: none;
		    border-right-style: solid;
		    border-bottom-style: solid;
		    border-left-style: solid;
		    border-color: rgb(0,0,0);
		    border-top:1px solid rgba(0,0,0,0.08);
		}
		.form-signin-heading {
		    color: #fff;
		    text-align: center;
		    text-shadow: 0 2px 2px rgba(0,0,0,0.5);
		}
	</style>
   </head>
   
   <body>

					<div id="fullscreen_bg" />

					<div class="container">

							<h1 class="form-signin-heading text-muted">Sign In</h1>
							<input type="text"  id='username' class="form-control" placeholder="jhon@gmail.com" required="" autofocus="" value='abhilash@spread.oo'>
							<input type="password" id='password' class="form-control" placeholder="Password" required="" value='decemberthird'>
							<button class="btn btn-lg btn-primary btn-block" type="button" id='btn_submit'>
								Sign In
							</button>
							<img='images/loader.gif' id='loading-image' style='display:none'>
					</div>
				
					
	</div>
   </body>
       <?php
		include_once('javascript_include.php');
	?>  
	<script>
	<?php
		include_once('Cls_CommonFunction.php');
		$Obj_Commonfunction=new CommonFunctions();
		$URL=$Obj_Commonfunction->config("APIURL");
	?>
		$(document).ready(function(){
				
			$('#btn_submit').click(function()
			{
				
				username=$("#username").val()
				password=$("#password").val()
				var Data={"email":username ,"password":password};
				var posting=$.post("<?php echo $URL; ?>/login",Data);
				posting.done(function(data) 
				{
					console.log(data)
					if (data.statusCode!=200)
					{
						$('.container').append("<span class='label label-danger'>"+data.message+"</span>");
						setTimeout(function(){ $(".label").fadeOut();console.log("X");}, 3000);
					}else
					{
						if(data.status=='failed')
						{
							$('.container').append("<span class='label label-danger'>"+data.message+"</span>");
							setTimeout(function(){ $(".label").fadeOut();console.log("X");}, 3000);
						}else
						{
							setSession("USERID",data.data.authcode);
							setSession("USERNAME",data.data.name);
							setSession("COLLECTIVE",data.data.isCollective);
							location.href='dashboard.php';
						}
					}
				});	
			});	
		
		});
		
	</script>
</html>