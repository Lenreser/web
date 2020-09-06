<?php
    $PAGE_TITLE = 'Edit';
    include('header.php');
?>

<div>    
    <h1>Edit Product</h1>
    
    <?php
    require_once('helper.php');
    $hideform = false;
    
    if($_SERVER['REQUEST_METHOD'] == 'GET')
    {
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
            }
        }
        else
        {
            echo 'Opps. record not found ! <a href="list.php"/>Back to list</a>';
            
            $hideform = true;
        }
        
    }
    else
    {
        $id                 = strtoupper(trim($_POST['id']));
        $name               = trim($_POST['name']);
        $quantity           = trim($_POST['quantity']);
        $price              = trim($_POST['price']);
        $description        = trim($_POST['description']);
        $shortDescription   = trim($_POST['shortDescription']);
        
        $error['name']              = validateProductName($name);
        $error['quantity']          = validateQty($quantity);
        $error['price']             = validatePrice($price);
        $error['description']       = validateDescription($description);
        $error['shortDescription']  = validateShortDescription($shortDescription);
        $error = array_filter($error);
    
        if(empty($error))
        {
            $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die('Could not connect to MySQL : '. mysqli_connect_error());
            $sql = "UPDATE product SET name = '$name', qty = '$quantity', price = '$price', description = '$description', short_desc = '$shortDescription' WHERE id = '$id'";        
        
            $result = mysqli_query($con, $sql);
            if($result)
            {
                if(mysqli_affected_rows($con) > 0)
                {
                    printf('<div>Product <strong>%s</strong> has been updated.</div>',$name);
                }
            }
            else
            {
                printf('<div>Opps, Record not updated. Meassage : %s</div>',mysqli_error($con));
            }
        }
        else
        {
            echo '<ul>';
            foreach($error as $value)
            {
                echo "<li>$value</li>";
            }
            echo '</ul>';
        }
    }
    
    ?>
    
    <?php if($hideform == false) : ?>
    <form action="" method="post"> 
        <table cellpadding="5" cellspacing="0">
            <tr>
                <td><label for="id">Product ID </label></td>
                <td>
                    <?php echo $id ?>
                    <?php htmlInputHidden('id',$id) ?>
                </td>
            </tr>
            <tr>
                <td><label for="name">Product Name </label></td>
                <td><?php htmlInputText('name',$name,255) ?></td>
            </tr>
            <tr>
                <td><label for="quantity">Quantity </label></td>
                <td><?php htmlInputText('quantity',$quantity,5) ?></td>
            </tr>
            <tr>
                <td><label for="price">Price </label></td>
                <td><?php htmlInputText('price',$price,10) ?></td>
            </tr> 
            <tr>
                <td><label for="description">Description </label></td>
                <td><textarea name="description" id="description" rows="5" cols="50"/><?php echo $description ?></textarea></td></td
            </tr>
            <tr>
                <td><label for="shortDescription">Short Description </label></td>
                <td><textarea name="shortDescription" id="shortDescription" rows="5" cols="50"/><?php echo $shortDescription ?></textarea></td>
            </tr>
        </table> 
        
        <input type="submit" name="update" value="Update" />
        <input type="button" value="Cancel" onclick="location='list.php'" />
        
    </form>
    <?php endif; ?>
   
</div>

<?php
    include('footer.php');
?>