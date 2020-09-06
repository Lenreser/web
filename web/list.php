<?php
    $PAGE_TITLE = 'list';
    include('header.php');
?>

<div>
    
    <h1>List Product</h1>
    
    <table border="1" cellspacing="0" cellpadding="5">
        <tr>
            <th>Product ID</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Short Description</th>
            <th>Description</th>
        </tr>
        
        <?php
            require_once('helper.php');
            $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die('Could not connect to MySQL : '. mysqli_connect_error());
            $sql = "SELECT * FROM product";
            
            $result = mysqli_query($con, $sql);
            if($result)
            {
                while($row = mysqli_fetch_array($result))
                {
                    printf(               
                    '<tr>'
                        . '<td>%s</td>'
                        . '<td>%s</td>'
                        . '<td>%s</td>'
                        . '<td>%s</td>'
                        . '<td>%s</td>'
                        . '<td>%s</td>'   
                        . '<td><a href="edit.php?id=%s"/>Edit</a></td>'
                        . '<td><a href="delete.php?id=%s"/>Delete</a></td>'
                    . '</tr>'
                    ,$row['id'], $row['name'], $row['qty'], $row['price'], $row['short_desc'], $row['description'] ,$row['id'], $row['id']);
                
                }           
            }
            
            
            mysqli_free_result($result);
            mysqli_close($con);
        ?>
        
        
    </table>
    
    
    
</div>




<?php
    include('footer.php');
?>
