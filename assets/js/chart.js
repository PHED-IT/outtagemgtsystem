
$(document).ready(function(){



    var feeder_name=$('#feeder_name').val();
    //alert(feeder_name)
    var dt=$('#date_type').val();
    var date=$('.captured_date').val();
    var type=$('#type').val();
    var page=$('#page').val();

    //coincendental report chart
        var dt1=$('#dt').val();
        var month1=$('#month').val();
        var year1=$('#year').val();
        var date1=$('#date').val();
    //end

    //var date=$('#captured_date').val();
    if (feeder_name!="" && page=='mis') {
        //alert(feeder_name);
         var url=BASE_URL+"mis/get_chart_data";
     $.ajax({
        url:url,
        type:'POST',
        data:{feeder_id:feeder_name,dt:dt,date:date,type:type},
        success:function(response){
            console.log(response)

            var dataRx=JSON.parse(response);
            if (dataRx.length<1) {
                alert('Cannot generate monthly chart by this time')
                $('#barChart').hide()
            } else {
                
if (type=="load_reading") {
    type_r="LOAD (MW)";
} else if(type=="load_mvr") {
    type_r="LOAD (MVR)";
}else if(type=="current_reading"){
    type_r="CURRENT (AMP)";
}
//alert(type)
//
if (type=="energy") {   

    var consumptionChart = new CanvasJS.Chart("consumptionChart", {
    animationEnabled: true,
    theme: "light2",
    title:{
        text: (dt=="day"?"DAY WISE ":"MONTH WISE") +" CONSUMPTION"
    },
    axisX:{
        //includeZero: true,
        interval:1,
        title: (dt=="day"?"HOUR":"DAY"),
    },
    axisY:{
        includeZero: true,
        title: " CONSUMPTION ",
    },
    data: [{        
        type: "spline",       
        dataPoints: dataRx['daily_consumption']
    }]
});
$('#consumptionChart').css({ "height": "370px", "max-width": "920px", "margin": "0px auto"})
consumptionChart.render();
}else if(type=="current_reading" || type=="voltage" || type=="load_mvr"){


    if (dt=='month') {

       var month_hourly = new CanvasJS.Chart("month_hourly", {
    animationEnabled: true,
    theme: "light2",
    title:{
        text: "HOURLY AVERAGE AND PEAK "
    },
    axisX:{
        //includeZero: false,
        title: "HOUR",
        interval:1
    },
    axisY:[{
        interval:100,
        includeZero: true,
        //title: "AVERAGE ",
        lineColor: "#369EAD",
        titleFontColor: "#369EAD",
        labelFontColor: "#369EAD"
    },{
        interval:100,
        includeZero: true,
        //title: "PEAK ",
        lineColor: "#C24642",
        titleFontColor: "#C24642",
        labelFontColor: "#C24642"
    }],
    data: [{  
        name: "Axis Y-1 (AVERAGE)",      
        type: "spline",   
        showInLegend: true,    
        dataPoints: dataRx['hourly_avg']
    },{  
        name: "Axis Y-2 (PEAK)",      
        type: "spline", 
        showInLegend: true,      
        dataPoints: dataRx['hourly_peak']
    }]
});

   var peakChart = new CanvasJS.Chart("peakChart", {
    animationEnabled: true,
    theme: "light2",
    title:{
        text: "DAY WISE MONTHLY AVERAGE AND PEAK"
    },
    axisX:{
        interval:2,
        includeZero: false,
        title: "DAY",
    },
    axisY:[{
        interval:100,
        includeZero: true,
        //title: "DAILY AVERAGE ",
        lineColor: "#369EAD",
        titleFontColor: "#369EAD",
        labelFontColor: "#369EAD"
    },{
       interval:100,
        includeZero: true,
        //title: "DAILY PEAK ", 
        lineColor: "#C24642",
        titleFontColor: "#C24642",
        labelFontColor: "#C24642"
    }],
    data: [{        
        name: "Axis Y-1 (AVERAGE)",      
        type: "spline",   
        showInLegend: true,      
        dataPoints: dataRx['average']
    },{
       name: "Axis Y-2 (PEAK)",      
        type: "spline",   
        showInLegend: true,      
        dataPoints: dataRx['peak'] 
    }]
});

 var minChart = new CanvasJS.Chart("minChart", {
    animationEnabled: true,
    theme: "light2",
    title:{
        text: "MONTH WISE MINIMUM "
    },
    axisX:{
        //includeZero: true,
        title: "DAY",
    },
    axisY:{
        interval:100,
        includeZero: true,
        title: "DAILY MINIMUM ",
    },
    data: [{        
        type: "spline",       
        dataPoints: dataRx['min']
    }]
});


//  $('#sumChart').css({ "height": "370px", "max-width": "920px", "margin": "0px auto"})
// sumChart.render();
  $('#month_hourly').css({ "height": "370px", "max-width": "920px", "margin": "0px auto"})
month_hourly.render();
$('#peakChart').css({ "height": "370px", "max-width": "920px", "margin": "0px auto"})
peakChart.render();
// $('#avgChart').css({ "height": "370px", "max-width": "920px", "margin": "0px auto"})
// avgChart.render();
$('#minChart').css({ "height": "370px", "max-width": "920px", "margin": "0px auto"})
minChart.render();
}
if (dt=="day") {
    var lineChart = new CanvasJS.Chart("lineCharts", {
    animationEnabled: true,
    theme: "light2",
    title:{
        text: " DAY WISE REPORT"
    },
    axisX:{
        //includeZero: true,
        interval:1,
        title: "HOUR",
    },
    axisY:{
        interval:5,
        includeZero: true,
        title: type_r.toUpperCase(),
    },
    data: [{        
        type: "spline",       
        dataPoints: dataRx['daily_reading_chart']
    }]
});
    $('#lineCharts').show()
    $('#lineCharts').css({ "height": "370px", "max-width": "920px", "margin": "0px auto"})

lineChart.render();

}

} else {
    //

    if (dt=='month') {
// var chart = new CanvasJS.Chart("barChart", {
//     animationEnabled: true,
//     theme: "light2", // "light1", "light2", "dark1", "dark2"
//     title:{
//         text: "CUMMULATIVE " +type_r.toUpperCase() +" REPORT "+date.toUpperCase()
//     },
//     axisY: {
//         title: type_r.toUpperCase()
//     },
//     data: [{        
//         type_r: "column",  
//         showInLegend: true, 
//         legendMarkerColor: "grey",
//         // legendText: " = one million barrels",
//         dataPoints:dataRx['bar']
//     }]
// });
// $('#barChart').css({ "height": "370px", "max-width": "920px", "margin": "0px auto"})
// chart.render();

    //   var sumChart = new CanvasJS.Chart("sumChart", {
    //     animationEnabled: true,
    //     theme: "light2",
    //     title:{
    //         text: "DAILY "+type_r.toUpperCase()+" REPORT"
    //     },
    //     axisX:{
    //         //includeZero: true,
    //         title: "DAY",
    //     },
    //     axisY:{
    //         includeZero: true,
    //         title: "DAILY SUM "+type_r.toUpperCase(),
    //     },
    //     data: [{        
    //         type_r: "spline",       
    //         dataPoints: dataRx['sum_daily']
    //     }]
    // });

       var month_hourly = new CanvasJS.Chart("month_hourly", {
    animationEnabled: true,
    theme: "light2",
    title:{
        text: "HOURLY AVERAGE AND PEAK "
    },
    axisX:{
        //includeZero: false,
        title: "HOUR",
        interval:1
    },
    axisY:[{
        interval:5,
        includeZero: true,
        //title: "AVERAGE ",
        lineColor: "#369EAD",
        titleFontColor: "#369EAD",
        labelFontColor: "#369EAD"
    },{
        interval:5,
        includeZero: true,
        //title: "PEAK ",
        lineColor: "#C24642",
        titleFontColor: "#C24642",
        labelFontColor: "#C24642"
    }],
    data: [{  
        name: "Axis Y-1 (AVERAGE)",      
        type: "spline",   
        showInLegend: true,    
        dataPoints: dataRx['hourly_avg']
    },{  
        name: "Axis Y-2 (PEAK)",      
        type: "spline", 
        showInLegend: true,      
        dataPoints: dataRx['hourly_peak']
    }]
});

   var peakChart = new CanvasJS.Chart("peakChart", {
    animationEnabled: true,
    theme: "light2",
    title:{
        text: "DAY WISE MONTHLY AVERAGE AND PEAK"
    },
    axisX:{
        interval:2,
        includeZero: false,
        title: "DAY",
    },
    axisY:[{
        interval:5,
        includeZero: true,
        //title: "DAILY AVERAGE ",
        lineColor: "#369EAD",
        titleFontColor: "#369EAD",
        labelFontColor: "#369EAD"
    },{
       interval:5,
        includeZero: true,
        //title: "DAILY PEAK ", 
        lineColor: "#C24642",
        titleFontColor: "#C24642",
        labelFontColor: "#C24642"
    }],
    data: [{        
        name: "Axis Y-1 (AVERAGE)",      
        type: "spline",   
        showInLegend: true,      
        dataPoints: dataRx['average']
    },{
       name: "Axis Y-2 (PEAK)",      
        type: "spline",   
        showInLegend: true,      
        dataPoints: dataRx['peak'] 
    }]
});

 var minChart = new CanvasJS.Chart("minChart", {
    animationEnabled: true,
    theme: "light2",
    title:{
        text: "MONTH WISE MINIMUM "
    },
    axisX:{
        //includeZero: true,
        title: "DAY",
    },
    axisY:{
        interval:5,
        includeZero: true,
        title: "DAILY MINIMUM ",
    },
    data: [{        
        type: "spline",       
        dataPoints: dataRx['min']
    }]
});

//   var avgChart = new CanvasJS.Chart("avgChart", {
//     animationEnabled: true,
//     theme: "light2",
//     title:{
//         text: "MONTH WISE AVERAGE "
//     },
//     axisX:{
//         //includeZero: true,
//         title: "DAY",
//     },
//     axisY:{
//         interval:2,
//         includeZero: true,
//         title: "DAILY AVERAGE ",
//     },
//     data: [{        
//         type_r: "spline",       
//         dataPoints: dataRx['average']
//     }]
// });

//  $('#sumChart').css({ "height": "370px", "max-width": "920px", "margin": "0px auto"})
// sumChart.render();
  $('#month_hourly').css({ "height": "370px", "max-width": "920px", "margin": "0px auto"})
month_hourly.render();
$('#peakChart').css({ "height": "370px", "max-width": "920px", "margin": "0px auto"})
peakChart.render();
// $('#avgChart').css({ "height": "370px", "max-width": "920px", "margin": "0px auto"})
// avgChart.render();
$('#minChart').css({ "height": "370px", "max-width": "920px", "margin": "0px auto"})
minChart.render();
}
if (dt=="day") {
    var lineChart = new CanvasJS.Chart("lineCharts", {
    animationEnabled: true,
    theme: "light2",
    title:{
        text: " DAY WISE REPORT"
    },
    axisX:{
        //includeZero: true,
        interval:1,
        title: "HOUR",
    },
    axisY:{
        interval:5,
        includeZero: true,
        title: type_r.toUpperCase(),
    },
    data: [{        
        type: "spline",       
        dataPoints: dataRx['daily_reading_chart']
    }]
});
    $('#lineCharts').show()
    $('#lineCharts').css({ "height": "370px", "max-width": "920px", "margin": "0px auto"})

lineChart.render();

}
}


}
        },
        error:function(error){
            console.log(error)
            console.log(url)
        }
     })   
    
    }



    if (page=="chart_coinc") {
        
       // alert(month1)
         var url=BASE_URL+"mis/get_coincendal_peak_chart_data";
     $.ajax({
        url:url,
        type:'POST',
        data:{month:month1,dt:dt1,date:date1,year:month1},
        success:function(response){
            console.log(response)

            var dataRx=JSON.parse(response);
            console.log(dataRx[0])
            if (dataRx.length<1) {
            }else{


                var chartCoin = new CanvasJS.Chart("coincendetal_peak_chart", {
    exportEnabled: true,
    animationEnabled: true,
    title:{
        text: ""
    },
    subtitles: [{
        text: ""
    }], 
    axisX: {
        title: "States"
    },
    axisY: {
        title: "Day Peak - MW",
        titleFontColor: "#4F81BC",
        lineColor: "#4F81BC",
        labelFontColor: "#4F81BC",
        tickColor: "#4F81BC"
    },
    axisY2: {
        title: "Night Peak - MW",
        titleFontColor: "#C0504E",
        lineColor: "#C0504E",
        labelFontColor: "#C0504E",
        tickColor: "#C0504E"
    },
    toolTip: {
        shared: true
    },
    legend: {
        cursor: "pointer",
        //itemclick: toggleDataSeries
    },
    data: [{
        type: "column",
        name: "Day Peak",
        showInLegend: true,      
        yValueFormatString: "#,##0.# Units",
        dataPoints:dataRx[0]
    },
    {
        type: "column",
        name: "Night Peak",
        axisYType: "secondary",
        showInLegend: true,
        yValueFormatString: "#,##0.# Units",
        dataPoints:dataRx[1]
    }]
});
$('#coincendetal_peak_chart').css({ "margin-bottom": "500px"})

chartCoin.render();

            }
        }
    })
    }
    
})
 