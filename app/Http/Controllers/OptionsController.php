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

          


		 $bitcoin = new \App\jsonRPCClient('http://optuse1:SweaterStaplePen@127.0.0.1:8332/');	 
         #$bitcoin = new \App\jsonRPCClient('http://optuse1:SweaterStaplePen@104.236.85.204/');  
		# $info = $bitcoin->getinfo();
         $info = $bitcoin->getblockcount();

        #$info = "!!!POPOPOPO!!!";

        return view('hello', ['btcinfo' => $info]);

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





