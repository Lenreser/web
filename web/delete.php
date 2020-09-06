<?php
    $PAGE_TITLE = 'Delete';
    include('header.php');
?>
<div>
    <h1>Delete Product</h1>
    
    <?php
    require_once('helper.php');
    
    if($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        $hideform = false;
        $id = strtoupper(trim($_GET['id']));
        $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die('Could not connect to MySQL : '. mysqli_connect_error());
        $id = mysqli_real_escape_string($con, $id);
        $sql = "SELECT * FROM product WHERE id = '$id'";
        
        $result = mysqli_query($con, $sql);
        if(mysqli_num_rows($result) > 0)
        {
            while($row = mysqli_fetch_array($result))
            {
                $id                 = $row['id'];
                $name               = $row['name'];
                $quantity           = $row['qty'];
                $price              = $row['price'];
                $description        = $row['description'];
                $shortDescription   = $row['short_desc'];
                
                printf('<p>Are you sure to delete the following Product?</p>');
            }
        }
        
    }
    else 
    {
        $hideform = true;
        
        $id = strtoupper(trim($_POST['id']));
        $name = trim($_POST['name']);
        
        $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die('Could not connect to MySQL : '. mysqli_connect_error());
        $sql = "DELETE FROM product WHERE id = '$id'";
        
        $result = mysqli_query($con,$sql);
        
        if($result)
        {
            if(mysqli_affected_rows($con) > 0)
            {
                printf('<div>Product <strong>%s</strong> has been deleted.</div>',$name);
            }
        }
        else
        {
            printf('<div>Opps, Record not deleted. Meassage : %s</div>',mysqli_error($con));
        }
        
    }
    
    if($hideform == false) :
    ?>
    
    <table border="1" cellpadding="5" cellpadding="1">
        <tr>
            <td>Product ID</td>
            <td><?php echo $id ?></td>
        </tr>
        <tr>
            <td>Product name</td>
            <td><?php echo $name ?></td>
        </tr>
        <tr>
            <td>Quantity</td>
            <td><?php echo $quantity ?></td>
        </tr>
        <tr>
            <td>Product price</td>
            <td><?php echo $price ?></td>
        </tr>
        <tr>
            <td>Short Description</td>
            <td><?php echo $shortDescription ?></td>
        </tr>
        <tr>
            <td>Description</td>
            <td><?php echo $description ?></td>
        </tr>
        
    </table>
    
    <form action="" method="post">
        <?php htmlInputHidden('id',$id) ?>
        <?php htmlInputHidden('name',$name) ?>
        <input type="submit" name="yes" value="yes"/>
        <input type="button" value="Cancel" onclick="location='list.php'"/>
    </form>
    <?php endif ?>
</div>


<?php
    include('footer.php');
?>