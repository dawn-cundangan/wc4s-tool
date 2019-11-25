<!DOCTYPE html>
<html>
<head>
<meta name="_token" content="{{ csrf_token() }}">
<title>Live Search</title>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
</head>
<body>
<div class="container">
  <div class="row">
    <div class="panel panel-default">
      <div class="panel-heading">
      </div>
        <div class="panel-body">
          <div class="form-group">
            <input type="text" class="form-controller" id="search" name="search"></input>
          </div>
          <label id="loading">Loading Results...</label>
          <table class="table table-bordered table-hover cont" id="table">
            <thead>
              <tr>
                <th>Name</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$("#table").hide();
$("#loading").hide();
$('#search').on('keyup',function(){
$value=$(this).val();
$.ajax({
type : 'get',
url : '{{URL::to('search')}}',
data:{'search':$value},
beforeSend: function(){
    $("#loading").show();
    $("#table").hide();
},
complete: function(){
    $("#loading").hide();
    $("#table").show();
},
success:function(data){
$('tbody').html(data);
}
});
})

$(function() {
  $('table.cont').on("click", "tr.table-tr", function() {
    var $item = $(this).text();         // Retrieves the text within <td>
    alert($item);
});
});
</script>
<script type="text/javascript">
$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>

</body>
</html>
