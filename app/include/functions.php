<?
require_once "database.php";



function get_library() {

    global $link;

    $sql = "SELECT * FROM library";

    $result = mysqli_query($link, $sql);

    $library = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $library;

}

function get_library_by_id($lib_id) {
    global $link;

    $sql = "SELECT * FROM library WHERE id = ".$lib_id;

    $result = mysqli_query($link, $sql);

    $lib = mysqli_fetch_assoc($result);

    return $lib;
}

function get_news() {

    global $link;

    $sql = "SELECT * FROM news";

    $result = mysqli_query($link, $sql);

    $news = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $news;

}

function get_news_by_id($new_id) {
    global $link;

    $sql = "SELECT * FROM news WHERE newsid = ".$new_id;

    $result = mysqli_query($link, $sql);

    $new = mysqli_fetch_assoc($result);

    return $new;
}

function get_company() {

    global $link;

    $sql = "SELECT * FROM company";

    $result = mysqli_query($link, $sql);

    $companys = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $companys;

}

function get_company_by_id($company_id) {
    global $link;

    $sql = "SELECT * FROM company WHERE id = ".$company_id;

    $result = mysqli_query($link, $sql);

    $company = mysqli_fetch_assoc($result);

    return $company;
}

function get_posts() {

    global $link;

    $sql = "SELECT * FROM rc_kpp_marks";

    $result = mysqli_query($link, $sql);

    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $posts;

}

function get_post_by_id($post_id) {
    global $link;

    $sql = "SELECT * FROM rc_kpp_marks WHERE id = ".$post_id;

    $result = mysqli_query($link, $sql);

    $post = mysqli_fetch_assoc($result);

    return $post;
}
