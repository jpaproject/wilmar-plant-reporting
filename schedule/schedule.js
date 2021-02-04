var schedule = require('node-schedule');
var exec = require('child_process').exec;



var j = schedule.scheduleJob('00 00 10 * * *', function () {
    // --- Backup Database 
    let commandBackup1 = exec('cd ../  && php artisan alarm:dashboard && php artisan alarm:silo ');
    commandBackup1.stdout.on('data', function (data) {
        // console.log('ALARM : ====' + data);
    });
});


var k = schedule.scheduleJob('00 01 * * * *', function () {
    // --- Backup Database 
    // let commandBackup = exec('cd ../ && php artisan alarm:mills && php artisan alarm:dashboard && php artisan alarm:silo ');
    // commandBackup.stdout.on('data', function (data) {
    // console.log('ALARM ');
    let commandBackup2 = exec('cd ../ && php artisan alarm:voltage && php artisan alarm:mills  && php artisan alarm:wb');
    commandBackup2.stdout.on('data', function (data) {
        // console.log('ALARM : ====' + data);
    });
    // });
});
var wb = schedule.scheduleJob('*/5 * * * *', function () {
    // --- Backup Database 
    // let commandBackup = exec('cd ../ && php artisan alarm:mills && php artisan alarm:dashboard && php artisan alarm:silo ');
    // commandBackup.stdout.on('data', function (data) {
    // console.log('ALARM ');
    let commandBackup2 = exec('cd ../ && php artisan alarm:wb');
    commandBackup2.stdout.on('data', function (data) {
        // console.log('ALARM : ====' + data);
    });
    // });
});

var l = schedule.scheduleJob('00 05 * * * *', function () {
    // --- Backup Database 
    // let commandBackup = exec('cd ../ && php artisan alarm:mills && php artisan alarm:dashboard && php artisan alarm:silo ');
    // commandBackup.stdout.on('data', function (data) {
    // console.log('ALARM ');
    let commandBackup3 = exec('cd ../ && php artisan alarm:mixers');
    commandBackup3.stdout.on('data', function (data) {
        // console.log('ALARM : ====' + data);
    });
    // });
});

