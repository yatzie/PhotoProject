<?php include_once("includes/header.php"); ?>
<!-- this page deltes comment for specific photo by id using get method, calls delete method and redirects -->



<?php if(!$session->is_signed_in()) { redirect("login.php"); } ?>

<?php



if (empty($_GET['id'])) {

    redirect("comments.php");

}

$comment = Comment::find_by_id($_GET['id']);

if ($comment) {

    $comment->delete();
    $session->message("The comment by {$comment->author} has been deleted");
    redirect("comment_photo.php?id={$comment->photo_id}");

} else {

    redirect("comment_photo.php?id={$comment->photo_id}");
    
}



?>
