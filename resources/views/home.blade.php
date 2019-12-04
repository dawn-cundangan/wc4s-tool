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
                <div class="accordion" id="screenAccordion">
                    <div class="card">
                        <div class="card-header py-0" id="parentHeading">
                            <p class="my-0 py-0" id="getParentScreenTitle">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseParent" aria-expanded="true" aria-controls="collapseParent">
                                    Parents
                                </button>
                            </p>
                        </div>
                        <div id="collapseParent" class="collapse show" aria-labelledby="parentHeading" data-parent="#screenAccordion">
                            <div class="card-body scrollbar-near-moon-wide my-1" style="overflow-y:auto; min-height:75vh; max-height:75vh; background-color:#ebebeb3b;">
                                <div class="list-group list-group-root well" id="getParentFlow">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header py-0" id="childHeading">
                            <p class="my-0 py-0" id="getChildScreenTitle">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseChild" aria-expanded="false" aria-controls="collapseChild">
                                    Children
                                </button>
                            </p>
                        </div>
                        <div id="collapseChild" class="collapse" aria-labelledby="childHeading" data-parent="#screenAccordion">
                            <div class="card-body scrollbar-near-moon-wide my-1" style="overflow-y:auto; min-height:75vh; max-height:75vh; background-color:#ebebeb3b;">
                                <div class="list-group list-group-root well" id="getChildFlow">
                                </div>
                            </div>
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
                var item = jQuery(this).text(); 
                /* Leaf to root: Get parent */
                jQuery.ajax ({
                    type: 'get',
                    url: '{{URL::to("leafToRoot")}}',
                    data: {'leafToRoot':item},
                    success: function(data) {
                        htmlString = "";
                        console.log(data);
                        if (data[0] == "File doesn't exist.") {
                            htmlString = "<a class='list-group-item screens get-parent' style='font-style:italic'>File doesn't exist!</a>";
                        } else if (data[0]) {
                            for (i = 0; i < data.length; i++) {
                                htmlString += "<a href='#parent" + data[i] + "' class='list-group-item screens get-parent' data-toggle='collapse'>";
                                htmlString += "<i class='fa fa-chevron-right'></i>" + data[i] + "</a>";
                                htmlString += "<div class='list-group collapse pl-3' id='parent" + data[i] + "' style='background-color:#d4d4d459'></div>";
                            }
                        } else {
                            htmlString = "<a class='list-group-item screens get-parent' style='font-style:italic'>This screen has no parent.</a>";
                        }
                        title = "<button class='btn btn-link' type='button' data-toggle='collapse' data-target='#collapseParent' aria-expanded='true' aria-controls='collapseParent'>";
                        title += item + " Parents </button>";
                        jQuery('#getParentScreenTitle').html(title);
                        jQuery('#getParentFlow').html(htmlString);
                    }
                });
                /* Root to Leaf: Get child */
                jQuery.ajax ({
                    type: 'get',
                    url: '{{URL::to("rootToLeaf")}}',
                    data: {'rootToLeaf':item},
                    success: function(data) {
                        htmlString = "";
                        console.log(data);
                        if (data[0] == "File doesn't exist.") {
                            htmlString = "<a class='list-group-item screens get-child' style='font-style:italic'>File doesn't exist!</a>";
                        } else if (data[0]) {
                            for (i = 0; i < data.length; i++) {
                                htmlString += "<a href='#" + data[i] + "' class='list-group-item screens get-child' data-toggle='collapse'>";
                                htmlString += "<i class='fa fa-chevron-right'></i>" + data[i] + "</a>";
                                htmlString += "<div class='list-group collapse pl-3' id='" + data[i] + "' style='background-color:#d4d4d459'></div>";
                            }
                        } else {
                            htmlString = "<a class='list-group-item screens get-child' style='font-style:italic'>This screen has no child.</a>";
                        }
                        title = "<button class='btn btn-link collapsed' type='button' data-toggle='collapse' data-target='#collapseChild' aria-expanded='false' aria-controls='collapseChild'>";
                        title += item + " Children </button>";
                        jQuery('#getChildScreenTitle').html(title);
                        jQuery('#getChildFlow').html(htmlString);
                    }
                });
                jQuery('.fa', this)
                .toggleClass('fa fa-chevron-right')
                .toggleClass('fa fa-chevron-down');
            });

            /* Leaf to root: Get parent */
            jQuery('#getParentFlow').on("click", ".get-parent", function() {
                var item = jQuery(this).text();
                jQuery.ajax ({
                    type: 'get',
                    url: '{{URL::to("leafToRoot")}}',
                    data: {'leafToRoot':item},
                    success: function(data) {
                        htmlString = "";
                        console.log(data);
                        if (data[0] == "File doesn't exist.") {
                            htmlString = "<a class='list-group-item screens get-parent' style='font-style:italic'>File doesn't exist!</a>";
                        } else if (data[0]) {
                            for (i = 0; i < data.length; i++) {
                                htmlString += "<a href='#parent" + data[i] + "' class='list-group-item screens get-parent' data-toggle='collapse'>";
                                htmlString += "<i class='fa fa-chevron-right'></i>" + data[i] + "</a>";
                                htmlString += "<div class='list-group collapse pl-3' id='parent" + data[i] + "' style='background-color:#d4d4d459'></div>";
                            }
                        } else {
                            htmlString = "<a class='list-group-item screens get-parent' style='font-style:italic'>This screen has no parent.</a>";
                        }
                        jQuery("#" + item).html(htmlString);
                    }
                });
                jQuery('.fa', this)
                .toggleClass('fa fa-chevron-right')
                .toggleClass('fa fa-chevron-down');
            });
            /* Root to Leaf: Get child */
            jQuery('#getChildFlow').on("click", ".get-child", function() {
                var item = jQuery(this).text();
                jQuery.ajax ({
                    type: 'get',
                    url: '{{URL::to("rootToLeaf")}}',
                    data: {'rootToLeaf':item},
                    success: function(data) {
                        htmlString = "";
                        console.log(data);
                        if (data[0] == "File doesn't exist.") {
                            htmlString = "<a class='list-group-item screens get-child' style='font-style:italic'>File doesn't exist!</a>";
                        } else if (data[0]) {
                            for (i = 0; i < data.length; i++) {
                                htmlString += "<a href='#" + data[i] + "' class='list-group-item screens get-child' data-toggle='collapse'>";
                                htmlString += "<i class='fa fa-chevron-right'></i>" + data[i] + "</a>";
                                htmlString += "<div class='list-group collapse pl-3' id='" + data[i] + "' style='background-color:#d4d4d459'></div>";
                            }
                        } else {
                            htmlString = "<a class='list-group-item screens get-child' style='font-style:italic'>This screen has no child.</a>";
                        }
                        jQuery("#" + item).html(htmlString);
                    }
                });
                jQuery('.fa', this)
                .toggleClass('fa fa-chevron-right')
                .toggleClass('fa fa-chevron-down');
            });

            jQuery.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>