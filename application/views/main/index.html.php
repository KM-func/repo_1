<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/assets/less/style.css">
</head>
<body>
    <div class="wrapper">
        <header>
            <h2><a href="<?=base_url()?>">KM Store</a></h2> 
            <a href="<?= base_url().'main/cart' ?>" class="nav-link"> 
                Cart (<?=$unique_products['product_count']?>) 
            </a>
        </header> 
          
            <?= $this->session->flashdata("add_to_cart_success"); ?>
            
            <div class="item-container">
<?php   foreach($products as $product => $key){?>
                <div class="item">
                    <img src="/assets/imgs/<?=$key['product_name'].".jpg"?>" alt="Photo of a <?= $key['product_name'] ?>">
                    <p><span><?= $key['product_name'] ?></span> $<?= $key['price'] ?></p> 
                    <form method="POST" action="main/add_to_cart">
                        <input type="hidden" name="product_id" value="<?= $key['id']?>">

                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

                        <input type="number" name="quantity" min="0">
                        <input type="submit" value="Buy" class="submit">
                    </form>
                </div>
<?php   }?> 
            </div> 
    </div>
</body>
</html>