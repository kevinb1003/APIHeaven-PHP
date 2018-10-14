<?php
/**
 * APIHeaven v1 client library
 *
 * @author kevinb1003 <https://github.com/kevinb1003>
 *
 */
class APIHeaven
{
  private $api_key;
  private $api_url = 'https://apiheaven.com/';
  private $timeout = 8;
  public $http_status;
  /**
   * Set api key and optionally API endpoint
   * @param      $api_key
   * @param null $api_url
   */
  public function __construct($api_key, $api_url = null)
  {
    $this->api_key = $api_key;
    if (!empty($api_url)) {
      $this->api_url = $api_url;
    }
  }
  /**
   * Generate Ethereum Address
   * @param $genpair
   * @return mixed
   */
  public function getEthereumAddress($genpair)
  {
    return $this->call('ethereum/?genpair=' . $genpair);
  }
  /**
   * Generate Bitcoin Address
   * @param $genpair
   * @return mixed
   */
  public function getBitcoinAddress($genpair)
  {
    return $this->call('bitcoin/?genpair=' . $genpair);
  }
  /**
   * Curl run request
   *
   * @param null $api_method
   * @param string $http_method
   * @return mixed
   * @throws Exception
   */
  private function call($api_method = null, $http_method = 'GET')
  {
    $url     = $this->api_url . '' . $api_method . '&key=' . $this->api_key . '';
    $options = array(
      CURLOPT_URL => $url,
      CURLOPT_ENCODING => 'gzip,deflate',
      CURLOPT_FRESH_CONNECT => 1,
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_TIMEOUT => $this->timeout,
      CURLOPT_HEADER => false
    );
    
    $curl = curl_init();
    curl_setopt_array($curl, $options);
    $response          = json_decode(curl_exec($curl));
    $this->http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    return (object) $response;
  }
}
