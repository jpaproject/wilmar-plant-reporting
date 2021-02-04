 
 
 
function totalMaterial() {
    var consumption = echarts.init(document.getElementById('data-exist'));
    consumption.clear();
    option1 = {
        legend: {
            data: ['CORN', 'SOYA', 'WHEAT']
        },
        animation: true,
        tooltip: {
            trigger: 'axis',
            position: function (pt) {
                return [pt[0], '10%'];
            }
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
        xAxis: {
            type: 'category',
            data: ['-'],
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
            name: 'CORN',
            type: 'bar',
            barGap: '2%',
            data: [25, 30, 18]
        }, {
            name: 'SOYA',
            type: 'bar',
            barGap: '2%',
            data: [10, 29, 13]

        }, {
            name: 'WHEAT',
            type: 'bar',
            barGap: '2%',

            data: [28, 20, 30]

        }],
        color: ['#86111E', '#388E3C', '#F9A825']
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
