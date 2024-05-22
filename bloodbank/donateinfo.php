<?php
require 'file/connection.php';
session_start();
if (!isset($_SESSION['demail'])) {
    header("location:login.php");
    exit();
}
$did = $_SESSION['did'];
$dname = isset($_SESSION['dname']) ? $_SESSION['dname'] : '';
$dbg_query = "SELECT dbg FROM donors WHERE did='$did'";
$result = mysqli_query($conn, $dbg_query);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $dbg = $row['dbg'];
} else {
    $dbg = ''; // Default value if not found
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bloodbank | Donate Blood</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <?php require 'head.php'; ?>
    <style>
        .form-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-light">
    <?php require 'header.php'; ?>
    <div class="container mt-5">
        <?php require 'message.php'; ?>
        <div class="form-container">
            <h2 class="mb-4 text-center">Enter Donation Information</h2>
            <form action="savedonation.php" method="post">
                <div class="form-group">
                    <label for="dname">Donor Name:</label>
                    <input type="text" class="form-control" id="dname" name="dname" value="<?php echo htmlspecialchars($dname); ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="hname">Hospital Name:</label>
                    <input type="text" class="form-control" id="hname" name="hname" required>
                </div>

                <div class="form-group">
                    <label for="hcity">Hospital City:</label>
                    <input type="text" class="form-control" id="hcity" name="hcity" required>
                </div>

                <div class="form-group">
                    <label for="dbg">Blood Group:</label>
                    <input type="text" class="form-control" id="dbg" name="dbg" value="<?php echo htmlspecialchars($dbg); ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="units">Number of Units:</label>
                    <input type="number" class="form-control" id="units" name="units" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block" name="submit_donation">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>

