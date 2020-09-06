<?php
    $PAGE_TITLE = 'Insert';
    include('header.php');
?>

<div>
    <h1>Insert Product</h1>
    
    <?php
    require_once('helper.php');
    $id                 = '';
    $name               = '';
    $quantity           = '';
    $price              = '';
    $description        = '';
    $shortDescription   = '';
    
    
    
    if(isset($_POST['insert']))
    {
        $id                 = strtoupper(trim($_POST['id']));
        $name               = trim($_POST['name']);
        $quantity           = trim($_POST['quantity']);
        $price              = trim($_POST['price']);
        $description        = trim($_POST['description']);
        $shortDescription   = trim($_POST['shortDescription']);
        
        $error['id']                = validateProductID($id);
        $error['name']              = validateProductName($name);
        $error['quantity']          = validateQty($quantity);
        $error['price']             = validatePrice($price);
        $error['description']       = validateDescription($description);
        $error['shortDescription']  = validateShortDescription($shortDescription);
        $error = array_filter($error);
        
        if(empty($error))
        {
            $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die('Could not connect to MySQL : '. mysqli_connect_error());
            $sql = "INSERT INTO product(id, name, qty, price, description, short_desc) VALUES ('$id', '$name', '$quantity', '$price', '$description', '$shortDescription')";
            $result = mysqli_query($con, $sql);
            
            if(mysqli_affected_rows($con) > 0)
            {
                printf('<div>Product <strong>%s</strong> has been inserted.</div>',$name);
                $id                 = null;
                $name               = null;
                $price              = null;
                $quantity           = null;
                $description        = null;
                $shortDescription   = null;
            }
            else
            {
                printf('<div>Opps. Database issue. Record not inserted. Message : %s</div>', mysqli_error($con));
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
    
    <form action="" method="post"> 
        <table cellpadding="5" cellspacing="0">
            <tr>
                <td><label for="id">Product ID </label></td>
                <td><?php htmlInputText('id',$id,5) ?></td>
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
        
        <input type="submit" name="insert" value="Insert" />
        <input type="button" value="Cancel" onclick="location='list.php'" />
        
    </form>
    
</div>

<?php
    include('footer.php');
?>
