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
                                <i class="fa fa-rss"></i>{{ $title }}
                            </div>
                            <div class="tools">
                                <a class="collapse" onclick="$('#news-items').toggle();"></a>
                            </div>
                        </div>
                        <div class="portlet-body" id="news-items">


                            @if(count($contracts)==0)
                                <h4>There are no contracts to display</h4>
                            @endif



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

                        @foreach ($contracts as $contract)



                              <tr>
                                <td>{{ $contract->symbol }}</td>
                                <td>{{ $contract->status }}</td>
                                <td>{{ $contract->start_date }}</td>
                                <td>{{ $contract->end_date }}</td>
                                <td>{{ $contract->strike_price }}</td>
                                <td>{{ $contract->payout }}</td>
                                <td>{{ $contract->purchase_price }}</td> 
                                <td><a href='/ContractDetail/{{ $contract->contract_id }}'>view</a></td>                       
                              </tr>


                            @endforeach

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
    </div>



@stop