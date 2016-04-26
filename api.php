<?php

ini_set('memory_limit', '-1');
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");

$host = "localhost";
$username = "root";
$password = "";
$database = "asiana";
$json = json_encode(array());

//key=HkpFqD66217c2j4n404e8rdeef5pJ61k
$key = (string) filter_input(INPUT_GET, 'key');
$module = (string) filter_input(INPUT_GET, 'module');
$method = (string) filter_input(INPUT_GET, 'method');

if (strcasecmp($key, "5a0a-d773-0d59-c19a-bcbf-7ad1-cf3d-64c4") == 0) {

    // user
    if (strcasecmp($module, "user") == 0) {

        // create
        if (strcasecmp($method, "create") == 0) {

            $name = (string) filter_input(INPUT_GET, 'name');
            $useremail = (string) filter_input(INPUT_GET, 'email');
            $userpassword = (string) filter_input(INPUT_GET, 'password');
            $hashed = MD5($userpassword);

            $conn = mysqli_connect($host, $username, $password, $database);
            $userSql = "INSERT INTO users(name, email, password, joined_date, last_login) VALUES ('" . $name . "','" . $useremail . "','" . $hashed . "', NOW(), NOW())";
            $result = mysqli_query($conn, $userSql);
            $rowcount = mysqli_affected_rows($conn);
            $userId = mysqli_insert_id($conn);
            mysqli_close($conn);

            $success = array(
                "status" => "success",
                "rowcount" => $rowcount,
                "results" => "User created: " . $userId
            );

            $json = json_encode($success);
        }

        // update
        if (strcasecmp($method, "update") == 0) {

            $userid = (string) filter_input(INPUT_GET, 'userid');
            $name = (string) filter_input(INPUT_GET, 'name');
            $email = (string) filter_input(INPUT_GET, 'email');
            $userpassword = (string) filter_input(INPUT_GET, 'password');
            $hashed = MD5($userpassword);

            $conn = mysqli_connect($host, $username, $password, $database);
            if(empty($hashed)){
                $sql = "update users set name = '" . $name . "', email = '" . $email . "', last_update = NOW() where user_id = '" . $userid . "'";
            } else {
                $sql = "update users set name = '" . $name . "', email = '" . $email . "', password = '" . $hashed . "', last_update = NOW() where user_id = '" . $userid . "'";
            }
            $result = mysqli_query($conn, $sql);
            mysqli_close($conn);

            $success = array(
                "status" => "success",
                "results" => "User updated: " . $userid
            );

            $json = json_encode($success);
        }

        // delete
        if (strcasecmp($method, "delete") == 0) {
            $userid = (string) filter_input(INPUT_GET, 'userid');

            $conn = mysqli_connect($host, $username, $password, $database);
            $sql = "delete from users where user_id = '" . $userid . "'";
            $result = mysqli_query($conn, $sql);
            mysqli_close($conn);

            $success = array(
                "status" => "success",
                "results" => "User deleted: " . $userid
            );

            $json = json_encode($success);
        }
    }

    // post
    // author, title, content, photo
    if (strcasecmp($module, "post") == 0) {

        // create
        if (strcasecmp($method, "create") == 0) {

            // retrieve inputs
            $userid = (string) filter_input(INPUT_GET, 'userid');
            $title = (string) filter_input(INPUT_GET, 'title');
            $content = (string) filter_input(INPUT_GET, 'content');

            // init db conn & execute create post statement
            $conn = mysqli_connect($host, $username, $password, $database);
            $userSql = "INSERT INTO post(title, content, author, date_created, last_update) VALUES ('" . $title . "','" . $content . "','" . $userid . "', NOW(), NOW())";
            $result = mysqli_query($conn, $userSql);
            $postId = mysqli_insert_id($conn);
            mysqli_close($conn);

            // init db conn & execute create post statement
            $conn2 = mysqli_connect($host, $username, $password, $database);
            $userSql = "INSERT INTO likes(post_id, date_created) VALUES ('" . $postId . "', NOW())";
            $result = mysqli_query($conn2, $userSql);
            mysqli_close($conn2);

            // create photo
            // $conn2 = mysqli_connect($host, $username, $password, $database);
            // $userSql = "INSERT INTO gallery(post, imageid, date_created) VALUES ('" . $content . "','" . $userid . "', NOW())";
            // $result = mysqli_query($conn, $userSql);
            // mysqli_close($conn2);

            $success = array(
                "status" => "success",
                "results" => "Post created: " . $postId
            );

            $json = json_encode($success);
        }

        // update
        if (strcasecmp($method, "update") == 0) {

            // retrieve inputs
            $userid = (string) filter_input(INPUT_GET, 'userid');
            $titleId = (string) filter_input(INPUT_GET, 'titleid');
            $title = (string) filter_input(INPUT_GET, 'title');
            $content = (string) filter_input(INPUT_GET, 'content');

            $conn = mysqli_connect($host, $username, $password, $database);
            $sql = "update post set title = '" . $title . "', content = '" . $content . "', author = '" . $userid . "', last_update = NOW() where post_id = '" . $titleId . "'";
            $result = mysqli_query($conn, $sql);
            $rowcount = mysqli_affected_rows($conn);
            mysqli_close($conn);

            $success = array(
                "status" => "success",
                "results" => "Post updated: " . $titleId
            );  
            $json = json_encode($success);
        }

        // delete
        if (strcasecmp($method, "delete") == 0) {

            // retrieve inputs
            $titleId = (string) filter_input(INPUT_GET, 'titleId');

            $conn = mysqli_connect($host, $username, $password, $database);
            $sql = "delete post where post_id = '" . $titleId . "'";
            $result = mysqli_query($conn, $sql);
            $rowcount = mysqli_affected_rows($conn);
            mysqli_close($conn);

            $success = array(
                "status" => "success",
                "results" => "Post deleted: " . $titleId
            );  
            $json = json_encode($success);
        }

        // like
        if (strcasecmp($method, "like") == 0) {

            // retrieve inputs
            $titleid = (string) filter_input(INPUT_GET, 'titleid');
            $userid = (string) filter_input(INPUT_GET, 'userid');

            // init db conn & execute create post statement
            $conn = mysqli_connect($host, $username, $password, $database);
            $userSql = "update likes set likes = likes + 1, last_update = NOW() where post_id = '" . $titleid . "'";
            $result = mysqli_query($conn, $userSql);
            $postId = mysqli_insert_id($conn);
            mysqli_close($conn);

            $success = array(
                "status" => "success",
                "results" => "Post liked: " . $titleid
            );  
            $json = json_encode($success);
        }

        // unlike
        if (strcasecmp($method, "unlike") == 0) {

            // retrieve inputs
            $titleid = (string) filter_input(INPUT_GET, 'titleid');
            $userid = (string) filter_input(INPUT_GET, 'userid');

            // init db conn & execute create post statement
            $conn = mysqli_connect($host, $username, $password, $database);
            $userSql = "update likes set unlike = unlike + 1, last_update = NOW() where post_id = '" . $titleid . "'";
            $result = mysqli_query($conn, $userSql);
            $rowcount = mysqli_affected_rows($conn);
            $postId = mysqli_insert_id($conn);
            mysqli_close($conn);

            $success = array(
                "status" => "success",
                "results" => "Post unliked: " . $titleid
            );  
            $json = json_encode($success);
        }
    }

    echo $json;
} else {
    $error = array(
        "status" => "failed",
        "statusmsg" => "INVALID KEY"
    );
    $json = json_encode($error);
    echo $json;
}
?> 