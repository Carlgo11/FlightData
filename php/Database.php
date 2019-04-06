<?php

namespace Flightdata;

use Flightdata\Authentication\User;

class Database
{

    protected $_conf;
    protected $_db;

    /**
     * Database constructor.
     */
    public function __construct() {
        $this->_conf = $conf = require_once(__DIR__ . '/config.php');
        $this->_db = mysqli_connect($conf['mysql-host'], $conf['mysql-user'], $conf['mysql-password'], $conf['mysql-database']) or $this->mySQLError($this->_db);
    }

    /**
     * Used when the script is unable to establish a connection to the MySQL server.
     * Outputs an error message and kills the session.
     *
     * @param mysqli $mysql_connection The failed MySQL connection.
     */
    private function mySQLError(mysqli $mysql_connection) {
        error_log('MySQL connection failed: ' . htmlspecialchars($mysql_connection->error));
        http_response_code(500);
        die("Connection to our database failed.");
    }

    /**
     * Get user's data from database.
     *
     * @param string $username Username of the user.
     * @return User Returns the user data in the form of a User object.
     */
    public function getUser(string $username) {
        $query = $this->_db->prepare("SELECT * FROM `user` LEFT JOIN `userdata` ON `userdata`.`username` = `user`.`username` WHERE `user`.`username` = ?");
        $query->bind_param("s", $username);
        $query->execute();
        $result = $query->get_result();
        $rows = $result->fetch_assoc();
        $query->close();

        $user = new User();

        //If data is unavailable from DB a Null pointer exception will be thrown.
        try {
            if(isset($rows['username']))$user->setUsername($rows['username']);
            if(isset($rows['password']))$user->setPasswordHash($rows['password']);
            if(isset($rows['firstname']))$user->setFirstName($rows['firstname']);
            if(isset($rows['lastname']))$user->setLastName($rows['lastname']);
            if(isset($rows['email']))$user->setEmailAddress($rows['email']);
            if(isset($rows['ip']))$user->setIPAddress($rows['ip']);
        } catch (Exception $ex) {
            error_log($ex);
        }
        return $user;
    }

    /**
     * Add a user to the database.
     *
     * @param User $user User object of which the user data is stored.
     * @return bool Returns TRUE if successful, otherwise FALSE.
     */
    public function addUser(User $user) {
        $username = $user->getUsername();
        $passwordHash = $user->getPasswordHash();
        $email = $user->getEmailAddress();
        $firstname = $user->getFirstName();
        $lastname = $user->getLastName();
        $ip = $user->getIPAddress();

        // As Mysql prepared statements only allow data to be inserted into one table, two queries are needed.
        $user_query = $this->_db->prepare("INSERT INTO `user` (`username`, `password`) VALUES (?, ?);");
        $userdata_query = $this->_db->prepare("INSERT INTO `userdata` (`username`, `firstname`, `lastname`, `email`, `ip`) VALUES (?, ?, ?, ?, ?)");
        $user_query->bind_param("ss", $username, $passwordHash);
        $userdata_query->bind_param("sssss", $username, $firstname, $lastname, $email, $ip);

        $user_query->execute();
        $userdata_query->execute();
        $user_query->close();
        $userdata_query->close();
        return TRUE;
    }


}