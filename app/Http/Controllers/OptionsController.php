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

          
         $address = "http://".env('RPC_USER', 'route').":".env('RPC_USER_PWD', 'route')."@".env('RPC_IP', '172.30.0.179').":".env('RPC_PORT', '18333')."/";

		 $bitcoin = new \App\jsonRPCClient($address);	 

         #$bitcoin = new \App\jsonRPCClient('http://optuse1:SweaterStaplePen@104.236.85.204/');  
		 $info = $bitcoin->getblockcount();
         #$info = $bitcoin->listaddressgroupings();


        return view('hello', ['btcinfo' => $info]);

    }


    private function getRPCAddress()
    {
        return "http://".env('RPC_USER', 'route').":".env('RPC_USER_PWD', 'route')."@".env('RPC_IP', '127.0.0.1').":".env('RPC_PORT', '18333')."/";
    }


    public function generateContract($security, $operator, $execution_price,$payout, $start_date,$end_date,$contract_price,$underwriter_address)
    {

        $has_error = false;
        $error_message = "";

                $contract_text = "The owner of this contract will be paid <payout> BTC if the price of <security> <operator> <execution_price> between <start_date> and <end_date>.This contract will expire on <end_date> at which time <payout> will be returned to the underwriter at <underwriter_address> if the above contract is not executed acording to the terms above. Once <payout> is sent to <escrow_address>, this contract will be active and available for purchase. <contract_price> will be sent to <underwriter_address> upon sale of the contract.";

    // Validate Input
    if (!\App\Security::where('symbol', '=', $security)->where('status','=','ACTIVE')->exists()) 
    {
       $has_error = true;
       $error_message = $error_message.' Invalid Security Symbol <br>';
    }

    if (!($operator == "Above" || $operator == "Below"))
    {
       $has_error = true;
       $error_message = $error_message.' Invalid Operator. Use Above or Below as valid values. <br>';
    }


    if (!(is_numeric($execution_price) && $execution_price > 0 && $execution_price == round($execution_price, 10)))
    {
       $has_error = true;
       $error_message = $error_message.' Invalid Execution Price. Value must be positive and no more than 10 decimal places <br>';        
    }

    if (!(is_numeric($payout) && $payout > 0 && $payout == round($payout, 10)))
    {
       $has_error = true;
       $error_message = $error_message.' Invalid Payout Price. Value must be positive and no more than 10 decimal places <br>';        
    }

    if (!(is_numeric($contract_price) && $payout > 0 && $contract_price == round($contract_price, 10)))
    {
       $has_error = true;
       $error_message = $error_message.' Invalid Contract Price. Value must be positive and no more than 10 decimal places <br>';        
    }

    if (!(strtotime(str_replace('-', '/', $start_date)) > strtotime('now')))
    {
       $has_error = true;
       $error_message = $error_message.' Invalid Start Date. Start Date must be in mm/dd/yyyy format and must be after the current date <br>';        
    }

    if (!(strtotime(str_replace('-', '/', $end_date)) > strtotime(str_replace('-', '/', $start_date))))
    {
       $has_error = true;
       $error_message = $error_message.' Invalid End Date. End Date must be in mm/dd/yyyy format and must be after the Start Date <br>';        
    }


    if (!(strlen($underwriter_address) == 35 || strlen($underwriter_address) == 34))
    {
       $has_error = true;
       $error_message = $error_message.' Enter a valid bitcoin address <br>';        
    }

    $contract = new \App\Contract();

    if (!$has_error)
    {

        $bitcoin = new \App\jsonRPCClient($this->getRPCAddress());    
        $escrow_address = $bitcoin->getnewaddress();

        #$escrow_address='2N9goa19eAfPQiVQB3MXTVCMgRq9CuZe9HL';
        $contract_text =  str_replace('<security>', $security, $contract_text);
        $contract_text =  str_replace('<operator>', $operator, $contract_text);
        $contract_text =  str_replace('<execution_price>', $execution_price, $contract_text);
        $contract_text =  str_replace('<start_date>', $start_date, $contract_text);
        $contract_text =  str_replace('<end_date>', $end_date, $contract_text);
       
        $contract_text =  str_replace('<payout>', $payout, $contract_text);
        $contract_text =  str_replace('<escrow_address>', $escrow_address, $contract_text);
        $contract_text =  str_replace('<contract_price>', $contract_price, $contract_text);
        $contract_text =  str_replace('<underwriter_address>', $underwriter_address, $contract_text);

        # Commit to the database in draft state



            $contract->status ='DRAFT';
            $contract->type = 'S';
            $contract->underwriter_address = $underwriter_address;
            $contract->escrow_address = $escrow_address;
            $contract->symbol = $security;
            $contract->start_date = date('Y-m-d H:i:s',  strtotime(str_replace('-', '/', $start_date)) );
            $contract->end_date = date('Y-m-d H:i:s',  strtotime(str_replace('-', '/', $end_date))  );
            $contract->expiration_date = date('Y-m-d H:i:s',  strtotime(str_replace('-', '/', $end_date))  );
            $contract->strike_price = $execution_price;
            $contract->payout = $payout;
            $contract->contract_text = $contract_text;
            $contract->date_created = \Carbon\Carbon::now();
            $contract->purchase_price =  $contract_price;
            #$contract->signature =         
            $contract->save();
      
    }

        return array(true,$contract,$error_message); 

    }


    public function home()
    {

        
        return \Redirect::to('/ContractList/ALL/ALL');  
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


    function purchaseContract(Request $request,$contract_id,$owner_address)
    {

        // Send Request for Paymnet to Under
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
                c.symbol,
                COUNT(*) DESC";


    $sub_items = \DB::select(\DB::raw($sql));

    return $sub_items;

}

function CreateContract(Request $request)
{
    return view('create_contract');
}

private function GetAddressBalance($address)
{

    // https://blockchain.info/q/addressbalance/mzACLcMfzwXck6srdatbStTB13AFJgUrus

    $client = new GuzzleHttp\Client();
    $resp = $client->get('https://blockchain.info/q/addressbalance/'.$address);
    
    $balance =0;

    $status = $resp->getStatusCode(); // 200

    if ($status == 200)
    {
      $balance = $res->getBody();   
    }
    

    return $balance;

}


function postValidateContract(Request $request)
{

     $signature              = $request->input('underwriter-signature');
     $contract_id            = $request->input('contract-id');
     $purchase_price         = $request->input('purchase-price');
     $is_valid               = true;
     $error_message          = '';


     $contract = \App\Contract::where('contract_id', '=',$contract_id )->first();

     $result = $this->validateContract($contract,$signature);

     if ($result == false)
     {
        $is_valid = false;
        $error_message = $error_message.' Invalid Signature. Please sign the contract text with the underwriter address:'.$contract->underwriter_address; 
     }


     if ($result == true)
     {
        // Update the Purchase Price and set the status to AVAILABLE
        $contract->signature = $signature;
        $contract->status = 'DRAFT';
        $contract->save();           
     }

     return view('contract_detail', ['title' => "Contract : ".$contract_id,'contract' => $contract]);
     
}



function validateContract($contract,$signature)
{

    $error_message = '';
    $valid = true;

    // Confirm Signature against contract text and underwriter address

    $bitcoin = new \App\jsonRPCClient($this->getRPCAddress());    
    #print_r($signature);
    $valid = $bitcoin->verifymessage($contract->underwriter_address,$signature,$contract->contract_text);
    #$valid = $bitcoin->verifymessage('mn5w58Ff5QAz7cR2eAWHRrkNMBjzG7ijyF','IF9vzNKOiuiF3ijTjbe9aA+0CzE9w+gjcOBsWQqvmG3HIWCBzh4v/ZHCNnW62trQEUFY5r44vmmRdJ/XCywIgXE=','123');
    return $valid;

}

function postCreateContract(Request $request)
{

     $security              = $request->input('security');
     $operator              = $request->input('operator');
     $execution_price       = $request->input('execution-price');
     $payout                = $request->input('payout');
     $start_date            = $request->input('start-date');
     $end_date              = $request->input('end-date');
     $underwriter_address   = $request->input('underwriter-address');
     $contract_price        = $request->input('contract-price');

//return array($contract_text,$escrow_account,true,'');
    $result = $this->generateContract($security, $operator, $execution_price,$payout, $start_date,$end_date,$contract_price,$underwriter_address);

    $contract = $result[1];

     return view('validate_contract',
                [
                 'valid_contract' => $result[0],
                 'contract' => $contract,
                 'error_message' => $result[2]
                ]
                 );


}
 

function postCreateContract_OLD(Request $request)

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





