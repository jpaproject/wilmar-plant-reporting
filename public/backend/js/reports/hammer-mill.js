// ================* MOTHLY *


function submitDate() {
    let daterange = $('#daterange').val();
    let date = $('#date').val()
    if (daterange == 'day' || daterange == 'minute') {
        date = $('#date').val()
    } else if (daterange == 'month') {
        date = $('#month').val()
    } else if (daterange == 'year') {
        date = $('#year').val()
    }
    $('#status').html('<span class="tx-12 align-self-center badge badge-warning">Loading ...</span>')
    toastr.warning(new Date().toLocaleString('en-US', {
            timeZone: 'Asia/Jakarta'
        }) +
        ": Loading..");
    axios.post('./api/consumption', {
            date: date,
            daterange: daterange,
        })
        .then(function (response) {
            toastr.success(new Date().toLocaleString('en-US', {
                timeZone: 'Asia/Jakarta'
            }) + ": Success !");
            $('#periode').text(response.data.date)
            $('#date').val(response.data.date)
            let dataCount = response.data.dataexist.tstamp.length;
            if (dataCount > 0) {
                $('#status').html(dataCount + ' data : ' + '<span class="tx-12 align-self-center badge badge-success">Success</span> ')
            } else {
                $('#status').html(dataCount + ' data : ' + '<span class="tx-12 align-self-center badge badge-danger">No Data Available</span> ')
            }
            dataExist(response.data.dataexist);
            dataTotal(response.data.datatotal);

            // Datatable Add

            // --dataexist
            table.clear();
            $.each(response.data.dataexist.all, function (i, key) {
                table.row.add([
                    i + 1,
                    response.data.dataexist.all[i].datetime,
                    response.data.dataexist.all[i].kwh_exist,
                    response.data.dataexist.all[i].kvarh_exist,
                    response.data.dataexist.all[i].kvah_exist,
                ])
            });
            table.draw();

            // --datatotal
            table2.clear();
            $.each(response.data.dataexist.all, function (i, key) {
                table2.row.add([
                    i + 1,
                    response.data.dataexist.all[i].datetime,
                    response.data.dataexist.all[i].kwh_total,
                    response.data.dataexist.all[i].kvarh_total,
                    response.data.dataexist.all[i].kvah_total,
                ])
            });
            table2.draw();

        })
        .catch(function (error) {

            toastr.error("Failed !");
            $('#status').html('<span class="tx-12 align-self-center badge badge-danger">Failed</span>')

            console.log(error);
        });
}
// ---DATA EXIST
function dataExist() {
    var consumption = echarts.init(document.getElementById('data-exist'));
    consumption.clear();
    option1 = {
        legend: {
            data: ['kWh/Ton', 'kWh', 'Ton']
        },
        animation: true,
        tooltip: {
            trigger: 'axis',
             
        },
        toolbox: {
            feature: {
                restore: {
                    title: 'Reset',
                },
                saveAsImage: {
                    title: 'Save Png',
                }
            }
        },
        title: {
            left: 'center',
            text: '',
        },
        yAxis: {
            type: 'value',
            axisLabel: {
                formatter: function (val) {
                    return (val) + '%';
                }
            }
        },
        xAxis: {
            type: 'category',
            data: data_chart.tstamp,
            splitLine: {
                show: true,
                onGap: null,
                // Garis Pebatas
                lineStyle: {
                    color: '#E4E4E4',
                    type: 'solid',
                    width: 1,
                    shadowColor: 'rgba(0,0,0,0)',
                    shadowBlur: 5,
                    shadowOffsetX: 3,
                    shadowOffsetY: 3,
                },
            },
        },
        yAxis: {
            type: 'value',
            boundaryGap: [0, '5%']
        },
        grid: {
            x: 60,
            y: 20,
            x2: 40,
            y2: 80
        },
        dataZoom: [{
                type: 'inside',
                start: 0,
            },
            {
                start: 0,
                handleSize: '100%',
                handleStyle: {
                    color: '#fff',
                    shadowBlur: 10,
                    shadowColor: 'rgba(0, 0, 0, 0.6)',
                    shadowOffsetX: 2,
                    shadowOffsetY: 2
                }
            }
        ],
        
        series: [{
            name: 'kWh/Ton',
            type: 'bar',
            barGap: '2%',
            detail: {
                formatter: '{value} ' + 'kWh/Ton',
                offsetCenter: [0, '90%'],
                textStyle: {
                    color: 'auto',
                    // fontWeight: 'bolder'
                }
            },
            data: data_chart.kwh_ton
        }
        // , {
        //     name: 'kWh',
        //     type: 'bar',
        //     barGap: '2%',
        //         data: data_chart.kwh

        // }
        // , {
        //     name: 'Ton',
        //     type: 'bar',
        //     barGap: '2%',
        //         data: data_chart.ton

        // }
    ],
        color: [ '#FABD2A', '#F9A825']
    };
    consumption.setOption(option1);

}

$(function () {
    var consumption = echarts.init(document.getElementById('data-exist'));
    new ResizeSensor(jQuery('#data-exist'), function () {
        console.log('Changed');
        consumption.resize();
    })
});
