<?php
require 'file/connection.php';
session_start();
if (!isset($_SESSION['demail'])) {
    header("location:login.php");
    exit();
}
$did = $_SESSION['did'];
$dname = isset($_SESSION['dname']) ? $_SESSION['dname'] : '';

// Call stored procedure to fetch donation details
$donation_query = "CALL GetDonationDetailsByDonor('$did')";
$result = mysqli_query($conn, $donation_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bloodbank | Donation History</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <?php require 'head.php'; ?>
    <style>
        .donation-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .donation-container table {
            width: 100%;
            border-collapse: collapse;
        }
        .donation-container th, .donation-container td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .donation-container th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body class="bg-light">
    <?php require 'header.php'; ?>
    <div class="container mt-5">
        <?php require 'message.php'; ?>
        <div class="donation-container">
            <h2 class="mb-4 text-center">Donation History</h2>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Hospital Name</th>
                            <th>Hospital City</th>
                            <th>Blood Group</th>
                            <th>Units Donated</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['hospital_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['hospital_city']); ?></td>
                                <td><?php echo htmlspecialchars($row['blood_group']); ?></td>
                                <td><?php echo htmlspecialchars($row['units_donated']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No donations found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
