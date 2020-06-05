<?php
/**
 * Handles user interactions within the app
 *
 * PHP version 7.4.4
 *
 * @author Jos Wigchert
 * @copyright 
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 *
 */

include_once $_SERVER['DOCUMENT_ROOT'] . "/common/var.php";

class product {
    private $_db;


    public static function printProduct($product)
    {
        $productHTML = '
        <div class="col-sm-4"> 
            <img src="data:image/jpeg;base64, ' . base64_encode($product['picSmall']) . '" alt="' . $product['name'] . '">
            <a class="a" href="/pages/product.php?product=' . $product['ID'] . '"><h4>' . $product['name'] . '</h4></a>
            <p>' . $product['descrSmall'] . '</p>
            <div class="row">';
            if ($product['sale'] == 1)
            {
                $productHTML = $productHTML . '<div class="price col-sm-4">' . $product['newPrice'] . '</div>';
                $productHTML = $productHTML . '<div class="old-price col-sm-4">' . $product['price'] . '</div>';
            }
            else
            {
                $productHTML = $productHTML . '<p><div class="price">' . $product['price'] . '</div></p>';
            }
        $productHTML = $productHTML . ' </div>
        </div>
        ';

        echo $productHTML;
    }

    public static function printProductUpdate($product)
    {
        echo '<hr>';

        include_once $_SERVER['DOCUMENT_ROOT'] . "/php/class.shop.php";
        $shop = new WebshopShop();

        $categories = $shop->getAllCategories();
        echo '
        <li><form class="flex-box-container" action="/admin/updateItem.php" method="post" enctype="multipart/form-data">
            <span class="flex-item-10">Name</span>
            <input class="flex-item-20 input" type="text" name="productName" value="' . $product['name'] . '">

            <span class="flex-item-10">Product Image</span>
            <label class="file flex-item-30">
                <input type="file" name="img" id="img" aria-label="File browser">
                <span class="file-custom"></span>
            </label>


            <button class="flex-item-30 input" name="productID" value="' . $product['ID'] . '" type="submit">Update Product</button>
            <input type="hidden" name="updateType" value="Product">


            <span class="flex-item-10">Category</span>
            <select class="flex-item-30" name="categoryID">
                <option value="-1">None</option>';
            foreach ($categories as $row)
            {
                echo '<option value="' . $row['ID'] . '"';
                if ($row['ID'] == $product['categoryID'])
                {
                    echo 'selected';
                }
                echo '>' . $row['name'] . '</option>';
            }
            echo '
            </select>

            <span class="flex-item-10">Price</span>
            <input class="flex-item-10" type="number" name="price" id="price" placeholder="price" '; echo ($product['price']) ? 'value=' . $product['price'] : ''; echo ' min="0" step=".01">

            <div class="flex-item-10 flex-box-container-col">
                <input type="checkbox" name="inSale" id="inSale" '; echo ($product['sale']) ? 'checked ' : ''; echo '>
                <div>In Sale</div>
            </div>

            <span class="flex-item-10">Price when in sale</span>
            <input class="flex-item-10" type="number" name="salePrice" id="salePrice" placeholder="price" '; echo ($product['newPrice']) ? 'value=' . $product['newPrice'] : ''; echo ' min="0" step=".01">


            <span class="flex-item-10">Descrition</span>

            <textarea  class="flex-item-90 description-input" name="description" id="description" cols="30" rows="10">' . $product['descrLarge'] . '</textarea>

        </form></li>';
    }

    public static function printCategoryUpdate($category)
    {
        echo '<hr>';

        include_once $_SERVER['DOCUMENT_ROOT'] . "/php/class.shop.php";
        $shop = new WebshopShop();

        $categories = $shop->getAllCategories();

        echo '
        <li><form class="flex-box-container" action="/admin/updateItem.php" method="post">
            <span class="flex-item-10">Name</span>
            <input class="flex-item-20" type="text" name="categoryName" value="' . $category['name'] . '">

            <span class="flex-item-10">Parent Category</span>
            <select class="flex-item-40" name="parentID">
                <option value="-1">None</option>';
            foreach ($categories as $row)
            {
                echo '<option value="' . $row['ID'] . '"';
                if ($row['ID'] == $category['parentID'])
                {
                    echo 'selected';
                }
                echo '>' . $row['name'] . '</option>';
            }
        echo '
            </select>

            <button class="flex-item-20 input" name="categoryID" value="' . $category['ID'] . '" type="submit">Update Category</button>
            <input type="hidden" name="updateType" value="Category">
        </form></li>';
    }

    public static function printShoppingCartItem($shoppingCartItem)
    {
        echo '<hr>';

        include_once $_SERVER['DOCUMENT_ROOT'] . "/php/class.shop.php";
        $shop = new WebshopShop();

        $product = $shop->getProduct($shoppingCartItem['productID']);

        echo '
        <li><form class="flex-box-container" action="/pages/updateShoppingCart.php" method="post">
            <img class="img-fluid flex-item-20" src="data:image/jpeg;base64, ' . base64_encode($product['picSmall']) . '" alt="' . $product['name'] . '">
            <span class="flex-item-20">' . $product['name'] . '</span>
            <div class="quantity flex-item-10">
                <button class="plus-btn item-30" type="button" name="button">
                    <img class="img-fluid" src="/img/plus.png" alt="" />
                </button>
                <input class="quantity-input item-40" type="text" pattern="[0-9]" name="amount" value="' . $shoppingCartItem['quantity'] . '">
                <button class="minus-btn item-30" type="button" name="button">
                    <img class="img-fluid" src="/img/minus.png" alt="" />
                </button>
            </div>

            <div class="price flex-item-10">'; echo ($product['inSale'] == 1) ? $product['salePrice'] : $product['price']; echo '</div>
            
            <button class="flex-item-30" type="submit" name="product" value="' . $shoppingCartItem['productID'] . '">update item</button>
        </form></li>';

    }

    public static function printOrderItem($orderID)
    {
        echo '<hr>';

        include_once $_SERVER['DOCUMENT_ROOT'] . "/php/class.shop.php";
        $shop = new WebshopShop();

        $order = $shop->getOrderContents($orderID[0]);

        echo '<li>';
        echo '<h3>Order ' . $orderID[0] . '</h3>';
        foreach ($order as $row)
        {
            echo '<h4><p>' . $row['strName'] . ' -> ' . $row['quantity'] . '</p></h4>';
        }

        echo '<form action="/pages/orderUpdate.php" method="post">';
        echo '<button type="submit" name="orderID" value="' . $orderID[0] . '">Mark as received</button>';
        echo '</form>';


        echo '</li>';
    }
}

?>