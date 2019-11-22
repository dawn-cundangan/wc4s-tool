<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <title>ScreenFlow</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

  </head>
  <body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <a class="navbar-brand light" href="#">
            <img src="{{asset('favicon.png')}}" width="30" height="30" class="d-inline-block align-top" alt="">
            ScreenFlow
        </a>
    </nav>
    <div class="container-fluid row p-5 mt-5">
        <div class="container col-md-6">
            <div class="row">
                <div class="active-cyan-4 mb-4 col-sm-10">
                    <input class="form-control" type="text" placeholder="Enter keywords" aria-label="Search">
                </div>
                <div class="container col-sm-2 px-0">
                    <button type="button btn-block" class="btn btn-outline-info">Search</button>
                </div>
            </div>
            <div class="container scrollbar-near-moon p-0" style="overflow-y:auto; max-height:57vh;">
                <table class="table table-hover table-sm" id="searchResult">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Screen ID</th>
                            <th scope="col">Screen Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>TD_Copy_Something_Something</td>
                            <td>Copy</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>TS_Send_This_That</td>
                            <td>Send</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>FX_Fax_Ni_Shimasu</td>
                            <td>Fax</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="container col-md-6">
            <div class="accordion" id="accordionExample">
                    <div class="card">
                        <div class="card-header py-0" id="headingOne">
                            <h2 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    SD_Dulo_Ng_Send
                                </button>
                            </h2>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
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
                        <div class="card-header py-0" id="headingTwo">
                            <h2 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    SM_Dulo_Ng_SM
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
                                FD_Dulo_Ng_Buhay_Mo
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
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
