<?php
/**
 * @var $pdo PDO
 * @var $postId integer
 * @var $commentCount integer
 */
?>
<form
    action="view-post.php?action=delete-comment&amp;post_id=<?= $postId?>&amp;"
    method="post"
    class="comment-list"
>
    <h3><?= $commentCount ?> comments</h3>

    <?php foreach (getCommentsForPost($pdo, $postId) as $comment): ?>
        <div class="comment">
            <div class="comment-meta">
                Comment from
                <?= htmlEscape($comment['name']) ?>
                on
                <?= convertSqlDate($comment['created_at']) ?>
                <?php if (isLoggedIn()): ?>
                    <input
                        type="submit"
                        name="delete-comment[<?= $comment['id'] ?>]"
                        value="Delete"
                    />
                <?php endif ?>
            </div>
            <div class="comment-body">
                <?php // This is already escaped ?>
                <?= convertNewlinesToParagraphs($comment['text']) ?>
            </div>
        </div>
    <?php endforeach ?>
</form>
