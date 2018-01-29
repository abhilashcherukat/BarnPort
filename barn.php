<!DOCTYPE html>
<html lang="en">
	<?php 
	include_once('Cls_CommonFunction.php');
	$Obj_Commonfunction=new CommonFunctions();
	$URL=$Obj_Commonfunction->config("APIURL");
	if(isset($_GET['page']) && $_GET['page']>0){$Page=$_GET['page'];}else{$Page=1;}
	?>
	<head>
		<?php require_once('head_include.php'); ?>
	</head>
	<body>
	<?php
		//var_dump($_POST);
		if(isset($_POST['Yes_btn_ConfirmYesNo']))
		{
			$params=[];
			$post_url = $URL."/barn?id=".$_POST['IdValue'];
			$post_response=$Obj_Commonfunction->CurlSendDelRequest($post_url,$params) ;
		}
		if(isset($_POST['OK_btn_CreateFormPopup_Editbarn']))
		{
			$params=['opt'=>2,
						'title'=>$_POST['barn_title'],
						'location'=>$_POST['barn_location'],
						'poc'=>$_POST['barn_poc'],
						'phone'=>$_POST['barn_phone'],
						'address'=>$_POST['barn_address'],
						'amenities'=>json_encode($_POST['ameni'])];
			$post_url = $URL."/barn/".$_POST['Editbarn_IdValue'];
			$post_response=$Obj_Commonfunction->CurlSendPostRequest($post_url,$params) ;
		}
	if(isset($_POST['OK_btn_CreateFormPopup_Addbarn']))
		{
			//var_dump($_POST);
			if(!isset($_POST['ameni']))
			{
				$Ameni=[];
			}else
			{
				$Ameni=$_POST['ameni'];
			}
			$params=['opt'=>1,
						'title'=>$_POST['barn_title'],
						'location'=>$_POST['barn_location'],
						'poc'=>$_POST['barn_poc'],
						'phone'=>$_POST['barn_phone'],
						'address'=>$_POST['barn_address'],
						'amenities'=>json_encode($Ameni)];
			$post_url = $URL."/barn/";
			$post_response=$Obj_Commonfunction->CurlSendPostRequest($post_url,$params) ;
			$J=json_decode($post_response);
			//Creating floor
			if($J->statusCode==200)
			{
				if(isset($_POST['isFloorexist']))
				{
					$post_url = $URL."/floor/";
					$params=['opt'=>1,	'barn'=>$J->data,'capacity'=>'200x200'];
					$post_response2=$Obj_Commonfunction->CurlSendPostRequest($post_url,$params) ;
				}
				if(isset($_POST['isExhibitexist']))
				{
					$post_url = $URL."/exhibit/";
					$params=['opt'=>1,	'barn'=>$J->data,'capacity'=>'200x200'];
					$post_response2=$Obj_Commonfunction->CurlSendPostRequest($post_url,$params) ;
				}
				for($i=0;$i<$_POST['classrooms'];$i++)
				{
					$post_url = $URL."/classroom/";
					$params=['opt'=>1,	'barn'=>$J->data,'capacity'=>0];
					$post_response2=$Obj_Commonfunction->CurlSendPostRequest($post_url,$params) ;
				}
				for($i=0;$i<$_POST['table'];$i++)
				{
					$post_url = $URL."/table/";
					$params=['opt'=>1,	'barn'=>$J->data];
					$post_response2=$Obj_Commonfunction->CurlSendPostRequest($post_url,$params) ;
				}
			}
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
								<div class='btn btn-success circle' id='btn_addbarn' ><a href='#' data-toggle='modal' data-target='#Addbarn' data-original-title>Add new</a></div>
								<div class="col-md-12" id='container'>
									<?php
										if(isset($post_response))
										{
											$J=json_decode($post_response);
											echo "<script>console.log(".$post_response.");setTimeout(function(){ $('.alert').fadeOut();}, 3000);</script>";
											
											$Arr=array();
											$Arr['success']="alert-success";
											$Arr['error']="alert-danger";
											$Arr['failure']="alert-warning";
											echo "<div class='alert ".$Arr[$J->status]."'>".$J->message."</div>";
									
									}
									
									?>
									<table class='table' id='barntbl'>
										<tr>
										<th>#</th>
										<th>Title</th>
										<th>Location</th>
										<th>Phone</th>
										<th>POC</th>
										<th>Address</th>
										<th>Amenities</th>
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
			$Str=$Obj_Commonfunction->GetData("LIST","commonlist/amenities?opt=combo");
			
		$HtmlEdit="<input type='hidden' name='opt'  id='opt' class='form-control input-sm' required value=1>
					<div class='row'>
						<div class='col-xs-6 col-sm-6 col-md-1'>Name</div>
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
						<div class='col-xs-6 col-sm-6 col-md-1'>Contact Person</div>
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
		CreateFormPopup("Editbarn","Edit barn",$HtmlEdit,'Editbarn',"?page=".$Page);
		$HtmlAdd="<input type='hidden' name='opt'  id='opt' class='form-control input-sm' required value=2>
					<div class='row'>
						<div class='col-xs-6 col-sm-6 col-md-1'>Name</div>
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
						<div class='col-xs-6 col-sm-6 col-md-1'>Contact Person</div>
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
						<div class='col-xs-6 col-sm-6 col-md-6'>
							<input type='checkbox' name='isFloorexist' id='floor'>Is there a floor in the barn?
						</div>
						<div class='col-xs-6 col-sm-6 col-md-6'>
							<input type='checkbox' name='isExhibitexist' id='exhibit'>Is there a exhibition space in the barn?
						</div>
					</div>
					<div class='row'>
						<div class='col-xs-6 col-sm-6 col-md-6'>
							How many classrooms?<input type='number' value=1 name='classrooms'  id='classroom'>
						</div>
						<div class='col-xs-6 col-sm-6 col-md-6'>
							How many tables?<input type='number' value=1 name='table'  id='table'>
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
						<div class='col-xs-6 col-sm-6 col-md-12' id='aminites'>".$Str."
					</div>
				</div>";
		
		CreateFormPopup("Addbarn","Add a barn",$HtmlAdd,'Addbarn',"?page=".$Page);
		
		?>
	</body>
	<?php 
	
		require_once('javascript_include.php'); 
		
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
							
							Str=""
							if(data.data[0].data.length<=0)
							{
								$('#barntbl').append("<tr><td>No records</td></tr>");
							}
							//console.log("This is the length:"+data.data[0].data.length);
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
								Str+="<td>Classroom:"+JData.classroom+"<br>Floor:"+JData.floor+"<br>Exhibit:"+JData.exhibit+"<br>Table:"+JData.table+"</td>";
								Str+="<td>"+GetAmenities(JData.amenities)+"</td>";
								//console.log(JData.amenities+" "+JData.title+" "+i)
								Str+="<td><a href='#' data-toggle='modal' data-target='#Editbarn' data-original-title onclick='Editthis(\""+JData.id+"\")' >Edit</a>";
								Str+=" | <a data-toggle='modal' data-target='#ConfirmYesNo' data-original-title onclick='Deletethis(\""+JData.id+"\")'>Delete</a></td></tr>";
							}
							Str+="<tr><td colspan=8 id='tblPaginate'></td></tr>";
							$('#barntbl').append(Str);
							
							Str=pagination	(<?php echo $Page; ?>,data.data[0].totalrecords)	
							$('#tblPaginate').append(Str);
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
				//clog(J)
			$('#barn_title').val(J.data.title);
			$('#barn_address').val(J.data.address);
			$('#barn_phone').val(J.data.phone);
			$('#barn_poc').val(J.data.poc);
			$('#barn_location').val(J.data.location);
			if(J.data.floor==0){$('#floor').attr("checked","");}else{$('#floor').attr("checked","checked");}
			if(J.data.exhibit==0){$('#exhibit').attr("checked","");}else{$('#exhibit').attr("checked","checked");}
			$('#classroom').val(J.data.classroom);
			$('#table').val(J.data.table);
			$('#opt').val(2);
			
			var posting=$.ajax({ 	
										type: "GET",
										url: "<?php echo $URL; ?>/commonlist/amenities",
										<?php if(isset($_SESSION['USERID'])){$USERID=$_SESSION['USERID'];}else{$USERID="";} 	?>
										headers: {'Authcode':<?php echo "'".$USERID."'";?>},
										data:{'opt':'combo'}
									});
			posting.done(function(Amen) {
				clog(Amen.data)
				Str1="<ul>";
				for(k=0;k<Amen.data.length;k++)
				{
					
					Id=Amen.data[k].title.replace(" ","_")
					Str1+="<li class='list'><input type='checkbox' name=ameni[] value='"+Amen.data[k].id+"' id='"+Id+"'>"+Amen.data[k].title+"</li>";
				}
				Str1+="</ul>";
				
				$('#aminites').html(Str1)
				clog(J.data.amenities)
				for(k=0;k<J.data.amenities.length;k++)
				{
					IDr='#'+J.data.amenities[k].title.replace(" ","_")
					$(IDr).attr("checked","checked");
				}
			});
			$('#Editbarn_IdValue').val(Id);
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