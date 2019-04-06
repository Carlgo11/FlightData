<?php

/**
 * Flight Class
 */
class Flight
{
    protected $_destination;
    protected $_origin;
    protected $_flightICAO;
    protected $_flightIATA;
    protected $_airplane;
    protected $_status;
    protected $_airline;

    /**
     * Flight constructor.
     *
     * @param array $data
     * @throws Exception
     */
    public function __construct(array $data = NULL) {
        if (isset($data['status'])) $this->setStatus($data['status']);
        if (isset($data['flight']['icao_number'])) $this->setFlightICAO($data['flight']['icao_number']);
        if (isset($data['flight']['iata_number'])) $this->setFlightIATA($data['flight']['iata_number']);

        if (isset($data['arrival'])) {
            require_once __DIR__ . '/Airport.php';
            $this->setDestination(new Flightdata\Flight\Airport($data['arrival']));
        }

        if (isset($data['departure'])) {
            require_once __DIR__ . '/Airport.php';
            $this->setOrigin(new Flightdata\Flight\Airport($data['departure']));
        }

        if (isset($data['aircraft'])) {
            require_once __DIR__ . '/Vehicle.php';
            require_once __DIR__ . '/Airplane.php';
            $this->setAirplane(new Flightdata\Flight\Airplane($data['aircraft']));
        }

        if (isset($data['airline'])) {
            require_once __DIR__ . '/Airline.php';
            $this->setAirline(new Flightdata\Flight\Airline($data['airline']));
        }
    }

    /**
     * Get the airline that operates the flight.
     * If several airlines operate the flight _(such as a joint flight between Delta, AirFrance and KLM)_ then only the main airline will be returned.
     *
     * @return \Flightdata\Flight\Airline Returns the airline that operates the flight.
     * @throws Exception Throws an exception if the output data isn't an {@see Airline} object.
     */
    public function getAirline() {
        if ($this->_airline instanceof Flightdata\Flight\Airline)
            return $this->_airline;
        throw new Exception("Airline is invalid.");
    }

    /**
     *
     * @param \Flightdata\Flight\Airline $airline
     * @return bool
     */
    public function setAirline(Flightdata\Flight\Airline $airline) {
        return ($this->_airline = $airline) !== NULL;
    }

    public function getFlightICAO() {
        return $this->_flightICAO;
    }

    public function setFlightICAO(string $icao) {
        return ($this->_flightICAO = $icao) !== NULL;
    }

    public function getFlightIATA() {
        return $this->_flightIATA;
    }

    public function setFlightIATA(string $iata) {
        return ($this->_flightIATA = $iata) !== NULL;
    }

    public function getOrigin() {
        if ($this->_origin instanceof Flightdata\Flight\Airport)
            return $this->_origin;
        throw new Exception("Origin airport is invalid.");
    }

    public function setOrigin(Flightdata\Flight\Airport $origin) {
        return ($this->_origin = $origin) !== NULL;
    }

    public function getDestination() {
        if ($this->_destination instanceof Flightdata\Flight\Airport)
            return $this->_destination;
        throw new Exception("Destination airport invalid.");
    }

    public function setDestination(Flightdata\Flight\Airport $destination) {
        return $this->_destination = $destination;
    }

    public function getAirplane() {
        if ($this->_airplane instanceof Flightdata\Flight\Airplane)
            return $this->_airplane;
        throw new Exception("Airplane invalid");
    }

    public function setAirplane(Flightdata\Flight\Airplane $airplane) {
        return ($this->_airplane = $airplane) !== NULL;
    }

    public function getStatus() {
        return $this->_status;
    }

    public function setStatus(string $status) {
        return ($this->_status = $status) !== NULL;
    }


}