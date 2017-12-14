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
                            Contract Detail
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
                                <i class="fa fa-rss"></i>Contract Detail
                            </div>
                            <div class="tools">
                                <a class="collapse" onclick="$('#news-items').toggle();"></a>
                            </div>
                        </div>

                        <div class="portlet-body" id="news-items">

                            
                            

                        <div class="panel-group" id="article-panel-506960">

                        <table class="table table-bordered">
                        <tr>
                            <td width="150">Contract ID</td>
                            <td>{{ $contract->contract_id }}</td>                       
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>{{ $contract->status }}</td>                     
                        </tr> 

                        <tr>
                            <td>Currency</td>
                            <td>{{ $contract->symbol }}</td>                       
                        </tr>  
                        <tr>
                            <td>Purchase Price</td>
                            <td>{{ $contract->purchase_price }}</td>                       
                        </tr>  
                        <tr>
                            <td>Payout Price</td>
                            <td>{{ $contract->payout }}</td>                       
                        </tr>
                        <tr>
                            <td>Execution Price</td>
                            <td>{{ $contract->strike_price }}</td>                       
                        </tr>            
                        <tr>
                            <td>Start Date</td>
                            <td>{{ date('m-d-Y',strtotime($contract->start_date)) }}</td>                       
                        </tr>                        
                        <tr>
                            <td>End Date</td>
                            <td>{{ date('m-d-Y',strtotime($contract->end_date)) }}</td>                       
                        </tr>                       

                        <tr>
                            <td>Underwriter Address</td>
                            <td>{{ $contract->underwriter_address }}</td>                       
                        </tr>                        
                        <tr>
                            <td>Owner Address</td>
                            <td>{{ $contract->owner_address }}</td>                       
                        </tr>
                        <tr>
                            <td>Expiration Date</td>
                            <td>{{ date('m-d-Y',strtotime($contract->expiration_date)) }}</td>                       
                        </tr>                         

                        </table>

                        <div class="row">


                        <a class="btn btn-info" id="purchase-contract" href="#" data-toggle="modal" data-target="#purchase-contract-modal">Purchase</a>
                        <a class="btn btn-info" id="delete-contract" href="#" data-toggle="modal" data-target="#delete-contract-modal">Delete</a>
                        <a class="btn btn-info" id="back" href="#">Back</a>
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
</div>


@stop