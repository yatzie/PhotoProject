<?php include_once("includes/header.php"); ?>
<!-- This Page Will Display Comments From Users -->



<?php if(!$session->is_signed_in()) { redirect("login.php"); } ?><!-- Checking for session variable -->

<?php

    $comments = Comment::find_all();//instatiating a class

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
                        Comments Page
                    </h1>
                    
                    <!-- table to display users -->
                    <div class="col-md-12">
                    	<?php if ($message) { ?><p class="bg-success alert"><a href="#" class="close" data-dismiss="alert">&times;</a><?php echo $message; ?></p><?php } ?>
                        <table class="table table-hover">

                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Author</th>
                                    <th>Body</th>
                                    <th>Date</th>
                                </tr>
                            </thead>

                            <tbody>

                                <!-- looping through array to display properties -->
                                <?php foreach ($comments as $comment) : ?>

                                    <tr>
                                        <td><?php echo $comment->id; ?></td>
                                        <td><?php echo $comment->author; ?>
                                            <div class="action_links">
                                                <?php if($session->loged_in_user == "yatzie") {?><a href="delete_comment.php?id=<?php echo $comment->id; ?>">Delete</a><?php } ?>
                                            </div>
                                        </td>
                                        <td><?php echo $comment->body; ?></td>
                                        <td><?php echo $comment->comment_date; ?></td>
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