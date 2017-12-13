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
                                <i class="fa fa-rss"></i>Active Contracts
                            </div>
                            <div class="tools">
                                <a class="collapse" onclick="$('#news-items').toggle();"></a>
                            </div>
                        </div>
                        <div class="portlet-body" id="news-items">

                        <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Symbol</th>
                          <th>Status</th>
                          <th>Start Date</th>
                          <th>End Date</th>
                          <th>Strike Price</th>
                          <th>Payout</th>
                          <th>Purchase Price</th>     
                          <th></th>     
                                           
                        </tr>
                      </thead>


                      <tbody>
                        <tr>
                          <td>BCH</td>
                          <td>Open</td>
                          <td>1/1/2017</td>
                          <td>1/1/2018</td>
                          <td>$14,000</td>
                          <td>$1,000</td>
                          <td>$500</td>   
                          <td><a href="contract_detail.html">view</a></td>                       
                        </tr>
                        <tr>
                          <td>BCS</td>
                          <td>Open</td>
                          <td>1/1/2017</td>
                          <td>1/1/2018</td>
                          <td>$2,000</td>
                          <td>$600</td>
                          <td>$400</td> 
                          <td><a href="contract_detail.html">view</a></td>                            
                        </tr>
                        <tr>
                          <td>ETH</td>
                          <td>Active</td>
                          <td>1/1/2017</td>
                          <td>1/1/2018</td>
                          <td>$1,000</td>
                          <td>$1,000</td>
                          <td>$500</td>
                          <td><a href="contract_detail.html">view</a></td>                            
                        </tr>
                        <tr>
                          <td>XRP</td>
                          <td>Open</td>
                          <td>1/1/2017</td>
                          <td>1/1/2018</td>
                          <td>$1</td>
                          <td>$1,000</td>
                          <td>$500</td>
                          <td><a href="contract_detail.html">view</a></td>                             
                        </tr>
                        <tr>
                          <td>STR</td>
                          <td>Open</td>
                          <td>1/1/2017</td>
                          <td>1/1/2018</td>
                          <td>$.50</td>
                          <td>$80</td>
                          <td>$120</td> 
                          <td><a href="contract_detail.html">view</a></td>                             
                        </tr>
                        <tr>
                          <td>BCH</td>
                          <td>Open</td>
                          <td>1/1/2017</td>
                          <td>3/1/2018</td>
                          <td>$14,000</td>
                          <td>$2,000</td>
                          <td>$500</td>    
                          <td><a href="contract_detail.html">view</a></td>                          
                        </tr>
                      </tbody>
                         </table>                            
       



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



@stop