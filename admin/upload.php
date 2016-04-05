<?php include_once("includes/header.php"); ?>

<?php if(!$session->is_signed_in()) { redirect("login.php"); } ?><!-- Checking for session variable -->

<?php

    //code to check for form submit
    $message = "";

    if (isset($_FILES['file'])) {

        $photo = new Photo();

        $photo->title = $_POST['title'];
        $photo->set_file($_FILES['file']);
        $photo->photo_username = $session->loged_in_user;

        if ($photo->save()) {

            $message = "photo uploaded succesfully";

        } else {

            $message = join("<br>", $photo->errors);

        }

    }

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
                        Upload Photo Page 
                        <small>
                            <p class="bg-success"><?php echo $message; ?></p>
                        </small>
                    </h1>

                    <!-- file upload form 
                    <div class="row">
                        <div class="div.col-md-6">        
                            <form action="upload.php" method="post" enctype="multipart/form-data">
                                
                                <div class="form-group">
                                    <input type="text" name="title" class="form-control">
                                </div>

                                <div class="form-group">
                                    <input type="file" name="file">
                                </div>

                                <input type="submit" name="submit">

                            </form>
                        </div>
                    </div> -->

                    <!-- dropzone form -->
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="upload.php" class="dropzone"></form>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->


    </div>
    <!-- /#page-wrapper -->

<?php include_once("includes/footer.php"); ?>