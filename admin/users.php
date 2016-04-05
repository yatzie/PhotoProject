<?php include_once("includes/header.php"); ?>
<!-- This Page Will Display Pictures From Gallery -->



<?php if(!$session->is_signed_in()) { redirect("login.php"); } ?><!-- Checking for session variable -->

<?php

    $users = User::find_all();//instatiating a class

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
                        Users Page
                    </h1>

                    <?php if($session->loged_in_user == "yatzie") { ?><a href="add_user.php" class="btn btn-primary"><span class="fa fa-fw fa-user"></span> Add User</a><hr><?php } ?>
                    
                    <!-- table to display users -->
                    <div class="col-md-12">
                    	<?php if ($message) { ?><p class="bg-success alert"><a href="#" class="close" data-dismiss="alert">&times;</a><?php echo $message; ?></p><?php } ?>
                        <table class="table table-hover">

                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Photo</th>
                                    <th>Username</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                </tr>
                            </thead>

                            <tbody>

                                <!-- looping through array to display properties -->
                                <?php foreach ($users as $user) : ?>

                                    <tr>
                                        <td><?php echo $user->id; ?></td>
                                        <td>
                                            <img class="admin-user-thumbnail user_image" src="<?php echo $user->image_path_and_placeholder(); ?>" alt="">
                                        </td>
                                        <td><?php echo $user->username; ?>
                                            <div class="action_links">
                                                <?php if($session->loged_in_user == "yatzie") { if ($user->id != 1) {?><a class="delete_link" href="delete_user.php?id=<?php echo $user->id; ?>">Delete</a><?php }} ?>
                                                <?php if ($user->id != 1) {?><a href="edit_user.php?id=<?php echo $user->id; ?>">Edit</a><?php } ?>
                                            </div>
                                        </td>
                                        <td><?php echo $user->first_name; ?></td>
                                        <td><?php echo $user->last_name; ?></td>
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