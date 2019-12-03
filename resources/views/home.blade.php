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
        
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
                    <div class="active-cyan-4 mb-4 col-sm-12">
                        <input class="form-control" type="text" placeholder="Enter keywords" aria-label="Search" id="search" name="search">
                    </div>
                    <!-- <div class="px-3">
                        <a href="#" class="export pb-2">Export table data into Excel</a>               
                    </div> -->
                </div>
                <div class="container scrollbar-near-moon-wide p-0 sm-mb-5 md-mb-0" id="resultsDiv" style="overflow-y:auto; max-height:78vh;">
                    <label id="loading">Loading results...</label>
                    <label id="noResults">No results found!</label>
                    <table class="table table-sm table-hover cont mb-0" id="table">
                        <thead>
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
                <div class="card">
                    <div class="card-header py-0" id="heading">
                        <p class="my-0 py-2" id="mainScreen">
                            Flow
                        </p>
                    </div>
                    <div class="card-body scrollbar-near-moon-wide" style="overflow-y:auto; min-height:80vh; max-height:80vh;">
                        <div class="list-group list-group-root well" id="flowCard">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            jQuery.get("file:///C:/Users/z000044455/Desktop/Source/", function(data) {
                jQuery(".resultsDiv").append(data);
            });

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
            
            jQuery('table.cont').on("click", "td.filename", function() {
                var item = jQuery(this).text(); // Retrieves the text within <td>
                jQuery.ajax ({
                    type: 'get',
                    url: '{{URL::to("openFile")}}',
                    data: {'openFile':item},
                    success: function(data) {
                        htmlString = "";
                        console.log(data);
                        for (i = 0; i < data.length; i++) {
                            htmlString += "<a href='#" + data[i] + "' class='list-group-item screens' data-toggle='collapse'>";
                            htmlString += "<i class='fa fa-chevron-right'></i>" + data[i] + "</a>";
                            htmlString += "<div class='list-group collapse pl-3' id='" + data[i] + "'></div>";
                        }

                        jQuery('#mainScreen').html(item);
                        jQuery('#flowCard').html(htmlString);
                    }
                });
            });

            jQuery('#flowCard').on("click", ".screens", function() {
                var item = jQuery(this).text();
                jQuery.ajax ({
                    type: 'get',
                    url: '{{URL::to("openFile")}}',
                    data: {'openFile':item},
                    success: function(data) {
                        htmlString = "";
                        console.log(data);
                        for (i = 0; i < data.length; i++) {
                            htmlString += "<a href='#" + data[i] + "' class='list-group-item screens' data-toggle='collapse'>";
                            htmlString += "<i class='fa fa-chevron-right'></i>" + data[i] + "</a>";
                            htmlString += "<div class='list-group collapse pl-3' id='" + data[i] + "'></div>";
                            // var padding = jQuery("#"  + data[i]).css('padding-left'); // get the padding
                            // jQuery("#" + data[i]).css('padding-left', padding + 20);
                        }

                        jQuery("#" + item).html(htmlString);
                    }
                });
            });

            jQuery.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
        </script>
        <script src="{{ asset('js/display.js') }}"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>

<!-- //   ref
// <a href="#item-1" class="list-group-item" data-toggle="collapse">
//     <i class="fa fa-chevron-right"></i>Item 1
// </a>
// <div class="list-group collapse" id="item-1">
//     <a href="#item-1-1" class="list-group-item" data-toggle="collapse">
//        <i class="fa fa-chevron-right"></i>Item 1.1
//     </a>
//     <div class="list-group collapse" id="item-1-1">
//        <a href="#" class="list-group-item">Item 1.1.1</a>
//        <a href="#" class="list-group-item">Item 1.1.2</a>
//        <a href="#" class="list-group-item">Item 1.1.3</a>
//      </div>
// </div> -->