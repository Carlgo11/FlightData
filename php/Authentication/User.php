<?php

namespace Flightdata\Authentication;

/**
 * User class
 *
 * @package Flightdata\Authentication
 */
class User
{
    protected $_username;
    protected $_passwordHash;
    protected $_firstName;
    protected $_lastName;
    protected $_email;
    protected $_ip;

    /**
     * Get the username.
     *
     * @return string|null Returns the username if available, otherwise NULL.
     */
    public function __toString() {
        return $this->_username;
    }

    /**
     * Get the username.
     *
     * @return string|null Returns the username if available, otherwise NULL.
     */
    public function getUsername() {
        return $this->_username;
    }

    /**
     * Set the username.
     *
     * @param string $username New username.
     * @return bool Returns TRUE if the change was successful, otherwise FALSE.
     */
    public function setUsername(string $username) {
        return ($this->_username = $username) !== NULL;
    }

    /**
     * Set the password hash.
     *
     * @param string $hash New password hash.
     * @return bool Returns TRUE if the change was successful, otherwise FALSE.
     */
    public function setPasswordHash(string $hash) {
        return ($this->_passwordHash = $hash) !== NULL;
    }

    /**
     * Verify password with stored password hash.
     *
     * @param string $password Password to compare with stored hash.
     * @return bool Returns TRUE if the password matches the hash, otherwise FALSE.
     */
    public function verifyPassword(string $password) {
        return password_verify($password, $this->_passwordHash);
    }

    /**
     * Get password hash.
     *
     * @return string|null Returns stored password hash if available, otherwise NULL.
     */
    public function getPasswordHash() {
        return $this->_passwordHash;
    }

    /**
     * Get user's first name.
     *
     * @return string|null Returns user's first name.
     */
    public function getFirstName() {
        return $this->_firstName;
    }

    /**
     * Set user's first name.
     *
     * @param string $firstName First name.
     * @return bool Returns TRUE if the change was successful, otherwise FALSE.
     */
    public function setFirstName(string $firstName) {
        return ($this->_firstName = $firstName) !== NULL;
    }

    /**
     * Get user's last name (surname).
     *
     * @return string|null Returns last name if available, otherwise FALSE.
     */
    public function getLastName() {
        return $this->_lastName;
    }

    /**
     * Set user's last name.
     *
     * @param string $lastName Last name.
     * @return bool Returns TRUE if the change was successful, otherwise FALSE.
     */
    public function setLastName(string $lastName) {
        return ($this->_lastName = $lastName) !== NULL;
    }

    /**
     * Set user's email address.
     *
     * @param string $email Email address to use.
     * @return bool Returns TRUE if the change was successful, otherwise FALSE.
     */
    public function setEmailAddress(string $email) {
        return ($this->_email = $email) !== NULL;
    }

    /**
     * Set the user's last used IP address.
     *
     * @param string $ip IP address to store.
     * @return bool Returns TRUE if the change was successful, otherwise FALSE.
     */
    public function setIPAddress(string $ip) {
        return ($this->_ip = $ip) !== NULL;
    }

    /**
     * Get last used IP address.
     *
     * @return string|null Returns last used IP address is defined, otherwise NULL.
     */
    public function getIPAddress() {
        return $this->_ip;
    }

    /**
     * Get the gravatar profile picture of the user.
     *
     * @param string $options Any optional options.
     * @return string Returns Gravatar profile picture URL.
     */
    public function getGravatarURI(string $options = "") {
        $url = "https://www.gravatar.com/avatar/";
        $email = strtolower($this->getEmailAddress());
        $hash = md5($email);
        return $url . $hash . $options;
    }

    /**
     * Get user's email address.
     *
     * @return string|null Returns the user's email address if defined, otherwise NULL.
     */
    public function getEmailAddress() {
        return $this->_email;
    }
}