<?php
session_start();
require_once 'users/class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
 $user_home->redirect('users/login');
}

$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE id_no=:id_no");
$stmt->execute(array(":id_no"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html class="" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta charset="utf-8">
<title>E-Payroll System > Calendar</title>  
	<link rel="icon" href="images/mylogo.jpg" type="image/x-icon">
	<link href="link/nanoscroller.css" media="screen" rel="stylesheet" type="text/css">
	<link href="link/style-1.css" media="screen" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="link/layout.css" type="text/css" />
	<link rel="stylesheet" href="link/bootstrap.min.css" />

	<script src="link/jquery.min.js"></script>
	<script src="link/bootstrap.min.js"></script>
	<link rel="stylesheet" href="link/link/bootstrap-datepicker.css"/>
	<script src="link/bootstrap-datepicker.js"></script>
	<link rel="stylesheet" href="date/search/css/datepicker.min.css" type="text/css">
	<script type="text/javascript" src="date/search/datepicker.min.js"></script>
	<script type="text/javascript" src="date/search/date.js"></script>
<!--LOGIN DIV-->
    <link href="link/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href='fullcalendar/fullcalendar.min.css' rel='stylesheet' />
	<link href='fullcalendar/fullcalendar.print.min.css' rel='stylesheet' media='print' />
	<script src='fullcalendar/lib/moment.min.js'></script>
	<script src='fullcalendar/lib/jquery.min.js'></script>
	<script src='fullcalendar/lib/jquery-ui.min.js'></script>
	<script src='fullcalendar/fullcalendar.min.js'></script>

<script>

	$(document).ready(function() {

		var zone = "05:30";  //Change this to your timezone

	$.ajax({
		url: 'fullcalendar/process.php',
        type: 'POST', // Send post data
        data: 'type=fetch',
        async: false,
        success: function(s){
        	json_events = s;
        }
	});

	var currentMousePos = {
	    x: -1,
	    y: -1
	};
		jQuery(document).on("mousemove", function (event) {
        currentMousePos.x = event.pageX;
        currentMousePos.y = event.pageY;
    });

/* initialize the external events--------------------------------*/

		$('#external-events .fc-event').each(function() {

			// store data so the calendar knows to render an event upon drop
			$(this).data('event', {
				title: $.trim($(this).text()), // use the element's text as the event title
				stick: true // maintain when user navigates (see docs on the renderEvent method)
			});

			// make the event draggable using jQuery UI
			$(this).draggable({
				zIndex: 999,
				revert: true,      // will cause the event to go back to its
				revertDuration: 0  //  original position after the drag
			});

		});
/* initialize the calendar-----------------------------------------------------*/

		$('#calendar').fullCalendar({
			events: JSON.parse(json_events),
			//events: [{"id":"14","title":"New Event","start":"2015-01-24T16:00:00+04:00","allDay":false}],
			utc: true,
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay,listDay,listWeek,listMonth,listYear'
			},
			views: {
				month: { buttonText: 'Month' },
				agendaWeek: { buttonText: 'Week' },
				agendaDay: { buttonText: 'Day' },
				listDay: { buttonText: 'List Day' },
				listWeek: { buttonText: 'List Week' },
				listMonth: { buttonText: 'List Month' },
				listYear: { buttonText: 'List Year' }
			},
			
			editable: true,
			droppable: true, 
			navLinks: true, // can click day/week names to navigate views
			businessHours: true,
			slotDuration: '00:30:00',
			
			eventReceive: function(event){
				var title = event.title;
				var start = event.start.format("YYYY-MM-DD[T]HH:mm:SS");
				$.ajax({
		    		url: 'fullcalendar/process.php',
		    		data: 'type=new&title='+title+'&startdate='+start+'&zone='+zone,
		    		type: 'POST',
		    		dataType: 'json',
		    		success: function(response){
		    			event.id = response.eventid;
		    			$('#calendar').fullCalendar('updateEvent',event);
		    		},
		    		error: function(e){
		    			console.log(e.responseText);

		    		}
		    	});
				$('#calendar').fullCalendar('updateEvent',event);
				console.log(event);
			},
			eventDrop: function(event, delta, revertFunc) {
		        var title = event.title;
		        var start = event.start.format();
		        var end = (event.end == null) ? start : event.end.format();
		        $.ajax({
					url: 'fullcalendar/process.php',
					data: 'type=resetdate&title='+title+'&start='+start+'&end='+end+'&eventid='+event.id,
					type: 'POST',
					dataType: 'json',
					success: function(response){
						if(response.status != 'success')		    				
						revertFunc();
					},
					error: function(e){		    			
						revertFunc();
						alert('Error processing your request: '+e.responseText);
					}
				});
		    },
		    eventClick: function(event, jsEvent, view) {
		    	console.log(event.id);
		          var title = prompt('Event Title:', event.title, { buttons: { Ok: true, Cancel: false} });
		          if (title){
		              event.title = title;
		              console.log('type=changetitle&title='+title+'&eventid='+event.id);
		              $.ajax({
				    		url: 'fullcalendar/process.php',
				    		data: 'type=changetitle&title='+title+'&eventid='+event.id,
				    		type: 'POST',
				    		dataType: 'json',
				    		success: function(response){	
				    			if(response.status == 'success')			    			
		              				$('#calendar').fullCalendar('updateEvent',event);
				    		},
				    		error: function(e){
				    			alert('Error processing your request: '+e.responseText);
				    		}
				    	});
		          }
			},
			eventResize: function(event, delta, revertFunc) {
				console.log(event);
				var title = event.title;
				var end = event.end.format();
				var start = event.start.format();
		        $.ajax({
					url: 'fullcalendar/process.php',
					data: 'type=resetdate&title='+title+'&start='+start+'&end='+end+'&eventid='+event.id,
					type: 'POST',
					dataType: 'json',
					success: function(response){
						if(response.status != 'success')		    				
						revertFunc();
					},
					error: function(e){		    			
						revertFunc();
						alert('Error processing your request: '+e.responseText);
					}
				});
		    },
			eventDragStop: function (event, jsEvent, ui, view) {
			    if (isElemOverDiv()) {
			    	var con = confirm('Are you sure to delete this event permanently?');
			    	if(con == true) {
						$.ajax({
				    		url: 'fullcalendar/process.php',
				    		data: 'type=remove&eventid='+event.id,
				    		type: 'POST',
				    		dataType: 'json',
				    		success: function(response){
				    			console.log(response);
				    			if(response.status == 'success'){
				    				$('#calendar').fullCalendar('removeEvents');
            						getFreshEvents();
            					}
				    		},
				    		error: function(e){	
				    			alert('Error processing your request: '+e.responseText);
				    		}
			    		});
					}   
				}
			},
			// this allows things to be dropped onto the calendar
			drop: function() {
				// is the "remove after drop" checkbox checked?
				if ($('#drop-remove').is(':checked')) {
					// if so, remove the element from the "Draggable Events" list
					$(this).remove();
				}
			}
		});

	function getFreshEvents(){
		$.ajax({
			url: 'fullcalendar/process.php',
	        type: 'POST', // Send post data
	        data: 'type=fetch',
	        async: false,
	        success: function(s){
	        	freshevents = s;
	        }
		});
		$('#calendar').fullCalendar('addEventSource', JSON.parse(freshevents));
	}

	function isElemOverDiv() {
        var trashEl = jQuery('#trash');

        var ofs = trashEl.offset();

        var x1 = ofs.left;
        var x2 = ofs.left + trashEl.outerWidth(true);
        var y1 = ofs.top;
        var y2 = ofs.top + trashEl.outerHeight(true);

        if (currentMousePos.x >= x1 && currentMousePos.x <= x2 &&
            currentMousePos.y >= y1 && currentMousePos.y <= y2) {
            return true;
        }
        return false;
    }

	});

</script>
</head>

<body>
<div id="wrapper">
<!--------NAVIGATION DIV---------->
<div class="am-wrapper am-fixed-sidebar">
<!-- Top Navbar Start-->  
<nav class="navbar navbar-fixed-top am-top-header">
    <div class="container-fluid">
        <div id="am-navbar-collapse">
            <div class="page-header-top">
            <h1 class="header"><center>E - Payroll System<small></small></center></h1>
            </div>
			<ul class="nav-right user-right" style="margin-right:0;">
			  <li class="dropdown get_tooltip" data-toggle="tooltip" data-placement="bottom" title="View your profile">
				  <a class="dropdown-toggle" data-toggle="dropdown" href="#">
				   <strong> <?php echo $row['uname']?> ID:<?php echo $row['id_no'] ?></strong>
					<i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
				  </a>
				  <ul class="dropdown-right dropdown-user">
					  <li><a href="users/logout"><i class="fa fa-sign-out fa-fw"></i><strong> Logout</strong></a>
					  </li>
				  </ul>
			  </li>
			</ul> 
			<span class="decor"></span>
        </div>
    </div>
</nav>
<div class="am-left-sidebar">
    <div class="am-scroller nano has-scrollbar">
	<div class="content nano-content" tabindex="0" style="right: -17px;">
        <div class="am-logo"></div>
        <ul class="sidebar-elements">
			<li class="parent"><a href="#"><i class="fa fa-windows fa-fw" style="color:#fff; font-size:26px;"></i><span>Home</span></a>
                <ul class="sub-menu"><li class="title">Home</li>
                <li class="nav-items">
				   <div class="am-scroller nano has-scrollbar">
				   <div class="content nano-content" tabindex="0" style="right: -17px;">
				   <ul><li><a href="index"><i class="fa fa-th-list fa-fw" style="color:#fff;"></i>  Dashboard</a></li>
						<li><a href="calendar"><i class="fa fa-calendar fa-fw" style="color:#fff;"></i>  Calendar</a></li>
					</ul></div>
					</div>
				</li>
				</ul>
            </li>
			<li class="parent">
				<a href="employee/employee"><i class="fa fa-group fa-fw" style="color:#fff; font-size:26px;"></i><span>Staff Records</span></a>
			</li>
			<li class="parent"><a href="#"><i class="fa fa-tasks fa-fw" style="color:#fff; font-size:26px;"></i><span>Payroll Transactions</span></a>
                <ul class="sub-menu"><li class="title">Transactions</li>
                <li class="nav-items">
				   <div class="am-scroller nano has-scrollbar">
				   <div class="content nano-content" tabindex="0" style="right: -17px;">
				   <ul><li><a href="admin/payroll"><i class="fa fa-book fa-fw" style="color:#fff;"></i>  Transactions</a></li>
						<li><a href="admin/sms"><i class="fa fa-envelope fa-fw" style="color:#fff;"></i>  SMS & Mail</a></li>
					</ul></div>
					</div>
				</li>
				</ul>
            </li>
			<li class="parent"><a href="#"><i class="fa fa-gears fa-fw" style="color:#fff; font-size:26px;"></i><span>Set - Ups</span></a>
                <ul class="sub-menu"><li class="title">Payroll Setups</li>
                <li class="nav-items">
				   <div class="am-scroller nano has-scrollbar">
				   <div class="content nano-content" tabindex="0" style="right: -17px;">
				   <ul><li><a href="admin/earnings"><i class="fa fa-magic fa-fw" style="color:#fff;"></i>  Earnings</a></li>
						<li><a href="admin/allowances"><i class="fa fa-dropbox fa-fw" style="color:#fff;"></i>  Allowances</a></li>
						<li><a href="admin/deductions"><i class="fa fa-calculator fa-fw" style="color:#fff;"></i>  Deductions</a></li>
						<li><a href="admin/banks"><i class="fa fa-building fa-fw" style="color:#fff;"></i>  Banks</a></li>
					</ul></div>
					</div>
				</li>
				</ul>
            </li>
			<li class="parent">
				<a href="employee/departments"><i class="fa fa-link fa-fw" style="color:#fff; font-size:30px;"></i><span>Departments</span></a>
            </li>
			<li class="parent"><a href="employee/advanced"><i class="fa fa-laptop fa-fw" style="color:#fff; font-size:30px;"></i><span>Advanced</span></a>
            </li>
        </ul>
    </div>
	</div>
</div>  
        
<div class="am-content">
<div class="page-head">
    <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-windows fa-fw"></i>  Home</a></li>
         <li class="active"><i class="fa fa-calendar fa-fw"></i>Organization Calendar</li>
		 <p class="fl_right" style="font-weight:bold; color:green; background:#fff; padding:0 10px 0 10px;" id="clockbox"></p>
    </ol>
</div>

<div class="main-content">
	<ul class="nav nav-tabs">
		<li ><a href="index">Dashboard</a></li>
		<li class="active"><a href="#">Calendar</a></li>
	</ul>
	<div class="tab-content col-ks-12">
	<div id='wrap'>
		<div id='external-events'>
			<h4>Draggable Events</h4>
			<div class='fc-event'>Annual General Meeting</div>
			<div class='fc-event'>General Meeting</div>
			<div class='fc-event'>Board Meeting</div>
			<div class='fc-event'>Conference</div>
			<div class='fc-event'>Recruitment</div>
			<div class='fc-event'>Training</div>
			<div class='fc-event'>Holiday</div>
			<div class='fc-event'>Christmas Holiday</div>
			<div class='fc-event'>Lunch</div>
			<div class='fc-event'>Dinner</div>
			<p>
				<label for='drop-remove' style='margin-top:8px;'><input type='checkbox' id='drop-remove' >  remove after drop</label>
			</p>
			<p><img src="fullcalendar/assets/img/trashcan.png" id="trash" alt=""></p>
		</div>
		<div id='calendar' class="table  col-kk-12" style="color:#000;"></div>
	</div>
	</div>
</div>
</div>
</div>
<?php include 'includes/footer.php' ?>
<!--IMPORTANT FOR SMAL WINDOW DEVICES **** DO NOT REMOVE--->
        <script type="text/javascript">
            $(document).ready(function () {
                //initialize the javascript 

                App.init();
                //App.dashboard2();
                App.livePreview();

            });
        </script>

</body>
</html>


<script type="text/javascript">
	tday=new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
	tmonth=new Array("January","February","March","April","May","June","July","August","September","October","November","December");

	function GetClock(){
	var d=new Date();
	var nday=d.getDay(),nmonth=d.getMonth(),ndate=d.getDate(),nyear=d.getFullYear();
	var nhour=d.getHours(),nmin=d.getMinutes(),nsec=d.getSeconds(),ap;

	if(nhour==0){ap=" AM";nhour=12;}
	else if(nhour<12){ap=" AM";}
	else if(nhour==12){ap=" PM";}
	else if(nhour>12){ap=" PM";nhour-=12;}

	if(nmin<=9) nmin="0"+nmin;
	if(nsec<=9) nsec="0"+nsec;

	document.getElementById('clockbox').innerHTML=""+tday[nday]+", "+tmonth[nmonth]+" "+ndate+", "+nyear+" "+nhour+":"+nmin+":"+nsec+ap+"";
	}

	window.onload=function(){
	GetClock();
	setInterval(GetClock,1000);
	}
</script>

