<?php 
    //Include COnstants Page
    include('conn.php');

    //echo "Delete item Page";

    if(isset($_GET['id']) && isset($_GET['image_name'])) //Either use '&&' or 'AND'
    {
        //Process to Delete
        //echo "Process to Delete";

        //1.  Get ID and Image NAme
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //2. Remove the Image if Available
        //CHeck whether the image is available or not and Delete only if available
        if($image_name != "")
        {
            // IT has image and need to remove from folder
            //Get the Image Path
            $path = "../images/item/".$image_name;

            //REmove Image File from Folder
            $remove = unlink($path);

            //Check whether the image is removed or not
            if($remove==false)
            {
                //Failed to Remove image
                $_SESSION['upload'] = "<div class='error'>Failed to Remove Image File.</div>";
                //REdirect to Manage item
                header('location: manage-sport.php');
                //Stop the Process of Deleting item
                die();
            }

        }

        //3. Delete item from Database
        $sql = "DELETE FROM tbl_sport WHERE id=$id";
        //Execute the Query
        $res = mysqli_query($conn, $sql);

        //CHeck whether the query executed or not and set the session message respectively
        //4. Redirect to Manage item with Session Message
        if($res==true)
        {
            //item Deleted
            $_SESSION['delete'] = "<div class='success'>item Deleted Successfully.</div>";
            header('location: manage-sport.php');
        }
        else
        {
            //Failed to Delete item
            $_SESSION['delete'] = "<div class='error'>Failed to Delete item.</div>";
            header('location: manage-sport.php');
        }

        

    }
    else
    {
        //Redirect to Manage item Page
        //echo "REdirect";
        $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access.</div>";
        header('location: manage-sport.php');
    }

?>