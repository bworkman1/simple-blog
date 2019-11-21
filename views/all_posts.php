<?php
    // PAGE THAT SHOWS ALL THE BLOG POSTS

    require 'constants.php';
    require './classes/Blog.php';

    $Blog = new Blog();

    // Count for the pagination functionality
    $totalPosts = $Blog->getTotalBlogPosts();
    $totalPages = ceil($totalPosts / POST_PER_PAGE);

    // Get the page number the visitor is looking at
    $currentPage = (int) isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $totalPages
        ? $_GET['page'] : 1;

    // Get the posts for the user based on current page number
    $offset = (int) (POST_PER_PAGE * ($currentPage - 1));
    $posts = $Blog->getBlogPosts(POST_PER_PAGE, $offset);

    // Set the page number settings for the blog pagination
    $Blog->setPageNumbersForPagination($totalPages, $currentPage);
?>

<?php require './views/templates/header.php'; ?>

<?php require './views/templates/nav.php'; ?>

<main class="container">
    <h1>Blog Posts</h1>
    <div class="row">
        <?php
        if(!empty($posts)) {
            foreach($posts as $i => $post) {
                echo '<div class="col-md">';
                    echo '<div class="card">';
                        echo '<div class="card-body">';
                            echo '<h5 class="card-title">' . ucwords(htmlspecialchars($post['title'], ENT_QUOTES)) . '</h5>';
                            echo '<p class="card-text">';
                                echo substr(htmlspecialchars($post['content'], ENT_QUOTES), 0, EXCERPT_LENGTH);
                            echo '...</p>';
                            echo '<a href="' . BASE_URL . '/index.php/post?id=' . $post['id'] . '" class="btn btn-outline-secondary">View</a>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';

                echo ($i + 1) % POST_COLUMNS == 0 ? '</div><div class="row">' : '';
            }
        } else {
            echo '<div class="col-md">';
                echo '<div class="alert alert-warning" role="alert">';
                    echo 'No blog post have been entered yet, check back later or enter a <a href="' . BASE_URL . '/index.php/new-post" class="alert-link">new post</a>.';
                echo '</div>';
            echo '</div>';
        }
        ?>
    </div>

    <?php if($totalPages > 0) { ?>
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item <?php echo $currentPage <= 1 ? 'disabled' : ''; ?>">
                    <a class="page-link" href="<?php echo BASE_URL . '?page=1'; ?>">First</a>
                </li>

                <?php
                    // Build out the pagination based on the current selected page
                    for($i = $Blog->Start_Page; $i <= $Blog->End_Page; $i++) {
                        $active =  $currentPage == $i ? 'active' : '';
                        echo '<li class="page-item ' . $active . '">';
                            echo '<a class="page-link" href="' . BASE_URL . '?page=' . $i . '">' . $i . '</a>';
                        echo '</li>';
                    }
                ?>

                <li class="page-item <?php echo $currentPage >= $totalPages ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?php echo BASE_URL . '?page=' . $totalPages; ?>">Last</a>
                </li>
            </ul>
        </nav>
    <?php } ?>
</main>

<?php require './views/templates/footer.php'; ?>
