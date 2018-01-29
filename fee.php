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
			width: 930px;
		}  
		table input
		{
			border-radius:3px;
			border:1px solid grey;
		}
		</style>
	</head>
	<body>
	<?php
		if(isset($_POST['Yes_btn_ConfirmYesNo']))
		{
			$params=[];
			$post_url = $URL."/feestructure?id=".$_POST['IdValue'];
			$post_response=$Obj_Commonfunction->CurlSendDelRequest($post_url,$params) ;
		}
		if(isset($_POST['OK_btn_CreateFormPopup_Addfee']))
		{
			$Jarr=array("title"=>"basefare","value"=>$_POST['fee_base']);
			
			$len1=count($_POST['ADV']);
			$JAdv=array();
			for($i=0;$i<$len1;$i++)
			{
				array_push($JAdv,array("title"=>$_POST['ADT'][$i],"value"=>$_POST['ADV'][$i]));
			}
			
			$len1=count($_POST['DDV']);
			$JDdv=array();
			for($i=0;$i<$len1;$i++)
			{
				array_push($JDdv,array("title"=>$_POST['DDT'][$i],"value"=>$_POST['DDV'][$i],"code"=>$_POST['DDC'][$i]));
			}
			
			$Structure=array("base"=>$Jarr,"addon"=>$JAdv,"discount"=>$JDdv);
			
			$params=['opt'=>'1',
			'title'=>$_POST['fee_title'],
			'structure'=>json_encode($Structure)];
			$post_url = $URL."/feestructure/";
			$post_response=$Obj_Commonfunction->CurlSendPostRequest($post_url,$params) ;
		}
		if(isset($_POST['OK_btn_CreateFormPopup_Editfee']))
		{
				
			$Jarr=array("title"=>"basefare","value"=>$_POST['fee_base']);
			
			$len1=count($_POST['ADV']);
			$JAdv=array();
			for($i=0;$i<$len1;$i++)
			{
				array_push($JAdv,array("title"=>$_POST['ADT'][$i],"value"=>$_POST['ADV'][$i]));
			}
			
			$len1=count($_POST['DDV']);
			$JDdv=array();
			for($i=0;$i<$len1;$i++)
			{
				array_push($JDdv,array("title"=>$_POST['DDT'][$i],"value"=>$_POST['DDV'][$i],"code"=>$_POST['DDC'][$i]));
			}
			
			$Structure=array("base"=>$Jarr,"addon"=>$JAdv,"discount"=>$JDdv);
			
			$params=['opt'=>'2',
			'title'=>$_POST['fee_title'],
			'structure'=>json_encode($Structure)];
			$post_url = $URL."/feestructure/".$_POST['Addfee_IdValue'];
			//echo "<script>console.log('".$post_url."');</script>";
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
								<li class="active">fee</li>
							</ul>
						</div>
						<div class="col-md-8">
						</div>
					</div>
			
					<div class="row">
						<div class="col-md-12">
							<div class="main-header">
								<h2>Fee structures</h2>
								<em>the first priority information</em>
								<img src='images/loader.gif' id='loading-image'>
							</div>
							<div class="row padding-top">
								<div class='btn btn-success circle' id='btn_addfee' data-toggle='modal' data-target='#Addfee' data-original-title onclick='Addnew()' >Add new</div>
								<div class="col-md-12" id='container'>
									<?php
										if(isset($post_response))
										{
											echo "<script>setTimeout(function(){ $('.alert').fadeOut();}, 3000);</script>";
											$J=json_decode($post_response);
											echo $post_response;
											$Arr=array();
											$Arr['success']="alert-success";
											$Arr['error']="alert-danger";
											$Arr['failure']="alert-warning";
											echo "<div class='alert ".$Arr[$J->status]."'>".$J->message."</div>";
										}
									
									?>
									<table class='table' id='feetbl'>
										<tr>
										<th>#</th>
										<th>Name</th>
										<th>Base Price</th>
										<th>Addons</th>
										<th>Discount</th>
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
			CreateConfirmModal("Delete fee structure","Are you sure you want to add a delete fee structure?");
			
		$Html="<input type='hidden' name='opt'  id='opt' class='form-control input-sm' required value=1>
					<div class='row'>
						<div class='col-xs-6 col-sm-6 col-md-1'>Title</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
									<input type='text' name='fee_title'  id='fee_title' class='form-control input-sm' required>
							</div>
						</div>
						<div class='col-xs-6 col-sm-6 col-md-2'>
							Base price
						</div>
						<div class='col-xs-6 col-sm-6 col-md-3'>
							<div class='form-group'>
									<input type='text' name='fee_base'  id='fee_base' class='form-control input-sm' required>
							</div>
						</div>
					</div>
					
					<div class='row'>
						<div class='col-xs-5 col-sm-5 col-md-5'>
							
							<table border=0 >
							<thead ><b>Addon</b><i class='fa fa-plus pull-right' onclick=AddX(1)></i></thead>
								<tr>
									<th>Title</th><th colspan=2>Value</th>
								</tr>
							<tbody  id='ADT' >
								<tr id='0'>
									<td>
										<input type='text'  id='ADT_0' name='ADT[]' required>
									</td>
									<td>
										<input type='text'  id='ADV_0' name='ADV[]' required>
									</td>	
									<td>	
										<a onclick='removeTime(0)'><i class='text-danger fa fa-trash'></i></a>
									</td>
								</tr>
								</tbody>
							</table>
						</div>
						<div class='col-xs-6 col-sm-6 col-md-6' style='border-left:1px solid #444'>
							
							<table >
							<thead ><b>Discount</b><i class='fa fa-plus pull-right' onclick=AddX(2)></i></thead>
								<tr>
									<th>Title</th><th colspan=2>Value</th>
								</tr>
							<tbody id='DDT'>
								<tr id='1'>
									<td>
										<input type='text'  id='DDT_1' name='DDT[]' required>
									</td>
									<td>
										<input type='number'  id='DDV_1' name='DDV[]' style='width:50px' required>
									</td>
									<td>
										<input type='text'  id='DDC_1' name='DDC[]' required>
									</td>	
									<td>	
										<a onclick='removeTime(1)'><i class='text-danger fa fa-trash'></i></a>
									</td>
								</tr>
								</tbody>
							</table>
						</div>
					</div>";
			CreateFormPopup("Addfee","Add fee",$Html,'Addfee',"?page=".$Page);
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
										url: "<?php echo $URL; ?>/feestructure/",
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
								$('#feetbl').append("<tr><td>No records</td></tr>");
							}
							//console.log("This is the length:"+data.data[0].data.length);
							for(i=0;i<data.data[0].data.length;i++)
							{
								
								JData=data.data[0].data[i];
								Str+="<tr id='TR_"+i+"'>";
								Str+="<td>"+(i+1)+"</td>";
								Str+="<td>"+JData.title+"</td>";
								Str+="<td>"+JData.structure.base.value+"</td>";
								Str+="<td><table>";
								len=JData.structure.addon.length
								for(io=0;io<len;io++)
								{
									Str+="<tr><td style='margin:2px;'>"+JData.structure.addon[io].title+":"+JData.structure.addon[io].value+"</td></tr>";
								}
								Str+="</td></table>";
								
								Str+="<td><table>";
								len=JData.structure.discount.length
								for(io=0;io<len;io++)
								{
									Str+="<tr><td style='margin:2px;'>"+JData.structure.discount[io].title+":"+JData.structure.discount[io].value+" - "+JData.structure.discount[io].code+"</td></tr>";
								}
								Str+="</td></table>";
		
								
								Str+="<td><a href='#' data-toggle='modal' data-target='#Addfee' data-original-title onclick='Editthis(\""+JData.id+"\")' >Edit</a>";
								Str+=" | <a data-toggle='modal' data-target='#ConfirmYesNo' data-original-title onclick='Deletethis(\""+JData.id+"\")'>Delete</a></td></tr>";
							}
							Str+="<tr><td colspan=8 id='tblPaginate'></td></tr>";
							$('#feetbl').append(Str);
							
							Str=pagination	(<?php echo $Page; ?>,data.data[0].totalrecords)	
							$('#tblPaginate').append(Str);
					}
				}
			});	
		});
	
	
	var X=2;
	function AddX(which)
	{
		if (which==1)
		{
			First=MakeSelect(X,1);
			addElement("ADT","tr",X,First)	
			X++;
		}else
		{
			First=MakeSelect(X,2);
			addElement("DDT","tr",X,First)	
			X++;
		}
	}
	

function MakeSelect(id,From)
{
	if (From==1)
	{
		Str0="<td><input type='text'   id='ADT_"+id+"' name='ADT[]' ></td>";
		Str1="<td><input type='text'  id='ADV_"+id+"' name='ADV[]' ></td>";
		return Str0+Str1+"<td><a onclick='removeTime("+id+")'><i class='text-danger fa fa-trash'></i></a></td>";
	}else
	{
		Str0="<td><input type='text'   id='DDT_"+id+"' name='DDT[]' ></td>";
		Str1="<td><input type='text'  id='DDV_"+id+"' name='DDV[]' style='width:50px'></td>";
		Str2="<td><input type='text'  id='DDC_"+id+"' name='DDC[]'></td>";
		return Str0+Str1+Str2+"<td><a onclick='removeTime("+id+")'><i class='text-danger fa fa-trash'></i></a></td>";
	}
}

function removeTime(id)
{
	var p = document.getElementById(id);
	p.parentNode.removeChild(p);
}
function addElement(parentId,elementTag,elementId,html) {
    // Adds an element to the document
    var p = document.getElementById(parentId);
    var newElement = document.createElement(elementTag);
	newElement .id=  elementId
    newElement.innerHTML = html;
    p.appendChild(newElement);
}
	
	function Addnew()
	{
		$('#TIT_Addfee').html("Add");
		$('#fee_title').val("");
		$('#OK_btn_CreateFormPopup').attr('name','OK_btn_CreateFormPopup_Addfee');
	}
	function Editthis(Id)
	{
		$('#TIT_Addfee').html("Edit");
		$('#ADT').html("");
		$('#DDT').html("");
		X=0;
		var posting=$.ajax({ 	
										type: "GET",
										url: "<?php echo $URL; ?>/feestructure/"+Id,
										<?php if(isset($_SESSION['USERID'])){$USERID=$_SESSION['USERID'];}else{$USERID="";} 	?>
										headers: {'Authcode':<?php echo "'".$USERID."'";?>},
										data:{"id":Id}
									});
			posting.done(function(J) {
				clog(J)
			$('#fee_title').val(J.data.title);
			$('#fee_base').val(J.data.structure.base.value);
			for(i=0;i<J.data.structure.addon.length;i++)
			{
				AddX(1);
				Id1="#ADT_"+(X-1);
				Id2="#ADV_"+(X-1);
				$(Id1).val(J.data.structure.addon[i].title);
				$(Id2).val(J.data.structure.addon[i].value);
			}
			for(ii=0;ii<J.data.structure.discount.length;ii++)
			{
				AddX(2);
				Id1="#DDT_"+(X-1);
				Id2="#DDV_"+(X-1);
				Id3="#DDC_"+(X-1);
				$(Id1).val(J.data.structure.discount[ii].title);
				$(Id2).val(J.data.structure.discount[ii].value);
				$(Id3).val(J.data.structure.discount[ii].code);
			}
			$('#opt').val(2);
			$('#Addfee_IdValue').val(Id);
			$('#OK_btn_CreateFormPopup').attr('name','OK_btn_CreateFormPopup_Editfee');
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