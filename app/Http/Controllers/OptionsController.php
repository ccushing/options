<?php

namespace App\Http\Controllers;


use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

//require_once 'jsonRPCClient.php';

//use jsonRPCClient;

class OptionsController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


public function hello() {

          


	//	 $bitcoin = new jsonRPCClient('http://optuse1:SweaterStaplePen@127.0.0.1:8332/');	 
	//	 $info = $bitcoin->getinfo();


      $info = "!!!POPOPOPO!!!";

        return view('hello', ['btcinfo' => $info]);

    }


    public function home()
    {

        return view('home');
    }


    function contractlist(Request $request,$status,$symbol)
    {


        # Submit a SQL statement for efficiency which retrieves the sorted list of articles for the logged in user
        $sql = "SELECT 
                c.contract_id,
                c.underWriter_address,
                c.symbol,
                c.start_date,
                c.end_date,
                c.type,
                c.status,
                c.strike_price,
                c.purchase_price,
                c.expiration_date,
                c.owner_address,
                c.payout
                FROM 
                contract c 
                WHERE
                (c.status = '".$status."' OR '".$status."' = 'All') AND 
                (c.symbol = '".$symbol."' OR '".$symbol."' = 'All')                  
                ORDER BY 
                c.expiration_date DESC";


        $items = \DB::select(\DB::raw($sql));
        $contract_count = count($items);


        # Pagination needs to be done manually with raw SQL queries
        //$page = $request->input('page', 1); 
        //$articles = $this->setupPagination($items,$page,env('PAGE_SIZE', 50));
        //$articles->setPath('/Category/'.$category_id);
        return view('contract_list', ['title' => $status." contracts for ".$symbol." (".$contract_count." contracts)",'contracts' => $items]);

    }



    function contractDetail(Request $request,$contract_id)
    {


        # Submit a SQL statement for efficiency which retrieves the sorted list of articles for the logged in user
        $sql = "SELECT 
                c.contract_id,
                c.underwriter_address,
                c.symbol,
                c.start_date,
                c.end_date,
                c.type,
                c.status,
                c.strike_price,
                c.purchase_price,
                c.expiration_date,
                c.owner_address,
                c.payout
                FROM 
                contract c 
                WHERE
                contract_id = ".$contract_id;


        $items = \DB::select(\DB::raw($sql));

        return view('contract_detail', ['title' => "Contract : ".$contract_id,'contract' => $items[0]]);



    }



public static function leftNavItems()
{

    $sql = "SELECT
                c.status,
                COUNT(*) Cnt
                FROM 
                contract c 
                GROUP BY
                c.status
                ORDER BY
                CASE 
                    WHEN c.status = 'ACTIVE' THEN 1
                    WHEN c.status = 'OPEN' THEN 2
                    WHEN c.status = 'DRAFT' THEN 3  
                    WHEN c.status = 'EXPIRED' THEN 4
                    WHEN c.status = 'EXECUTED' THEN 5
                    WHEN c.status = 'DELETED' THEN 6
                END ";


    $top_items = \DB::select(\DB::raw($sql));


    return $top_items;

}


public static function subNavItems($status)
{
    $sql = "SELECT
                c.symbol,
                COUNT(*) Cnt
                FROM 
                contract c 
                WHERE
                c.status = '".$status."'
                GROUP BY
                c.symbol
                ORDER BY
                c.status,
                COUNT(*) DESC";


    $sub_items = \DB::select(\DB::raw($sql));

    return $sub_items;

}



function createContract(Request $request)
{

    return view('create_contract');

}

function postCreateContract(Request $request)

{
    $isValid = true;

#dd($request->all());

#d($request->all());
    #$timestamp = strtotime($request->input('start-date'));
    #echo($request->input('start-date'));
    #echo("<br>");

    echo(date("Y-m-d",strtotime(str_replace("-","/","12-13-2017")))); 




        $underwriterAddress = $request->input('underwriter-address');
        $symbol = $request->input('symbol');
        $startDate = date("Y-m-d",strtotime(str_replace("-","/",$request->input('start-date')))) ;
        $endDate =date("Y-m-d",strtotime(str_replace("-","/",$request->input('end-date')))) ;
        $expirationDate = date("Y-m-d",strtotime(str_replace("-","/",$request->input('expiration-date')))) ;
        $strikePrice = $request->input('strike-price');
        $payoutPrice = $request->input('payout-price');
        $purchasePrice = $request->input('purchase-price');
        $signature = $request->input('signature');

        #echo("underwriter_address=".$underwriterAddress);

        // Validate
        if ($isValid)
        {

            $contract = new \App\Contract();

            $contract->underwriter_address=$underwriterAddress;
            $contract->symbol=$symbol;
            $contract->start_date=$startDate;
            $contract->end_date=$endDate;
            $contract->expiration_date=$expirationDate;
            $contract->strike_price=$strikePrice;
            $contract->payout=$payoutPrice;
            $contract->purchase_price=$purchasePrice;
            $contract->signature=$signature;
            $contract->save();       

        }

        $contract_id = $contract->id;

        return \Redirect::to('/ContractDetail/'.$contract_id);  
        

}



}




class jsonRPCClient
{
    protected $url = null, $is_debug = false, $parameters_structure = 'array';

    /**
     * Default options for curl
     *
     * @var array
     */
    protected $curl_options = array(
        CURLOPT_CONNECTTIMEOUT => 8,
        CURLOPT_TIMEOUT => 8
    );

    /**
     * Http error statuses
     *
     * Source: http://en.wikipedia.org/wiki/List_of_HTTP_status_codes
     *
     * @var array
     */
    private $httpErrors = array(
        400 => '400 Bad Request',
        401 => '401 Unauthorized',
        403 => '403 Forbidden',
        404 => '404 Not Found',
        405 => '405 Method Not Allowed',
        406 => '406 Not Acceptable',
        408 => '408 Request Timeout',
        500 => '500 Internal Server Error',
        502 => '502 Bad Gateway',
        503 => '503 Service Unavailable'
    );

    /**
     * Takes the connection parameter and checks for extentions
     *
     * @param string $pUrl - url name like http://example.com/
     */
    public function __construct($pUrl)
    {
        $this->validate(false === extension_loaded('curl'), 'The curl extension must be loaded for using this class!');
        $this->validate(false === extension_loaded('json'), 'The json extension must be loaded for using this class!');

        // set an url to connect to
        $this->url = $pUrl;
    }

    /**
     * Return http error message
     *
     * @param $pErrorNumber
     *
     * @return string|null
     */
    private function getHttpErrorMessage($pErrorNumber)
    {
        return isset($this->httpErrors[$pErrorNumber]) ? $this->httpErrors[$pErrorNumber] : null;
    }

    /**
     * Set debug mode
     *
     * @param boolean $pIsDebug
     *
     * @return jsonRPCClient
     */
    public function setDebug($pIsDebug)
    {
        $this->is_debug = !empty($pIsDebug);
        return $this;
    }

    /**
     * Set structure to use for parameters
     *
     * @param string $pParametersStructure 'array' or 'object'
     *
     * @throws UnexpectedValueException
     * @return jsonRPCClient
     */
    public function setParametersStructure($pParametersStructure)
    {
        if (in_array($pParametersStructure, array('array', 'object')))
        {
            $this->parameters_structure = $pParametersStructure;
        }
        else
        {
            throw new UnexpectedValueException('Invalid parameters structure type.');
        }

        return $this;
    }

    /**
     * Set extra options for curl connection
     *
     * @param array $pOptionsArray
     *
     * @throws InvalidArgumentException
     * @return jsonRPCClient
     */
    public function setCurlOptions($pOptionsArray)
    {
        if (is_array($pOptionsArray))
        {
            $this->curl_options = $pOptionsArray + $this->curl_options;
        }
        else
        {
            throw new InvalidArgumentException('Invalid options type.');
        }

        return $this;
    }

    /**
     * Performs a request and gets the results
     *
     * @param string $pMethod - A String containing the name of the method to be invoked.
     * @param array  $pParams - An Array of objects to pass as arguments to the method.
     *
     * @throws RuntimeException
     * @return array
     */
    public function __call($pMethod, $pParams)
    {
        static $requestId = 0;

        // generating uniuqe id per process
        $requestId++;

        // check if given params are correct
        $this->validate(false === is_scalar($pMethod), 'Method name has no scalar value');
        $this->validate(false === is_array($pParams), 'Params must be given as array');

        // send params as an object or an array
        $pParams = ($this->parameters_structure == 'object') ? $pParams[0] : array_values($pParams);

        // Request (method invocation)
        $request = json_encode(array('jsonrpc' => '2.0', 'method' => $pMethod, 'params' => $pParams, 'id' => $requestId));

        // if is_debug mode is true then add url and request to is_debug
        $this->debug('Url: ' . $this->url . "\r\n", false);
        $this->debug('Request: ' . $request . "\r\n", false);

        $responseMessage = $this->getResponse($request);

        // if is_debug mode is true then add response to is_debug and display it
        $this->debug('Response: ' . $responseMessage . "\r\n", true);

        // decode and create array ( can be object, just set to false )
        $responseDecoded = json_decode($responseMessage, true);

        // check if decoding json generated any errors
        $jsonErrorMsg = $this->getJsonLastErrorMsg();
        $this->validate( !is_null($jsonErrorMsg), $jsonErrorMsg . ': ' . $responseMessage);

        // check if response is correct
        $this->validate(empty($responseDecoded['id']), 'Invalid response data structure: ' . $responseMessage);
        $this->validate($responseDecoded['id'] != $requestId, 'Request id: ' . $requestId . ' is different from Response id: ' . $responseDecoded['id']);
        if (isset($responseDecoded['error']))
        {
            $errorMessage = 'Request have return error: ' . $responseDecoded['error']['message'] . '; ' . "\n" .
                'Request: ' . $request . '; ';

            if (isset($responseDecoded['error']['data']))
            {
                $errorMessage .= "\n" . 'Error data: ' . $responseDecoded['error']['data'];
            }

            $this->validate( !is_null($responseDecoded['error']), $errorMessage);
        }

        return $responseDecoded['result'];
    }

    /**
     * When the method invocation completes, the service must reply with a response.
     * The response is a single object serialized using JSON
     *
     * @param string $pRequest
     *
     * @throws RuntimeException
     * @return string
     */
    protected function & getResponse(&$pRequest)
    {
        // do the actual connection
        $ch = curl_init();
        if ( !$ch)
        {
            throw new RuntimeException('Could\'t initialize a cURL session');
        }

        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $pRequest);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if ( !curl_setopt_array($ch, $this->curl_options))
        {
            throw new RuntimeException('Error while setting curl options');
        }

        // send the request
        $response = curl_exec($ch);

        // check http status code
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (isset($this->httpErrors[$httpCode]))
        {
            throw new RuntimeException('Response Http Error - ' . $this->httpErrors[$httpCode]);
        }
        // check for curl error
        if (0 < curl_errno($ch))
        {
            throw new RuntimeException('Unable to connect to '.$this->url . ' Error: ' . curl_error($ch));
        }
        // close the connection
        curl_close($ch);

        return $response;
    }

    /**
     * Throws exception if validation is failed
     *
     * @param bool   $pFailed
     * @param string $pErrMsg
     *
     * @throws RuntimeException
     */
    protected function validate($pFailed, $pErrMsg)
    {
        if ($pFailed)
        {
            throw new RuntimeException($pErrMsg);
        }
    }

    /**
     * For is_debug and performance stats
     *
     * @param string $pAdd
     * @param bool   $pShow
     */
    protected function debug($pAdd, $pShow = false)
    {
        static $debug, $startTime;

        // is_debug off return
        if (false === $this->is_debug)
        {
            return;
        }
        // add
        $debug .= $pAdd;
        // get starttime
        $startTime = empty($startTime) ? array_sum(explode(' ', microtime())) : $startTime;
        if (true === $pShow and !empty($debug))
        {
            // get endtime
            $endTime = array_sum(explode(' ', microtime()));
            // performance summary
            $debug .= 'Request time: ' . round($endTime - $startTime, 3) . ' s Memory usage: ' . round(memory_get_usage() / 1024) . " kb\r\n";
            echo nl2br($debug);
            // send output imidiately
            flush();
            // clean static
            $debug = $startTime = null;
        }
    }

    /**
     * Getting JSON last error message
     * Function json_last_error_msg exists from PHP 5.5
     *
     * @return string
     */
    function getJsonLastErrorMsg()
    {
        if (!function_exists('json_last_error_msg'))
        {
            function json_last_error_msg()
            {
                static $errors = array(
                    JSON_ERROR_NONE           => 'No error',
                    JSON_ERROR_DEPTH          => 'Maximum stack depth exceeded',
                    JSON_ERROR_STATE_MISMATCH => 'Underflow or the modes mismatch',
                    JSON_ERROR_CTRL_CHAR      => 'Unexpected control character found',
                    JSON_ERROR_SYNTAX         => 'Syntax error',
                    JSON_ERROR_UTF8           => 'Malformed UTF-8 characters, possibly incorrectly encoded'
                );
                $error = json_last_error();
                return array_key_exists($error, $errors) ? $errors[$error] : 'Unknown error (' . $error . ')';
            }
        }
        
        // Fix PHP 5.2 error caused by missing json_last_error function
        if (function_exists('json_last_error'))
        {
            return json_last_error() ? json_last_error_msg() : null;
        }
        else
        {
            return null;
        }
    }
}

