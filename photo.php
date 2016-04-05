<?php ob_start(); ?>
<?php include_once("includes/header.php"); ?>

<?php

    //require_once("admin/includes/init.php");

    if(empty($_GET['id'])) {

        redirect("index.php");

    }

    $photo = Photo::find_by_id($_GET['id']);

    if(isset($_POST['submit'])) {

        $author = trim($_POST['author']);
        $body = trim($_POST['body']);
        $comment_date = "";

        $new_comment = Comment::create_comment($photo->id, $author, $body, $comment_date);

        if ($new_comment && $new_comment->save()) {

            redirect("photo.php?id={$photo->id}");

        } else {

            $message = "There was some problem saving";

        }

    } else {

        $author = "";
        $body = "";
        $comment_date = "";

    }

    $comments = Comment::find_the_comments($photo->id);

?>


        <div class="row">
            <div class="col-lg-12">

                <!-- Blog Post -->

                <!-- Title -->
                <h1 class="bg-success custom_label_title"><?php echo $photo->title; ?></h1>

                <!-- Author -->
                <p class="lead">                 
                    by <label class="custom_label"><?php echo $photo->photo_username; ?></label> 
                </p>

                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Posted on: <?php echo $photo->photo_date; ?></p>

                <hr>

                <!-- Preview Image -->
                <img class="img-responsive photo_page_photo" src="admin/<?php echo $photo->picture_path(); ?>" title="<?php echo $photo->filename; ?>">

                <hr>

                <!-- Post Content -->
                <p class="lead"><?php echo $photo->caption; ?></p>
                <p><?php echo $photo->description; ?></p>

                

                <!-- Blog Comments -->

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" method="post">
                        <div class="form-group">
                            <label class="custom_label" for="author">Author</label>
                            <input type="text" name="author" class="form-control"></input>
                        </div>
                        <div class="form-group">
                            <textarea name="body" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" name="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <?php foreach ($comments as $comment): ?>
                    <!-- Displaying Comment -->
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object photo_page_photo" src="http://placehold.it/64x64" alt="">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading"><label class="custom_label"><?php echo $comment->author; ?></label>
                                <small><?php echo $comment->comment_date; ?></small>
                            </h4>
                            <?php echo $comment->body; ?><hr>
                        </div>
                    </div>
                <?php endforeach; ?><!-- loop closed -->

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <!-- <div class="col-md-4">
            
                <?php //include("includes/sidebar.php"); ?>

            </div> -->
        <!-- /.row -->
        </div>

        <?php include("includes/footer.php"); ?>