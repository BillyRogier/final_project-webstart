<?php

require('../config/init.php');

$app->xmlRequest($route);

$_SESSION['message'] = "";
