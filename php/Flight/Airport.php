<?php

namespace Flightdata\Flight;

use InvalidArgumentException;

/**
 * Airport class
 *
 * @package Flightdata\Flight
 */
class Airport
{
    protected $_name;
    protected $_airportIATA;
    protected $_airportICAO;
    protected $_website;
    protected $_city;
    protected $_country;


    /**
     * Airport constructor.
     *
     * @param array $data Any data to be parsed by the Airport constructor.
     * @throws InvalidArgumentException Throws an exception if any of the data is invalid.
     */
    public function __construct(array $data = NULL) {
        if (isset($data)) {
            if (isset($data['icao_code'])) $this->setICAO($data['icao_code']);
            if (isset($data['iata_code'])) $this->setIATA($data['iata_code']);
            if (isset($data['name'])) $this->setName($data['name']);
            if (isset($data['website'])) $this->setWebsite($data['website']);
            if (isset($data['city'])) $this->setCity($data['city']);
            if (isset($data['country_name'])) $this->setCountry($data['country_name']);

        }
    }

    /**
     * Set the Airport ICAO code.
     *
     * @see https://en.wikipedia.org/wiki/ICAO_airport_code
     * @param string $icao New airport ICAO code.
     * @return bool Returns TRUE if the change was successful, otherwise FALSE.
     * @throws InvalidArgumentException Throws an exception if the $icao code doesn't comply with ICAO standards.
     */
    public function setICAO(string $icao) {
        // Filter $icao and make uppercase.
        $icao = strtoupper(filter_var($icao, FILTER_SANITIZE_STRING));
        // Make sure $icao is 4 chars long and only letters.
            if (preg_match_all('/^[A-Z]{4}/', $icao))
                return ($this->_airportICAO = $icao) !== NULL;
        throw new InvalidArgumentException("Airport ICAO code match ICAO guidelines.");
    }

    /**
     * Set the Airport IATA code.
     *
     * @see https://en.wikipedia.org/wiki/IATA_airport_code
     * @param string $iata New airport IATA code.
     * @return bool Returns TRUE if the change was successful, otherwise FALSE.
     * @throws InvalidArgumentException Throws and exception if the $iata code doesn't comply with IATA standards.
     */
    public function setIATA(string $iata) {
        // Filter $iata and make uppercase.
        $iata = strtoupper(filter_var($iata, FILTER_SANITIZE_STRING));
        // Make sure $iata is 3 chars long and only letters.
            if (preg_match_all('/^[A-Z]{3}$/', $iata))
                return ($this->_airportIATA = $iata) !== NULL;
        throw new InvalidArgumentException("Airport IATA code doesn't match IATA guidelines.");
    }

    /**
     * Get the airport ICAO code.
     *
     * @return string|null Returns the Airport ICAO code.
     */
    public function __toString() {
        return $this->_airportICAO;
    }

    /**
     * Get the airport IATA code.
     *
     * @return string|null Returns the Airport IATA code if available, otherwise NULL.
     * @see Airport::setIATA()
     */
    public function getIATA() {
        return $this->_airportIATA;
    }

    /**
     * Get the airport ICAO code.
     *
     * @return string|null Returns the Airport ICAO code if available, otherwise NULL.
     * @see Airport::setICAO()
     */
    public function getICAO() {
        return $this->_airportICAO;
    }

    /**
     * Get the official website of the airport.
     *
     * @return string|null Returns the Airport's website URL if available, otherwise NULL.
     * @see Airport::setWebsite()
     */
    public function getWebsite() {
        return $this->_website;
    }

    /**
     * Set the official website URL of the airport.
     *
     * @param string $url New URL.
     * @return bool Returns TRUE if the change was successful, otherwise FALSE.
     */
    public function setWebsite(string $url) {
        return ($this->_website = filter_var($url, FILTER_SANITIZE_URL)) !== NULL;
    }

    /**
     * Get the airport name.
     *
     * @return string|null Returns the airport name if available, otherwise NULL.
     * @see Airport::setName()
     */
    public function getName() {
        return $this->_name;
    }

    /**
     * Set the official airport name.
     *
     * @param string $name New name.
     * @return bool Returns TRUE if the change was successful, otherwise FALSE.
     */
    public function setName(string $name) {
        return ($this->_name = filter_var($name, FILTER_SANITIZE_STRING)) !== NULL;
    }


    /**
     * Get the city in which the airport is located.
     *
     * @return string|null Returns the city name of which the airport is located in if set, otherwise NULL.
     * @see Airport::setCity()
     */
    public function getCity() {
        return $this->_city;
    }

    /**
     * Set the city of which the airport is located.
     *
     * @param string $city Full city name.
     * @return bool Returns TRUE if the change was successful, otherwise FALSE.
     * @see Airport::getCity()
     */
    public function setCity(string $city) {
        return ($this->_city = filter_var($city, FILTER_SANITIZE_STRING)) !== NULL;
    }

    /**
     * Get the country of which the airport is located.
     *
     * @return string|null Returns the country name of which the airport is located in if available, otherwise NULL.
     * @see Airport::setCountry()
     */
    public function getCountry() {
        return $this->_country;
    }

    /**
     * Set the country of which the airport is located in.
     *
     * @param string $country Full country name.
     * @return bool Returns TRUE if the change was successful, otherwise FALSE.
     * @see Airport::getCountry()
     */
    public function setCountry(string $country) {
        return ($this->_country = filter_var($country, FILTER_SANITIZE_STRING)) !== NULL;
    }
}