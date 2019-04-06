<?php

namespace Flightdata\Flight;

use InvalidArgumentException;

/**
 * Airline class
 *
 * @package Flightdata\Flight
 */
class Airline
{

    protected $_airlineICAO;
    protected $_airlineIATA;
    protected $_name;
    protected $_fleet;
    protected $_twitter;
    protected $_facebook;
    protected $_website;
    protected $_callsign;

    /**
     * Airline constructor.
     *
     * @param array $data Any data to be parsed by the Airline constructor.
     */
    public function __construct(array $data = NULL) {
        if (isset($data['icao_code'])) $this->setICAO($data['icao_code']);
        if (isset($data['iata_code'])) $this->setIATA($data['iata_code']);
        if (isset($data['name'])) $this->setName($data['name']);
        if (isset($data['callsign'])) $this->setCallsign($data['callsign']);
    }

    /**
     * Set the ICAO code of the Airline.
     *
     * @see https://en.wikipedia.org/wiki/Airline_codes#ICAO_airline_designator
     * @param string $icao new ICAO code.
     * @return bool Returns TRUE if the change was successful, otherwise FALSE.
     */
    public function setICAO(string $icao) {
        $icao = filter_var($icao, FILTER_SANITIZE_STRING);
        if (strlen($icao) === 3)
            return ($this->_airlineICAO = $icao) !== NULL;
        throw new InvalidArgumentException("Airline ICAO codes has to be 3 characters long.");

    }

    /**
     * Set the IATA code of the Airline.
     *
     * @see https://en.wikipedia.org/wiki/Airline_codes#IATA_airline_designator
     * @param string $iata new IATA code.
     * @return bool Returns TRUE if the change was successful, otherwise FALSE.
     */
    public function setIATA(string $iata) {
        $iata = filter_var($iata, FILTER_SANITIZE_STRING);
        if (strlen($iata) === 2)
            return ($this->_airlineIATA = $iata) !== NULL;
        throw new InvalidArgumentException("Airline IATA codes has to be 2 characters long");
    }

    /**
     * Get the ICAO code of the Airline.
     *
     * @return string|null Returns the ICAO code if one has been set, otherwise NULL.
     * @see Airline::setICAO()
     */
    public function __toString() {
        return $this->_airlineICAO;
    }

    /**
     * Get the ICAO code of the Airline.
     *
     * @return string|null Returns the ICAO code if one has been set, otherwise NULL.
     * @see Airline::setICAO()
     */
    public function getICAO() {
        return $this->_airlineICAO;
    }

    /**
     * Get the IATA code of the Airline.
     *
     * @return string|null Returns the IATA code if one has been set, otherwise NULL.
     * @see Airline::setIATA()
     */
    public function getIATA() {
        return $this->_airlineIATA;
    }

    /**
     * Get the Airline display name.
     *
     * @return string|null Returns the name of the airline if one is set, otherwise NULL.
     */
    public function getName() {
        return $this->_name;
    }

    /**
     * Set the name of the Airline.
     *
     * @param string $name New airline name.
     * @return bool Returns TRUE if the change was successful, otherwise FALSE.
     */
    public function setName(string $name) {
        return ($this->_name = filter_var($name, FILTER_SANITIZE_STRING)) !== NULL;
    }

    /**
     * Get the URL of the Airline's official website.
     *
     * @return string|null Returns the URL as a string if a URL has been set, otherwise NULL.
     */
    public function getURL() {
        return $this->_website;
    }

    /**
     * Set the Airlines official website URL.
     *
     * @param string $url New URL.
     * @return bool Returns TRUE if the change was successful, otherwise FALSE.
     */
    public function setURL(string $url) {
        return ($this->_website = filter_var($url, FILTER_SANITIZE_URL)) !== NULL;
    }

    /**
     * Get the Twitter handle of the Airline if one is set.
     *
     * @return string|null Returns the Twitter handle if set, otherwise NULL.
     */
    public function getTwitter() {
        return $this->_twitter;
    }

    /**
     * Set the Airline Twitter handle.
     *
     * @param string $twitter New Twitter handle.
     * @return bool Returns TRUE if the change was successful, otherwise FALSE.
     * @throws InvalidArgumentException Throws exception if the $twitter handle doesn't conform to Twitter's handle rules.
     */
    public function setTwitter(string $twitter) {
        $twitter = filter_var($twitter, FILTER_SANITIZE_STRING);
        if (!preg_match_all('/(\w){1,15}$/', $twitter))
            throw new InvalidArgumentException("Twitter handle doesn't match the username format.");
        return ($this->_twitter = $twitter) !== NULL;
    }

    /**
     * Get the Facebook username of the Airline.
     *
     * @return string|null Returns the Facebook username if set, otherwise NULL.
     */
    public function getFacebook() {
        return $this->_facebook;
    }

    /**
     * Set the Facebook username of the Airline.
     *
     * @param string $facebook New Facebook username.
     * @return bool Returns TRUE if the change was successful, otherwise FALSE.
     * @throws InvalidArgumentException Throws exception if the facebook username doesn't conform to Facebook's username rules.
     */
    public function setFacebook(string $facebook) {
        if (!preg_match_all('/(\w){1,50}/', $facebook))
            throw new InvalidArgumentException("Facebook username is in an invalid format");
        return ($this->_facebook = $facebook) !== NULL;
    }

    /**
     * Get the callsign of the Airline.
     * Callsigns are often used when communicating with ATC on HF or VHF radio.
     *
     * @return string|null Returns the callsign if one is set, otherwise NULL.
     */
    public function getCallsign() {
        return $this->_callsign;
    }

    /**
     * Set the callsign of the airline.
     *
     * @param string $callsign New callsign.
     * @return bool Returns TRUE if the change was successful, otherwise FALSE.
     */
    public function setCallsign(string $callsign) {
        return ($this->_callsign = filter_var($callsign, FILTER_SANITIZE_STRING)) !== NULL;
    }

    /**
     * Get the fleet information of the airline.
     *
     * @return array|null Returns the fleet information if set, otherwise NULL.
     */
    public function getFleet() {
        return $this->_fleet;
    }

    /**
     * Set the fleet information of the airline.
     *
     * @param int $size Fleet size.
     * @param int $age Average fleet age.
     * @return bool Returns TRUE if the change was successful, otherwise FALSE.
     */
    public function setFleet(int $size, int $age) {
        $fleet['size'] = filter_var($size, FILTER_SANITIZE_NUMBER_INT);
        $fleet['age'] = filter_var($age, FILTER_SANITIZE_NUMBER_INT);
        return ($this->_fleet = $fleet) !== NULL;
    }
}