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

        Name: <input type="text" name="name" id="name" value="" class="form-control" placeholder="Country"> 
        <div id="c_id"></div>  
        <div id="list"></div>    
    
    </div>        
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#name").keyup(function(){
            var query = $(this).val();
            if ((query.length > 2)) {
                //console.log(query);
                if(query !== ''){
                    $.ajax({
                        url:"search.php",          
                        method: "POST",
                        data: {query: query},
                        success:function(data){
                            $('#list').fadeIn();
                            $('#list').html(data)
                        }
                    });
                }
            }            

        });

        $(document).on('click', 'li', function(){
            var str = $(this).text();
            var pos = str.indexOf("-");
            var c_id = str.slice(0, pos);
            alert(c_id);
            var name = str.slice(pos+1);
            $('#name').val(name);
            console.log($('#name').val());
            $('#c_id').html(c_id);
            $('#list').fadeOut();
        })
        
    });

    
</script>



    
</body>
</html>