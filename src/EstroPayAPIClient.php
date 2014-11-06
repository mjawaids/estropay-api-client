<?php
/**
 * EstroPayAPICleint class provides an easy interface to call EstroPay APIs.
 * 
 * Author: Muhammad Jawaid Shamshad
 * Version: 1.0
 */
class EstroPayAPIClient {

    const ESTROPAY_API_URL = "https://www.estropay.com/apis/";
    const ESTROPAY_API_KEY_HEADER = "X-API-KEY";
    const ESTROPAY_ENDPOINT_BALANCE = "balance";
    const ESTROPAY_ENDPOINT_HISTORY = "history";
    const ESTROPAY_ENDPOINT_TRANSACTION = "transaction";
    const ESTROPAY_ENDPOINT_TRANSFER = "transfer";

    private $_apiKey;
    private $_curlHandle;
    private $_errorCode;

    /**
     * Constructor expecting API Key for authentication purposes.
     */
    public function __construct($api_key) {
        $this->_apiKey = $api_key;

        $this->_curlHandle = curl_init();
        curl_setopt($this->_curlHandle, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($this->_curlHandle, CURLOPT_HTTPHEADER, array(self::ESTROPAY_API_KEY_HEADER . ": {$this->_apiKey}"));
    }

    /**
     * Destructor to cleanup stuff at exit.
     */
    public function __destruct() {
        curl_close($this->_curlHandle);
    }

    /**
     * Calls APIs with GET HTTP method and returns the result.
     * @return object PHP object decoded from JSON
     */
    private function _get($end_point) {
        curl_setopt($this->_curlHandle, CURLOPT_URL, self::ESTROPAY_API_URL . $end_point);
        curl_setopt($this->_curlHandle, CURLOPT_HTTPGET, TRUE);
        
        $buffer = curl_exec($this->_curlHandle);
        $this->_errorCode = curl_getinfo($this->_curlHandle, CURLINFO_HTTP_CODE);
        
        return json_decode($buffer);
    }

    /**
     * Calls APIs with POST HTTP method and returns the result.
     * @return object PHP object decoded from JSON
     */
    private function _post($end_point, $post_array) {
        
        curl_setopt($this->_curlHandle, CURLOPT_URL, self::ESTROPAY_API_URL . $end_point);
        curl_setopt($this->_curlHandle, CURLOPT_POST, TRUE);
        curl_setopt($this->_curlHandle, CURLOPT_POSTFIELDS, $post_array);
        
        $buffer = curl_exec($this->_curlHandle);
        $this->_errorCode = curl_getinfo($this->_curlHandle, CURLINFO_HTTP_CODE);
        
        return json_decode($buffer);
    }

    /**
     * Returns balance amount in your account.
     * @return object Balance object
     */
    public function balance() {
        return $this->_get(self::ESTROPAY_ENDPOINT_BALANCE);
    }

    /**
     * Returns complete history of your account transactions.
     * @return object History container object with transactions array
     */
    public function history() {
        return $this->_get(self::ESTROPAY_ENDPOINT_HISTORY);
    }

    /**
     * Finds transaction with ID provided and returns the found transaction.
     * @param numeric $transaction_id
     * @return object Transaction object
     */
    public function transaction($transaction_id) {
        $queryString = "/transaction_id/$transaction_id";
        return $this->_get(self::ESTROPAY_ENDPOINT_TRANSACTION . $queryString);
    }
    
    /**
     * Transfers an amount to another EstroPay user account.
     * @param currency $amount
     * @param string $receiver_account
     * @param string $receiver_name
     * @return object Transaction object
     */
    public function transfer($amount, $receiver_account, $receiver_name = NULL) {
        $post_array = array(
            "amount" => $amount,
            "account" => $receiver_account,
            "beneficiary" => $receiver_name
        );

        return $this->_post(self::ESTROPAY_ENDPOINT_TRANSFER, $post_array);
    }
    
    /**
     * Returns HTTP code of last API call.
     * @return number HTTP Code
     */
    public function getCode(){
        return $this->_errorCode;
    }
    
    /**
     * Returns TRUE if last API call had error, FALSE otherwise.
     * @return bool
     */
    public function isError(){
        return ($this->_errorCode != 200 && $this->_errorCode != 201);
    }
}
