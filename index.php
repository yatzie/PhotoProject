<?php include("includes/header.php"); ?>

<?php 
    
    //pagination, setting a requested page
    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
    $items_per_page = 12; //how many pictures per page
    $items_total_count = Photo::count_all();

    //instatiating Paginate class and passing variables
    $paginate = new Paginate($page, $items_per_page, $items_total_count);

    $sql = "SELECT * FROM photos ";
    $sql .= "LIMIT {$items_per_page} ";
    $sql .= "OFFSET {$paginate->offset()}";

    $photos = Photo::find_by_query($sql);

?>


        <div class="row"><hr>
		
            <!-- Blog Entries Column -->
            <div class="col-md-12">
                <div class="row">
                    <?php foreach ($photos as $photo): ?>                                   
                        <div class="col-xs-6 col-md-3">
                            <a class="img-thumbnail" href="photo.php?id=<?php echo $photo->id; ?>">
                                <img class="home_page_photo img-responsive" src="admin/<?php echo $photo->picture_path(); ?>" title="<?php echo $photo->filename; ?>">
                            </a>
                        </div>                   
                    <?php endforeach; ?>
                </div><hr>
                <!-- this will display button for previos or next pages and page numer that is curruntly displayed-->
                <div class="row">
                    <ul class="pagination">

                        <?php

                            if ($paginate->page_total() > 1) {
                                
                                if ($paginate->has_previous()) {

                                    echo "<li class='previous'><a href='index.php?page={$paginate->previous()}'>Previous</a></li>";

                                }

                                for ($i=1; $i <= $paginate->page_total(); $i++) { 
                                    
                                    if ($i == $paginate->current_page) {

                                        echo "<li class='active'><a href='index.php?page={$i}'>{$i}</a></li>";

                                    } else {

                                        echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";

                                    }

                                }

                                if ($paginate->has_next()) {
                                    
                                    echo "<li class='next'><a href='index.php?page={$paginate->next()}'>Next</a></li>";

                                }

                            }

                        ?>

                    </ul>
                </div>
            </div>




            <!-- Blog Sidebar Widgets Column -->
            <!-- <div class="col-md-4">

            
                 <?php //include("includes/sidebar.php"); ?> -->



        </div>
        <!-- /.row -->

        <?php include("includes/footer.php"); ?>