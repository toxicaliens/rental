<?php

// Define the working path
define ('WPATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);

// Initialise the app
include WPATH . "core/bootstrap.php";

// Load the core controller
include WPATH . "controller.php";
