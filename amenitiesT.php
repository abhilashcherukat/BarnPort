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
		if(isset($_POST['OK_btn_CreateFormPopup_AddAmenitiesType']))
		{
			
			$params=['opt'=>'1','title'=>$_POST['AmenitiesType_title'],'id'=>$_POST['AddAmenitiesType_IdValue']];
			
			
			if(isset($_FILES['AmenitiesType_icon']))
			{
				$FileName=$_FILES["AmenitiesType_icon"]["name"];
				$file_tmp= $_FILES["AmenitiesType_icon"]['tmp_name'];
				//$file_ext = strtolower( end(explode('.',$FileName)));
				$type = pathinfo($file_tmp, PATHINFO_EXTENSION);
				$data = file_get_contents($file_tmp);
				$base64 = base64_encode($data);//'data:image/' . $type . ';base64,' .
				$Array=array("name"=>$FileName,"content"=>$base64);
				$params['icon']=json_encode($Array);
		}
		//echo "<br><br><br><div class='pull-right'>".$params['icon']."</div>";
			$post_url = $URL."/commonlist/amenities";
			$post_response=$Obj_Commonfunction->CurlSendPostRequest($post_url,$params) ;
			
				
		}
		if(isset($_POST['OK_btn_CreateFormPopup_EditAmenitiesType']))
		{
			
			$params=['opt'=>'2','title'=>$_POST['AmenitiesType_title'],'id'=>$_POST['AddAmenitiesType_IdValue']];
			
			
			if(isset($_FILES['AmenitiesType_icon']))
			{
				$FileName=$_FILES["AmenitiesType_icon"]["name"];
				$file_tmp= $_FILES["AmenitiesType_icon"]['tmp_name'];
				//$file_ext = strtolower( end(explode('.',$FileName)));
				$type = pathinfo($file_tmp, PATHINFO_EXTENSION);
				$data = file_get_contents($file_tmp);
				$base64 =base64_encode($data);// 'data:image/' . $type . ';base64,' .
				$Array=array("name"=>$FileName,"content"=>$base64);
				$params['icon']=json_encode($Array);
			}
			//echo "<br><br><br><div class='pull-right'>".$params['icon']."</div>";
			$post_url = $URL."/commonlist/amenities";
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
								<li class="active">AmenitiesType</li>
							</ul>
						</div>
						<div class="col-md-8">
						</div>
					</div>
			
					<div class="row">
						<div class="col-md-12">
							<div class="main-header">
								<h2>AmenitiesType</h2>
								<em>the first priority information</em>
								<img src='images/loader.gif' id='loading-image'>
							</div>
							<div class="row padding-top">
								<div class='btn btn-success circle' id='btn_addAmenitiesType' data-toggle='modal' data-target='#AddAmenitiesType' data-original-title onclick='Addnew()' >Add new</div>
								<div class="col-md-12" id='container'>
									
									<table class='table' id='AmenitiesTypetbl'>
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
			CreateConfirmModal("Delete AmenitiesType","Are you sure you want to delete <b id='currentObject'>this</b>?");
			
			$Html="  <div class='row'>
						<div class='col-xs-6 col-sm-6 col-md-1'>
							Title
						</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
								<input type='text' name='AmenitiesType_title'  id='AmenitiesType_title' class='form-control input-sm' required>
							</div>
						</div>
						<div class='col-xs-6 col-sm-6 col-md-1'>
							Icon File
						</div>
							<input type='hidden' name='opt'  id='opt' class='form-control input-sm' required value=1>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
								<input type='file' name='AmenitiesType_icon'  id='AmenitiesType_icon' class='form-control input-sm'>
							</div>
						</div>
					</div>";
		
		
			CreateFormPopup("AddAmenitiesType","Add new AmenitiesType",$Html,'AddAmenitiesType',"?page=".$Page,"enctype= multipart/form-data");
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
										url: "<?php echo $URL; ?>/commonlist/amenities",
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
								$('#AmenitiesTypetbl').append("<tr><td>No records</td></tr>");
							}
							//console.log("This is the length:"+data.data[0].data.length);
							for(i=0;i<data.data[0].data.length;i++)
							{
								
								JData=data.data[0].data[i];
								
								Str+="<tr id='TR_"+i+"'>";
								Str+="<td>"+(i+1)+"</td>";
								Str+="<td>"+JData.title+"</td>";
								Str+="<td><img style='width:25px;height:25px;' src='images/amenities/"+JData.icon+"'></td>";
								
								Str+="<td><a href='#' data-toggle='modal' data-target='#AddAmenitiesType' data-original-title onclick='Editthis(\""+JData.id+"\")' >Edit</a>";
								Str+="<a href='#'>Delete</a></td></tr>";
							}
							Str+="<tr><td colspan=8 id='tblPaginate'></td></tr>";
							$('#AmenitiesTypetbl').append(Str);
							
							Str=pagination	(<?php echo $Page; ?>,data.data[0].totalrecords)	
							$('#tblPaginate').append(Str);
					}
				}
			});	
		});
	function Addnew()
	{
		$('#TIT_AddAmenitiesType').html("Add");
		$('#AmenitiesType_title').val("");
		$('#OK_btn_CreateFormPopup').attr('name','OK_btn_CreateFormPopup_AddAmenitiesType');
	}
	function Editthis(Id)
	{
		$('#TIT_AddAmenitiesType').html("Edit");
		var posting=$.ajax({ 	
										type: "GET",
										url: "<?php echo $URL; ?>/commonlist/amenities",
										<?php if(isset($_SESSION['USERID'])){$USERID=$_SESSION['USERID'];}else{$USERID="";} 	?>
										headers: {'Authcode':<?php echo "'".$USERID."'";?>},
										data:{"id":Id}
									});
			posting.done(function(J) {
				clog(J)
			$('#AmenitiesType_title').val(J.data.title);
			$('#opt').val(2);
			$('#AddAmenitiesType_IdValue').val(Id);
			$('#OK_btn_CreateFormPopup').attr('name','OK_btn_CreateFormPopup_EditAmenitiesType');
		});
	}	
	
	function Deletethis(Id,Title)
	{
		$('#currentObject').html(Title);
		$('#IdValue').val(Id);
	}	
	</script>
</html>