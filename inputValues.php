<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <title>
            Kreegur - input values
        </title>
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
		<link href="css/jquery-ui.css" rel="stylesheet">
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <td>
                        Name
                    </td>
                    <td>
                        Value
                    </td>
                    <td>
                        Action
                    </td>
                </tr>
            </thead>
            <tbody id="latestValues">
            </tbody>
        </table>
<script src = "js/jquery-3.3.1.min.js"></script>
		<script src = "js/jquery-ui.min.js"></script>
        <script>
            var nodeId = -1;
			$(document).ready(function(){
                //alert("working");
                $('body').on('click','.updateValue',function(){
                   var tagName = $(this).attr('id');
                    var value = $("#input"+tagName).val();
                    //alert("Should update tagName: "+tagName+" to value: "+value);
                    $.post(
                        'api/updateTag.php',
                        {
                            tagName: tagName,
                            value: value
                        },
                        function(data){
                            console.log(JSON.stringify(data));
                        },
                        'json'
                    );
                });
                updateValues();
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
                            html += '<td><input type="text" id="input'+value.name+'" value="'+value.value+'"></td>';
                            html += '<td><button class="myButtons updateValue" id="'+value.name+'">Update</button></td>';
                            html += '</tr>';
                            $("#latestValues").append(html);
                        });
                        $(".myButtons").button();
                    },
                    'json'
                );
            }
        </script>
</body></html>
