﻿
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
                            <div class="col-md-3 col-sm-3 col-xs-6">
                            <label  for="security"><span class="required">*</span>Security</label>
                                  <select class="form-control" id="security" name="security" >
                                    <option value="BTC">BTC - Bitcoin</option>
                                    <option value="ETH">ETH - Ethereum</option>
                                    <option value="XRP">XRP - Ripple</option>
                                    <option value="SLR">SLR - Stellar</option>
                                    <option value="LTE">LTE - Lite Coin</option>
                                  </select>
                            </div>

                            <div class="col-md-3 col-sm-3 col-xs-6">
                            <label  for="operator"><span class="required">*</span>Operator</label>
                                  <select class="form-control" id="operator" name="operator" >
                                    <option value="Above">Goes above</option>
                                    <option value="Below">Goes below</option>
                                  </select>
                            </div>

                            <div class="col-md-3 col-sm-3 col-xs-6">
                            <label  for="execution-price"><span class="required">*</span>Execution Price <a title="" href="#" data-original-title="Execution Price" data-toggle="tooltip"><span class="fa fa-info-circle"></span></a>
                            </label>
                            
                              <input type="text" id="execution-price" name="execution-price" required="required" class="form-control col-md-3 col-xs-2">
                            </div>



                        </div>




                        <div class="row">
                            <div class="col-md-3 col-sm-3 col-xs-4">
                            <label  for="start-date"><span class="required">*</span>Start Date <a title="" href="#" data-original-title="Enter the Start Date for the Contract" data-toggle="tooltip"><span class="fa fa-info-circle"></span></a>
                            </label>
                            
                                            <div class='input-group date'>
                                                <input type='text' id='start-date' name="start-date" class="form-control" />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                            </div>
                           
                            <div class="col-md-3 col-sm-3 col-xs-4">
                            <label  for="end-date"><span class="required">*</span>End Date <a title="" href="#" data-original-title="Enter the End Date for the Contract" data-toggle="tooltip"><span class="fa fa-info-circle"></span></a>
                            </label>
                            
                                            <div class='input-group date' >
                                                <input type='text' id='end-date' name="end-date" class="form-control" />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                            </div>




                            </div>



                        <div class="row">

                            <div class="col-md-3 col-sm-3 col-xs-4">
                            <label  for="payout"><span class="required">*</span>Contract Payout <a title="" href="#" data-original-title="Contract Payout" data-toggle="tooltip"><span class="fa fa-info-circle"></span></a>
                            </label>
                            
                              <input type="text" id="payout" name="payout" required="required" class="form-control col-md-7 col-xs-12">
                            </div>

                            <div class="col-md-3 col-sm-3 col-xs-4">
                            <label  for="contract-price"><span class="required">*</span>Contract Sale Price <a title="" href="#" data-original-title="Contract Sale Price" data-toggle="tooltip"><span class="fa fa-info-circle"></span></a>
                            </label>
                            
                              <input type="text" id="contract-price" name="contract-price" required="required" class="form-control col-md-7 col-xs-12">
                            </div>


                        </div>




                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                            <label  for="underwriter-address"><span class="required">*</span>Underwriter Address <a title="" href="#" data-original-title="Enter your wallet address here" data-toggle="tooltip"><span class="fa fa-info-circle"></span></a>
                            </label>
                            
                              <input type="text" id="underwriter-address" name="underwriter-address" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>


                            </div>


                            <div class="row">
                            <button class="btn btn-round btn-primary" type="submit">Generate Contract</button>
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

                    var currency = document.getElementById('symbol').value;
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