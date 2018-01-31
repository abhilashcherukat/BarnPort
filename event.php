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
		        
        <link rel="stylesheet" type="text/css" href="css/daterangepicker.css" />
	</head>
	<body>
	<?php
		function MakeDate($Dt)
		{
			$FirstCut=explode(" ",$Dt);
			$Date=explode("/",$FirstCut[0]);
			$Dates=$Date[2]."-".$Date[1]."-".$Date[0];
			
			if($FirstCut[2]=="PM")
			{
				$Time=explode(":",$FirstCut[1]);
				$Times=($Time[0]+12).":".$Time[1];
			}else
			{
				$Times=$FirstCut[1];
			}
			return $Dates." ".$Times;
		}
		if(isset($_POST['Yes_btn_ConfirmYesNo']))
		{
			$params=[];
			$post_url = $URL."/event/".$_POST['IdValue'];
			$post_response=$Obj_Commonfunction->CurlSendDelRequest($post_url,$params) ;
		}
		if(isset($_POST['OK_btn_CreateFormPopup_Addevent']))
		{
			//echo "<script>console.log('".$_POST['event_range']."');</script>";
			$FirstCut=explode(" - ",$_POST['event_range']);
			
			$Start=$FirstCut[0];
			$End=$FirstCut[1];
			
			$params=['opt'=>'1',
			'title'=>$_POST['event_title'],
			'description'=>$_POST['event_desc'],
			'duration'=>$_POST['event_hpd'],
			'end'=>MakeDate($End),
			'start'=>MakeDate($Start),
			'status'=>'RGT',
			'feestructure'=>$_POST['event_fee'],
			'eventtype'=>$_POST['event_type'],
			'tags'=>$_POST['event_tags'],
			'barn'=>$_POST['event_barn'],
			'organiser'=>$_POST['event_organiser'],
			$post_url = $URL."/event/"];
			//var_dump($params);
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
			$FirstCut=explode(" - ",$_POST['event_range']);
			
			$Start=$FirstCut[0];
			$End=$FirstCut[1];
			
			$params=['opt'=>'2',
			'title'=>$_POST['event_title'],
			'description'=>$_POST['event_desc'],
			'duration'=>$_POST['event_hpd'],
			'end'=>MakeDate($End),
			'start'=>MakeDate($Start),
			'status'=>'RGT',
			'feestructure'=>$_POST['event_fee'],
			'eventtype'=>$_POST['event_type'],
			'tags'=>$_POST['event_tags'],
			'barn'=>$_POST['event_barn'],
			'organiser'=>$_POST['event_organiser']];
			$post_url = $URL."/event/".$_POST['Addevent_IdValue'];
			echo $post_url;
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
										<th>Organiser</th>
										<th>Image</th>
										<th>Venue</th>
										<th>Dates</th>
										<th>Description</th>
										<th>Type</th>
										<th>Tags</th>
										<th>Fee</th>
										
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
			CreateConfirmModal("Delete event","Are you sure you want to delete this event</b>?");
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
									<input type='text' name='event_title'  id='event_title'  class='form-control input-sm' required>
							</div>
						</div>
						
						<div class='col-xs-6 col-sm-6 col-md-1'>
							Organiser
						</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
									<select name='event_organiser' id='event_organiser' class='form-control input-sm' >
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
						<div class='col-xs-6 col-sm-6 col-md-1'>Range</div>
						
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
									<input type='text' name='event_range' id='event_range' class='form-control input-sm' required>
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
								<select name='event_barn' id='event_barn' class='form-control input-sm'>
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
									<input type='text' name='event_desc'  id='event_desc'  value='XDesc' class='form-control input-sm' required>
							</div>
						</div>
					</div>";
			CreateFormPopup("Addevent","Add event",$Html,'Addevent',"?page=".$Page,"enctype= multipart/form-data");
			?>
	</body>
	<?php 
	
		require_once('javascript_include.php'); 
		
	?>
	<script src="js/moment.min.js"></script>         

        <script src="js/daterangepicker.js"></script>
	<script>
		$(document).ready(function()
		{
				
			var posting=$.ajax({ 	
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
								Str+="<td>"+JData.title+"</td>";
								Str+="<td>"+JData.organiser.name+"</td>";
								Str+="<td><img style='width:50px;height:50px;' src="+JData.image+"></td>";
								Str+="<td>"+JData.venue.title+"<sub>("+JData.venue.location+")</sub></td>";
								
								var Starts=MakeDate(JData.startdate);
								var Ends=MakeDate(JData.enddate);
								Str+="<td>"+Starts+" to "+Ends+"</td>";
								Str+="<td>"+JData.description+"</td>";
								
								Str+="<td>"+JData.type.title+"</td>";
								Str+="<td>"+JData.tags+"</td>";
								Str+="<td>"+GetFee(JData.fee)+"</td>";
								
								
								
								Str+="<td><a href='#' data-toggle='modal' data-target='#Addevent' data-original-title onclick='Editthis(\""+JData.id+"\")' >Edit</a>";
								Str+=" | <a data-toggle='modal' data-target='#ConfirmYesNo' data-original-title onclick='Deletethis(\""+JData.id+"\")'>Delete</a></td></tr>";
							}
							Str+="<tr><td colspan=11 id='tblPaginate'></td></tr>";
							$('#eventtbl').append(Str);
							
							Str=pagination	(<?php echo $Page; ?>,data.data[0].totalrecords)	
							$('#tblPaginate').append(Str);
					}
				}
			});	
		});
	function Addnew()
	{
		$('#TIT_Addevent').html("Add");
		//$('#event_title').val("");
		$('#OK_btn_CreateFormPopup').attr('name','OK_btn_CreateFormPopup_Addevent');
	}
	function MakeDate(Dt)
	{
		//09/01/2018 12:00 AM - 09/02/2018 11:00 PM
		//console.log(Dt)
		var time = new Date(Dt);
		//console.log(time)
		Y = time.getFullYear();
		X=parseInt(time.getMonth())+1
		m =X<9?"0"+X:X;
		d = time.getDate()<9?"0"+time.getDate():time.getDate();
		if (time.getHours()>12)
		{
			var hour = parseInt(time.getHours()) - 12;
			var amPm = "PM";
		} else 
		{
			var hour = time.getHours(); 
			var amPm = "AM";
		}
		h =hour<9?"0"+hour:hour;
		mi = time.getMinutes()<9?"0"+time.getMinutes():time.getMinutes();
		RetStr= d+"/"+m+"/"+Y+" "+h+":"+mi+" "+amPm;
		//console.log(RetStr);
		return RetStr
		
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
				clog(J)
			$('#event_title').val(J.data.title);
			$('#event_desc').val(J.data.description);
			
			var Starts=MakeDate(J.data.startdate);
			var Ends=MakeDate(J.data.enddate);
			$('#event_range').data('daterangepicker').setStartDate(Starts);
			$('#event_range').data('daterangepicker').setEndDate(Ends);
			
			$('#event_type').val(J.data.type.id).attr("selected", "selected");
			$('#event_fee').val(J.data.fee.id).attr("selected", "selected");
			$('#event_organiser').val(J.data.organiser.id).attr("selected", "selected");
			$('#event_barn').val(J.data.venue.id).attr("selected", "selected");
			$('#event_tags').val(J.data.tags).attr("selected", "selected");
			//$('#event_type').val(J.data.type.id).attr("selected", "selected");
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
	$(function() {
                                $('input[name="event_range"]').daterangepicker({
                                    timePicker: true,
                                    timePickerIncrement: 30,
                                    locale: {
                                        format: 'DD/MM/YYYY h:mm A'
                                    }
                                });
                            });
	</script>
</html>