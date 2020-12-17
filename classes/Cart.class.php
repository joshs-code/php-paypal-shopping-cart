<?php

class Cart extends Db {

    public function getItems($id) {

        $sql = "SELECT * FROM products WHERE id = $id";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetch();
    }

    public function displayCartItems() {
        $total = 0;

        foreach($_SESSION as $key => $value) {
            if($value > 0) {
                if(substr($key, 0, 5) == 'cart_'){
                    // Gets item id
                    $id = substr($key, 5, strlen($key) - 5);
                    $row = $this->getItems($id);
                    $sub = number_format($row['price'] * $value, 2 );
                    echo '<p>'.$row['name'] . ' x ' . $value . ' = $' . $sub . '</p>';
                    
                }

                $total +=  $sub;
            }
        }
    }

    public function addItem() {
        if(isset($_GET['add'])){
            $_SESSION['cart_' . $_GET['add']]++;
            header('Location: index.php');
            exit();
    
        }
    }

    public function removeItem() {
        if($_SESSION['cart_' . $_GET['remove']] != 0)
            $_SESSION['cart_'.$_GET['remove']] = 0;
            header('Location: index.php');
            exit();
    }

    public function clearCart() {
        if($_SESSION['cart_' . $_GET['clear']] != 0)
            $_SESSION['cart_'.$_GET['clear']] = 0;
            header('Location: index.php');
            exit();
    }

    public function paypal_items() {
        $num = 0;

        foreach($_SESSION as $key => $value) {
            if($value > 0) {
                // Removes Session: cart_
                if(substr($key, 0, 5) == 'cart_'){
                    // Gets item id
                    $id = substr($key, 5, strlen($key) - 5);
                    $row = $this->getItems($id);
                    $num++;

                    echo '<input type="hidden" name="item_name_'.$num.'" value="'.$row['name'].'">';
                    echo '<input type="hidden" name="item_number_'.$num.'" value="'.$id.'">';
                    echo '<input type="hidden" name="amount_'.$num.'" value="'.$row['price'].'">';
                    echo '<input type="hidden" name="quantity_'.$num.'" value="'.$value.'">';
                }
            }
        }
    }
}