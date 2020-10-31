<nav class="navbar navbar-fixed-top am-top-header">
    <div class="container-fluid">
        <div id="am-navbar-collapse">
            <div class="page-header-top">
            <h1 class="header"><center>E - Payroll System <?php echo $row['role'] ?><small></small></center></h1>
            </div>
			<ul class="nav-right user-right" style="margin-right:0;">
			  <li class="dropdown get_tooltip" data-toggle="tooltip" data-placement="bottom" title="View your profile">
				  <a class="dropdown-toggle" data-toggle="dropdown" href="#">
				   <strong> <?php echo $row['uname']?> ID:<?php echo $row['id_no'] ?></strong>
					<i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
				  </a>
				  <ul class="dropdown-right dropdown-user">
					  <li><a href="../users/logout.php"><i class="fa fa-sign-out fa-fw"></i><strong> Logout</strong></a>
					  </li>
				  </ul>
			  </li>
			</ul> 
			<span class="decor"></span>
        </div>
    </div>
</nav>