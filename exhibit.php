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
			$post_url = $URL."/exhibit/".$_POST['IdValue'];
			$post_response=$Obj_Commonfunction->CurlSendDelRequest($post_url,$params) ;
		}
		
		if(isset($_POST['OK_btn_CreateFormPopup_Addexhibit']))
		{
			
			$params=['opt'=>'1','name'=>$_POST['exhibit_name'],'barn'=>$_POST['exhibit_barn'],'capacity'=>$_POST['exhibit_capacity']];
			$post_url = $URL."/exhibit/";
			$post_response=$Obj_Commonfunction->CurlSendPostRequest($post_url,$params) ;
		}
		if(isset($_POST['OK_btn_CreateFormPopup_Editexhibit']))
		{
			$params=['opt'=>'2','name'=>$_POST['exhibit_name'],'barn'=>$_POST['exhibit_barn'],'capacity'=>$_POST['exhibit_capacity']];
			$post_url = $URL."/exhibit/".$_POST['Addexhibit_IdValue'];
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
								<li class="active">exhibit</li>
							</ul>
						</div>
						<div class="col-md-8">
						</div>
					</div>
			
					<div class="row">
						<div class="col-md-12">
							<div class="main-header">
								<h2>Exhibit</h2>
								<em>the first priority information</em>
								<img src='images/loader.gif' id='loading-image'>
							</div>
							<div class="row padding-top">
								<div class='btn btn-success circle' id='btn_addexhibit' data-toggle='modal' data-target='#Addexhibit' data-original-title onclick='Addnew()' >Add new</div>
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
									<table class='table' id='exhibittbl'>
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
			CreateConfirmModal("Add a chair","Are you sure you want to add a chair  to this</b>?");
			
			$Html="  <div class='row'>
						Are you sure you want to add a chair  to this?
					</div>";
			CreateFormPopup("AddChair","Add new chair",$Html,'AddChair');
			
			$Str=$Obj_Commonfunction->GetData("COMBO","barn/?opt=combo");
			$Html="  <div class='row'>
						<div class='col-xs-6 col-sm-6 col-md-1'>
							Barn
						</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
								<select name='exhibit_barn' id='exhibit_barn' class='form-control input-sm'>
								".$Str."
								</select>
							</div>
						</div>
						
						<div class='col-xs-6 col-sm-6 col-md-1'>
							Capacity
						</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
								<input type='text' name='exhibit_capacity' id='exhibit_capacity' class='form-control input-sm'>
							</div>
						</div>
					</div>";
		
		
			CreateFormPopup("Addexhibit","Add new exhibit",$Html,'Addexhibit',"?page=".$Page,"enctype= multipart/form-data");
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
										url: "<?php echo $URL; ?>/exhibit/",
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
								$('#exhibittbl').append("<tr><td>No records</td></tr>");
							}
							
							for(i=0;i<data.data[0].data.length;i++)
							{
								
								JData=data.data[0].data[i];
								Str+="<tr id='TR_"+i+"'>";
								Str+="<td>"+(i+1)+"</td>";
								Str+="<td>"+JData.capacity+"</td>";
								Str+="<td>"+JData.barn.title+"</td>";
										
								Str+="<td><a href='#' data-toggle='modal' data-target='#Addexhibit' data-original-title onclick='Editthis(\""+JData.id+"\")' >Edit</a>";
								Str+=" | <a data-toggle='modal' data-target='#ConfirmYesNo' data-original-title onclick='Deletethis(\""+JData.id+"\")'>Delete</a></td></tr>";
						
							}
							Str+="<tr><td colspan=8 id='tblPaginate'></td></tr>";
							$('#exhibittbl').append(Str);
							
							Str=pagination	(<?php echo $Page; ?>,data.data[0].totalrecords)	
							$('#tblPaginate').append(Str);
					}
				}
			});	
		});
	function Addnew()
	{
		$('#TIT_Addexhibit').html("Add");
		$('#exhibit_capacity').val("");
		$('#OK_btn_CreateFormPopup[name="OK_btn_CreateFormPopup_Editexhibit"]').attr('name','OK_btn_CreateFormPopup_Addexhibit');
	}
	function Editthis(Id)
	{
		$('#TIT_Addexhibit').html("Edit");
		var posting=$.ajax({ 	
										type: "GET",
										url: "<?php echo $URL; ?>/exhibit/"+Id,
										<?php if(isset($_SESSION['USERID'])){$USERID=$_SESSION['USERID'];}else{$USERID="";} 	?>
										headers: {'Authcode':<?php echo "'".$USERID."'";?>},
										data:{"id":Id}
									});
			posting.done(function(J) {
				clog(J)
			$('#OK_btn_CreateFormPopup[name="OK_btn_CreateFormPopup_Addexhibit"]').attr('name','OK_btn_CreateFormPopup_Editexhibit');
			$('#OK_btn_CreateFormPopup').val("KIT");
			$('#exhibit_barn').val(J.data.barn.id).attr("selected", "selected");
			$('#exhibit_capacity').val(J.data.capacity);
			$('#opt').val(2);
			$('#Addexhibit_IdValue').val(Id);
			
			});
			posting.error(function(J) {
				console.log(J);
			})
	}	
	
	function Deletethis(Id,Title)
	{
		$('#currentObject').html(Title);
		$('#IdValue').val(Id);
	}	
	</script>
</html>
