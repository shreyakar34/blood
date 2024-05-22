<?php
require 'file/connection.php';
session_start();
if(!isset($_SESSION['did']))
{
  header('location:login.php');
}
else {
	if(isset($_SESSION['did'])){
		$id=$_SESSION['did'];
		$sql = "SELECT * FROM donors WHERE did='$id'";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($result);
	}
}
?>

<!DOCTYPE html>
<html>
<?php $title="Bloodbank | Donor Profile"; ?>
<?php require 'head.php';?>
<body>
	<?php require 'header.php'; ?>

	<div class="container cont">

		<?php require 'message.php'; ?>

		<div class="row justify-content-center">
			<div class="col-lg-4 col-md-6 col-sm-8 mb-5">
				<div class="card">
					<div class="media justify-content-center mt-1">
						<img src="image/user.png" alt="profile" class="rounded-circle" width="60" height="60">
					</div>
					<div class="card-body">
					   <form action="file/updateprofile.php" method="post">
					   	<label class="text-muted font-weight-bold">Donor Name</label>
						<input type="text" name="dname" value="<?php echo $row['dname']; ?>" class="form-control mb-3">
						<label class="text-muted font-weight-bold">Donor Email</label>
						<input type="email" name="demail" value="<?php echo $row['demail']; ?>" class="form-control mb-3">
						<label class="text-muted font-weight-bold">Donor Password</label>
						<input type="text" name="dpassword" value="<?php echo $row['dpassword']; ?>" class="form-control mb-3">
						<label class="text-muted font-weight-bold">Donor Phone Number</label>
						<input type="text" name="dphone" value="<?php echo $row['dphone']; ?>" class="form-control mb-3">
						<label class="text-muted font-weight-bold">Donor City</label>
						<input type="text" name="dcity" value="<?php echo $row['dcity']; ?>" class="form-control mb-3">
						<label class="text-muted font-weight-bold">Donor Blood Group</label>
						<select class="form-control mb-3" name="dbg" required>
                             <option selected><?php echo $row['dbg']; ?></option>
                             <option>A-</option>
                             <option>A+</option>
                             <option>B-</option>
                             <option>B+</option>
                             <option>AB-</option>
                             <option>AB+</option>
                             <option>O-</option>
                             <option>O+</option>
                        </select>
						<input type="submit" name="update" class="btn btn-block btn-primary" value="Update">
					   </form>
					</div>
					<a href="index.php" class="text-center">Cancel</a><br>
				</div>
			</div>
		</div>
	</div>
	
</body>
</html>
