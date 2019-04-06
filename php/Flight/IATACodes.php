<?php

namespace Flightdata\Flight;

use DateTime;
use Exception;

/**
 * Class IATACodes
 *
 * @copyright
 * @author Carlgo11
 * @package Flightdata\Flight
 */
class IATACodes
{
    protected $api_key;
    protected $_version;
    protected $_url = "http://iatacodes.org/api/";
    protected $_method;
    protected $_params;
    protected $_response;
    protected $_request;

    /**
     * IATACodes constructor.
     *
     * @param int $version Version of the API to use. Default is version 7.
     * @param String $method IATACode method/(category) to use for the query. See {@see IATACodes::setMethod}.
     */
    public function __construct(int $version = 7, String $method = NULL) {
        $conf = require(__DIR__ . '/../config.php');
        $this->setAPIKey($conf["IATACodes-API-Key"]);
        $this->setVersion($version);
        if (!empty($method)) $this->setMethod($method);
        $this->_method = $method;
    }

    /**
     * Set the API key that's used when executing the query.
     *
     * @param string $key New API Key to use.
     * @return bool Returns TRUE if the change was successful, otherwise FALSE.
     */
    public function setAPIKey(string $key) {
        return ($this->api_key = $key) !== NULL;
    }

    /**
     * Specifies the version of the API to use. Default is `7`.
     *
     * @param int $version Version of the API to use.
     * @return bool Returns TRUE if the version was successfully changed, otherwise FALSE.
     * @example setVersion(7);
     */
    public function setVersion(int $version) {
        return ($this->_version = 'v' . $version) !== NULL;
    }

    /**
     * Set the method (category) to use when calling the IATACodes.org API.
     *
     * The available methods for version 7 are:
     * * Aircrafts
     * * Airlines
     * * Airports
     * * Airplanes
     * * Autocomplete
     * * Cities
     * * Counties
     * * Flights
     * * Taxes
     * * Timezones
     * * Timetable
     * * Routes
     * * Mixed
     *
     * @param string $method
     * @return bool Returns TRUE if the method was successfully set, otherwise FALSE.
     * @example setMethod('flights');
     */
    public function setMethod(string $method) {
        return ($this->_method = strtolower($method)) !== NULL;
    }

    /**
     * Set the URL used for the query. Default is `http://iatacodes.org/api/`.
     *
     * @param string $url New API URL.
     * @return bool Returns TRUE if the URL was successfully set, otherwise FALSE.
     */
    public function setURL(string $url) {
        return ($this->_url = $url) !== NULL;
    }

    /**
     * Set parameters to the query.
     *
     * @param string $name Name of the parameter (function)
     * @param string $value Parameter value.
     * @return bool Returns TRUE if the parameter was successfully set, otherwise FALSE.
     * @example addParam('reg_number', 'EI-LNA');
     */
    public function addParam(string $name, $value) {
        $filtered_name = filter_var($name, FILTER_SANITIZE_STRING);
        $filtered_value = filter_var($value, FILTER_SANITIZE_STRING);
        return ($this->_params .= "&" . $filtered_name . "=" . $filtered_value) !== NULL;
    }

    /**
     * Sends the query to the API.
     * Use @see getResponse for the result.
     *
     * @return string Returns the full URI used for the query.
     * @throws Exception Throws an exception if one or more parameters haven't been set before executing the query.
     */
    public function execute() {
        // Make sure all parameters have been set.
        if (in_array(NULL, [
            $this->api_key,
            $this->_url,
            $this->_params,
            $this->_method,
            $this->_version
        ]))
            throw new Exception("One or more required parameters haven't been set.");

        // Complete URI that the request will be sent to.
        $uri = $this->_url . $this->_version . "/" . $this->_method . "/?api_key=" . $this->api_key . $this->_params;
        $result = json_decode(file_get_contents($uri), TRUE);

        $this->_request = $result['request'];
        $this->_response = $result['response'];

        // Return complete URI in case the response needs to be debugged.
        return $uri;
    }

    /**
     * Get the output from the API query.
     *
     * @return array|bool Returns an array of the response from IATACodes.org if one was received, otherwise FALSE.
     */
    public function getResponse() {
        if (isset($this->_response) && is_array($this->_response))
            return $this->_response;
        return FALSE;
    }

    /**
     * Returns a string describing why a query failed.
     *
     * @return bool|string Returns a the reason for the failed query if one was found, otherwise TRUE.
     * @throws Exception Throws an error if the expiry date provided by the API was invalid.
     */
    public function GetError() {
        $request = $this->_request;

        if ($request['karma']['is_blocked']) return "Request blocked";
        if ($request['key']['type'] === 'demo') return "Demo account. Get an API key";
        $expiry = new DateTime($request['key']['expired']);
        $today = new DateTime();
        if ($expiry < $today) return "Key has expired. Renew your subscription.";
        return TRUE;
    }

}
