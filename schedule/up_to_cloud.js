var schedule = require('node-schedule');
var exec = require('child_process').exec;
const axios = require('axios');
var fs = require('fs');

var j = schedule.scheduleJob('*/5 * * * *', function () {
    // --- Backup Database 
    upWeightBridge();
    upTrf();
    upAdjustment();
    upMixer();
    upHpMaterial();
});

var k = schedule.scheduleJob('*/10 * * * * *', function () {
    // --- Backup Database 
    upHpMill() 
});

function upHpMaterial() {
    axios.post('http://192.168.28.11/plant-reporting/public/api/hp-material', {})
        .then(function (response) {
            // console.log(response.data.msg);
            // writeLog('MIX', response.data.datetime, response.data.msg)
        })
        .catch(function (error) {
            console.log("error");
        });
};
function upHpMill() {
    axios.get('http://192.168.28.11/plant-reporting/public/api/hp-mill', {})
        .then(function (response) {
            console.log(response.data.msg);
            // writeLog('MIX', response.data.datetime, response.data.msg)
        })
        .catch(function (error) {
            console.log(error);
        });
};

function upMixer() {
    axios.get('http://192.168.28.11/plant-reporting/public/api/mixer', {})
        .then(function (response) {
            // console.log(response.data.msg);
            // writeLog('MIX', response.data.datetime, response.data.msg)
        })
        .catch(function (error) {
            // console.log("WEBSOCKET ERROR ! ");
        });
};


function upAdjustment() {
    axios.get('http://192.168.28.11/plant-reporting/public/api/adjustment', {})
        .then(function (response) {
            // console.log(response.data.msg);
            // writeLog('ADJ', response.data.datetime, response.data.msg)
        })
        .catch(function (error) {
            // console.log("WEBSOCKET ERROR ! ");
        });
};

function upTrf() {
    axios.post('http://192.168.28.11/plant-reporting/public/api/trf', {})
        .then(function (response) {
            // console.log(response.data.msg);
            // writeLog('TRF', response.data.datetime, response.data.msg)
        })
        .catch(function (error) {
            // console.log("WEBSOCKET ERROR ! ");
        });
};


function upWeightBridge() {
    axios.post('http://192.168.28.11/plant-reporting/public/api/weight-bridge', {})
        .then(function (response) {
            // console.log(response.data.msg);
            // writeLog('WB', response.data.datetime, response.data.msg)
        })
        .catch(function (error) {
            // console.log("WEBSOCKET ERROR ! ");
        });
};

// -- Write File
function writeLog(process,datetime,msg) {
    var stream = fs.createWriteStream("./logs_cloud/" +process+'_'+ datetime+".txt");
    stream.once('open', function (fd) {
        stream.write(datetime+"\n");
        stream.write(msg+"\n");
        stream.end();
    });
}





