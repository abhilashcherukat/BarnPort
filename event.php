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
	</head>
	<body>
	<?php
		
		if(isset($_POST['OK_btn_CreateFormPopup_Addevent']))
		{
			
			$params=['opt'=>'1',
			'name'=>$_POST['event_name'],
			'type'=>$_POST['event_type'],
			'description'=>$_POST['event_desc'],
			'id'=>$_POST['Addevent_IdValue']];
			$post_url = $URL."/event/";
			var_dump($_FILES);
			echo "<script>console.log('IMAGE:".empty($_FILES['event_img']['name']).":".$_FILES['event_img']['name']."')</script>";
			if (empty($_FILES['event_img']['name'])!=1) 
			{
				$FileName=$_FILES["event_img"]["name"];
				$file_tmp= $_FILES["event_img"]['tmp_name'];
				$type = pathinfo($file_tmp, PATHINFO_EXTENSION);
				$data = file_get_contents($file_tmp);
				$base64 = base64_encode($data);
				$Array=array("name"=>$FileName,"content"=>$base64);
				$params['image']=json_encode($Array);
			}else
			{
				$Array=array("name"=>"","content"=>"");
				$params['image']=json_encode($Array);
			}
		
			$post_response=$Obj_Commonfunction->CurlSendPostRequest($post_url,$params) ;
		}
		if(isset($_POST['OK_btn_CreateFormPopup_Editevent']))
		{
			$params=['opt'=>'2',
			'name'=>$_POST['event_name'],
			'type'=>$_POST['event_type'],
			'description'=>$_POST['event_desc'],
			'id'=>$_POST['Addevent_IdValue']];
			$post_url = $URL."/event/";
			
			if (!empty($_FILES['event_img']['name'])) 
			{
				$FileName=$_FILES["event_img"]["name"];
				$file_tmp= $_FILES["event_img"]['tmp_name'];
				$type = pathinfo($file_tmp, PATHINFO_EXTENSION);
				$data = file_get_contents($file_tmp);
				$base64 = base64_encode($data);
				$Array=array("name"=>$FileName,"content"=>$base64);
				$params['image']=json_encode($Array);
			}else
			{
				$Array=array("name"=>"","content"=>"");
				$params['image']=json_encode($Array);
			}
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
								<li class="active">event</li>
							</ul>
						</div>
						<div class="col-md-8">
						</div>
					</div>
			
					<div class="row">
						<div class="col-md-12">
							<div class="main-header">
								<h2>event</h2>
								<em>the first priority information</em>
								<img src='images/loader.gif' id='loading-image'>
							</div>
							<div class="row padding-top">
								<div class='btn btn-success circle' id='btn_addevent' data-toggle='modal' data-target='#Addevent' data-original-title onclick='Addnew()' >Add new</div>
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
									<table class='table' id='eventtbl'>
										<tr>
										<th>#</th>
										<th>Name</th>
										<th>Image</th>
										<th>Description</th>
										<th>Type</th>
										<th>Events</th>
										<th></th>
										</tr>
									</event>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php require_once('Modal.php'); 
			CreateConfirmModal("Add a chair","Are you sure you want to add a chair  to this</b>?");
			$Str1=$Str2=$Str3=$Str4="";
			$Str1=$Obj_Commonfunction->GetData("COMBO","organiser/?opt=combo",true);
			$Str2=$Obj_Commonfunction->GetData("COMBO","commonlist/event?opt=combo");
			$Str3=$Obj_Commonfunction->GetData("COMBO","barn/?opt=combo");
			$Str4=$Obj_Commonfunction->GetData("COMBO","feestructure/?opt=combo");
			
		$Html="<input type='hidden' name='opt'  id='opt' class='form-control input-sm' required value=1>
					<div class='row'>
						<div class='col-xs-6 col-sm-6 col-md-1'>Title</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
									<input type='text' name='event_title'  id='event_title' class='form-control input-sm' required>
							</div>
						</div>
						
						<div class='col-xs-6 col-sm-6 col-md-1'>
							Organiser
						</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
									<select name='event_type' id='event_type' class='form-control input-sm' >
									".$Str1."
									</select>
							</div>
						</div>
						
						<div class='col-xs-6 col-sm-6 col-md-1'>
							Logo
						</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
									<input type='file' name='event_img' id='event_img' class='form-control input-sm' >
							</div>
						</div>	
					</div>
					
					<div class='row'>
						<div class='col-xs-6 col-sm-6 col-md-1'>Start</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
									<input type='date' name='event_start'  id='event_start' class='form-control input-sm' required>
							</div>
						</div>
						
						<div class='col-xs-6 col-sm-6 col-md-1'>End</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
									<input type='date' name='event_end' id='event_end' class='form-control input-sm' >
							</div>
						</div>
						
						<div class='col-xs-6 col-sm-6 col-md-1'>Hours per day</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
									<input type='number' name='event_hpd' id='event_hpd' class='form-control input-sm' >
							</div>
						</div>
					</div>
					
					<div class='row'>
						<div class='col-xs-6 col-sm-6 col-md-1'>Type</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
								<select name='event_type' id='event_type' class='form-control input-sm'>
								".$Str2."
								</select>
							</div>
						</div>
						
						<div class='col-xs-6 col-sm-6 col-md-1'>Barn</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
								<select name='event_barn' id='event_type' class='form-control input-sm'>
								".$Str3."
								</select>
							</div>
						</div>
						
						<div class='col-xs-6 col-sm-6 col-md-1'>Tags</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
									<input type='text' name='event_tags' id='event_tags' class='form-control input-sm' >
							</div>
						</div>
					</div>
					
					<div class='row'>
						<div class='col-xs-6 col-sm-6 col-md-1'>Fee structure</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
							<select name='event_fee' id='event_fee' class='form-control input-sm'>
								".$Str4."
								</select>
							</div>
						</div>
						<div class='col-xs-6 col-sm-6 col-md-1'>Description</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
									<input type='text' name='event_desc'  id='event_desc' class='form-control input-sm' required>
							</div>
						</div>
					</div>";
			CreateFormPopup("Addevent","Add event",$Html,'Addevent',"?page=".$Page,"enctype= multipart/form-data");
			?>
	</body>
	<?php 
	
		require_once('javascript_include.php'); 
		
	?>
	<script>
		$(document).ready(function()
		{
				
			/*var posting=$.ajax({ 	
										type: "GET",
										url: "<?php echo $URL; ?>/event/",
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
								$('#eventtbl').append("<tr><td>No records</td></tr>");
							}
							//console.log("This is the length:"+data.data[0].data.length);
							for(i=0;i<data.data[0].data.length;i++)
							{
								
								JData=data.data[0].data[i];
								Str+="<tr id='TR_"+i+"'>";
								Str+="<td>"+(i+1)+"</td>";
								Str+="<td>"+JData.name+"</td>";
								Str+="<td><img style='width:50px;height:50px;' src="+JData.image+"></td>";
								Str+="<td>"+JData.description+"</td>";
								
								Str+="<td>"+JData.type.title+"</td>";
								
								
								
								Str+="<td><a href='#' data-toggle='modal' data-target='#Addevent' data-original-title onclick='Editthis(\""+JData.id+"\")' >Edit</a>";
								Str+=" | <a href='#'>Delete</a> </td></tr>";
							}
							Str+="<tr><td colspan=8 id='tblPaginate'></td></tr>";
							$('#eventtbl').append(Str);
							
							Str=pagination	(<?php echo $Page; ?>,data.data[0].totalrecords)	
							$('#tblPaginate').append(Str);
					}
				}
			});	*/
		});
	function Addnew()
	{
		$('#TIT_Addevent').html("Add");
		$('#event_title').val("");
		$('#OK_btn_CreateFormPopup').attr('name','OK_btn_CreateFormPopup_Addevent');
	}
	function Editthis(Id)
	{
		$('#TIT_Addevent').html("Edit");
		var posting=$.ajax({ 	
										type: "GET",
										url: "<?php echo $URL; ?>/event/"+Id,
										<?php if(isset($_SESSION['USERID'])){$USERID=$_SESSION['USERID'];}else{$USERID="";} 	?>
										headers: {'Authcode':<?php echo "'".$USERID."'";?>},
										data:{"id":Id}
									});
			posting.done(function(J) {
				clog(JSON.stringify(J))
			$('#event_name').val(J.data.name);
			$('#event_desc').val(J.data.description);
			$('#event_type').val(J.data.type.id).attr("selected", "selected");
			$('#opt').val(2);
			$('#Addevent_IdValue').val(Id);
			$('#OK_btn_CreateFormPopup').attr('name','OK_btn_CreateFormPopup_Editevent');
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