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
		if(isset($_POST['Yes_btn_ConfirmYesNo']))
		{
			$params=[];
			$post_url = $URL."/commonlist/organiser?id=".$_POST['IdValue'];
			$post_response=$Obj_Commonfunction->CurlSendDelRequest($post_url,$params) ;
		}
		if(isset($_POST['OK_btn_CreateFormPopup_AddorganiserType']))
		{
			
			$params=['opt'=>'1','title'=>$_POST['organiserType_title'],'id'=>$_POST['AddorganiserType_IdValue']];
			$post_url = $URL."/commonlist/organiser";
			$post_response=$Obj_Commonfunction->CurlSendPostRequest($post_url,$params) ;
		}
		if(isset($_POST['OK_btn_CreateFormPopup_EditorganiserType']))
		{
			$params=['opt'=>'2','title'=>$_POST['organiserType_title'],'id'=>$_POST['AddorganiserType_IdValue']];
			$post_url = $URL."/commonlist/organiser";
			$post_response=$Obj_Commonfunction->CurlSendPostRequest($post_url,$params) ;
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
								<li class="active">organiserType</li>
							</ul>
						</div>
						<div class="col-md-8">
						</div>
					</div>
			
					<div class="row">
						<div class="col-md-12">
							<div class="main-header">
								<h2>organiserType</h2>
								<em>the first priority information</em>
								<img src='images/loader.gif' id='loading-image'>
							</div>
							<div class="row padding-top">
								<div class='btn btn-success circle' id='btn_addorganiserType' data-toggle='modal' data-target='#AddorganiserType' data-original-title onclick='Addnew()' >Add new</div>
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
									<table class='table' id='organiserTypetbl'>
										<tr>
										<th>#</th>
										<th>Title</th>
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
			CreateConfirmModal("Delete organiserType","Are you sure you want to delete <b id='currentObject'>this</b>?");
			
			$Html="  <div class='row'>
						<div class='col-xs-6 col-sm-6 col-md-1'>
							Title
						</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
								<input type='text' name='organiserType_title'  id='organiserType_title' class='form-control input-sm' required>
							</div>
						</div>
						
					</div>";
		
		
			CreateFormPopup("AddorganiserType","Add new organiserType",$Html,'AddorganiserType',"?page=".$Page,"enctype= multipart/form-data");
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
										url: "<?php echo $URL; ?>/commonlist/organiser",
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
								$('#organiserTypetbl').append("<tr><td>No records</td></tr>");
							}
							//console.log("This is the length:"+data.data[0].data.length);
							for(i=0;i<data.data[0].data.length;i++)
							{
								
								JData=data.data[0].data[i];
								
								Str+="<tr id='TR_"+i+"'>";
								Str+="<td>"+(i+1)+"</td>";
								Str+="<td>"+JData.title+"</td>";
								
								Str+="<td><a href='#' data-toggle='modal' data-target='#AddorganiserType' data-original-title onclick='Editthis(\""+JData.id+"\")' >Edit</a>";
								Str+="<a href='#'>Delete</a></td></tr>";
							}
							Str+="<tr><td colspan=8 id='tblPaginate'></td></tr>";
							$('#organiserTypetbl').append(Str);
							
							Str=pagination	(<?php echo $Page; ?>,data.data[0].totalrecords)	
							$('#tblPaginate').append(Str);
					}
				}
			});	
		});
	function Addnew()
	{
		$('#TIT_AddorganiserType').html("Add");
		$('#organiserType_title').val("");
		$('#OK_btn_CreateFormPopup').attr('name','OK_btn_CreateFormPopup_AddorganiserType');
	}
	function Editthis(Id)
	{
		$('#TIT_AddorganiserType').html("Edit");
		var posting=$.ajax({ 	
										type: "GET",
										url: "<?php echo $URL; ?>/commonlist/organiser",
										<?php if(isset($_SESSION['USERID'])){$USERID=$_SESSION['USERID'];}else{$USERID="";} 	?>
										headers: {'Authcode':<?php echo "'".$USERID."'";?>},
										data:{"id":Id}
									});
			posting.done(function(J) {
				clog(J)
			$('#organiserType_title').val(J.data.title);
			$('#opt').val(2);
			$('#AddorganiserType_IdValue').val(Id);
			$('#OK_btn_CreateFormPopup').attr('name','OK_btn_CreateFormPopup_EditorganiserType');
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