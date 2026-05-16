<?php

ob_start();
include('partials/menu.php');
?>
<style>
    form {
        width: 450px;
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f4f4f4;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    form table {
        width: 100%;
    }

    form table td {
        padding: 10px 0;
    }

    form input[type="text"],
    form input[type="number"],
    form input[type="file"],
    form select,
    form textarea {
        width: 300px;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 14px;
    }

    form input[type="radio"] {
        margin-right: 8px;
    }

    form .btn-secondary {
        width: 100%;
        padding: 10px;
        background-color: #5cb85c;
        color: white;
        border: none;
        cursor: pointer;
        font-size: 16px;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }

    form .btn-secondary:hover {
        background-color: #4cae4c;
    }
</style>
<div class="main-content">
    <div class="wrapper">
        <h1 style="text-align: center;">Add Item</h1>

        <br><br>

        <?php
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the Item">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the Item."></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            <?php
                            // Create SQL to get all active categories from the database
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            $res = mysqli_query($conn, $sql);
                            $count = mysqli_num_rows($res);

                            if ($count > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $id = $row['id'];
                                    $title = $row['title'];
                            ?>
                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                <?php
                                }
                            } else {
                                ?>
                                <option value="0">No Category Found</option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add item" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            // Get the Data from Form
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];

            $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
            $active = isset($_POST['active']) ? $_POST['active'] : "No";

            // Handle Image Upload
            if (isset($_FILES['image']['name'])) {
                $image_name = $_FILES['image']['name'];
                if ($image_name != "") {
                    $ext = end(explode('.', $image_name));
                    $image_name = "item-Name-" . rand(0000, 9999) . "." . $ext;
                    $src = $_FILES['image']['tmp_name'];
                    $dst = "../images/item/" . $image_name;
                    $upload = move_uploaded_file($src, $dst);
                    if ($upload == false) {
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                        header('location: add-iten.php');
                        ob_end_flush();
                        die();
                    }
                }
            } else {
                $image_name = ""; // Default value
            }

            // Insert into Database
            $sql2 = "INSERT INTO tbl_sport SET 
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = $category,
                    featured = '$featured',
                    active = '$active'";

            $res2 = mysqli_query($conn, $sql2);

            // Redirect with Message
            if ($res2 == true) {
                $_SESSION['add'] = "<div class='success'>Item Added Successfully.</div>";
                header('location: manage-sport.php');
            } else {
                $_SESSION['add'] = "<div class='error'>Failed to Add Item.</div>";
                header('location: manage-sport.php');
            }
            ob_end_flush();
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>