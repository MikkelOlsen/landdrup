<?php

unset($_SESSION['userid'], $_SESSION['profilid'], $_SESSION['username']);
unset($user);

header('Location: ?p=login');