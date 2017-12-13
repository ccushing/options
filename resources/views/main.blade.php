<html>
   <head>
      <meta charset="utf-8">
      <title id="PageTitle">Crypto Futures</title>
      <meta name="description" content="Cryptocurrency Futures">
      <meta name="author" content="xxx">
      <!--    Bootstrap CSS Files and CSS Plugins -->
      <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/6.1.1/css/bootstrap-slider.min.css">
      <link href="/plugins/style-responsive.css" rel="stylesheet" type="text/css">
      <link href="/plugins/plugins.css" rel="stylesheet" type="text/css">
      <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
      <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
      <script type="text/javascript" src="http://twitter.github.io/bootstrap/assets/js/bootstrap-transition.js"></script>
      <script type="text/javascript" src="http://twitter.github.io/bootstrap/assets/js/bootstrap-collapse.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/6.1.1/bootstrap-slider.min.js"></script>
      <!-- Datatables -->
      <link href="/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
      <link href="/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
      <link href="/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
      <link href="/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
      <link href="/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
      <!--    CSS File for the Site -->
      <link href="/css/layout.css" rel="stylesheet" type="text/css">
   </head>
   <body class="page-header-fixed">
      <div id="container">
         <div class="header navbar navbar-inverse" id="header">
            <div id="headertitle">
               <h2 id="PageTitleHeader" class="header-title">Cryptocurrency Futures<br>
                  <small class="sub-header">An Anonymous Cryptocurrency Futures Contract Platform</small>
               </h2>
            </div>
            <div id="topnav">
               <ul class="page-breadcrumb breadcrumb">
                  <li><a href="/Home">Home</a></li>
                  <li><a href="/About">About</a></li>
                  <li><a href="/Help">Help</a></li>
               </ul>
            </div>
         </div>
         <div class="clearfix">
         </div>
         <div class="page-container">
            <div class="page-sidebar-wrapper">
               <div class="page-sidebar">
                  <ul class="page-sidebar-menu">
                     <li>
                        <form class="" role="form" action="/Search" method="post">
                           <input type="hidden" name="_token" value="ro6OzBpmv3xn5AxIvJSlZQZzMMtnXpemSllrbjUF">
                           <div class="searchbox">
                              <input type="text" class="form-control input-medium" name="search-term" placeholder="Search...">
                           </div>
                        </form>
                        <p><a href="/AdvancedSearch" class="search-link" >Advanced Search</a></p>
                     </li>
                     <li class="start active ">
                        <a href="/Home">
                        <span class="active">Home</span>
                        <span class="selected"></span>
                        </a>
                     </li>


                     @foreach (App\Http\Controllers\OptionsController::leftNavItems() as $topmenuitem) 
                     <li>
                        <a href="#" onclick="$('#cat-{{ $topmenuitem->status }}').toggle();"><i class="fa fa-angle-down"></i><span class="title">{{ ucfirst(strtolower($topmenuitem->status)) }} Contracts ({{ $topmenuitem->Cnt }})</span></a>

                           <ul class="sub-menu" id="cat-{{ $topmenuitem->status }}" style="display:none;">
                              <li><a href="/ContractList/{{ $topmenuitem->status }}/ALL" class="feed-menuitem"><span class="active">All ({{ $topmenuitem->Cnt }})</span></a></li>
                              @foreach (App\Http\Controllers\OptionsController::subNavItems($topmenuitem->status) as $submenuitem) 
                              <li><a href="/ContractList/{{ $topmenuitem->status }}/{{ $submenuitem->symbol }}" class="feed-menuitem"><i class="fa fa-arrow-circle-right"></i><span class="active">{{ $submenuitem->symbol }} ({{ $submenuitem->Cnt }})</span></a></li>
                              @endforeach
                           </ul>

                        

                     </li>
                     @endforeach


       
                     <li><a href="/CreateContract"><i class="fa fa-line-chart"></i><span>Create a Contract</span><span class="selected"></span></a></li>
                  </ul>
               </div>
            </div>




            @yield('page-content')
         




         <div class="footer">
            <a href="/Support">Support</a> | <a href="/Contact">Contact</a>
         </div>

      </div>
      </div>
         <!--    Bootstrap, Custom & JQuery add ins -->
         <!--
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js" type="text/javascript"></script>
            <script src="http://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js" type="text/javascript"></script>
            -->
         <script src="/js/p4.js" type="text/javascript"></script>
         <!-- jQuery -->
         <script src="/vendors/jquery/dist/jquery.min.js"></script>
         <!-- Bootstrap -->
         <script src="/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
         <!-- Datatables -->
         <script src="/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
         <script src="/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
         <script src="/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
         <script src="/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
         <script src="/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
         <script src="/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
         <script src="/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
         <script src="/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
         <script src="/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
         <script src="/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
         <script src="/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
         <script src="/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
         <!-- Custom Theme Scripts -->
         <!--<script src="../build/js/custom.min.js"></script>-->
         <script src="/js/p4.js" type="text/javascript"></script>
         <script type="text/javascript">
            init_DataTables(); 
            $('.input-group').datetimepicker({format: 'MM-DD-YYYY'});     
         </script>

   </body>
</html>


