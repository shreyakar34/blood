<?php 
require 'file/connection.php'; 
session_start();

if (!isset($_SESSION['rid'])) {
    header('location:login.php');
    exit();
}

$rid = $_SESSION['rid'];
$sql = "SELECT bloodrequest.*, hospitals.* FROM bloodrequest, hospitals WHERE rid='$rid' AND bloodrequest.hid=hospitals.hid";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<?php $title="Bloodbank | Sent Requests"; ?>
<?php require 'head.php'; ?>
<body>
    <?php require 'header.php'; ?>
    <div class="container cont">
        <?php require 'message.php'; ?>

        <table class="table table-responsive table-striped rounded mb-5">
            <tr><th colspan="9" class="title">Sent requests</th></tr>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>City</th>
                <th>Phone</th>
                <th>Blood Group</th>
                <th>Units</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php if ($result): ?>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php $counter = 0; ?>
                    <?php while ($row = mysqli_fetch_array($result)): ?>
                        <tr>
                            <td><?php echo ++$counter; ?></td>
                            <td><?php echo htmlspecialchars($row['hname']); ?></td>
                            <td><?php echo htmlspecialchars($row['hemail']); ?></td>
                            <td><?php echo htmlspecialchars($row['hcity']); ?></td>
                            <td><?php echo htmlspecialchars($row['hphone']); ?></td>
                            <td><?php echo htmlspecialchars($row['bg']); ?></td>
                            <td><?php echo htmlspecialchars($row['units']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td>
                                <?php if ($row['status'] == 'Accepted'): ?>
                                    <!-- You can add any action for accepted requests if needed -->
                                <?php else: ?>
                                    <a href="file/cancel.php?reqid=<?php echo htmlspecialchars($row['reqid']); ?>" class="btn btn-danger">Cancel</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" style="color:white;background-color:red;padding:7px;border-radius: 15px 50px;text-align:center;">You have not requested yet.</td>
                    </tr>
                <?php endif; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" style="color:white;background-color:red;padding:7px;border-radius: 15px 50px;text-align:center;">Error: <?php echo htmlspecialchars(mysqli_error($conn)); ?></td>
                </tr>
            <?php endif; ?>

        </table>
    </div>
</body>
</html>
<?php 
mysqli_close($conn); // Closing the connection
?>
