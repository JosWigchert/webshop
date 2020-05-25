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

class WebshopShop {
    private $_db;

    /**
     * Checks for a database object and creates one if none is found
     *
     * @param object $db
     * @return void
     */
    public function __construct($db=NULL)
    {
        if(is_object($db))
        {
            $this->_db = $db;
        }
        else
        {
            $dsn = "mysql:host=".constant('DB_HOST').";dbname=".constant('DB_NAME');
            try {
                $this->_db = new PDO($dsn, constant('DB_USER'), constant('DB_PASS'));
            } catch(PDOException $e) {
                die("Connection Error: " . $e->getMessage());
            }
        }
    }

    public function getRootCategories()
    {
        $stmt = $this->_db->prepare("CALL getRootCategories();");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getChildCategories($parent)
    {
        $stmt = $this->_db->prepare("CALL getChildCategories(:parent);");
        $stmt->bindParam('parent', $parent);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getCategory($catID)
    {
        $stmt = $this->_db->prepare("CALL getCategory(:catID);");
        $stmt->bindParam('catID', $catID);
        $stmt->execute();
        return $stmt->fetch()[0];
    }

    public function getAllCategories()
    {
        $stmt = $this->_db->prepare("CALL getAllCategories();");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getProductsFromCategory($catID)
    {
        $stmt = $this->_db->prepare("CALL getProductsFromCategory(:catID);");
        $stmt->bindParam('catID', $catID);
        $stmt->execute() or die(print_r($stmt->errorInfo(), true));
        return $stmt->fetchAll();
    }

    public function getProductsFromCategoryInSale($catID)
    {
        $stmt = $this->_db->prepare("CALL getProductsFromCategoryInSale(:catID);");
        $stmt->bindParam('catID', $catID);
        $stmt->execute() or die(print_r($stmt->errorInfo(), true));
        return $stmt->fetchAll();
    }

    public function getAllProducts()
    {
        $stmt = $this->_db->prepare("CALL getAllProducts();");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllProductsInSale()
    {
        $stmt = $this->_db->prepare("CALL getAllProductsInSale();");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getProduct($productID)
    {
        $stmt = $this->_db->prepare("CALL getProduct(:productID);");
        $stmt->bindParam('productID', $productID);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function addProduct($name, $myImage, $thumb, $categoryID, $description, $price, $inSale, $salePrice)
    {
        $stmt = $this->_db->prepare("CALL addProduct(:name, :myImage, :thumb, :categoryID, :description, :price, :inSale, :salePrice);");
        $stmt->bindParam('name', $name);
        $stmt->bindParam('myImage', $myImage);
        $stmt->bindParam('thumb', $thumb);
        $stmt->bindParam('categoryID', $categoryID);
        $stmt->bindParam('description', $description);
        $stmt->bindParam('price', $price);
        $stmt->bindParam('inSale', $inSale);
        $stmt->bindParam('salePrice', $salePrice);
        $stmt->execute() or die(print_r($stmt->errorInfo(), true));
        return $stmt->fetchAll();
    }

    public function updateCategory($id, $name, $parentid)
    {
        $stmt = $this->_db->prepare("CALL updateCategory(:id, :name, :parentid);");
        $stmt->bindParam('id', $id);
        $stmt->bindParam('name', $name);
        $stmt->bindParam('parentid', $parentid);
        $stmt->execute() or die(print_r($stmt->errorInfo(), true));
        return $stmt->fetchAll();
    }

    public function updateProduct($ID, $name, $myImage, $thumb, $categoryID, $description, $price, $inSale, $salePrice)
    {
        $stmt = $this->_db->prepare("CALL updateProduct(:ID, :name, :myImage, :thumb, :categoryID, :description, :price, :inSale, :salePrice);");
        $stmt->bindParam('ID', $ID);
        $stmt->bindParam('name', $name);
        $stmt->bindParam('myImage', $myImage);
        $stmt->bindParam('thumb', $thumb);
        $stmt->bindParam('categoryID', $categoryID);
        $stmt->bindParam('description', $description);
        $stmt->bindParam('price', $price);
        $stmt->bindParam('inSale', $inSale);
        $stmt->bindParam('salePrice', $salePrice);
        $stmt->execute() or die(print_r($stmt->errorInfo(), true));
        return $stmt->fetchAll();
    }
    
    public function addToShoppingCart($username, $product, $amount)
    {
        $stmt = $this->_db->prepare("CALL addToShoppingCart(:username, :product, :amount);");
        $stmt->bindParam('username', $username);
        $stmt->bindParam('product', $product);
        $stmt->bindParam('amount', $amount);
        $stmt->execute() or die(print_r($stmt->errorInfo(), true));
        return $stmt->fetchAll();
    }

    public function getShoppingCart($username)
    {
        $stmt = $this->_db->prepare("CALL getShoppingCart(:username);");
        $stmt->bindParam('username', $username);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function checkout($username)
    {
        $stmt = $this->_db->prepare("CALL checkout(:username);");
        $stmt->bindParam('username', $username);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

?>