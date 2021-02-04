var datetime = require('node-datetime');
const csv = require('csv-parser');
const fs = require('fs');
var glob = require("glob");
var path = require('path');
const {
    Client
} = require('pg')
var InfiniteLoop = require('infinite-loop');
var il = new InfiniteLoop();

// DEFINISIKAN PATH GENERATE DAN IMPORT
var path = '../';



const conn = require('./pgsqlconnection');

const query = require('./pgsqlquery');



// CEK FILE YANG SUDAH DI IMPORT
async function checkFileImport() {
    return await new Promise((resolve, reject) => {
        conn.client.query('SELECT * from csv_imports', (err, res) => {
            resolve(res.rows);
            reject(err);
        })
    })
}

// CEK FILE DI ROOT
async function checkFileRoot() {
    return await new Promise((resolve, reject) => {
        glob.glob("**/*.csv", {
                cwd: path
            },
            function (err, res) {
                resolve(res)
                reject(err);
            });
    })
}

// INSERT PROCESS
async function insertProcess(dateTime, csvGenerated) {

    return new Promise((resolve, reject) => {
        // LOOP SEMUA DATA YANG BELUM DIIMPORT
        for (let index = 0; index < csvGenerated.length; index++) {
            // DEFINISI INSERT CSV_IMPORTS
            let data = {};
            data['file_name'] = csvGenerated[index];
            data['process_type'] = csvGenerated[index].split("_")[0];
            data['datetime'] = dateTime;
            // JIKA TIPE DATFILE TRF
            if (data['process_type'] === 'MOV') {
                // BACA ISI CSV TRF
                let file = path + data['file_name'];
                let results = [];
                fs.createReadStream(file)
                    .pipe(csv({
                        separator: ';',
                        headers: false
                    }))
                    .on('data', (data) => results.push(data))
                    .on('end', () => {
                        // LOOP ISI FILE
                        for (const t in results) {
                            if (results.hasOwnProperty(t)) {
                                // DEFINISI INSERT TRF
                                const element = results[t];
                                let data_tonn = {};

                                data_tonn['device'] = element['0'].split(":")[0]
                                data_tonn['job'] = element['0'].split(":")[1]
                                data_tonn['tonnage'] = element['3']
                                data_tonn['start_time'] = element['5']
                                data_tonn['end_time'] = element['6']
                                data_tonn['tstamp'] = dateTime

                                //  INSERT TRF
                                query.insert('hp_tonnage', data_tonn, function (res) {
                                    console.log(res.msg)
                                });

                                //  INSERT CSV_IMPORTS
                                query.insert('csv_imports', data, function (res) {
                                    console.log(res.msg)
                                });
                            }
                        }
                    });
            }

        }
    })
}

// LOOP PROCESS
async function loop() {
    var FileImports = await checkFileImport();
    var csvGenerated = await checkFileRoot();
    var dt = datetime.create();
    var dateTime = dt.format('Y-m-d H:M:S');

    // CEK UNTUK FILTER DATA YANG SUDAH DI IMPORT 
    for (const key in FileImports) {
        if (FileImports.hasOwnProperty(key)) {
            let FileImport = FileImports[key]['file_name'];
            csvGenerated = csvGenerated.filter(function (item) {
                // RETURN DATA YANG BELUM DIIMPORT
                return item !== FileImport
            })
        }
    }


    // PROCESS INSERT
    console.log('===================');
    await insertProcess(dateTime, csvGenerated);


}

il.setInterval(60000).add(loop).run();