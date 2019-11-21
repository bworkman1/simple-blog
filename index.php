<?php
// QUICK AND DIRTY ROUTER
$res = $_SERVER['REQUEST_URI'];

// Remove and get params for routing
$resArray = explode('?', $res);

// Add each route to the following switch statement
switch ($resArray[0]) {
    case '/blog/':
        require __DIR__ . '/views/all_posts.php';
        break;
    case '/blog/index.php':
        require __DIR__ . '/views/all_posts.php';
        break;
    case '/blog/index.php/post':
        require __DIR__ . '/views/single_post.php';
        break;
    case '/blog/index.php/new-post':
        require __DIR__ . '/views/new_post.php';
        break;
    case '/blog/index.php/add-post':
        require __DIR__ . '/post.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}