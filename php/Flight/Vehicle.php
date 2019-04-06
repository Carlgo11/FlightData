<?php

namespace Flightdata\Flight;


class Vehicle
{
    protected $_manufacture;
    protected $_vehicleICAO;
    protected $_vehicleIATA;
    protected $_name;
    protected $_type;
    protected $_age;

    /**
     * Get vehicle model ICAO code.
     *
     * @return string|null Returns vehicle model ICAO code.
     */
    public function __toString() {
        return $this->_vehicleICAO;
    }

    /**
     * Get the manufacture name.
     *
     * @return string|null Returns the manufacture name if defined, otherwise NULL.
     */
    public function getManufacture() {
        return $this->_manufacture;
    }

    /**
     * Set the vehicle manufacture name.
     *
     * @param string $manufacture Manufacture name.
     * @return bool Returns TRUE if the change was successful, otherwise FALSE.
     */
    public function setManufacture(string $manufacture) {
        return ($this->_manufacture = $manufacture) !== NULL;
    }

    /**
     * Get the vehicle model name.
     *
     * @return string|null Returns the vehicle name if available, otherwise NULL.
     */
    public function getName() {
        return $this->_name;
    }

    /**
     * Set the vehicle model name.
     *
     * @param string $name Vehicle name.
     * @return bool Returns TRUE if the change was successful, otherwise FALSE.
     */
    public function setName(string $name) {
        return ($this->_name = $name) !== NULL;
    }

    /**
     * Get the vehicle model ICAO code.
     *
     * @return string|null Returns the vehicle ICAO code if available, otherwise NULL.
     */
    public function getVehicleICAO() {
        return $this->_vehicleICAO;
    }

    /**
     * Set the vehicle model ICAO code.
     *
     * @param string $icao Vehicle model ICAO code.
     * @return bool Returns TRUE if the change was successful, otherwise FALSE.
     */
    public function setVehicleICAO(string $icao) {
        return ($this->_vehicleICAO = $icao) !== NULL;
    }

    /**
     * Get the vehicle IATA code.
     *
     * @return string|null Returns the vehicle model IATA code.
     */
    public function getVehicleIATA() {
        return $this->_vehicleIATA;
    }

    /**
     * Set the vehicle IATA code.
     *
     * @param string $iata Vehicle model IATA code.
     * @return bool Returns TRUE if the change was successful, otherwise FALSE.
     */
    public function setVehicleIATA(string $iata) {
        return ($this->_vehicleIATA = $iata) !== NULL;
    }

    /**
     * Get the age of the vehicle.
     *
     * @return int|null Returns the age in number of years if defined, otherwise NULL.
     */
    public function getAge() {
        return $this->_age;
    }

    /**
     * Set the age of the vehicle.
     *
     * @param int $age Age in number of years.
     * @return bool Returns TRUE if the change was successful, otherwise FALSE.
     */
    public function setAge(int $age) {
        return ($this->_age = $age) !== NULL;
    }
}