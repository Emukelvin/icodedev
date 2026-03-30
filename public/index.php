<?php

// Mark that we're running from the public directory (local development)
define('LARAVEL_PUBLIC_PATH', __DIR__);

// Forward to the root index.php
require __DIR__.'/../index.php';
