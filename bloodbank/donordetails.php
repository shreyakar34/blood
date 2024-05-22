<?php 
require 'file/connection.php'; 
session_start();

if (!isset($_SESSION['hid'])) {
    header('location:login.php');
    exit();
}

$hid = $_SESSION['hid'];

?>

<!DOCTYPE html>
<html>
<?php $title="Bloodbank | Donor Details"; ?>
<?php require 'head.php'; ?>
<body>
    <?php require 'header.php'; ?>
    <div class="container cont">
        <?php require 'message.php'; ?>

        <table class="table table-responsive table-striped rounded mb-5">
            <tr><th colspan="7" class="title">Donor Details</th></tr>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>City</th>
                <th>Phone</th>
                <th>Blood Group</th>
                <th>Units</th>
            </tr>

            <?php 
            $sql = "CALL GetDonorDetailsByHospital('$hid')";
            $result = mysqli_query($conn, $sql);

            if ($result): ?>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php $counter = 0; ?>
                    <?php while ($row = mysqli_fetch_array($result)): ?>
                        <tr>
                            <td><?php echo ++$counter; ?></td>
                            <td><?php echo htmlspecialchars($row['dname']); ?></td>
                            <td><?php echo htmlspecialchars($row['demail']); ?></td>
                            <td><?php echo htmlspecialchars($row['dcity']); ?></td>
                            <td><?php echo htmlspecialchars($row['dphone']); ?></td>
                            <td><?php echo htmlspecialchars($row['dbg']); ?></td>
                            <td><?php echo htmlspecialchars($row['units']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="color:white;background-color:red;padding:7px;border-radius: 15px 50px;text-align:center;">No donations yet.</td>
                    </tr>
                <?php endif; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="color:white;background-color:red;padding:7px;border-radius: 15px 50px;text-align:center;">Error: <?php echo htmlspecialchars(mysqli_error($conn)); ?></td>
                </tr>
            <?php endif; ?>

        </table>
    </div>
</body>
</html>
<?php 
mysqli_close($conn); // Closing the connection
?>
