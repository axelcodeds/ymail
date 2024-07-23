<?php

setcookie('usuario', '', time() - 3600, '/');
setcookie('contra', '', time() - 3600, '/');

header('location: ../login.php');
