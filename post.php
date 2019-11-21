<?php

// ACCEPTS ONLY POST REQUEST FROM THE ADD BLOG POST FORM

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require 'constants.php';

    // Set the data for the response
    $res = [
        'success' => false,
        'msg' => 'Failed to submit form, fix the errors and try again',
        'data' => []
    ];

    // Gather the post variables
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';
    $creator = isset($_POST['creator']) ? $_POST['creator'] : '';

    // First check the csrf tokens for any shenanigans
    if(isset($_COOKIE['csrf_token'])
        && $_COOKIE['csrf_token'] === $_POST['csrf_forgery_token']) {

        // Validate title input
        if(!$title) {
            $res['data']['titleInput'] = 'Title is required';
        } elseif(strlen($title) > 70) {
            $res['data']['titleInput'] = 'Title cannot be longer than 70 characters, currently at ' . strlen($title) . ' characters';
        }

        // Validate content input
        if(!$content) {
            $res['data']['contentInput'] = 'Content is required';
        } elseif(strlen($content) > 500) {
            $res['data']['contentInput'] = 'Content cannot be longer than 500 characters, currently at ' . strlen($content) . ' characters';
        }

        // Validate creator input
        if(!$creator) {
            $res['data']['creatorInput'] = 'Title is required';
        } elseif(strlen($creator) > 50) {
            $res['data']['creatorInput'] = 'Creator cannot be longer than 50 characters, currently at ' . strlen($creator) . ' characters';
        }

        // Check to see if any errors where found
        if(empty($res['data'])) {

            require './classes/Blog.php';
            $Blog = new Blog();

            // Save the blog post
            $newBlog = $Blog->saveNewBlogPost($title, $content, $creator);

            if(!$newBlog) {
                $res['msg'] = 'There was an error saving the post, try again';
            } else {
                // Return the post id so we can redirect the user to the newly saved blog post
                $res['success'] = true;
                $res['msg'] = 'Post submitted succesfully';
                $res['data'] = ['post_id' => $newBlog];

                setcookie('csrf_token', '', time()-1);
            }
        }

    } else {
        $res['msg'] = 'Invalid form data, refresh the page and try again';
    }

    header('Content-Type: application/json');
    echo json_encode($res);

} else {
    // Request was not a post
    http_response_code(404);
    require __DIR__ . '/views/404.php';
    exit;
}