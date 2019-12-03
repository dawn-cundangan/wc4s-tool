<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="_token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/jquery-ui.min.js') }}"></script>     
        <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
        <script src="{{ asset('js/display.js') }}"></script>
        
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <title>ScreenFlow</title>
        <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    </head>
    <body>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
            <a class="navbar-brand light" href="#">
                <img src="{{asset('favicon.png')}}" width="30" height="30" class="d-inline-block align-top mr-2" alt="">
                ScreenFlow
            </a>
        </nav>
        <div class="container-fluid row p-5 mt-4 mx-0">
            <div class="container col-md-6 md-mr-0 mt-3">
                <div class="row">
                    <!--div class="active-cyan-4 mb-4 col-sm-10"-->
                    <div class="active-cyan-4 mb-4 col-sm-12">
                        <input class="form-control" type="text" placeholder="Enter keywords" aria-label="Search" id="search" name="search">
                    </div>
                    <!--div class="container col-sm-2 px-0">
                        <button type="button" class="btn btn-outline-info">Search</button>
                    </div-->
                    <!-- <div class="px-3">
                        <a href="#" class="export pb-2">Export table data into Excel</a>               
                    </div> -->
                </div>
                <div class="container scrollbar-near-moon-wide p-0 sm-mb-5 md-mb-0" id="resultsDiv" style="overflow-y:auto; max-height:78vh;">
                    <label id="loading">Loading results...</label>
                    <label id="noResults">No results found!</label>
                    <table class="table table-sm table-hover cont mb-0" id="table">
                        <thead>
                            <!--tr class="thead-dark w-100" style="position:fixed">
                                <th>Screen ID</th>
                            </tr-->
                            <tr class="thead-dark">
                                <th style="width:8%">No.</th>
                                <th style="width:92%">Screen ID</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="container col-md-6 mt-3">
                <div class="accordion" id="accordionExample">
                        <div class="card">
                            <ul id="menu_tree"></ul>
                        </div>
                        <div class="card">
                            <div class="card-header py-0" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Sample First Root
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    <ol id="list1" class="my-0">
                                        <li>Root Screen</li>
                                        <li>Screen 1</li>
                                        <li>Screen 2</li>
                                        <li>Screen 3</li>
                                        <li>Screen 4</li>
                                    </ol> 
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header py-0" id="headingTwo">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Sample Second Root
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                <div class="card-body">
                                    <ol class="my-0">
                                        <li>Root Screen</li>
                                        <li>Screen 1</li>
                                        <li>Screen 2</li>
                                        <li>Screen 3</li>
                                        <li>Screen 4</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header py-0" id="headingThree">
                            <h2 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Sample Third Root
                                </button>
                            </h2>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                            <div class="card-body">
                                <ol class="my-0">
                                    <li>Root Screen</li>
                                    <li>Screen 1</li>
                                    <li>Screen 2</li>
                                    <li>Screen 3</li>
                                    <li>Screen 4</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function () 
            {
                $.get("file:///C:/Users/z000044455/Desktop/Source/", function(data) 
                {
                    $(".resultsDiv").append(data);
                });
            })
        </script>

        <script type="text/javascript">
            $(document).ready(function () 
            {
                $.get("file:///C:/Users/z000044455/Desktop/Source/", function(data) 
                {
                    $(".resultsDiv").append(data);
                });
            })
        </script>

        <!-- Search Screen ID -->
        <script type="text/javascript">
            jQuery("#table").hide();
            jQuery("#loading").hide();
            jQuery("#noResults").hide();
            jQuery('#search').on('keyup', function() {
                $value = jQuery(this).val();
                jQuery.ajax ({
                    type: 'get',
                    url: '{{URL::to("search")}}',
                    data: {'search':$value},
                    beforeSend: function() {
                        jQuery("#loading").show();
                        jQuery("#table").hide();
                        jQuery("#noResults").hide();
                    },
                    success:function(data) {
                        if (data == "none") {
                            jQuery("#noResults").show();
                            jQuery("#loading").hide();
                            jQuery("#table").hide();
                        } else {
                            jQuery('tbody').html(data);  
                            jQuery("#noResults").hide();
                            jQuery("#loading").hide();
                            jQuery("#table").show();
                        }
                        
                    }
                });
            })
            jQuery(function() {
                jQuery('table.cont').on("click", "td.filename", function() {
                    var $item = jQuery(this).text(); // Retrieves the text within <td>
                    jQuery.ajax ({
                        type: 'get',
                        url: '{{URL::to('openFile')}}',
                        data: {'openFile':$item},
                        success: function(data) {
                            //console.log(data[0]);
                            alert(data);
                        }
                    });
                });
            });
            jQuery.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>