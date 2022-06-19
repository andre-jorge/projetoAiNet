@extends('home')
@section('content')
     <script>
        $(function(){
            var datas = <?php echo json_encode($datas); ?>
            var barCanvas = $("#barChart");
            var barCharts = new Chart(barCanvas,{
                type:'bar',
                data:{
                    labels:['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Out','Nov','Dec'],
                    datasets:[
                        {
                            label:'New User Growth, 2020',
                            datas:date_date_setbackgroundColor:['silver'],
                        }
                    ]
                },
                options:{
                    scales:{
                        yAxes:[{
                            ticks:{
                                beginAtZero:true
                            }
                        }]
                    }
                }
            }) 

        }
        </script>
    <div style="height:400px;width:900px;margin:auto;">
        <canvas id="barChart"></canvas>
        
    </div>   
 @endsection
