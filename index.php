<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta charset="utf-8">
        <title>
            Kreegur - web based data logging
        </title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <style>
            * {
                box-sizing: border-box;
            }
            body {
                font-family:arial;
                
            }
            td {
                padding:5px;
            }
		</style>
		
    </head>
    <body>
        <nav class="navbar navbar-expand-md bg-dark navbar-dark">
            <!-- Brand -->
            <a class="navbar-brand" href="index.php">kreegur</a>

            <!-- Toggler/collapsibe Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="inputValues.php" target="_blank">Input values</a>
                    </li>
                </ul>
            </div>
        </nav> 
        <table class="table table-fluid table-striped table-sm m-top-1">
            <thead class="thead-dark">
                <tr>
                    <td>
                        Name
                    </td>
                    <td>
                        Value
                    </td>
                    <td>
                        Last updated
                    </td>
                </tr>
            </thead>
            <tbody id="latestValues">
            </tbody>
        </table>
        <script src = "js/jquery-3.3.1.min.js"></script>
        <script src="js/popper.min.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
		
        <script>
            var nodeId = -1;
			$(document).ready(function(){
                //alert("working");
                setInterval(updateValues, 500);
            });
            function updateValues(){
                $.post(
                    'api/latestValues.php',
                    function(data){
                        console.log(JSON.stringify(data));
                        $("#latestValues").empty();
                        $.each(data.values,function(index, value){
                            var html = '<tr>';
                            html += '<td>'+value.name+'</td>';
                            html += '<td>'+value.value+'</td>';
                            html += '<td>'+value.lastUpdate+'</td>';
                            html += '</tr>';
                            $("#latestValues").append(html);
                        });
                    },
                    'json'
                );
            }
        </script>
</body></html>
