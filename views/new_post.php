<?php
    // FORM TO ENTER NEW BLOG POSTS
    require 'constants.php';

    $csrf_token = bin2hex(random_bytes(CSRF_TOKEN_LENGTH));
    setcookie('csrf_token', $csrf_token, time() + 3600);
?>

<?php require './views/templates/header.php'; ?>

<?php require './views/templates/nav.php'; ?>

<main class="container">
    <h1 class="text-center">Add New Blog Post</h1>
    <div class="row justify-content-md-center">
        <div class="col-md-6">
            <form id="newBlogPostForm">
                <div id="form-feedback"></div>
                <div class="form-group">
                    <label for="titleInput"><span class="text-danger">*</span>Title</label>
                    <input type="text" id="titleInput" class="form-control" name="title" aria-describedby="inputTitle" required placeholder="Enter a Title">
                    <small id="titleHelp" class="form-text inputHelper text-danger"></small>
                </div>

                <div class="form-group ">
                    <label for="contentInput"><span class="text-danger">*</span>Content</label>
                    <textarea id="contentInput" class="form-control" name="content" required rows="3"></textarea>
                    <small id="contentHelp" class="form-text inputHelper text-danger"></small>
                </div>

                <div class="form-group">
                    <label for="creatorInput"><span class="text-danger">*</span>Creator</label>
                    <input type="text" id="creatorInput" class="form-control" name="creator" aria-describedby="creatorInput" required placeholder="Enter Name">
                    <small id="creatorHelp" class="form-text inputHelper text-danger"></small>
                </div>

                <input type="hidden" name="csrf_forgery_token" value="<?php echo $csrf_token; ?>">

                <button type="submit" id="submitBlogPostBtn" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

</main>

<?php require './views/templates/footer.php'; ?>
