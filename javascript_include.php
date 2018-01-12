<script src="js/jquery.min.js"></script>

<script src="js/bootstrap.js"></script>
   
  <script type="text/javascript">
	
    $(document).ready(function() {
		
	$('#No_btn_ConfirmYesNo').click(function(){$('#ConfirmYesNo').hide();});
      $("#panel1").click(function() {$("#arow1").toggleClass("fa-chevron-left");$("#arow1").toggleClass("fa-chevron-down");});
      $("#panel2").click(function() {$("#arow2").toggleClass("fa-chevron-left");$("#arow2").toggleClass("fa-chevron-down");});
      $("#panel3").click(function() {$("#arow3").toggleClass("fa-chevron-left");$("#arow3").toggleClass("fa-chevron-down");});
	
	$("#panel4").click(function() {$("#arow4").toggleClass("fa-chevron-left");  $("#arow4").toggleClass("fa-chevron-down");});
	$("#panel41").click(function() {$("#arow41").toggleClass("fa-chevron-left");  $("#arow41").toggleClass("fa-chevron-down");});
	$("#panel42").click(function() {$("#arow42").toggleClass("fa-chevron-left");  $("#arow42").toggleClass("fa-chevron-down");});
	$("#panel43").click(function() {$("#arow43").toggleClass("fa-chevron-left");  $("#arow43").toggleClass("fa-chevron-down");});
	$("#panel44").click(function() {$("#arow44").toggleClass("fa-chevron-left");  $("#arow44").toggleClass("fa-chevron-down");});
	$("#panel45").click(function() {$("#arow45").toggleClass("fa-chevron-left");  $("#arow45").toggleClass("fa-chevron-down");});
	
	$("#panel5").click(function() {$("#arow5").toggleClass("fa-chevron-left");$("#arow5").toggleClass("fa-chevron-down");});
     
     $("#panel6").click(function() {$("#arow6").toggleClass("fa-chevron-left");$("#arow6").toggleClass("fa-chevron-down");});
	$("#panel61").click(function() {$("#arow61").toggleClass("fa-chevron-left");$("#arow61").toggleClass("fa-chevron-down");});
	$("#panel62").click(function() {$("#arow62").toggleClass("fa-chevron-left");$("#arow62").toggleClass("fa-chevron-down"); });
	$("#panel63").click(function() {$("#arow63").toggleClass("fa-chevron-left");$("#arow63").toggleClass("fa-chevron-down"); });
	$("#panel64").click(function() {$("#arow64").toggleClass("fa-chevron-left");$("#arow64").toggleClass("fa-chevron-down"); });
	$("#panel65").click(function() {$("#arow65").toggleClass("fa-chevron-left");$("#arow65").toggleClass("fa-chevron-down"); });
	$("#panel66").click(function() {$("#arow66").toggleClass("fa-chevron-left");$("#arow66").toggleClass("fa-chevron-down"); });
	
      $("#panel7").click(function() {$("#arow7").toggleClass("fa-chevron-left");$("#arow7").toggleClass("fa-chevron-down");});
      $("#panel8").click(function() {$("#arow8").toggleClass("fa-chevron-left");$("#arow8").toggleClass("fa-chevron-down");});
      $("#panel9").click(function() {$("#arow9").toggleClass("fa-chevron-left");$("#arow9").toggleClass("fa-chevron-down");});
      $("#panel10").click(function() {$("#arow10").toggleClass("fa-chevron-left");$("#arow10").toggleClass("fa-chevron-down");});
      $("#panel11").click(function() {$("#arow11").toggleClass("fa-chevron-left");$("#arow11").toggleClass("fa-chevron-down");});
      $("#menu-icon").click(function() {$("#chang-menu-icon").toggleClass("fa-bars");$("#chang-menu-icon").toggleClass("fa-times");$("#show-nav").toggleClass("hide-sidebar");$("#show-nav").toggleClass("left-sidebar");  $("#left-container").toggleClass("less-width");$("#right-container").toggleClass("full-width");});
     
    });
	function clog(data){console.log(data);}
	function setSession(key, value)
	{
		DtArr=[];
		DtArr[0]=key;
		DtArr[1]=value;
		var Data={"OPT":"SETSESSION","DATA":DtArr};
		var posting=$.post("ajaxHandler.php",Data);
		posting.done(function(data) 
		{
			console.log(data);
		});
	}
		function Paginate(totalrecord,currentpage)
	{
		var recordperpage=2;
		var totalpages=Math.ceil(totalrecord/recordperpage);
		
		Str="<nav aria-label='Page navigation' id='div1'>"
		Str+="<ul class='pager'>"
		Str+="    <li>"
		Str+="	<a href='?page=1' aria-label='First'>"
		Str+="	  <span aria-hidden='true'>«</span>"
		Str+="	</a>"
		Str+="    </li>"
		for(i=1;i<=totalpages;i++)  
		  Str+="<li><a href='?page="+i+"'>"+i+"</a></li>"
		  
		Str+="    <li>"
		Str+="	<a href='?page="+totalrecord+"' aria-label='Last'>"
		Str+="	  <span aria-hidden='true'>»</span>"
		Str+="	</a>"
		Str+="    </li>"
		Str+="  </ul>"
		Str+="</nav>"
		return Str;
		
	}
	$('#loading-image').bind('ajaxStart', function(){clog("showing");$(this).show();}).bind('ajaxStop', function(){clog("hiding");$(this).hide();});
  </script>	