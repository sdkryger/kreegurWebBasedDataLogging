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
        <table class="table table-fluid">
            <thead>
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
        <a href="inputValues.php" target="_blank">Input values</a>
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
