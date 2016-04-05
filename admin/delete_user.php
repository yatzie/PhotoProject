<?php include_once("includes/header.php"); ?>
<!-- this page gets user id using get method, calls delete method and redirects -->



<?php if(!$session->is_signed_in()) { redirect("login.php"); } ?>

<?php



if (empty($_GET['id'])) {

    redirect("users.php");

}

$user = User::find_by_id($_GET['id']);

if ($user) {

    $user->delete_photo();
    redirect("users.php");
    $session->message("The {$user->username} User was deleted");

} else {

    redirect("users.php");
    
}



?>
