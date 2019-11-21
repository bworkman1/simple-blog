<?php
class Blog {

    private $Conn;
    public $Start_Page, $End_Page;

    public function __construct() {
        $this->Conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_TABLE);
    }

    public function getBlogById($id) {
        $stmt = $this->Conn->prepare("SELECT id, title, content, creator, created FROM blog_posts WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $res = $stmt->get_result();

        $post = [];
        if($res->num_rows > 0) {
            $post = $res->fetch_assoc();
        }

        $stmt->close();

        return $post;
    }

    public function getBlogPosts($limit, $offset) {
        $posts = [];

        $stmt = $this->Conn->prepare("SELECT id, title, content, creator, created FROM blog_posts LIMIT ? OFFSET ?");
        $stmt->bind_param('ii', $limit, $offset);
        $stmt->execute();

        $res = $stmt->get_result();
        if($res->num_rows > 0) {
            while($row = $res->fetch_assoc()) {
                $posts[] = $row;
            }
        }
        $stmt->close();

        return $posts;
    }

    public function getTotalBlogPosts() {
        $res = $this->Conn->query("SELECT created AS total FROM blog_posts");
        $count = $res->num_rows;
        $res->close();

        return $count;
    }

    /**
     * Returns the starting page number and ending page
     * number based on current page view for the pagnation functionality
     */
    public function setPageNumbersForPagination($totalPages, $currentPage) {
        if($totalPages <= (1+(PAGES_TO_SHOW * 2))) {
            $this->Start_Page = 1;
            $this->End_Page   = $totalPages;
        } else {
            if(($currentPage - PAGES_TO_SHOW) > 1) {
                if(($currentPage + PAGES_TO_SHOW) < $totalPages) {
                    $this->Start_Page = ($currentPage - PAGES_TO_SHOW);
                    $this->End_Page   = ($currentPage + PAGES_TO_SHOW);
                } else {
                    $this->Start_Page = ($totalPages - (1+(PAGES_TO_SHOW*2)));
                    $this->End_Page   = $totalPages;
                }
            } else {
                $this->Start_Page = 1;
                $this->End_Page   = (1+(PAGES_TO_SHOW * 2));
            }
        }
    }

    public function saveNewBlogPost($title, $content, $creator) {
        $stmt = $this->Conn->prepare("INSERT INTO blog_posts (title, content, creator) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $title, $content, $creator);
        $stmt->execute();

        $insertId = $this->Conn->insert_id;

        $stmt->close();

        return $insertId;
    }

    public function __destruct() {
        $this->Conn->close();
    }

}