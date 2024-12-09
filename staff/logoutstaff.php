<?php
session_start();  // Starts the session or resumes the current session.
session_unset();  // Clears all session variables.
session_destroy();  // Destroys the session, making the session ID invalid.
header("Location: loginstaff.php");  // Redirects the user to the login page.
exit();  // Ends the script execution to ensure the redirect works correctly.
?>