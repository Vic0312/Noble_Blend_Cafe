<?php

require_once __DIR__ . '/../controller/AuthController.php';

AuthController::logout();
header('Location: ../index.php');
exit;
