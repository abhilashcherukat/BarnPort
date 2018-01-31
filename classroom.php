<!DOCTYPE html>
<html lang="en">
	<?php 
	include_once('Cls_CommonFunction.php');
	$Obj_Commonfunction=new CommonFunctions();
	$URL=$Obj_Commonfunction->config("APIURL");
	if(isset($_GET['page']) && $_GET['page']>0){$Page=$_GET['page'];}else{$Page=1;}
	?>
	<head>
		<?php 
			require_once('head_include.php'); 
		?>
		<style>
		.modal-dialog {
			width: 800px;
		}   
		</style>
		
	</head>
	<body>
	<?php

		if(isset($_POST['Yes_btn_ConfirmYesNo']))
		{
			$params=[];
			$post_url = $URL."/classroom/".$_POST['IdValue'];
			$post_response=$Obj_Commonfunction->CurlSendDelRequest($post_url,$params) ;
		}
		
		
		if(isset($_POST['OK_btn_CreateFormPopup_Addclassroom']))
		{
			
			$params=['opt'=>'1','name'=>$_POST['classroom_name'],'barn'=>$_POST['classroom_barn'],'capacity'=>$_POST['classroom_capacity']];
			$post_url = $URL."/classroom/";
			$post_response=$Obj_Commonfunction->CurlSendPostRequest($post_url,$params) ;
		}
		if(isset($_POST['OK_btn_CreateFormPopup_Editclassroom']))
		{
			$params=['opt'=>'2','name'=>$_POST['classroom_name'],'barn'=>$_POST['classroom_barn'],'capacity'=>$_POST['classroom_capacity']];
			$post_url = $URL."/classroom/".$_POST['Addclassroom_IdValue'];
			$post_response=$Obj_Commonfunction->CurlSendPostRequest($post_url,$params) ;
		}
	
	?>
	 <?php require_once('navbar_include.php');
	 ?>
		<div class="wrapper" id="wrapper">
			<div class="left-container" id="left-container">
			<!-- begin SIDE NAV USER PANEL -->
				<?php require_once('sidebar_include.php'); 
				?>
			<!-- END SIDE NAV USER PANEL -->
			</div>
			<div class="right-container" id="right-container">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-4">
							<ul class="breadcrumb">
								<li><i class="fa fa-home"></i><a href="/"> Home</a></li>
								<li class="active">classroom</li>
							</ul>
						</div>
						<div class="col-md-8">
						</div>
					</div>
			
					<div class="row">
						<div class="col-md-12">
							<div class="main-header">
								<h2>Classroom</h2>
								<em>the first priority information</em>
								<img src='images/loader.gif' id='loading-image'>
							</div>
							<div class="row padding-top">
								<div class='btn btn-success circle' id='btn_addclassroom' data-toggle='modal' data-target='#Addclassroom' data-original-title onclick='Addnew()' >Add new</div>
								<div class="col-md-12" id='container'>
									<?php
										if(isset($post_response))
										{
											echo "<script>setTimeout(function(){ $('.alert').fadeOut();}, 3000);</script>";
											$J=json_decode($post_response);
											$Arr=array();
											$Arr['success']="alert-success";
											$Arr['error']="alert-danger";
											$Arr['failure']="alert-warning";
											echo "<div class='alert ".$Arr[$J->status]."'>".$J->message."</div>";
										}
									
									?>
									<table class='table' id='classroomtbl'>
										<tr>
										<th>#</th>
										<th>Name</th>
										<th>Capacity</th>
										<th>Barn</th>
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
			CreateConfirmModal("Delete classroom","Are you sure you want to this</b>?");
			
			
			$Str=$Obj_Commonfunction->GetData("COMBO","barn/?opt=combo");
			$Html="  <div class='row'>
						<div class='col-xs-6 col-sm-6 col-md-1'>
							Barn
						</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
								<select name='classroom_barn' id='classroom_barn' class='form-control input-sm'>
								".$Str."
								</select>
							</div>
						</div>
						<div class='col-xs-6 col-sm-6 col-md-1'>
							Name
						</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
								<input type='text' name='classroom_name' id='classroom_name' class='form-control input-sm'>
							</div>
						</div>
						<div class='col-xs-6 col-sm-6 col-md-1'>
							Capacity
						</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
								<input type='text' name='classroom_capacity' id='classroom_capacity' class='form-control input-sm'>
							</div>
						</div>
					</div>";
		
		
			CreateFormPopup("Addclassroom","Add new classroom",$Html,'Addclassroom',"?page=".$Page,"enctype= multipart/form-data");
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
										url: "<?php echo $URL; ?>/classroom/",
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
								$('#classroomtbl').append("<tr><td>No records</td></tr>");
							}
							
							for(i=0;i<data.data[0].data.length;i++)
							{
								
								JData=data.data[0].data[i];
								Str+="<tr id='TR_"+i+"'>";
								Str+="<td>"+(i+1)+"</td>";
								Str+="<td>"+JData.name+"</td>";
								Str+="<td>"+JData.capacity+"</td>";
								Str+="<td>"+JData.barn.title+"</td>";
										
								Str+="<td><a href='#' data-toggle='modal' data-target='#Addclassroom' data-original-title onclick='Editthis(\""+JData.id+"\")' >Edit</a>";
								Str+=" | <a data-toggle='modal' data-target='#ConfirmYesNo' data-original-title onclick='Deletethis(\""+JData.id+"\")'>Delete</a></td></tr>";
						
							}
							Str+="<tr><td colspan=8 id='tblPaginate'></td></tr>";
							$('#classroomtbl').append(Str);
							
							Str=pagination	(<?php echo $Page; ?>,data.data[0].totalrecords)	
							$('#tblPaginate').append(Str);
					}
				}
			});	
		});
	function Addnew()
	{
		$('#TIT_Addclassroom').html("Add");
		$('#classroom_name').val("");
		$('#classroom_capacity').val("");
		$('#OK_btn_CreateFormPopup[name="OK_btn_CreateFormPopup_Editclassroom"]').attr('name','OK_btn_CreateFormPopup_Addclassroom');
	}
	function Editthis(Id)
	{
		$('#TIT_Addclassroom').html("Edit");
		var posting=$.ajax({ 	
										type: "GET",
										url: "<?php echo $URL; ?>/classroom/"+Id,
										<?php if(isset($_SESSION['USERID'])){$USERID=$_SESSION['USERID'];}else{$USERID="";} 	?>
										headers: {'Authcode':<?php echo "'".$USERID."'";?>},
										data:{"id":Id}
									});
			posting.done(function(J) {
				clog(J)
			$('#OK_btn_CreateFormPopup[name="OK_btn_CreateFormPopup_Addclassroom"]').attr('name','OK_btn_CreateFormPopup_Editclassroom');
			$('#OK_btn_CreateFormPopup').val("KIT");
			$('#classroom_barn').val(J.data.barn.id).attr("selected", "selected");
			$('#classroom_name').val(J.data.name);
			$('#classroom_capacity').val(J.data.capacity);
			$('#opt').val(2);
			$('#Addclassroom_IdValue').val(Id);
			
			});
			posting.error(function(J) {
				console.log(J);
			})
	}	
	
	function Deletethis(Id,Title)
	{
		$('#currentObject').html(Title);
		$('#AddChair_IdValue').val(Id);
		$('#IdValue').val(Id);
	}	
	</script>
</html>
