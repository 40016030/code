<?php
session_start();
include '../account/db.php';

// Redirect if not logged in.
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['user_id'];

// Delete user's consultation bookings.
$stmt1 = $conn->prepare("DELETE FROM consultations WHERE customerID = ?");
$stmt1->bind_param("i", $userID);
$stmt1->execute();
$stmt1->close();

// Delete user's installation bookings.
$stmt2 = $conn->prepare("DELETE FROM installations WHERE customerID = ?");
$stmt2->bind_param("i", $userID);
$stmt2->execute();
$stmt2->close();

// Delete the user account.
$stmt3 = $conn->prepare("DELETE FROM users WHERE customerID = ?");
$stmt3->bind_param("i", $userID);
$stmt3->execute();
$stmt3->close();

// Destroy the session and redirect to login page.
session_destroy();
header("Location: login.php");
exit();
?>
