<div>
    <?php
        foreach($productList as $product){
            echo '<div>' . PHP_EOL . '<h1>' . $product->getName() . '</h1>';
            echo '<h2>' . $product->getPrice() . '</h2>';
            echo '<p>' . $product->getDescription() . '</p>' . PHP_EOL . '</div>';
        }
    ?>
</div>

