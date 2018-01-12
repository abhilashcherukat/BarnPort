<?php

function CreateConfirmModal($Title,$Desc,$IdTag='',$SubmitTags='')
{
$Str="
<div class='modal'  id='ConfirmYesNo".$IdTag."'>
  <div class='modal-dialog'>
    <div class='modal-content'>

      <div class='modal-header'>
		
        <h4 class='modal-title'>$Title</h4>
      </div>
      <div class='modal-body'>
        <p>$Desc</p>
        <div class='row'>
            <div class='col-12-xs text-center'>
			<form action='".$_SERVER['PHP_SELF'].$SubmitTags."' method='post'>
				<input type='hidden' id='IdValue".$IdTag."' value='' name='IdValue".$IdTag."'>
				<button class='btn btn-success btn-md' id='Yes_btn_ConfirmYesNo' name='Yes_btn_ConfirmYesNo".$IdTag."'>Yes</button>
				<button class='btn btn-danger btn-md' id='No_btn_ConfirmYesNo' data-dismiss='modal'>No</button>
			</form>
	     </div>
        </div>
      </div>
   
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->";
echo $Str;
}

function CreateBasicPopup($Title,$Html,$id='CreateBasicPopup')
{
$Str="
<div class='modal'  id='".$id."'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
		<input type='hidden' id='IdValue' value=''>
        <h4 class='modal-title' id='TIT_$id'>$Title</h4>
      </div>
      <div class='modal-body'>
       
        <div class='row'>
            <div class='col-12-xs text-center'>
                 <p>$Html</p>
            </div>
        </div>
		<div class='row'>
            <div class='col-12-xs text-center'>
				<button class='btn btn-default btn-md' data-dismiss='modal' id='No_btn_CreateBasicPopup'>Close</button>

			</div>
		</div>
      </div>
   
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->";
echo $Str;
}
function CreateFormPopup($ModalId,$Title,$Html,$Id='',$SubmitTag='')
{

	$Str="
<div class='modal'  id='$ModalId'>
	<div class='modal-dialog'>
		<div class='modal-content'>
			<div class='modal-header'>
				<h4 class='modal-title' id='TIT_$ModalId'>$Title</h4>
			</div>
			<div class='modal-body'>
				<div class='panel-body'>
					<form action='".$_SERVER['PHP_SELF'].$SubmitTag."' method='post' id='FRM_$ModalId'>
						<div class='row'>
							<div class='col-xs-6 col-sm-6 col-md-12'>
								<input type='hidden' id='".$ModalId."_IdValue' value='".$Id."' name='".$ModalId."_IdValue' >
								".$Html."
							</div>
						</div>
		
						<div class='row mt20'>
							<div class='col-xs-6 col-sm-6 col-md-6'>
								<input type='submit'  class='btn btn-primary'  id='OK_btn_CreateFormPopup' name='OK_btn_CreateFormPopup_".$ModalId."' value='OK'>
							
								<input type='button' data-dismiss='modal' class='btn btn-default' id='No_btn_CreateFormPopup' name='NO_btn_CreateFormPopup' value='Cancel'>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->"; 
	

echo $Str;
//echo "THis is the echoi:".$ModalId;
}
?>