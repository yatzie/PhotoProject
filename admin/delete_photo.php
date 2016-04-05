<?php include_once("includes/header.php"); ?>
<!-- this page get image by id using get method, calls delete method and redirects -->



<?php if(!$session->is_signed_in()) { redirect("login.php"); } ?><!-- Checking for session variable -->

<?php



if (empty($_GET['id'])) {

    redirect("photos.php");

}

$photo = Photo::find_by_id($_GET['id']);

if ($photo) {

    $photo->delete_photo();
    $session->message("The {$photo->title} Photo was deleted");
    redirect("photos.php");

} else {

    redirect("photos.php");
    
}



?>

