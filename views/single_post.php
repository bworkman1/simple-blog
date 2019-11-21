<?php
    // PAGE THAT SHOWS A SINGLE BLOG POSTS

    require './constants.php';
    require './classes/Blog.php';

    $Blog = new Blog();

    $id = (int) (isset($_GET['id']) && $_GET['id'] > 0) ? $_GET['id'] : 0;
    $post = $Blog->getBlogById($id);

    if(empty($post)) {
        header('Location: ' . BASE_URL . '/index.php/page-not-found');
        exit;
    }
?>

<?php require './views/templates/header.php'; ?>

<?php require './views/templates/nav.php'; ?>

    <main class="container">
        <h1><?php echo ucwords(htmlspecialchars($post['title'], ENT_QUOTES)); ?></h1>
        <p><?php echo htmlspecialchars($post['content'], ENT_QUOTES); ?></p>
        <hr>
        <p><b>By:</b> <?php echo htmlspecialchars($post['creator'], ENT_QUOTES); ?>
            <br>
            <small>On
                <?php
                    $postDate = DateTime::createFromFormat('Y-m-d H:i:s', $post['created']);
                    echo $postDate->format('m-d-Y');
                ?>
            </small>
        </p>
    </main>

<?php require './views/templates/footer.php'; ?>