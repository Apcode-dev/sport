<?php
// Start output buffering
ob_start();

include('partials/menu.php'); ?>

<?php
//CHeck whether id is set or not 
if (isset($_GET['id'])) {
    //Get all the details
    $id = $_GET['id'];

    //SQL Query to Get the Selected item
    $sql2 = "SELECT * FROM tbl_sport WHERE id=$id";
    //execute the Query
    $res2 = mysqli_query($conn, $sql2);

    //Get the value based on query executed
    $row2 = mysqli_fetch_assoc($res2);

    //Get the Individual Values of Selected item
    $title = $row2['title'];
    $description = $row2['description'];
    $price = $row2['price'];
    $current_image = $row2['image_name'];
    $current_category = $row2['category_id'];
    $featured = $row2['featured'];
    $active = $row2['active'];
} else {
    //Redirect to Manage item
    header('location:manage-sport.php');
    ob_end_flush(); // End output buffering before exit
    exit(); // Stop further script execution
}
?>
<style>
    .wrapper {
        width: 80%;
        margin: 0 auto;
    }

    .tbl-30 {
        width: 30%;
        margin: auto;
        border-collapse: collapse;
    }

    .tbl-30 td {
        padding: 10px;
        vertical-align: top;
    }

    input[type="text"],
    input[type="number"],
    input[type="file"],
    textarea,
    select {
        width: 300px;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
        margin-bottom: 10px;
    }

    textarea {
        resize: none;
    }

    input[type="radio"] {
        width: auto;
        margin-right: 10px;
    }

    input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        cursor: pointer;
        border-radius: 4px;
        font-size: 16px;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }

    img {
        width: 150px;
        border-radius: 4px;
        margin-top: 10px;
    }

    .btn-secondary {
        background-color: #555;
    }

    .btn-secondary:hover {
        background-color: #444;
    }

    .success {
        color: green;
    }

    .error {
        color: red;
    }
</style>
<div class="main-content">
    <div class="wrapper">
        <h1 style="text-align: center;">Update item</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">

                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                        if ($current_image == "") {
                            //Image not Available 
                            echo "<div class='error'>Image not Available.</div>";
                        } else {
                            //Image Available
                        ?>
                            <img src="../images/item/<?php echo $current_image; ?>" width="150px">
                        <?php
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Select New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            <?php
                            //Query to Get Active Categories
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            //Execute the Query
                            $res = mysqli_query($conn, $sql);
                            //Count Rows
                            $count = mysqli_num_rows($res);

                            //Check whether category available or not
                            if ($count > 0) {
                                //Category Available
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $category_title = $row['title'];
                                    $category_id = $row['id'];
                            ?>
                                    <option <?php if ($current_category == $category_id) {
                                                echo "selected";
                                            } ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                            <?php
                                }
                            } else {
                                //Category Not Available
                                echo "<option value='0'>Category Not Available.</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if ($featured == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if ($featured == "No") {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if ($active == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if ($active == "No") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">

                        <input type="submit" name="submit" value="Update item" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        <?php
        if (isset($_POST['submit'])) {
            //1. Get all the details from the form
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $current_image = $_POST['current_image'];
            $category = $_POST['category'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            //2. Upload the image if selected
            if (isset($_FILES['image']['name'])) {
                //Upload Button Clicked
                $image_name = $_FILES['image']['name']; //New Image Name

                //Check whether the file is available or not
                if ($image_name != "") {
                    //Image is Available
                    //A. Upload New Image
                    $ext = end(explode('.', $image_name)); //Get the extension
                    $image_name = "item-Name-" . rand(0000, 9999) . '.' . $ext; //Rename image
                    $src_path = $_FILES['image']['tmp_name']; //Source Path
                    $dest_path = "../images/item/" . $image_name; //Destination Path
                    $upload = move_uploaded_file($src_path, $dest_path);

                    // Check whether the image is uploaded or not
                    if ($upload == false) {
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload new Image.</div>";
                        header('location: manage-sport.php');
                        ob_end_flush();
                        exit();
                    }

                    //B. Remove Current Image if Available
                    if ($current_image != "") {
                        $remove_path = "../images/item/" . $current_image;
                        $remove = unlink($remove_path);

                        if ($remove == false) {
                            $_SESSION['remove-failed'] = "<div class='error'>Failed to remove current image.</div>";
                            header('location: manage-sport.php');
                            ob_end_flush();
                            exit();
                        }
                    }
                } else {
                    $image_name = $current_image; // Keep current image if no new image is selected
                }
            } else {
                $image_name = $current_image; // Default image when button is not clicked
            }

            //3. Update the item in the Database
            $sql3 = "UPDATE tbl_sport SET 
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active'
                    WHERE id=$id";

            // Execute the Query
            $res3 = mysqli_query($conn, $sql3);

            // Check whether the query executed successfully
            if ($res3 == true) {
                $_SESSION['update'] = "<div class='success'>Item Updated Successfully.</div>";
                header('location: manage-sport.php');
                ob_end_flush();
                exit();
            } else {
                $_SESSION['update'] = "<div class='error'>Failed to Update Item.</div>";
                header('location: manage-sport.php');
                ob_end_flush();
                exit();
            }
        }
        ?>
    </div>
</div>

<?php
include('partials/footer.php');

// End output buffering
ob_end_flush();
?>