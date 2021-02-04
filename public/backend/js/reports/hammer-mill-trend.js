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

function randomIntFromInterval(min, max) { // min and max included 
    return Math.floor(Math.random() * (max - min + 1) + min);
}

// Tonnage
function tonnage() {
    var consumption = echarts.init(document.getElementById('tonnage'));
    consumption.clear();
    option1 = {
        legend: {
            data: ['Hammer Mill 1', 'Hammer Mill 2', 'Hammer Mill 3'],
            textStyle: {
                color: "#ffffff"
            }
        },
        animation: true,
        tooltip: {
            trigger: 'axis',

            textStyle: {
                color: "#ffffff"
            }
        },
        toolbox: {

            feature: {
                restore: {
                    title: 'Reset',

                },
                saveAsImage: {
                    title: 'Save Png',
                },

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
            },

        },
        xAxis: {

            type: 'category',
            data: hm1.tstamp,
            splitLine: {
                show: true,
                onGap: null,
                // Garis Pebatas
                lineStyle: {
                    color: 'rgba(245, 245, 245, 0.10)',
                    type: 'solid',
                    width: 1,
                    shadowColor: 'rgba(245, 245, 245, 0.10)',
                    shadowBlur: 5,
                    shadowOffsetX: 3,
                    shadowOffsetY: 3,
                },

            },
            axisLabel: {
                color: "#ffffff"
            }

        },
        yAxis: {
            type: 'value',
            name: 'ton',
            nameTextStyle: {
                color: "#ffffff",
            },
            nameGap: 8,
            boundaryGap: [0, '5%'],
            axisLabel: {
                color: "#ffffff"
            },
            splitLine: {
                show: true,
                onGap: null,
                // Garis Pebatas
                lineStyle: {
                    color: 'rgba(245, 245, 245, 0.10)',
                    type: 'solid',
                    width: 1,
                    shadowColor: 'rgba(245, 245, 245, 0.10)',
                    shadowBlur: 5,
                    shadowOffsetX: 3,
                    shadowOffsetY: 3,
                },

            },
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
                type: 'slider',
                fillerColor: '#E9ECEF'
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
            name: 'Hammer Mill 1',
            type: 'line',
            smooth: true,
            barGap: '10%',
            data: hm1.tonnage,
            itemStyle: {
                shadowColor: '#DEE2E6',
                shadowBlur: 2,
            },
            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                offset: 0,
                color: '#4682b4' // color at 0% position
            }, {
                offset: 1,
                color: '#377fbb' // color at 100% position
            }], false)
        }, {
            name: 'Hammer Mill 2',
            type: 'line',
            smooth: true,
            barGap: '10%',
            data: hm2.tonnage,
            temStyle: {
                shadowColor: '#DEE2E6',
                shadowBlur: 2,
            },
            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                offset: 0,
                color: '#bd3e7d' // color at 0% position
            }, {
                offset: 1,
                color: '#953263' // color at 100% position
            }], false)

        }, {
            name: 'Hammer Mill 3',
            type: 'line',
            smooth: true,

            barGap: '10%',
            data: hm3.tonnage,
            temStyle: {
                shadowColor: '#DEE2E6',
                shadowBlur: 2,
            },
            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                offset: 0,
                color: '#f7d700' // color at 0% position
            }, {
                offset: 1,
                color: '#fba60c' // color at 100% position
            }], false)

        }],
        // Linear gradient. First four parameters are x0, y0, x2, and y2, each ranged from 0 to 1, standing for percentage in the bounding box. If another parameter is passed in as `true`, then the first four parameters are in absolute pixel positions.
        // color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
        //     offset: 0,
        //     color: 'red' // color at 0% position
        // }, {
        //     offset: 1,
        //     color: 'blue' // color at 100% position
        // }], false)
        // Radial gradient. First three parameters are x and y positions of center, and radius, similar to linear gradient.
        // color: new echarts.graphic.RadialGradient(0.5, 0.5, 0.5, [...], false)
        // // Fill with texture
        // color: new echarts.graphic.Pattern(
        //     imageDom, // HTMLImageElement, and HTMLCanvasElement are supported, while string path is not supported
        //     'repeat' // whether to repeat texture, whose value can be repeat-x, repeat-y, or no-repeat
        // )

        // color: ['#A1F89F', '#F5811E', '#018994']
    };
    consumption.setOption(option1);

}

function systemKwh() {
    var consumption = echarts.init(document.getElementById('system-kwh'));
    consumption.clear();
    option1 = {
        legend: {
            data: ['Hammer Mill 1', 'Hammer Mill 2', 'Hammer Mill 3'],
            textStyle: {
                color: "#ffffff"
            }
        },
        animation: true,
        tooltip: {
            trigger: 'axis',

            textStyle: {
                color: "#ffffff"
            }
        },
        toolbox: {

            feature: {
                restore: {
                    title: 'Reset',

                },
                saveAsImage: {
                    title: 'Save Png',
                },

            }
        },
        title: {
            left: 'center',
            text: '',

        },
        yAxis: {
            type: 'value',
            name: 'kwh',
            nameTextStyle: {
                color: "#ffffff",
            },
            nameGap: 8,
            boundaryGap: [0, '5%'],
            axisLabel: {
                color: "#ffffff"
            },
            splitLine: {
                show: true,
                onGap: null,
                // Garis Pebatas
                lineStyle: {
                    color: 'rgba(245, 245, 245, 0.10)',
                    type: 'solid',
                    width: 1,
                    shadowColor: 'rgba(245, 245, 245, 0.10)',
                    shadowBlur: 5,
                    shadowOffsetX: 3,
                    shadowOffsetY: 3,
                },

            },
        },
        xAxis: {

            type: 'category',
            data: hm1.tstamp,
            splitLine: {
                show: true,
                onGap: null,
                // Garis Pebatas
                lineStyle: {
                    color: 'rgba(245, 245, 245, 0.10)',
                    type: 'solid',
                    width: 1,
                    shadowColor: 'rgba(245, 245, 245, 0.10)',
                    shadowBlur: 5,
                    shadowOffsetX: 3,
                    shadowOffsetY: 3,
                },

            },
            axisLabel: {
                color: "#ffffff"
            }

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
                type: 'slider',
                fillerColor: '#E9ECEF'
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
            name: 'Hammer Mill 1',
            type: 'line',
            smooth: true,

            smooth: true,
            barGap: '10%',
            data: hm1.kwh_sys,
            itemStyle: {
                shadowColor: '#DEE2E6',
                shadowBlur: 2,
            },
            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                offset: 0,
                color: '#4682b4' // color at 0% position
            }, {
                offset: 1,
                color: '#377fbb' // color at 100% position
            }], false)
        }, {
            name: 'Hammer Mill 2',
            type: 'line',
            smooth: true,

            barGap: '10%',
            data: hm2.kwh_sys,
            itemStyle: {
                shadowColor: '#DEE2E6',
                shadowBlur: 2,
            },
            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                offset: 0,
                color: '#bd3e7d' // color at 0% position
            }, {
                offset: 1,
                color: '#953263' // color at 100% position
            }], false)

        }, {
            name: 'Hammer Mill 3',
            type: 'line',
            smooth: true,

            barGap: '10%',
            data: hm3.kwh_sys,
            itemStyle: {
                shadowColor: '#DEE2E6',
                shadowBlur: 2,
            },
            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                offset: 0,
                color: '#f7d700' // color at 0% position
            }, {
                offset: 1,
                color: '#fba60c' // color at 100% position
            }], false)

        }],
        // Linear gradient. First four parameters are x0, y0, x2, and y2, each ranged from 0 to 1, standing for percentage in the bounding box. If another parameter is passed in as `true`, then the first four parameters are in absolute pixel positions.
        // color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
        //     offset: 0,
        //     color: 'red' // color at 0% position
        // }, {
        //     offset: 1,
        //     color: 'blue' // color at 100% position
        // }], false)
        // Radial gradient. First three parameters are x and y positions of center, and radius, similar to linear gradient.
        // color: new echarts.graphic.RadialGradient(0.5, 0.5, 0.5, [...], false)
        // // Fill with texture
        // color: new echarts.graphic.Pattern(
        //     imageDom, // HTMLImageElement, and HTMLCanvasElement are supported, while string path is not supported
        //     'repeat' // whether to repeat texture, whose value can be repeat-x, repeat-y, or no-repeat
        // )

        // color: ['#A1F89F', '#F5811E', '#018994']
    };
    consumption.setOption(option1);

}

function motorKwh() {
    var consumption = echarts.init(document.getElementById('motor-kwh'));
    consumption.clear();
    option1 = {
        legend: {
            data: ['Hammer Mill 1', 'Hammer Mill 2', 'Hammer Mill 3'],
            textStyle: {
                color: "#ffffff"
            }
        },
        animation: true,
        tooltip: {
            trigger: 'axis',

            textStyle: {
                color: "#ffffff"
            }
        },
        toolbox: {

            feature: {
                restore: {
                    title: 'Reset',

                },
                saveAsImage: {
                    title: 'Save Png',
                },

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
            },

        },
        xAxis: {

            type: 'category',
            data: hm1.tstamp,
            splitLine: {
                show: true,
                onGap: null,
                // Garis Pebatas
                lineStyle: {
                    color: 'rgba(245, 245, 245, 0.10)',
                    type: 'solid',
                    width: 1,
                    shadowColor: 'rgba(245, 245, 245, 0.10)',
                    shadowBlur: 5,
                    shadowOffsetX: 3,
                    shadowOffsetY: 3,
                },

            },
            axisLabel: {
                color: "#ffffff"
            }

        },
        yAxis: {
            type: 'value',
            name: 'kwh',
            nameTextStyle: {
                color: "#ffffff",
            },
            nameGap: 8,
            boundaryGap: [0, '5%'],
            axisLabel: {
                color: "#ffffff"
            },
            splitLine: {
                show: true,
                onGap: null,
                // Garis Pebatas
                lineStyle: {
                    color: 'rgba(245, 245, 245, 0.10)',
                    type: 'solid',
                    width: 1,
                    shadowColor: 'rgba(245, 245, 245, 0.10)',
                    shadowBlur: 5,
                    shadowOffsetX: 3,
                    shadowOffsetY: 3,
                },

            },
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
                type: 'slider',
                fillerColor: '#E9ECEF'
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
            name: 'Hammer Mill 1',
            type: 'line',
            smooth: true,
            barGap: '10%',
            data: hm1.kwh_sys,
            itemStyle: {
                shadowColor: '#DEE2E6',
                shadowBlur: 2,
            },
            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                offset: 0,
                color: '#4682b4' // color at 0% position
            }, {
                offset: 1,
                color: '#377fbb' // color at 100% position
            }], false)
        }, {
            name: 'Hammer Mill 2',
            type: 'line',
            barGap: '10%',
            smooth: true,

            data: hm2.kwh_motor,

            itemStyle: {
                shadowColor: '#DEE2E6',
                shadowBlur: 2,
            },
            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                offset: 0,
                color: '#bd3e7d' // color at 0% position
            }, {
                offset: 1,
                color: '#953263' // color at 100% position
            }], false)

        }, {
            name: 'Hammer Mill 3',
            type: 'line',
            barGap: '10%',
            smooth: true,

            data: hm3.kwh_motor,
            itemStyle: {
                shadowColor: '#DEE2E6',
                shadowBlur: 2,
            },
            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                offset: 0,
                color: '#f7d700' // color at 0% position
            }, {
                offset: 1,
                color: '#fba60c' // color at 100% position
            }], false)

        }],
        // Linear gradient. First four parameters are x0, y0, x2, and y2, each ranged from 0 to 1, standing for percentage in the bounding box. If another parameter is passed in as `true`, then the first four parameters are in absolute pixel positions.
        // color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
        //     offset: 0,
        //     color: 'red' // color at 0% position
        // }, {
        //     offset: 1,
        //     color: 'blue' // color at 100% position
        // }], false)
        // Radial gradient. First three parameters are x and y positions of center, and radius, similar to linear gradient.
        // color: new echarts.graphic.RadialGradient(0.5, 0.5, 0.5, [...], false)
        // // Fill with texture
        // color: new echarts.graphic.Pattern(
        //     imageDom, // HTMLImageElement, and HTMLCanvasElement are supported, while string path is not supported
        //     'repeat' // whether to repeat texture, whose value can be repeat-x, repeat-y, or no-repeat
        // )

        // color: ['#A1F89F', '#F5811E', '#018994']
    };
    consumption.setOption(option1);

}

function current() {
    var consumption = echarts.init(document.getElementById('current'));
    consumption.clear();
    option1 = {
        legend: {
            data: ['Hammer Mill 1', 'Hammer Mill 2', 'Hammer Mill 3'],
            textStyle: {
                color: "#ffffff"
            }
        },
        animation: true,
        tooltip: {
            trigger: 'axis',

            textStyle: {
                color: "#ffffff"
            }
        },
        toolbox: {

            feature: {
                restore: {
                    title: 'Reset',

                },
                saveAsImage: {
                    title: 'Save Png',
                },

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
            },

        },
        xAxis: {

            type: 'category',
            data: hm1.tstamp,
            splitLine: {
                show: true,
                onGap: null,
                // Garis Pebatas
                lineStyle: {
                    color: 'rgba(245, 245, 245, 0.10)',
                    type: 'solid',
                    width: 1,
                    shadowColor: 'rgba(245, 245, 245, 0.10)',
                    shadowBlur: 5,
                    shadowOffsetX: 3,
                    shadowOffsetY: 3,
                },

            },
            axisLabel: {
                color: "#ffffff"
            }

        },
        yAxis: {
            type: 'value',
            name: 'A',
            nameTextStyle: {
                color: "#ffffff",
            },
            nameGap: 8,
            boundaryGap: [0, '5%'],
            axisLabel: {
                color: "#ffffff"
            },
            splitLine: {
                show: true,
                onGap: null,
                // Garis Pebatas
                lineStyle: {
                    color: 'rgba(245, 245, 245, 0.10)',
                    type: 'solid',
                    width: 1,
                    shadowColor: 'rgba(245, 245, 245, 0.10)',
                    shadowBlur: 5,
                    shadowOffsetX: 3,
                    shadowOffsetY: 3,
                },

            },
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
                type: 'slider',
                fillerColor: '#E9ECEF'
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
            name: 'Hammer Mill 1',
            type: 'line',
            smooth: true,
            barGap: '10%',
            data: hm1.current,
            itemStyle: {
                shadowColor: '#DEE2E6',
                shadowBlur: 2,
            },
            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                offset: 0,
                color: '#4682b4' // color at 0% position
            }, {
                offset: 1,
                color: '#377fbb' // color at 100% position
            }], false)
        }, {
            name: 'Hammer Mill 2',
            type: 'line',
            smooth: true,
            barGap: '10%',
            data: hm2.current,

            itemStyle: {
                shadowColor: '#DEE2E6',
                shadowBlur: 2,
            },
            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                offset: 0,
                color: '#bd3e7d' // color at 0% position
            }, {
                offset: 1,
                color: '#953263' // color at 100% position
            }], false)

        }, {
            name: 'Hammer Mill 3',
            type: 'line',
            smooth: true,
            barGap: '10%',
            data: hm3.current,
            itemStyle: {
                shadowColor: '#DEE2E6',
                shadowBlur: 2,
            },
            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                offset: 0,
                color: '#f7d700' // color at 0% position
            }, {
                offset: 1,
                color: '#fba60c' // color at 100% position
            }], false)

        }],
        // Linear gradient. First four parameters are x0, y0, x2, and y2, each ranged from 0 to 1, standing for percentage in the bounding box. If another parameter is passed in as `true`, then the first four parameters are in absolute pixel positions.
        // color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
        //     offset: 0,
        //     color: 'red' // color at 0% position
        // }, {
        //     offset: 1,
        //     color: 'blue' // color at 100% position
        // }], false)
        // Radial gradient. First three parameters are x and y positions of center, and radius, similar to linear gradient.
        // color: new echarts.graphic.RadialGradient(0.5, 0.5, 0.5, [...], false)
        // // Fill with texture
        // color: new echarts.graphic.Pattern(
        //     imageDom, // HTMLImageElement, and HTMLCanvasElement are supported, while string path is not supported
        //     'repeat' // whether to repeat texture, whose value can be repeat-x, repeat-y, or no-repeat
        // )

        // color: ['#A1F89F', '#F5811E', '#018994']
    };
    consumption.setOption(option1);

}

function current_motor() {
    var consumption = echarts.init(document.getElementById('current-motor'));
    consumption.clear();
    option1 = {
        legend: {
            data: ['Hammer Mill 1', 'Hammer Mill 2', 'Hammer Mill 3'],
            textStyle: {
                color: "#ffffff"
            }
        },
        animation: true,
        tooltip: {
            trigger: 'axis',

            textStyle: {
                color: "#ffffff"
            }
        },
        toolbox: {

            feature: {
                restore: {
                    title: 'Reset',

                },
                saveAsImage: {
                    title: 'Save Png',
                },

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
            },

        },
        xAxis: {

            type: 'category',
            data: hm1.tstamp,
            splitLine: {
                show: true,
                onGap: null,
                // Garis Pebatas
                lineStyle: {
                    color: 'rgba(245, 245, 245, 0.10)',
                    type: 'solid',
                    width: 1,
                    shadowColor: 'rgba(245, 245, 245, 0.10)',
                    shadowBlur: 5,
                    shadowOffsetX: 3,
                    shadowOffsetY: 3,
                },

            },
            axisLabel: {
                color: "#ffffff"
            }

        },
        yAxis: {
            type: 'value',
            name: 'A',
            nameTextStyle: {
                color: "#ffffff",
            },
            nameGap: 8,
            boundaryGap: [0, '5%'],
            axisLabel: {
                color: "#ffffff"
            },
            splitLine: {
                show: true,
                onGap: null,
                // Garis Pebatas
                lineStyle: {
                    color: 'rgba(245, 245, 245, 0.10)',
                    type: 'solid',
                    width: 1,
                    shadowColor: 'rgba(245, 245, 245, 0.10)',
                    shadowBlur: 5,
                    shadowOffsetX: 3,
                    shadowOffsetY: 3,
                },

            },
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
                type: 'slider',
                fillerColor: '#E9ECEF'
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
            name: 'Hammer Mill 1',
            type: 'line',
            smooth: true,
            barGap: '10%',
            data: hm1.current_motor,
            itemStyle: {
                shadowColor: '#DEE2E6',
                shadowBlur: 2,
            },
            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                offset: 0,
                color: '#4682b4' // color at 0% position
            }, {
                offset: 1,
                color: '#377fbb' // color at 100% position
            }], false)
        }, {
            name: 'Hammer Mill 2',
            type: 'line',
            smooth: true,
            barGap: '10%',
            data: hm2.current_motor,

            itemStyle: {
                shadowColor: '#DEE2E6',
                shadowBlur: 2,
            },
            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                offset: 0,
                color: '#bd3e7d' // color at 0% position
            }, {
                offset: 1,
                color: '#953263' // color at 100% position
            }], false)

        }, {
            name: 'Hammer Mill 3',
            type: 'line',
            smooth: true,
            barGap: '10%',
            data: hm3.current_motor,
            itemStyle: {
                shadowColor: '#DEE2E6',
                shadowBlur: 2,
            },
            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                offset: 0,
                color: '#f7d700' // color at 0% position
            }, {
                offset: 1,
                color: '#fba60c' // color at 100% position
            }], false)

        }],
        // Linear gradient. First four parameters are x0, y0, x2, and y2, each ranged from 0 to 1, standing for percentage in the bounding box. If another parameter is passed in as `true`, then the first four parameters are in absolute pixel positions.
        // color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
        //     offset: 0,
        //     color: 'red' // color at 0% position
        // }, {
        //     offset: 1,
        //     color: 'blue' // color at 100% position
        // }], false)
        // Radial gradient. First three parameters are x and y positions of center, and radius, similar to linear gradient.
        // color: new echarts.graphic.RadialGradient(0.5, 0.5, 0.5, [...], false)
        // // Fill with texture
        // color: new echarts.graphic.Pattern(
        //     imageDom, // HTMLImageElement, and HTMLCanvasElement are supported, while string path is not supported
        //     'repeat' // whether to repeat texture, whose value can be repeat-x, repeat-y, or no-repeat
        // )

        // color: ['#A1F89F', '#F5811E', '#018994']
    };
    consumption.setOption(option1);

}

function voltage() {
    var consumption = echarts.init(document.getElementById('voltage'));
    consumption.clear();
    option1 = {
        legend: {
            data: ['Hammer Mill 1', 'Hammer Mill 2', 'Hammer Mill 3'],
            textStyle: {
                color: "#ffffff"
            }
        },
        animation: true,
        tooltip: {
            trigger: 'axis',

            textStyle: {
                color: "#ffffff"
            }
        },
        toolbox: {

            feature: {
                restore: {
                    title: 'Reset',

                },
                saveAsImage: {
                    title: 'Save Png',
                },

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
            },

        },
        xAxis: {

            type: 'category',
            data: hm1.tstamp,
            splitLine: {
                show: true,
                onGap: null,
                // Garis Pebatas
                lineStyle: {
                    color: 'rgba(245, 245, 245, 0.10)',
                    type: 'solid',
                    width: 1,
                    shadowColor: 'rgba(245, 245, 245, 0.10)',
                    shadowBlur: 5,
                    shadowOffsetX: 3,
                    shadowOffsetY: 3,
                },

            },
            axisLabel: {
                color: "#ffffff"
            }

        },
        yAxis: {
            type: 'value',
            name: 'volt',
            nameTextStyle: {
                color: "#ffffff",
            },
            nameGap: 8,
            scale: true,
            max: 480,
            min: 300,
            splitNumber: 4,
            boundaryGap: [0, '5%'],
            axisLabel: {
                color: "#ffffff"
            },
            splitLine: {
                show: true,
                onGap: null,
                // Garis Pebatas
                lineStyle: {
                    color: 'rgba(245, 245, 245, 0.10)',
                    type: 'solid',
                    width: 1,
                    shadowColor: 'rgba(245, 245, 245, 0.10)',
                    shadowBlur: 5,
                    shadowOffsetX: 3,
                    shadowOffsetY: 3,
                },

            },
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
                type: 'slider',
                fillerColor: '#E9ECEF'
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
            name: 'Hammer Mill 1',
            type: 'line',
            smooth: true,
            barGap: '10%',
            data: hm1.voltage,
            itemStyle: {
                shadowColor: '#DEE2E6',
                shadowBlur: 2,
            },
            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                offset: 0,
                color: '#4682b4' // color at 0% position
            }, {
                offset: 1,
                color: '#377fbb' // color at 100% position
            }], false)
        }, {
            name: 'Hammer Mill 2',
            type: 'line',
            smooth: true,
            barGap: '10%',
            data: hm2.voltage,

            itemStyle: {
                shadowColor: '#DEE2E6',
                shadowBlur: 2,
            },
            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                offset: 0,
                color: '#bd3e7d' // color at 0% position
            }, {
                offset: 1,
                color: '#953263' // color at 100% position
            }], false)

        }, {
            name: 'Hammer Mill 3',
            type: 'line',
            smooth: true,
            barGap: '10%',
            data: hm3.voltage,
            itemStyle: {
                shadowColor: '#DEE2E6',
                shadowBlur: 2,
            },
            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                offset: 0,
                color: '#f7d700' // color at 0% position
            }, {
                offset: 1,
                color: '#fba60c' // color at 100% position
            }], false)

        }],
        // Linear gradient. First four parameters are x0, y0, x2, and y2, each ranged from 0 to 1, standing for percentage in the bounding box. If another parameter is passed in as `true`, then the first four parameters are in absolute pixel positions.
        // color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
        //     offset: 0,
        //     color: 'red' // color at 0% position
        // }, {
        //     offset: 1,
        //     color: 'blue' // color at 100% position
        // }], false)
        // Radial gradient. First three parameters are x and y positions of center, and radius, similar to linear gradient.
        // color: new echarts.graphic.RadialGradient(0.5, 0.5, 0.5, [...], false)
        // // Fill with texture
        // color: new echarts.graphic.Pattern(
        //     imageDom, // HTMLImageElement, and HTMLCanvasElement are supported, while string path is not supported
        //     'repeat' // whether to repeat texture, whose value can be repeat-x, repeat-y, or no-repeat
        // )

        // color: ['#A1F89F', '#F5811E', '#018994']
    };
    consumption.setOption(option1);

}

function kwhTon() {
    var consumption = echarts.init(document.getElementById('kwh_ton'));
    consumption.clear();
    option1 = {
        legend: {
            data: ['Hammer Mill 1', 'Hammer Mill 2', 'Hammer Mill 3'],
            textStyle: {
                color: "#ffffff"
            }
        },
        animation: true,
        tooltip: {
            trigger: 'axis',

            textStyle: {
                color: "#ffffff"
            }
        },
        toolbox: {

            feature: {
                restore: {
                    title: 'Reset',

                },
                saveAsImage: {
                    title: 'Save Png',
                },

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
            },

        },
        xAxis: {

            type: 'category',
            data: hm1.tstamp,
            splitLine: {
                show: true,
                onGap: null,
                // Garis Pebatas
                lineStyle: {
                    color: 'rgba(245, 245, 245, 0.10)',
                    type: 'solid',
                    width: 1,
                    shadowColor: 'rgba(245, 245, 245, 0.10)',
                    shadowBlur: 5,
                    shadowOffsetX: 3,
                    shadowOffsetY: 3,
                },

            },
            axisLabel: {
                color: "#ffffff"
            }

        },
        yAxis: {
            type: 'value',
            name: 'kwh/ton',
            nameTextStyle: {
                color: "#ffffff",
            },
            nameGap: 8,
            boundaryGap: [0, '5%'],
            axisLabel: {
                color: "#ffffff"
            },
            splitLine: {
                show: true,
                onGap: null,
                // Garis Pebatas
                lineStyle: {
                    color: 'rgba(245, 245, 245, 0.10)',
                    type: 'solid',
                    width: 1,
                    shadowColor: 'rgba(245, 245, 245, 0.10)',
                    shadowBlur: 5,
                    shadowOffsetX: 3,
                    shadowOffsetY: 3,
                },

            },
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
                type: 'slider',
                fillerColor: '#E9ECEF'
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
            name: 'Hammer Mill 1',
            type: 'line',
            smooth: true,
            barGap: '10%',
            data: hm1.kwh_ton,
            itemStyle: {
                shadowColor: '#DEE2E6',
                shadowBlur: 2,
            },
            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                offset: 0,
                color: '#4682b4' // color at 0% position
            }, {
                offset: 1,
                color: '#377fbb' // color at 100% position
            }], false)
        }, {
            name: 'Hammer Mill 2',
            type: 'line',
            smooth: true,
            barGap: '10%',
            data: hm2.kwh_ton,

            itemStyle: {
                shadowColor: '#DEE2E6',
                shadowBlur: 2,
            },
            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                offset: 0,
                color: '#bd3e7d' // color at 0% position
            }, {
                offset: 1,
                color: '#953263' // color at 100% position
            }], false)

        }, {
            name: 'Hammer Mill 3',
            type: 'line',
            smooth: true,
            barGap: '10%',
            data: hm3.kwh_ton,
            itemStyle: {
                shadowColor: '#DEE2E6',
                shadowBlur: 2,
            },
            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                offset: 0,
                color: '#f7d700' // color at 0% position
            }, {
                offset: 1,
                color: '#fba60c' // color at 100% position
            }], false)

        }],
        // Linear gradient. First four parameters are x0, y0, x2, and y2, each ranged from 0 to 1, standing for percentage in the bounding box. If another parameter is passed in as `true`, then the first four parameters are in absolute pixel positions.
        // color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
        //     offset: 0,
        //     color: 'red' // color at 0% position
        // }, {
        //     offset: 1,
        //     color: 'blue' // color at 100% position
        // }], false)
        // Radial gradient. First three parameters are x and y positions of center, and radius, similar to linear gradient.
        // color: new echarts.graphic.RadialGradient(0.5, 0.5, 0.5, [...], false)
        // // Fill with texture
        // color: new echarts.graphic.Pattern(
        //     imageDom, // HTMLImageElement, and HTMLCanvasElement are supported, while string path is not supported
        //     'repeat' // whether to repeat texture, whose value can be repeat-x, repeat-y, or no-repeat
        // )

        // color: ['#A1F89F', '#F5811E', '#018994']
    };
    consumption.setOption(option1);

}

$(function () {
    var tonnage = echarts.init(document.getElementById('tonnage'));
    var systemKwh = echarts.init(document.getElementById('system-kwh'));
    var motorKwh = echarts.init(document.getElementById('motor-kwh'));
    var current = echarts.init(document.getElementById('current'));
    var current_motor = echarts.init(document.getElementById('current_motor'));
    var voltage = echarts.init(document.getElementById('voltage'));
    resizeChart(tonnage, 'tonnage');
    resizeChart(systemKwh, 'system-kwh');
    resizeChart(motorKwh, 'motor-kwh');
    resizeChart(current, 'current');
    resizeChart(current_motor, 'current_motor');
    resizeChart(voltage, 'voltage');


    function resizeChart(el, id) {
        new ResizeSensor(jQuery('#' + id), function () {
            el.resize();
        })
    }
});
