<?php include("includes/header.php"); ?>
<!-- This Page Will Display Pictures From Gallery -->



<?php if(!$session->is_signed_in()) { redirect("login.php"); } ?><!-- Checking for session variable -->

<?php

    $photos = Photo::find_all();

?>



    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        

    <?php include("includes/top_nav.php"); ?>


        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
 

    <?php include("includes/side_nav.php"); ?>


        <!-- /.navbar-collapse -->
    </nav>


    <div id="page-wrapper">


        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Photo Page
                    </h1>
                    
                    <!-- table to display photos -->
                    <div class="col-md-12">
                    	<?php if ($message) { ?><p class="bg-success alert"><a href="#" class="close" data-dismiss="alert">&times;</a><?php echo $message; ?></p><?php } ?>
                        <table class="table table-hover">

                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>Id</th>
                                    <th>File Name</th>
                                    <th>Title</th>
                                    <th>Size</th>
                                    <th>Comments</th>
                                    <th>Date</th>
                                </tr>
                            </thead>

                            <tbody>

                                <!-- looping through array to display properties -->
                                <?php foreach ($photos as $photo) : ?>

                                    <tr>
                                        <td>
                                            <img class="admin-photo-thumbnail" src="<?php echo $photo->picture_path(); ?>" alt="">
                                            <div class="action_links">
                                                <?php if($session->loged_in_user == "yatzie") {?><a class ="delete_link" href="delete_photo.php?id=<?php echo $photo->id; ?>">Delete</a><?php } ?>
                                                <a href="edit_photo.php?id=<?php echo $photo->id; ?>">Edit</a>
                                                <a href="../photo.php?id=<?php echo $photo->id ?>">View</a>
                                            </div>
                                        </td>
                                        <td><?php echo $photo->id; ?></td>
                                        <td><?php echo $photo->filename; ?></td>
                                        <td><?php echo $photo->title; ?></td>
                                        <td><?php echo $photo->size; ?></td>
                                        <td><a href="comment_photo.php?id=<?php echo $photo->id ?>"><span class="badge"><?php $comments = Comment::find_the_comments($photo->id); echo count($comments); ?></span></a></td>
                                        <td><?php echo $photo->photo_date; ?></td>
                                    </tr>

                                <?php endforeach; ?>

                            </tbody> 

                        </table><!-- end of table -->
                    </div>

                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->


    </div>
    <!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>