	//=============TextBox Autopopulate==========//
	$(document).ready(function(){
		$("#id_no").on('change',function(){
			var keyword = $(this).val();
			$.ajax(
			{
				url:'fetch/fetch_name.php',
				type:'POST',
				data:'request='+keyword,
				success:function(data)
				{
					$("#name").val(data);
				},
			});
		});
		//Populate Account Number
		$("#id_no").on('change',function(){
			var keyword = $(this).val();
			$.ajax(
			{
				url:'fetch/fetch_acc.php',
				type:'POST',
				data:'request='+keyword,
				success:function(data)
				{
					$("#account").val(data);
				},
			});
		});
		//Pupulate Bank
		$("#id_no").on('change',function(){
			var keyword = $(this).val();
			$.ajax(
			{
				url:'fetch/fetch_bank.php',
				type:'POST',
				data:'request='+keyword,
				success:function(data)
				{
					$("#bank").val(data);
				},
			});
		});
		//Populate House Allowance
		$("#jobgroup").on('change',function(){
			var keyword = $(this).val();
			$.ajax(
			{
				url:'fetch/fetch_hse.php',
				type:'POST',
				data:'request='+keyword,
				dataType:"json", 
				
				success:function(data)
				{
					$("#all1").val(data);
					
				},
			});
		});
		//Populate Commuter Allowance
		$("#jobgroup").on('change',function(){
			var keyword = $(this).val();
			$.ajax(
			{
				url:'fetch/fetch_cmt.php',
				type:'POST',
				data:'request='+keyword,
				dataType:"json", 
				
				success:function(data)
				{
					$("#all2").val(data);
					
				},
			});
		});
	//=============Official Report Print==========//
	document.getElementById("btnPrint").onclick = function () {
		printElement(document.getElementById("dataModal"));
	}

	function printElement(elem) {
		var domClone = elem.cloneNode(true);
		var $printSection = document.getElementById("printSection");
		if (!$printSection) {
		   var $printSection = document.createElement("div");
		   $printSection.id = "printSection";
			document.body.appendChild($printSection);
		}
		$printSection.innerHTML = "";
		$printSection.appendChild(domClone);
		window.print();
	}
	//=============Disable Date Grater than Today==========//	
	$(function() {
		  $(document).ready(function () {
		   var todaysDate = new Date();
			var year = todaysDate.getFullYear();                       
			var month = ("0" + (todaysDate.getMonth() + 1)).slice(-2);
			var day = ("0" + todaysDate.getDate()).slice(-2);      
			var maxDate = (year +"-"+ month +"-"+ day); 
			$('#date').attr('max',maxDate);
		  });
	});
	
	//initialize the javascript Compulsary for Navbars
		App.init();
		//App.dashboard2();
		App.livePreview();

	});
	//========Only numbers Validator=========//
	function isNumber(evt) {
	evt = (evt) ? evt : window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
		}
			return true;
		}
	//=========Only letters Validator========//
	function isLetter(evt) {
	evt = (evt) ? evt : window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return true;
		}
			return false;
		}
	//=========ID Validate/**onkeyup="idValidation(this)"**/=======//
	function idValidation(text) {
		var validationRegex = /^[0-9]+/g;
		if (!validationRegex.test(text.value)) {
			swal('Oops...', 'Please Enter Only Numbers!', 'error'); 
		}
	}
	//=========Automatic Date and Time//
	tmonth=new Array("January","February","March","April","MAY","June","July","August","September","October","November","December");
	function GetClock(){
		var dt=new Date();
		var nmonth=dt.getMonth(),nyear=dt.getFullYear();
		document.getElementById('clockbox').innerHTML=""+tmonth[nmonth]+" - "+nyear+"";
		}
		window.onload=function(){
		GetClock();
		setInterval(GetClock,1000);
	}
