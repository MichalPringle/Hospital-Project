<?php
session_start();

// Destroy the server-side memory session
session_destroy();

// Redirect back to homepage
header("Location: homepage.html");

exit();

?>