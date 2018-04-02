<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<script
  src="https://code.jquery.com/jquery-1.12.4.min.js"
  integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
  crossorigin="anonymous"></script>


  <script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>

  <!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <title>Document</title>
    <style>
        ul {background-color: #eee;
            cursor: pointer; }
        li {
            padding: 12px;
        }
    </style>
</head>
<body>

<div class="container">
  <div class="row">
    <div class="col-md-8">
        <h1>Search Country</h1>
        <div>
            Name: <input type="text" name="name" id="name" class="form-control" placeholder="Country"> 
        </div> 
         <hr>      
        Result:
        <div id="log" style="height: 200px; width: 300px; overflow: auto;" class="ui-widget-content"></div>
    </div>        
    </div>
</div>

<script>
$(document).ready(function(){

    function log( message ) {
      $( "<div>" ).text( message ).prependTo( "#log" );
      $( "#log" ).scrollTop( 0 );
    }

    $("#name").autocomplete({
    source: "search_2.php",
    minLength: 2,
    select: function( event, ui ) {
        log( "Selected: " + ui.item.value + " --" + ui.item.id );
        $('#name').val(ui.item.value);
        console.log($('#name').val());
      }

    });
    
    //https://stackoverflow.com/questions/5643767/jquery-ui-autocomplete-width-not-set-correctly
    jQuery.ui.autocomplete.prototype._resizeMenu = function () {
        var ul = this.menu.element;
        ul.outerWidth(this.element.outerWidth());
        }
})
</script>
    
</body>
</html>