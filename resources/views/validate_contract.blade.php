
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
                                <i class="fa fa-rss"></i>Validate Contract
                            </div>
                            <div class="tools">
                                <a class="collapse" onclick="$('#contract-portlet').toggle();"></a>
                            </div>
                        </div>

                        <div class="panel-group" id="article-panel-506960">

                        <form method="post" action="/postValidateContract" id="add-new-contract-form">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-9 col-sm-9 col-xs-12">
                            <p>{{$contract->contract_text}}</p>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-9 col-sm-9 col-xs-12">
                            <p>{{$error_message}}</p>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                            <label  for="underwriter-signature"><span class="required">*</span>Digital Signature <a title="" href="#" data-original-title="Sign this contract message above with the underwriter address" data-toggle="tooltip"><span class="fa fa-info-circle"></span></a>
                            </label>
                            
                              <input type="text" id="underwriter-signature" name="underwriter-signature" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>


                            <div class="row">
                            <button class="btn btn-round btn-primary" type="submit">Validate Contract</button>
                            <input type="hidden" name="contract-id" value="{{$contract->contract_id}}">
                            </div>




                        </form>

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