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

class WebshopUser {
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

    public function finishUser($username, $firstname, $lastname, $streetName, $streetNummer, $postcode, $city, $land, $password, $verificationHash)
    {
        $stmt = $this->_db->prepare("CALL finishUser(:username, :firstname, :lastname, :streetName, :streetNummer, :postcode, :city, :land, :password, :verificationHash);");
        $stmt->bindParam('username', $username);
        $stmt->bindParam('firstname', $firstname);
        $stmt->bindParam('lastname', $lastname);
        $stmt->bindParam('streetName', $streetName);
        $stmt->bindParam('streetNummer', $streetNummer);
        $stmt->bindParam('postcode', $postcode);
        $stmt->bindParam('city', $city);
        $stmt->bindParam('land', $land);
        $stmt->bindParam('password', $password);
        $stmt->bindParam('verificationHash', $verificationHash);
        if($stmt->execute()):
            return $stmt->fetch()['error'];
        else:
            return -3;
        endif;
    }

    public function createUser($email, $verificationHash)
    {
        $stmt = $this->_db->prepare("CALL createUser(:email, :verificationHash);");
        $stmt->bindParam('email', $email);
        $stmt->bindParam('verificationHash', $verificationHash);
        if($stmt->execute()):
            return $stmt->fetch()['error'];
        else:
            return -2;
        endif;
    }

    public function login($username, $password)
    {
        $stmt = $this->_db->prepare("CALL login(:username, :pw);");
        $stmt->bindParam('username', $username);
        $stmt->bindParam('pw', $password);
        if($stmt->execute()):
            $id = $stmt->fetch()[0];
            return $id;
        else:
            return -3;
        endif;
    }

    public function getUserInfo($username)
    {
        $stmt = $this->_db->prepare("CALL getUser(:username);");
        $stmt->bindParam('username', $username);
        $stmt->execute();

        return $stmt->fetch();

    }

}

?>