<?php

/**
 * Logout Code for Online Course Registration System
 * @author Omar Eldanasoury
 */
session_start();
session_unset();
header("location: login.php");
