<?php
require '../config/db.php';
$id = $_GET['id'];
$conn->query("DELETE FROM perusahaan WHERE id=$id");
header("Location: index.php");
