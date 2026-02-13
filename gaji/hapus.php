<?php
require '../config/db.php';
$no_ref = $_GET['no_ref'];
$conn->query("DELETE FROM detail_gaji WHERE no_ref='$no_ref'");
$conn->query("DELETE FROM slip_gaji WHERE no_ref='$no_ref'");
header("Location: index.php");
