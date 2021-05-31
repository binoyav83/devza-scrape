<?php
define('DOMAIN', 'http://localhost/devza/site/');  // https://k2s.cc
define('URL', DOMAIN . 'index.php'); // Login page
define('USERNAME', 'kngstar@gmx.de');
define('PASS', 'hellcity');

class Scrape {

    public $url = '';
    public $username = '';
    public $password = '';

    function __construct($url, $username, $password) {
        
        $this->url = $url;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Returns the output from scraped data
     */
    function getScrapeData() {

        $loginParams = 'username=' . $this->username . '&password=' . $this->password;
        $result = $this->getConnect($this->url, $loginParams);
        return $this->parseResult($result);
    }

    /**
     * Get the info from the parsed data
     * @return array
     */
    function parseResult($html) {

        libxml_use_internal_errors( true);
        $doc = new DOMDocument;
        $doc->loadHTML( $html);
        $xpath = new DOMXpath( $doc);
        $output = array();        
        // Get account type
        $node = $xpath->query( '//div[contains(@class, "account-type")]')->item(0);
        if (isset($node->textContent)) {
            $output['account_type'] = trim($node->textContent); 
        }
        // Get traffic left
        $node = $xpath->query( '//div[contains(@class, "traffic-left")]')->item(0);
        if (isset($node->textContent)) {
            $output['traffic_left'] = trim($node->textContent); 
        }
        // Get used traffic data
        $node = $xpath->query( '//div[contains(@class, "used-traffic")]')->item(0);
        if (isset($node->textContent)) {
            $output['used_traffic'] = trim($node->textContent); 
        }
        
        return $output;
    }

    /**
     * Make the curl request and get the entire page data
     * @return array
     */
    function getConnect($url, $loginParams) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $loginParams);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // Store the cookie to local machine
        $tmpfname = dirname(__FILE__) . '/'. $_COOKIE['PHPSESSID'] . '.txt';
        curl_setopt($ch, CURLOPT_COOKIEJAR, $tmpfname);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $tmpfname);

        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        
        $res1 = curl_exec($ch);
        if (curl_error($ch)) {
            echo curl_error($ch);
        }

        // Another request to the profile page
        curl_setopt($ch, CURLOPT_URL, DOMAIN . 'profile.php');
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "");
        $res = curl_exec($ch);
        if (curl_error($ch)) {
            echo curl_error($ch);
        }
        return $res;
    }

}

// Call the function 
$objScrape = new Scrape(URL, USERNAME, PASS);
$output = $objScrape->getScrapeData();
echo "<pre>";
print_r($output);
?>