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
			width: 1000px;
		}   
		table
		{
			font-size:10px;
		}
		</style>
	</head>
	<body>
	<?php
		
		if(isset($_POST['OK_btn_CreateFormPopup_Addcourse']))
		{
			$params=['opt'=>'1',
			'title'=>$_POST['course_title'],
			'description'=>$_POST['course_desc'],
			'duration'=>'{"days":'.$_POST['course_days'].',"hours_per_day":'.$_POST['course_hpd'].'}',
			'agelimit'=>'{"from":'.$_POST['course_from'].',"to":'.$_POST['course_to'].'}',
			'coursehistory'=>'1',
			'status'=>'RGT',
			'feestructure'=>$_POST['course_fee'],
			'coursetype'=>$_POST['course_type'],
			'organiser'=>$_POST['course_organiser'],
			'tags'=>$_POST['course_tags'],
			];
			if(isset($_POST['ameni']))
			{
				$params['location']=json_encode($_POST['ameni']);
			}else
			{
					$params['location']=json_encode(array());
			}
			$post_url = $URL."/course/";
			var_dump($_FILES);
			if (empty($_FILES['course_img']['name'])!=1) 
			{
				$FileName=$_FILES["course_img"]["name"];
				$file_tmp= $_FILES["course_img"]['tmp_name'];
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
		if(isset($_POST['OK_btn_CreateFormPopup_Editcourse']))
		{
			$params=['opt'=>'2',
			'title'=>$_POST['course_title'],
			'description'=>$_POST['course_desc'],
			'duration'=>'{"days":'.$_POST['course_days'].',"hours_per_day":'.$_POST['course_hpd'].'}',
			'agelimit'=>'{"from":'.$_POST['course_from'].',"to":'.$_POST['course_to'].'}',
			'coursehistory'=>'1',
			'status'=>'RGT',
			'feestructure'=>$_POST['course_fee'],
			'coursetype'=>$_POST['course_type'],
			'organiser'=>$_POST['course_organiser'],
			'tags'=>$_POST['course_tags'],
			];
			if(isset($_POST['ameni']))
			{
				$params['location']=json_encode($_POST['ameni']);
			}else
			{
					$params['location']=json_encode(array());
			}
			$post_url = $URL."/course/".$_POST['Addcourse_IdValue'];
			if (empty($_FILES['course_img']['name'])!=1) 
			{
				$FileName=$_FILES["course_img"]["name"];
				$file_tmp= $_FILES["course_img"]['tmp_name'];
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
								<li class="active">course</li>
							</ul>
						</div>
						<div class="col-md-8">
						</div>
					</div>
			
					<div class="row">
						<div class="col-md-12">
							<div class="main-header">
								<h2>course</h2>
								<em>the first priority information</em>
								<img src='images/loader.gif' id='loading-image'>
							</div>
							<div class="row padding-top">
								<div class='btn btn-success circle' id='btn_addcourse' data-toggle='modal' data-target='#Addcourse' data-original-title onclick='Addnew()' >Add new</div>
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
									<table class='table' id='coursetbl'>
										<tr>
										<th>#</th>
										<th>Name</th>
										<th>Organiser</th>
										<th>Image</th>
										<th>Venue</th>
										<th>Description</th>
										<th>Duration</th>
										<th>Age limit</th>
										
										<th>Type</th>
										<th>Tags</th>
										<th>Fee</th>
										
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
			CreateConfirmModal("Delete course","Are you sure you want to delete this course?");
			$Str1=$Str2=$Str3=$Str4="";
			$Str1=$Obj_Commonfunction->GetData("COMBO","organiser/?opt=combo",true);
			$Str2=$Obj_Commonfunction->GetData("COMBO","commonlist/course?opt=combo");
			$Str3=$Obj_Commonfunction->GetData("LIST","barn/?opt=combo");
			$Str4=$Obj_Commonfunction->GetData("COMBO","feestructure/?opt=combo");
			
		$Html="<input type='hidden' name='opt'  id='opt' class='form-control input-sm' required value=1>
					<div class='row'>
						<div class='col-xs-6 col-sm-6 col-md-1'>Title</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
									<input type='text' name='course_title'  id='course_title'  class='form-control input-sm' required>
							</div>
						</div>
						
						<div class='col-xs-6 col-sm-6 col-md-1'>
							Organiser
						</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
									<select name='course_organiser' id='course_organiser' class='form-control input-sm' >
									".$Str1."
									</select>
							</div>
						</div>
						
						<div class='col-xs-6 col-sm-6 col-md-1'>
							Logo
						</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
									<input type='file' name='course_img' id='course_img' class='form-control input-sm' >
							</div>
						</div>	
					</div>
					
					<div class='row'>
						<div class='col-xs-6 col-sm-6 col-md-1'>Age Limit</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
									<input type='number' name='course_from'  value=10  id='course_from' class='form-control input-sm' required style='width:40%;float:left;'  min='10' max='60'>   to
									<input type='number' name='course_to'  value=35  id='course_to' class='form-control input-sm' required style='width:40%;float:right'  min='10' max='60'>
							</div>
						</div>
						
						<div class='col-xs-6 col-sm-6 col-md-1'>Days</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
								<input type='number' name='course_days' id='course_days'  value=1  class='form-control input-sm'  min='1' max='60' required>
							</div>
						</div>
						
						<div class='col-xs-6 col-sm-6 col-md-1'>Hours per day</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
									<input type='number' name='course_hpd' value=1 id='course_hpd' class='form-control input-sm'  min='1' max='8'>
							</div>
						</div>
					</div>
					
					<div class='row'>
						<div class='col-xs-6 col-sm-6 col-md-1'>Type</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
								<select name='course_type' id='course_type' class='form-control input-sm'>
								".$Str2."
								</select>
							</div>
						</div>
						
						<div class='col-xs-6 col-sm-6 col-md-1'>Location</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group' id='Locations'>
								
								".$Str3."
								
							</div>
						</div>
						
						<div class='col-xs-6 col-sm-6 col-md-1'>Tags</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
									<input type='text' name='course_tags' id='course_tags' class='form-control input-sm' >
							</div>
						</div>
					</div>
					
					<div class='row'>
						<div class='col-xs-6 col-sm-6 col-md-1'>Fee structure</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
							<select name='course_fee' id='course_fee' class='form-control input-sm'>
								".$Str4."
								</select>
							</div>
						</div>
						<div class='col-xs-6 col-sm-6 col-md-1'>Description</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
									<input type='text' name='course_desc'  id='course_desc'  value='XDesc' class='form-control input-sm' required>
							</div>
						</div>
					</div>";
			CreateFormPopup("Addcourse","Add course",$Html,'Addcourse',"?page=".$Page,"enctype= multipart/form-data");
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
										url: "<?php echo $URL; ?>/course/",
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
								$('#coursetbl').append("<tr><td>No records</td></tr>");
							}
							//console.log("This is the length:"+data.data[0].data.length);
							for(i=0;i<data.data[0].data.length;i++)
							{
								
								JData=data.data[0].data[i];
								Str+="<tr id='TR_"+i+"'>";
								Str+="<td>"+(i+1)+"</td>";
								Str+="<td>"+JData.title+"</td>";
								Str+="<td>"+JData.organiser.name+"</td>";
								//Str+="<td>"+JData.organiser.name+"</td>";
								Str+="<td><img style='width:50px;height:50px;' src="+JData.image+"></td>";
								Str+="<td>";
								for(ii=0;ii<JData.venues.length;ii++)
								{
									Str+=JData.venues[ii].barn.title+"<br>";
								}
								Str+="</td>"
								
								//Str+="<td>"+JData.startdate+" to "+JData.enddate+"</td>";
								Str+="<td>"+JData.description+"</td>";
								Str+="<td>Days:"+JData.duration.days+"<br>Per Hr:"+JData.duration.hours_per_day+"</td>";
								if(JData.agelimit.from==0)
								{
										Str+="<td>No limit</td>";
								}else
								{
									Str+="<td>"+JData.agelimit.from+" - "+JData.agelimit.to+"</td>";
								}
								Str+="<td>"+JData.type.title+"</td>";
								Str+="<td>"+JData.tags+"</td>";
								Str+="<td>"+GetFee(JData.fee)+"</td>";
								
								
								
								Str+="<td><a href='#' data-toggle='modal' data-target='#Addcourse' data-original-title onclick='Editthis(\""+JData.id+"\")' >Edit</a>";
								Str+=" | <a data-toggle='modal' data-target='#ConfirmYesNo' data-original-title onclick='Deletethis(\""+JData.id+"\")'>Delete</a></td></tr>";
							}
							Str+="<tr><td colspan=12 id='tblPaginate'></td></tr>";
							$('#coursetbl').append(Str);
							
							Str=pagination	(<?php echo $Page; ?>,data.data[0].totalrecords)	
							$('#tblPaginate').append(Str);
					}
				}
			});	
		});
	function Addnew()
	{
		$('#TIT_Addcourse').html("Add");
		$('#course_title').val(J.data.title);
			$('#course_desc').val("");
			$('#course_start').val("");
			$('#course_end').val("");
			$('#course_type')[0].selectedIndex = 0; 
			$('#course_fee')[0].selectedIndex = 0; 
			$('#course_organiser')[0].selectedIndex = 0; 
			$('#course_tags').val(J.data.tags)[0].selectedIndex = 0; 
			$('#course_type').val(J.data.type.id)[0].selectedIndex = 0; 
		$('#OK_btn_CreateFormPopup').attr('name','OK_btn_CreateFormPopup_Addcourse');
	}
	function Editthis(Id)
	{
		$('#TIT_Addcourse').html("Edit");
		var posting=$.ajax({ 	
										type: "GET",
										url: "<?php echo $URL; ?>/course/"+Id,
										<?php if(isset($_SESSION['USERID'])){$USERID=$_SESSION['USERID'];}else{$USERID="";} 	?>
										headers: {'Authcode':<?php echo "'".$USERID."'";?>},
										data:{"id":Id}
									});
			posting.done(function(J) {
				clog(J)
			$('#course_title').val(J.data.title);
			$('#course_desc').val(J.data.description);
			$('#course_start').val(J.data.startdate);
			$('#course_end').val(J.data.enddate);
			$('#course_type').val(J.data.type.id).attr("selected", "selected");
			$('#course_fee').val(J.data.fee.id).attr("selected", "selected");
			$('#course_organiser').val(J.data.organiser.id).attr("selected", "selected");
			$('#course_tags').val(J.data.tags).attr("selected", "selected");
			$('#course_type').val(J.data.type.id).attr("selected", "selected");
			
			console.log(J.data.venues.length);
			for(k=0;k<J.data.venues.length;k++)
			{
				Idx="input[value='"+J.data.venues[k].barn.id+"']";
				$(Idx).attr("checked","checked");
				console.log(J.data.venues[k].barn.title);
			}
		
			
			$('#opt').val(2);
			$('#Addcourse_IdValue').val(Id);
			$('#OK_btn_CreateFormPopup').attr('name','OK_btn_CreateFormPopup_Editcourse');
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