<?php
$password_baru = 'admin12345'; // Ganti dengan password yang diinginkan
echo password_hash($password_baru, PASSWORD_DEFAULT);
?>