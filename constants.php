<?php
// APP SETTINGS
defined('BASE_URL')         OR define('BASE_URL', 'http://localhost/blog');
defined('CSRF_TOKEN_LENGTH')    OR define('CSRF_TOKEN_LENGTH', 32);

// ALL BLOG POST PAGE SETTINGS
defined('POST_COLUMNS')     OR define('POST_COLUMNS', 3);
defined('POST_PER_PAGE')    OR define('POST_PER_PAGE', 9);
defined('PAGES_TO_SHOW')    OR define('PAGES_TO_SHOW', 2);
defined('EXCERPT_LENGTH')   OR define('EXCERPT_LENGTH', 100);

// DATABASE SETTINGS
defined('DB_HOST')              OR define('DB_HOST', 'localhost');
defined('DB_USER')              OR define('DB_USER', 'root');
defined('DB_PASSWORD')          OR define('DB_PASSWORD', '');
defined('DB_TABLE')             OR define('DB_TABLE', 'Blog');
