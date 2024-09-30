<?php

namespace App\Service;

/**
 * Class ApiService
 * 
 * @apiservice 
 * 
 * https://www.weatherapi.com/docs/
 * 
 * A service class for interacting with the WeatherAPI.
 */
class ApiService
{
    /**
     * The base URL for the WeatherAPI service.
     * 
     * This constant stores the root URL used for making requests to the WeatherAPI.
     */
    private const URL = 'http://api.weatherapi.com';

    /**
     * The API token for authentication.
     * 
     * This property holds the API key that is required to authenticate all requests to the WeatherAPI.
     * It is initialized in the constructor.
     *
     * @var string
     */
    private string $token;

    /**
     * The request parameters for the API.
     * 
     * This property holds an associative array of parameters to be sent with the API request.
     * It is set using the `setArguments` method.
     *
     * @var array
     */
    private array $arguments;

    /**
     * Constructor to initialize the API token.
     *
     * When creating an instance of this class, an API token must be provided. This token is required for authenticating all API requests.
     * After initializing the class with the token, you can build the request by setting the necessary parameters using the `setArguments` method.
     * 
     * @param string $token The API key required for authentication.
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * Retrieves the API token used for authentication.
     *
     * This method returns the API key previously set, which is required for authenticating API requests.
     * 
     * @return string The API key used for authentication.
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Retrieves the request parameters.
     *
     * This method returns an array of the API request parameters that were set using the `setArguments` method.
     * 
     * @return array An associative array containing the API request parameters.
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * Sets the API token used for authentication.
     *
     * Authentication:
     * - Access to the API data is protected using an API key.
     * - The API key is passed as a parameter in each request to authenticate the user.
     * - If the API key becomes compromised or vulnerable, it should be regenerated using the "Regenerate" option available in the API dashboard.
     * - Example of passing the key: `key=<YOUR API KEY>`
     *
     * @param string $token The API key required for authenticating requests to the WeatherAPI.com API.
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * Sets the request parameters for the API.
     *
     * Parameters:
     * - **key** (string) - Required. API key.
     * - **q** (string) - Required. Query parameter used to fetch data, which can take various forms, e.g., city name, geographic coordinates, postal code, etc. Examples:
     *   - Geographic coordinates: `q=48.8567,2.3508`
     *   - City name: `q=Paris`
     *   - IP address: `q=auto:ip` or `q=100.0.0.1`
     *   - Airport code: `q=iata:DXB`
     * - **days** (int) - Optional. Number of forecast days (from 1 to 14). Required for forecast API method.
     * - **dt** (string) - Optional. Date in `yyyy-MM-dd` format to restrict output for historical or forecast data (required for some API methods).
     * - **unixdt** (int) - Optional. Equivalent to `dt` parameter as Unix Timestamp.
     * - **end_dt** (string) - Optional. End date for historical data (only available for Pro users).
     * - **unixend_dt** (int) - Optional. Equivalent to `end_dt` parameter as Unix Timestamp.
     * - **hour** (int) - Optional. Restricts the forecast or history data to a specific hour (24-hour format).
     * - **alerts** (string) - Optional. Disable alerts in the forecast output: `alerts=yes` or `alerts=no`.
     * - **aqi** (string) - Optional. Enable/Disable Air Quality data in the forecast output: `aqi=yes` or `aqi=no`.
     * - **tides** (string) - Optional. Enable/Disable Tide data in the Marine API output: `tides=yes` or `tides=no`.
     * - **tp** (int) - Optional. Get 15-minute interval data (available for Enterprise clients only): `tp=15`.
     * - **current_fields** (string) - Optional. List of fields to return in the current weather element (e.g., `current_fields=temp_c,wind_mph`).
     * - **day_fields** (string) - Optional. List of fields to return in the forecast or history day element (e.g., `day_fields=temp_c,wind_mph`).
     * - **hour_fields** (string) - Optional. List of fields to return in the forecast or history hour element (e.g., `hour_fields=temp_c,wind_mph`).
     * - **lang** (string) - Optional. Sets the language for the `condition:text` field (e.g., `lang=fr` for French).
     * 
     * @param array $arguments API request parameters in the form of an associative array.
     */
    public function setArguments(array $arguments): void
    {
        $this->arguments = $arguments;
    }

    /**
     * Send the request with parameters for the API.
     * 
     * @return array $responseData 
     */
    public function sendRequest(): array
    {
        if (!isset($this->arguments) || empty($this->arguments)) {
            throw new Exception("Parameter arguments is missing", 1);
        }

        $arguments = $this->arguments;

        $ch = curl_init(ApiService::URL);

        curl_setopt(
            $ch,
            CURLOPT_RETURNTRANSFER,
            true
        );
        curl_setopt(
            $ch,
            CURLOPT_POST,
            true
        );
        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            json_encode($arguments)
        );
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            [
                'Content-Type: application/json',
            ]
        );

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new \RuntimeException(
                'cURL error: ' . curl_error($ch)
            );
        }

        curl_close($ch);

        $responseData = json_decode($response, true);

        return $responseData;
    }
}