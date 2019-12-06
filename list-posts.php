<?php
require_once 'lib/common.php';
require_once 'lib/list-posts.php';

session_start();

// Don't let non-auth users see this screen
if (!isLoggedIn())
{
    redirectAndExit('index.php');
}

if ($_POST)
{
    $deleteResponse = $_POST['delete-post'];
    if ($deleteResponse)
    {
        $keys = array_keys($deleteResponse);
        $deletePostId = $keys[0];
        if ($deletePostId)
        {
            deletePost(getPDO(), $deletePostId);
            redirectAndExit('list-posts.php');
        }
    }
}

// Connect to the database, run a query
$pdo = getPDO();
$posts = getAllPosts($pdo);

?>

<!DOCTYPE html>
<html>
    <head>
        <title>A blog application | Blog posts</title>
        <?php require 'templates/head.php' ?>
    </head>
    <body>
        <?php require 'templates/title.php' ?>

        <h1>Posts list</h1>

        <p>You have <?= count($posts) ?> posts.

        <form method="post">
            <table id="post-list">
                <tbody>
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td>
                                <?= htmlEscape($post['title']) ?>
                            </td>
                            <td>
                                <?= convertSqlDate($post['created_at']) ?>
                            </td>
                            <td>
                                <a href="edit-post.php?post_id=<?= $post['id']?>">Edit</a>
                            </td>
                            <td>
                                <input
                                    type="submit"
                                    name="delete-post[<?= $post['id']?>]"
                                    value="Delete"
                                />
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </form>
    </body>
</html>