<nav class="navbar navbar-expand-sm navbar-light bg-light sticky-top">
	<div class="container">
		<a class="navbar-brand" href="index.php"><img src="image/IMG_20240522_224539.jpg" width="30" height="30" class="rounded-circle">Hemo Hub</a>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar"><i class="fas fa-align-left"></i></span>
          </button>

          <div class="collapse navbar-collapse" id="collapsibleNavbar">

        <?php if (isset($_SESSION['hid'])) { ?>

		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<a class="nav-link btn btn-light" href="donordetails.php">Donors list</a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-light" href="bloodrequest.php">Blood Request</a>
            </li>
			<li class="nav-item">
				<a class="nav-link btn btn-light" href="habs.php">Available Blood Samples</a>
            </li>
            <li class="nav-item">
                <a href="hprofile.php?id=<?php echo $_SESSION['hid']; ?>" class="nav-link btn font-weight-bold"><img src="image/hospital.png" width="15" height="15" class="rounded-circle"><mark><?php echo $_SESSION['hname']; ?></mark></a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-danger btn-sm font-weight-bold" href="logout.php">Logout</a>
            </li>
        </ul>

        <?php } elseif (isset($_SESSION['rid'])) { ?>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link btn btn-light" href="sentrequest.php">Sent Blood Request</a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-light" href="abs.php">Available Blood Samples</a>
            </li>
			<li class="nav-item">
                <a class="nav-link btn btn-light" href="../bloodcomp.html">Blood Compatibility Checker</a>
            </li>
            <li class="nav-item">
                <a href="rprofile.php?id=<?php echo $_SESSION['rid']; ?>" class="nav-link btn font-weight-bold" href="#"><img src="image/user.png" width="15" height="15" class="rounded-circle"> <mark><?php echo ' '.$_SESSION['rname']; ?></mark></a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-danger btn-sm font-weight-bold" href="logout.php">Logout</a>
            </li>
        </ul>

        <?php } elseif (isset($_SESSION['did'])) { ?>

<ul class="navbar-nav ml-auto">
     <li class="nav-item">
				<a class="nav-link btn btn-light" href="donationhistory.php">Donation history</a>
            </li>
    <li class="nav-item">
        <a class="nav-link btn btn-light" href="donateinfo.php">Donate Blood</a>
    </li>
    <li class="nav-item">
        <a class="nav-link btn btn-light" href="bloodcomp.html">Blood Compatibility Checker</a>
    </li>
    <li class="nav-item">
        <a href="dprofile.php?id=<?php echo $_SESSION['did']; ?>" class="nav-link btn font-weight-bold" href="#"><img src="image/user.png" width="15" height="15" class="rounded-circle"> <mark><?php echo ' '.$_SESSION['dname']; ?></mark></a>
    </li>
    <li class="nav-item">
        <a class="nav-link btn btn-danger btn-sm font-weight-bold" href="logout.php">Logout</a>
    </li>
</ul>


        <?php }  else { ?>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link btn btn-light" href="abs.php">Available Blood Samples</a>
            </li>
			<li class="nav-item">
                <a class="nav-link btn btn-light" href="bloodcomp.html">Blood Compatibility Checker</a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-light" href="register.php">Register</a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-light" href="login.php">Login</a>
            </li>
        </ul>

        <?php } ?>
       </div>
    </div>
</nav>