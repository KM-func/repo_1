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
            
            <a href="<?= base_url() ?>" class="nav-link">Catalogue</a>
        </header> 
        <div class="content"> 
            <div>
                <h1>Check Out</h1>
                
                <?= $this->session->flashdata("remove_item"); ?>

                <h3>Total: $<?= $total["grand_total"]?></h3>
                <table>
                    <tr class="header">
                        <th>Item Name</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr> 
                    <tr class="gray"> 

<?php   foreach($cart_items as $item => $key){?>
<?php       if($item%2 == 0){ ?>
                        <tr class="gray">
<?php       } else{ ?>
                        <tr > 
<?php       } ?>
                            <td><?= $key["product_name"]?></td> 
                            <td><?= $key["quantity"]?></td>
                            <td>$<?= $key["price"] ?></td>
                            <td>
                                <form  action="/main/remove_item" method="POST">
                                    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />     
                                    <input type="hidden" name="product_id" value="<?= $key["product_id"]?>">
                                    <input type="submit" class="remove" value="X">                            
                                </form>
                            </td>
                        </tr>
<?php   }?>
                        <tr >
                            <td class="total" colspan="4">Total : $<?= (empty( $total["grand_total"])) ? "" : $total["grand_total"]?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div>
                <h1>Billing Info</h1>
                <form method="POST" action="/main/check_out">
                    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                    <label>Name: </label><input name="name" type="text">
                    <label>Address: </label><input name="address" type="text">
                    <label>Card Number: </label><input name="card_number" type="text">
                    <input type="submit" class="submit" value="Submit Order">
                </form>
            </div>
        </div>
        
    </div>
</body>
</html>