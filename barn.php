<!DOCTYPE html>
<html lang="en">
	<?php 
	if(isset($_GET['page']) && $_GET['page']>0){$Page=$_GET['page'];}else{$Page=1;}
	?>
	<head>
		<?php require_once('head_include.php'); ?>
	</head>
	<body>
	<?php
		if(isset($_POST['OK_btn_CreateFormPopup_Editbarn']))
		{
			var_dump($_POST);
			/*
				$params=['name'=>'John', 'surname'=>'Doe', 'age'=>36)
				$defaults = array(
				CURLOPT_URL => 'http://myremoteservice/', 
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => $params,
				);
				$ch = curl_init();
				curl_setopt_array($ch, ($options + $defaults));

			*/
		}
	?>
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
								<li class="active">Barn</li>
							</ul>
						</div>
						<div class="col-md-8">
						</div>
					</div>
			
					<div class="row">
						<div class="col-md-12">
							<div class="main-header">
								<h2>BARN</h2>
								<em>the first priority information</em>
								<img src='images/loader.gif' id='loading-image'>
							</div>
							<div class="row padding-top">
								<div class='btn btn-success circle' id='btn_addbarn'>Add new</div>
								<div class="col-md-12" id='container'>
									
									<table class='table' id='barntbl'>
										<tr>
										<th>#</th>
										<th>Title</th>
										<th>Location</th>
										<th>Phone</th>
										<th>POC</th>
										<th>Address</th>
										<th></th>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php require_once('Modal.php'); 
			CreateConfirmModal("Delete barn","Are you sure you want to delete <b id='currentObject'>this</b>?");
		$Html="<div class='row'>
						<div class='col-xs-6 col-sm-6 col-md-1'>
						Name
						</div>
						<input type='hidden' name='opt'  id='opt' class='form-control input-sm' required value=1>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
									<input type='text' name='barn_title'  id='barn_title' class='form-control input-sm' required>
							</div>
						</div>
						<div class='col-xs-6 col-sm-6 col-md-1'>
						City
						</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
									<input type='text' name='barn_location' id='barn_location' class='form-control input-sm' >
							</div>
						</div>
			</div>
			<div class='row'>
						<div class='col-xs-6 col-sm-6 col-md-1'>
						Contact Person
						</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
									<input type='text' name='barn_poc'  id='barn_poc' class='form-control input-sm' required>
							</div>
						</div>
						<div class='col-xs-6 col-sm-6 col-md-1'>
						Phone
						</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
									<input type='text' name='barn_phone' id='barn_phone' class='form-control input-sm' >
							</div>
						</div>
			</div>
			<div class='row'>
			<div class='col-xs-6 col-sm-6 col-md-12'>
			Address
			</div>
			<div class='col-xs-6 col-sm-6 col-md-12'>
				<div class='form-group'>
						<input type='text' name='barn_address' id='barn_address' class='form-control input-sm' >
				</div>
			</div>
			
			
			<div class='col-xs-6 col-sm-6 col-md-12'>
			Amenities
			</div>
			<div class='col-xs-6 col-sm-6 col-md-12' id='aminites'>
				
			</div>
			
		</div>";
		
		
		CreateFormPopup("Addbarn","Add new barn",$Html,'Addbarn',"/barn/");
		?>
	</body>
	<?php 
	
		require_once('javascript_include.php'); 
		include_once('Cls_CommonFunction.php');
		$Obj_Commonfunction=new CommonFunctions();
		$URL=$Obj_Commonfunction->config("APIURL");
	?>
	<script>
		$(document).ready(function()
		{
				
			var posting=$.ajax({ 	
										type: "GET",
										url: "<?php echo $URL; ?>/barn/",
										<?php if(isset($_SESSION['USERID'])){$USERID=$_SESSION['USERID'];}else{$USERID="";} 	?>
										headers: {'Authcode':<?php echo "'".$USERID."'";?>},
										data:{'page':<?php echo $Page; ?>}
									});
			posting.done(function(data)
			{
				clog(data)
				if (data.statusCode!=200)
				{
					$('.container').append("<span class='alert alert-danger'>"+data.message+"</span>");
					setTimeout(function(){ $(".alert").fadeOut();console.log("X");}, 3000);
				}else
				{
					
					if(data.status=='failed')
					{
							$('#container').append("<span class='alert alert-danger'>"+data.message+"</span>");
							setTimeout(function(){ $(".alert").fadeOut();}, 3000);
					}else
					{
							
							Str="";
							for(i=0;i<data.data[0].data.length;i++)
							{
								
								JData=data.data[0].data[i];
								Str+="<tr id='TR_"+i+"'>";
								Str+="<td>"+(i+1)+"</td>";
								Str+="<td>"+JData.title+"</td>";
								Str+="<td>"+JData.location+"</td>";
								Str+="<td>"+JData.phone+"</td>";
								Str+="<td>"+JData.poc+"</td>";
								Str+="<td>"+JData.address+"</td>";
								
								Str+="<td><a href='#' data-toggle='modal' data-target='#Addbarn' data-original-title onclick='Editthis(\""+JData.id+"\")' >Edit</a>";
								Str+="<a href='#'>Delete</a></td></tr>";
							}
							Str+="<tr><td colspan=8 id='barntblPaginate'></td></tr>";
							$('#barntbl').append(Str);
							Str=Paginate(data.data[0].totalrecords,<?php echo $Page; ?>)	
							$('#barntblPaginate').append(Str);
					}
				}
			});	
		});
	
	function Editthis(Id)
	{
	
		var posting=$.ajax({ 	
										type: "GET",
										url: "<?php echo $URL; ?>/barn/"+Id,
										<?php if(isset($_SESSION['USERID'])){$USERID=$_SESSION['USERID'];}else{$USERID="";} 	?>
										headers: {'Authcode':<?php echo "'".$USERID."'";?>},
									});
			posting.done(function(J) {
				clog(J.data.title)
			$('#barn_title').val(J.data.title);
			$('#barn_address').val(J.data.address);
			$('#barn_phone').val(J.data.phone);
			$('#barn_poc').val(J.data.poc);
			$('#barn_location').val(J.data.location);
			$('#opt').val(2);
			var posting=$.ajax({ 	
										type: "GET",
										url: "<?php echo $URL; ?>/commonlist/amenities",
										<?php if(isset($_SESSION['USERID'])){$USERID=$_SESSION['USERID'];}else{$USERID="";} 	?>
										headers: {'Authcode':<?php echo "'".$USERID."'";?>},
									});
			posting.done(function(Amen) {
				Str1="<ul>";
				for(k=0;k<Amen.data.length;k++)
				{
					Id=Amen.data[k].title.replace(" ","_")
					Str1+="<li class='list'><input type='checkbox' value='"+Amen.data[k].id+"' id='"+Id+"'>"+Amen.data[k].title+"</li>";
				}
				Str1+="</ul>";
				
				$('#aminites').html(Str1)
				for(k=0;k<J.data.amenities.length;k++)
				{
					IDr='#'+J.data.amenities[k].title.replace(" ","_")
					$(IDr).attr("checked","checked");
				}
			});
			
			$('#FRM_Addbarn').attr("action", "<?php echo $URL; ?>/barn/"+Id); //Changing action for attaching different ID to the URL
			$('#Addbarn_IdValue').val(Id);
			$('#OK_btn_CreateFormPopup').attr('name','OK_btn_CreateFormPopup_Editbarn');
			
		});
	}	

	function Deletethis(Id,Title)
	{
		$('#currentObject').html(Title);
		$('#IdValue').val(Id);
	}	
	</script>
</html>