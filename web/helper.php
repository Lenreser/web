<?php
    define('DB_HOST','localhost');
    define('DB_USER','root');
    define('DB_PASSWORD','');
    define('DB_NAME','assignment');
    
    
function htmlInputText($name, $value = '', $maxlength = '')
{
    printf('<input type="text" name="%s" id="%s" value="%s" maxlength="%s" />',
           $name, $name, $value, $maxlength);
    
}

function htmlInputHidden($name, $value = '')
{
    printf('<input type="hidden" name="%s" id="%s" value="%s" />' . "\n",
           $name, $name, $value);
}

function htmlSelect($name, $items, $selectedValue = '', $default = '')
{
    printf('<select name="%s" id="%s">' . "\n",
           $name, $name);

    if ($default != null)
    {
        printf('<option value="">%s</option>', $default);
    }

    foreach ($items as $value => $text)
    {
        printf('<option value="%s" %s>%s</option>' . "\n",
               $value,
               $value == $selectedValue ? 'selected="selected"' : '',
               $text);
    }
    
    echo "</select>\n";
}

function validateProductID($id)
{   printf('dsadsad');
    if($id == null)
    {
        return 'Please enter <strong>Product ID</Strong>';
    }
    else if(!preg_match('/[A-Z]\d{4}/',$id))
    {
        return '<strong>Product ID</strong> is invalid format. Format : X9999';
    }
    else if(isProductIDExist($id))
    {
        return '<strong>Product ID</strong> given already exist. Try another..';
    }
}

function isProductIDExist($id)
{
    $isExist = false;
    
    $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die('Could not connect to MySQL : '. mysqli_connect_error());
    $id = $con->real_escape_string($id);
    $sql = "SELECT * FROM product WHERE id = '$id'";
    
    $result = mysqli_query($con, $sql);
    
    if($result && mysqli_num_rows($result) > 0)
    {
        $isExist = true;
    }
    
    return $isExist;
}

function validateProductName($name)
{
    if($name == null)
    {
        return 'Please enter <strong>Product Name</strong>';
    }
    else if(strlen($name) > 255)
    {
        return '<strong>Product Name</strong> must not more than 255 letters';
    }
    else if(!preg_match('/^[A-Za-z &,\'\,\-,\/,\#,\$,^\d]+$/',$name))
    {
        return 'There are invalid letters in <strong>Product Name</strong>';
    }
}

function validateDescription($description)
{
    if($description == null)
    {
        return 'Please enter <strong>Product Description</strong>';
    }
    else if(strlen($description) > 2000)
    {
        return '<strong>Product Description</strong> must not more than 2000 letters';
    }
}

function validateShortDescription($shortDescription)
{
    if($shortDescription == null)
    {
        return 'Please enter <strong>Product Short Description</strong>';
    }
    else if(strlen($shortDescription) > 500)
    {
        return '<strong>Product Short Description</strong> must not more than 500 letters';
    }
}

function validateQty($quantity)
{
    if($quantity == null)
    {
        return "Please enter <strong>Quantity</strong>";
    }
    else if(!preg_match('/^\d+$/',$quantity))
    {
        return '<strong>Quantity</strong> only allow interger.';
    }
    else if($quantity > 10000)
    {
        return '<strong>Qunatity</strong> are not allow more then 10000';
    }
}

function validatePrice($price)
{
    if($price == null)
    {
        return 'Please enter <strong>Product Price</strong>';
    }
    else if(!preg_match('/^\d+(\.\d{2})+$/',$price))
    {
        return '<strong>Product Price</strong> is invalid format. Format : 999.99';
    }
}

?>




