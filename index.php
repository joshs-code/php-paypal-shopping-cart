<?php 
    session_start();
    require('./autoload.php');
    $title = 'Home';
    include('./includes/header.inc.php'); 

    $cart = new Cart();

    if(isset($_GET['add']))
        $cart->addItem();
    if(isset($_GET['remove']))
        $cart->removeItem();
    if(isset($_GET['clear']))
        $cart->clearCart();
?>

<div class="container">
    <div class="row">
        <div class="col-md-12 mt-5 mb-5">
            <h2 class="text-center">CHECKOUT</h2>
            <div class="text-center">
            <?php $cart = new Cart(); ?>
            <?php $cart->displayCartItems(); ?>
            <input type="hidden" name="cmd" value="_ext-enter">
            <form action="https://www.sandbox.paypal.com/us/cgi-bin/webscr" method="post">
                <input type="hidden" name="cmd" value="_cart">
                <input type="hidden" name="upload" value="1">
                <input type="hidden" name="business" value="sb-rkhz34104956@business.example.com">
                <?php $cart->paypal_items(); ?>
                <input type="hidden" name="currency_code" value="USD">
                <input type="hidden" name="amount" value="<?php echo $total ?>">
                <input type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" name="submit"
                    alt="Make payments with PayPal - it's fast, free and secure!">
            </form>
            </div>
        </div>
        
        <?php 
            $products = new Products();
            $data = $products->allProducts();
            foreach($data as $i) :
        ?>
        <div class="col-md-4">
            <div class="card">
                <h4 class="card-title"><?= $i['name'] ?></h4>
                <p class="card-body">
                    <img class="img-fluid" src="<?= $i['product_img'] ?>" alt="">
                </p>
                <div class="card-footer">
                    <a href="index.php?add=<?= $i['id'] ?>" class="btn btn-primary">Add</a>
                    <a href="index.php?remove=<?= $i['id'] ?>" class="btn btn-danger">Remove</a>
                    <a href="index.php?clear=<?= $i['id'] ?>" class="btn btn-warning">clear</a>
                    <span>$<?=  $i['price'] ?></span>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>


<?php include('./includes/footer.inc.php'); ?>