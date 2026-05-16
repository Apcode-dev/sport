    <?php include('partials-front/menu.php'); ?>


    <?php
    if (isset($_SESSION['order'])) {
        echo $_SESSION['order'];
        unset($_SESSION['order']);
    }
    ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Items</h2>

            <?php
            //Create SQL Query to Display CAtegories from Database
            $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 9";
            //Execute the Query
            $res = mysqli_query($conn, $sql);
            //Count rows to check whether the category is available or not
            $count = mysqli_num_rows($res);

            if ($count > 0) {
                //CAtegories Available
                while ($row = mysqli_fetch_assoc($res)) {
                    //Get the Values like id, title, image_name
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
            ?>

                    <a href="category-items.php?category_id=<?php echo $id; ?>">
                        <div class="box-3 float-container">
                            <?php
                            //Check whether Image is available or not
                            if ($image_name == "") {
                                //Display MEssage
                                echo "<div class='error'>Image not Available</div>";
                            } else {
                                //Image Available
                            ?>
                                <img src="./images/category/<?php echo $image_name; ?>" alt="" class="img-responsive img-curve">
                            <?php
                            }
                            ?>


                            <h3 class="float-text text-white"><?php echo $title; ?></h3>
                        </div>
                    </a>

            <?php
                }
            } else {
                //Categories not Available
                echo "<div class='error'>Category not Added.</div>";
            }
            ?>


            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->



    <!-- item MEnu Section Starts Here -->
    <section class="item-menu">
        <div class="container">
            <h2 class="text-center">Featured Items</h2>

            <?php

            //Getting items from Database that are active and featured
            //SQL Query
            $sql2 = "SELECT * FROM tbl_sport WHERE active='Yes' AND featured='Yes' LIMIT 10";

            //Execute the Query
            $res2 = mysqli_query($conn, $sql2);

            //Count Rows
            $count2 = mysqli_num_rows($res2);

            //CHeck whether item available or not
            if ($count2 > 0) {
                //item Available
                while ($row = mysqli_fetch_assoc($res2)) {
                    //Get all the values
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $description = $row['description'];
                    $image_name = $row['image_name'];
            ?>

                    <div class="item-menu-box">
                        <div class="item-menu-img">
                            <?php
                            //Check whether image available or not
                            if ($image_name == "") {
                                //Image not Available
                                echo "<div class='error'>Image not available.</div>";
                            } else {
                                //Image Available
                            ?>
                                <img src="images/item/<?php echo $image_name; ?>" alt="" class="img-responsive img-curve">
                            <?php
                            }
                            ?>

                        </div>

                        <div class="item-menu-desc">
                            <h4><?php echo $title; ?></h4>
                            <p class="item-price">₹<?php echo $price; ?></p>
                            <p class="item-detail">
                                <?php echo $description; ?>
                            </p>
                            <br>

                            <a href="order.php?item_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>

            <?php
                }
            } else {
                //item Not Available 
                echo "<div class='error'>item not available.</div>";
            }

            ?>





            <div class="clearfix"></div>



        </div>

        <p class="text-center">
            <a href="sports.php">See All Items</a>
        </p>
    </section>
    <!-- item Menu Section Ends Here -->


    <?php include('partials-front/footer.php'); ?>