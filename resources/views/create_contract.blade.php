
@extends('main')

@section('page-content')

<div class="page-content-wrapper">
    <div class="page-content-wrapper">
        <div class="page-content">


            <div class="row">
                <div class="col-md-12">

                    <ul class="page-breadcrumb breadcrumb">

                        <li>
                            <i class="fa fa-home"></i>
                            <a href="/Home">Home</a>
                        </li>
                        <li>
                            <i class="fa fa-rss"></i>
                            Create a Contract
                        </li>
                    </ul>


                </div>
            </div>


            <div class="clearfix">
            </div>

            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-rss"></i>Create a New Contract
                            </div>
                            <div class="tools">
                                <a class="collapse" onclick="$('#contract-portlet').toggle();"></a>
                            </div>
                        </div>
                        <div class="portlet-body" id="contract-portlet">

                            
                            

                        <div class="panel-group" id="article-panel-506960">

                        <form method="post" action="/postCreateContract" id="add-new-contract-form">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                            <label  for="underwriter-address"><span class="required">*</span>Underwriter Address <a title="" href="#" data-original-title="Enter your wallet address here" data-toggle="tooltip"><span class="fa fa-info-circle"></span></a>
                            </label>
                            
                              <input type="text" id="underwriter-address" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                            <label  for="symbol"><span class="required">*</span>Currency</label>
                                  <select class="form-control" id="symbol">
                                    <option value="BTC">BTC - Bitcoin</option>
                                    <option value="ETH">ETH - Ethereum</option>
                                    <option value="XRP">XRP - Ripple</option>
                                    <option value="SLR">SLR - Stellar</option>
                                    <option value="LTE">LTE - Lite Coing</option>
                                  </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-4col-xs-8">
                            <label  for="start-date"><span class="required">*</span>Start Date <a title="" href="#" data-original-title="Enter the Start Date for the Contract" data-toggle="tooltip"><span class="fa fa-info-circle"></span></a>
                            </label>
                            
                                            <div class='input-group date'>
                                                <input type='text' id='start-date' class="form-control" />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                            </div>
                           
                            <div class="col-md-4 col-sm-4col-xs-8">
                            <label  for="end-date"><span class="required">*</span>End Date <a title="" href="#" data-original-title="Enter the End Date for the Contract" data-toggle="tooltip"><span class="fa fa-info-circle"></span></a>
                            </label>
                            
                                            <div class='input-group date' >
                                                <input type='text' id='end-date' class="form-control" />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                            </div>


                            <div class="col-md-4 col-sm-4col-xs-8">
                            <label  for="expiration-date"><span class="required">*</span>Expiration Date <a title="" href="#" data-original-title="Enter the Expiration Date for the Contract" data-toggle="tooltip"><span class="fa fa-info-circle"></span></a>
                            </label>                        
                                            <div class='input-group date'>
                                                <input id='expiration-date' type='text' class="form-control" />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                            </div>
                        </div>

                            <div class="row">
                                <div class="col-md-4 col-sm-4col-xs-8">
                                <label  for="underwriter-address"><span class="required">*</span>Strike Price <a title="" href="#" data-original-title="Enter the Contract Strike Price in Bitcoin" data-toggle="tooltip"><span class="fa fa-info-circle"></span></a>
                                </label>
                                
                                  <input type="text" id="strike-price" required="required" class="form-control col-md-7 col-xs-12">
                                </div>

                                <div class="col-md-4 col-sm-4col-xs-8">
                                <label  for="payout-price"><span class="required">*</span>Payout Price <a title="" href="#" data-original-title="Enter the Payout Price to the owner if this contract is executed in Bitcoin" data-toggle="tooltip"><span class="fa fa-info-circle"></span></a>
                                </label>
                                  <input type="text" id="payout-price" required="required" class="form-control col-md-7 col-xs-12">
                                </div>

                                <div class="col-md-4 col-sm-4col-xs-8">
                                <label  for="purchase-price"><span class="required">*</span>Purchase Price <a title="" href="#" data-original-title="This is the price in Bitcoin that you are selling this contract" data-toggle="tooltip"><span class="fa fa-info-circle"></span></a>
                                </label>
                                <input type="text" id="purchase-price" required="required" class="form-control col-md-7 col-xs-12">
                                  
                                </div>
                            </div>


                            <div class="row">
                                <label  for="contract-text">Contract<a title="" href="#" data-original-title="This is the language of the contract you are creating" data-toggle="tooltip"><span class="fa fa-info-circle"></span></a>
                                </label>

                                <div class="contract-text">

                                <p id="contract-text"> </p>


                                <p id="contract-template" class="hidden"> I agree to pay the owner of the contract #payout-price# if the price of #currency-symbol# reaches #strike-price# between #start-date# and #end-date#. The option to purchase this contract expires on #expiration-date#. <br>
                                 This contract will be available for sale for #purchase-price# when #payout-price# is received by Address : #underwriter-address# to Escrow Address #escrow-address#. </p>

                                <input type="text" id="escrow-account" class="hidden" value="1EV8qZiiQYUL8uMrbvVjLafmt7dAjWyxF6">

                                </div>

                                    <p id="contract-instructions" >Copy the contract text above, sign the message and copy the digital signature into the digital signature box below from address #underwriter-address#.</p>
                            </div>




                            <div class="row">
                            <div class="col-md-12 col-sm-6 col-xs-12">
                            <label  for="underwriter-address"><span class="required">*</span>Digital Signature <a title="" href="#" data-original-title="Sign the contract language with your Bitcoin client and enter the signature here." data-toggle="tooltip"><span class="fa fa-info-circle"></span></a>
                            </label>
                            </div>

                            <div class="row">
                              <input type="text" id="signature" required="required" class="form-control col-md-7 col-xs-12">
                            </div>

                            <div class="row">
                            <button class="btn btn-round btn-primary" type="button" onclick="updateContract()">Check</button>
                            <button class="btn btn-round btn-primary" type="submit">Confirm</button>

                            </div>
                            </div>

                            </form>

                        </div>


                            



                        </div>
                    </div>

                </div>

            </div>



            <div class="clearfix">
            </div>

            <div class="row">
                <div class="col-md-12 col-sm-4">
                </div>
            </div>

        </div>
    </div>

</div>




             <script type="text/javascript">


                  function updateContract(){

                    var p = $('#contract-text');
                    var t = $('#contract-template');

                    var expdate = document.getElementById('expiration-date').value;
                    var startdate = document.getElementById('start-date').value;
                    var enddate = document.getElementById('end-date').value;

                    var strikeprice = document.getElementById('strike-price').value;
                    var purchaseprice = document.getElementById('purchase-price').value;
                    var payoutprice = document.getElementById('payout-price').value;

                    var currency = document.getElementById('currency').value;
                    var underwriteraddress = document.getElementById('underwriter-address').value;
                    var escrowaccount = document.getElementById('escrow-account').value;



                    u = t.html().replace('#expiration-date#', expdate)
                        .replace('#start-date#',startdate)
                        .replace('#end-date#',enddate)
                        .replace('#strike-price#',strikeprice)                        
                        .replace('#purchase-price#',purchaseprice)
                        .replace(/#payout-price#/g,payoutprice)                        
                        .replace('#currency-symbol#',currency)
                        .replace('#underwriter-address#',underwriteraddress) 
                        .replace('#escrow-address#',escrowaccount)                          
                        .replace('#start-date#',startdate);

                        p.html(u);
                   };





            </script>
@stop