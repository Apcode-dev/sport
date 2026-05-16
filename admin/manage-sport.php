<?php

include('partials/menu.php'); ?>
<center>
    <div class="main-content">
        <div class="wrapper">
            <h1>Manage item</h1>

            <br /><br />
            <!-- Button to Add Admin -->
            <a href="add-item.php" class="btn-primary" style="text-decoration: none; border-radius: 5px;">Add Item</a>

            <br /><br /><br />

            <?php
            if (isset($_SESSION['add'])) {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if (isset($_SESSION['delete'])) {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }

            if (isset($_SESSION['upload'])) {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }

            if (isset($_SESSION['unauthorize'])) {
                echo $_SESSION['unauthorize'];
                unset($_SESSION['unauthorize']);
            }

            if (isset($_SESSION['update'])) {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }

            ?>

            <table class="content-table">
                <tr>
                    <th>S.N.</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>

                <?php
                //Create a SQL Query to Get all the item
                $sql = "SELECT * FROM tbl_sport";

                //Execute the qUery
                $res = mysqli_query($conn, $sql);

                //Count Rows to check whether we have items or not
                $count = mysqli_num_rows($res);

                //Create Serial Number VAriable and Set Default VAlue as 1
                $sn = 1;

                if ($count > 0) {
                    //We have item in Database
                    //Get the items from Database and Display
                    while ($row = mysqli_fetch_assoc($res)) {
                        //get the values from individual columns
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                ?>

                        <tr>
                            <td><?php echo $sn++; ?>. </td>
                            <td><?php echo $title; ?></td>
                            <td>₹<?php echo $price; ?></td>
                            <td>
                                <?php
                                //CHeck whether we have image or not
                                if ($image_name == "") {
                                    //WE do not have image, DIslpay Error Message
                                    echo "<div class='error'>Image not Added.</div>";
                                } else {
                                    //WE Have Image, Display Image
                                ?>
                                    <img src="../images/item/<?php echo $image_name; ?>" width="100px">
                                <?php
                                }
                                ?>
                            </td>
                            <td><?php echo $featured; ?></td>
                            <td><?php echo $active; ?></td>
                            <td>
                                <a href="update-item.php?id=<?php echo $id; ?>">
                                    <image src="../images/icons/update.png">
                                </a>
                            </td>
                            <td>
                                <a href="delete-item.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>">
                                    <image src="../images/icons/delete.png" />
                                </a>
                            </td>
                        </tr>

                <?php
                    }
                } else {
                    //item not Added in Database
                    echo "<tr> <td colspan='7' class='error'> item not Added Yet. </td> </tr>";
                }

                ?>


            </table>
        </div>

    </div>
</center>

<?php include('partials/footer.php'); ?>