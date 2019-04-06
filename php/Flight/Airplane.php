<?php

namespace Flightdata\Flight;

/**
 * Airplane Class
 *
 * @package Flightdata\Flight
 */
class Airplane extends Vehicle
{
    protected $_tailNumber;
    protected $_factoryNumber;
    protected $_icaoHex;
    protected $_squawk;
    protected $_owner;

    /**
     * Airplane constructor.
     *
     * @param array $data Any data to be parsed by the Airplane constructor.
     */
    public function __construct(array $data = NULL) {
        if (isset($data['reg_number'])) $this->setTailNumber($data['reg_number']);
        if (isset($data['icao24'])) $this->setICAOHex($data['icao24']);
        if (isset($data['system']['squawk'])) $this->setSquawk($data['system']['squawk']);
        if (isset($data['construction_number'])) $this->setFactoryNumber($data['construction_number']);
        if (isset($data['icao_code'])) $this->setVehicleICAO($data['icao_code']);
        if (isset($data['iata_code'])) $this->setVehicleIATA($data['iata_code']);
        if (isset($data['name'])) $this->setName($data['name']);
        else if (isset($data['production_line'])) $this->setName($data['production_line']);
        if (isset($data['owner'])) $this->setOwner($data['owner']);
        if (isset($data['age'])) $this->setAge($data['age']);
    }

    /**
     * @return string|null Returns the tail number of the airline if set, otherwise NULL.
     */
    public function __toString() {
        return $this->_tailNumber;
    }

    /**
     * Get the tail number.
     *
     * @return string|null Returns the tail number of the airline if set, otherwise NULL.
     */
    public function getTailNumber() {
        return $this->_tailNumber;
    }

    /**
     * Set the tail number of the aircraft.
     *
     * @param string $tailNumber New tail number.
     * @return bool Returns TRUE if the change was successful, otherwise FALSE.
     */
    public function setTailNumber(string $tailNumber) {
        return ($this->_tailNumber = filter_var($tailNumber, FILTER_SANITIZE_STRING)) !== NULL;
    }

    /**
     * Get the factory number.
     *
     * @return int|null Returns the factory number of the aircraft if available, otherwise NULL.
     */
    public function getFactoryNumber() {
        return $this->_factoryNumber;
    }

    /**
     * Set the aircraft factory number.
     *
     * @param int $factoryNumber New factory number.
     * @return bool Returns TRUE if the change was successful, otherwise FALSE.
     */
    public function setFactoryNumber(int $factoryNumber) {
        return ($this->_factoryNumber = filter_var($factoryNumber, FILTER_SANITIZE_NUMBER_INT)) !== NULL;
    }

    /**
     * Get the ICAO hex (also called ICAO24) of the aircraft.
     * ICAO hex is a number used to identify aircrafts on ADS-B receivers.
     *
     * @return string|null Returns the aircraft ICAO hex number if available, otherwise NULL.
     */
    public function getICAOHex() {
        return $this->_icaoHex;
    }

    /**
     * Set the ICAO hex number of the aircraft.
     *
     * @param string $icaoHex New ICAO hex number.
     * @return bool Returns TRUE if the change was successful, otherwise FALSE.
     * @see Airplane::getICAOHex()
     */
    public function setICAOHex(string $icaoHex) {
        return ($this->_icaoHex = filter_var($icaoHex, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_ALLOW_HEX)) !== NULL;
    }

    /**
     * Get the current squawk of the aircraft.
     * Squawk codes are used by ATC to identify aircrafts on secondary radar.
     *
     * @see https://en.wikipedia.org/wiki/Transponder_(aeronautics)
     * @return int|null Returns the current squawk code if available, otherwise NULL.
     */
    public function Getquawk() {
        return $this->_squawk;
    }

    /**
     * Set the current squawk code of the aircraft.
     *
     * @param int $squawk New squawk code.
     * @return bool Returns TRUE if the change was successful, otherwise FALSE.
     * @see Airplane::Getquawk()
     */
    public function setSquawk(int $squawk) {
        return ($this->_squawk = filter_var($squawk, FILTER_SANITIZE_NUMBER_INT)) !== NULL;
    }

    /**
     * Get the current owner of the aircraft.
     *
     * @return string|null Returns the owner of the aircraft if available, otherwise NULL.
     */
    public function getOwner() {
        return $this->_owner;
    }

    /**
     * Set the current owner of the aircraft.
     *
     * @param string $owner Aircraft owner.
     * @return bool Returns TRUE if the change was successful, otherwise FALSE.
     */
    public function setOwner(string $owner) {
        return ($this->_owner = filter_var($owner, FILTER_SANITIZE_STRING)) !== NULL;
    }
}