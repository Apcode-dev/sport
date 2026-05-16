<?php

include('partials/menu.php'); ?>
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

    input[type="number"],
    select {
        width: 200px;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
        margin-bottom: 10px;
    }

    select {
        width: 100%;
        padding: 10px;
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

    .b {
        font-weight: bold;
    }

    .success {
        color: green;
    }

    .error {
        color: red;
    }

    .btn-secondary {
        background-color: #555;
        color: white;
        padding: 10px 20px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
    }

    .btn-secondary:hover {
        background-color: #444;
    }
</style>
<div class="main-content">
    <div class="wrapper">
        <h1 style="text-align: center;">Update Order</h1>
        <br><br>


        <?php

        //CHeck whether id is set or not
        if (isset($_GET['id'])) {
            //GEt the Order Details
            $id = $_GET['id'];

            //Get all other details based on this id
            //SQL Query to get the order details
            $sql = "SELECT * FROM tbl_order WHERE id=$id";
            //Execute Query
            $res = mysqli_query($conn, $sql);
            //Count Rows
            $count = mysqli_num_rows($res);

            if ($count == 1) {
                //Detail Availble
                $row = mysqli_fetch_assoc($res);

                $item = $row['item'];
                $price = $row['price'];
                $qty = $row['qty'];
                $status = $row['status'];
            } else {
                //DEtail not Available/
                //Redirect to Manage Order
                header('location: manage-order.php');
            }
        } else {
            //REdirect to Manage ORder PAge
            header('location: manage-order.php');
        }

        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>item Name</td>
                    <td><b> <?php echo $item; ?> </b></td>
                </tr>

                <tr>
                    <td>Price</td>
                    <td>
                        <b> ₹ <?php echo $price; ?></b>
                    </td>
                </tr>

                <tr>
                    <td>Qty</td>
                    <td>
                        <input type="number" name="qty" value="<?php echo $qty; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Status</td>
                    <td>
                        <select name="status">
                            <option <?php if ($status == "Ordered") {
                                        echo "selected";
                                    } ?> value="Ordered">Ordered</option>
                            <option <?php if ($status == "On Delivery") {
                                        echo "selected";
                                    } ?> value="On Delivery">On Delivery</option>
                            <option <?php if ($status == "Delivered") {
                                        echo "selected";
                                    } ?> value="Delivered">Delivered</option>
                            <option <?php if ($status == "Cancelled") {
                                        echo "selected";
                                    } ?> value="Cancelled">Cancelled</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td clospan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                        <input type="submit" name="submit" value="Update Order" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>


        <?php
        //CHeck whether Update Button is Clicked or Not
        if (isset($_POST['submit'])) {
            //echo "Clicked";
            //Get All the Values from Form
            $id = $_POST['id'];
            $price = $_POST['price'];
            $qty = $_POST['qty'];
            $total = $price * $qty;
            $status = $_POST['status'];
            //Update the Values
            $sql2 = "UPDATE tbl_order SET 
                    qty = $qty,
                    total = $total,
                    status = '$status'
                    WHERE id=$id
                ";

            //Execute the Query
            $res2 = mysqli_query($conn, $sql2);

            //CHeck whether update or not
            //And REdirect to Manage Order with Message
            if ($res2 == true) {
                //Updated
                $_SESSION['update'] = "<div class='success'>Order Updated Successfully.</div>";
                header('location: manage-order.php');
            } else {
                //Failed to Update
                $_SESSION['update'] = "<div class='error'>Failed to Update Order.</div>";
                header('location: manage-order.php');
            }
        }
        ?>


    </div>
</div>

<?php include('partials/footer.php'); ?>