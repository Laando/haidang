<html>
    <head>
        <style>
            body{
                background: #e5eec3;
            }
            svg text{
                font-weight: bold!important;
                font-size:15px!important; /*but its not reducing the font size */
            }
            .chuthich{
                font-weight: bold;
                float: right;
                padding-right: 50px;
            }
        </style>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    </head>
    <body onload="get()" >
    <center><h2>THỐNG KÊ NĂM HIỆN TẠI: <?php echo $year = (new DateTime)->format("Y"); ?></h2></center>
        <div id="chart" style="height: 350px;"></div>
        <div class="chuthich">
            CHÚ THÍCH <br>
            @for ($i = 0; $i <=11; $i++)
                <script>
                    var count = <?php echo json_encode($month); ?>;

                    if (count[{{$i}}]>=1){
                        document.write("Tháng "+{{$i+1}}+" có "+count[{{$i}}]+" Tour<br/>");
                    }
                </script>
            @endfor

        </div>
        <script>
            function get(){
                var month = <?php echo json_encode($month); ?>;

                Morris.Bar({
                    element: 'chart',
                    data: [
                        { date: 'Tháng 1 - Năm <?php echo $year;?>', value: month[0]},
                        { date: 'Tháng 2 - Năm <?php echo $year;?>', value: month[1] },
                        { date: 'Tháng 3 - Năm <?php echo $year;?>', value: month[2] },
                        { date: 'Tháng 4 - Năm <?php echo $year;?>', value: month[3] },
                        { date: 'Tháng 5 - Năm <?php echo $year;?>', value: month[4] },
                        { date: 'Tháng 6 - Năm <?php echo $year;?>', value: month[5] },
                        { date: 'Tháng 7 - Năm <?php echo $year;?>', value: month[6] },
                        { date: 'Tháng 8 - Năm <?php echo $year;?>', value: month[7] },
                        { date: 'Tháng 9 - Năm <?php echo $year;?>', value: month[8] },
                        { date: 'Tháng 10 - Năm <?php echo $year;?>', value: month[9] },
                        { date: 'Tháng 11 - Năm <?php echo $year;?>', value: month[10] },
                        { date: 'Tháng 12 - Năm <?php echo $year;?>', value: month[11] }
                    ],
                    xkey: 'date',
                    xLabelAngle: 20,
                    resize: true,
                    padding: 70,
                    barSize: 60,
                    ykeys: ['value'],

                    labels: ['Tổng Tour'],
                });
            }

        </script>

    </body>
</html>