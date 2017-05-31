	<nav class="navbar navbar">
		<div class="container-fluid">
			<div class="navbar-header">
				<div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
      	<span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
				<a class="navbar-brand" href="user_menu.php"><font size="6">HOSPITAL APPOINTMENT SYSTEM</font></a>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav navbar-right">
				<li class="active"><a href="user_menu.php">Home</a></li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#"> <?php echo $_SESSION['user'];?> <span class="caret"></span></a>
					
					<ul class="dropdown-menu">
						<li><a href="appointment_search.php">Check Availability</a></li>
						<li><a href="appointment_search.php">Book Appointment</a></li>
						<li><a href="edit_profile.php">Profile</a></li>
						<li><a href="logout.php">Logout</a></li>
					</ul>
				</li>
				<li><a href="#">Contact Us</a></li> 
			</ul>
		</div>
		</div>
	</nav>