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



const conn = require('./vps-pgsqlconnection');

const query = require('./vps-pgsqlquery');



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
            if (data['process_type'] === 'POS') {
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
                        let mixer = {};
                        let details = [];

                        let data_mixer = {};
                        for (const t in results) {
                            if (results.hasOwnProperty(t)) {
                                // console.log(results)
                                // DEFINISI INSERT POS
                                const element = results[t];
                                let isMixer = Object.keys(results[t]).length;
                                // ---- definisi mixer
                                if (isMixer > 5) {
                                    data_mixer['tstamp'] = dateTime
                                    data_mixer['job'] = element[0]
                                    data_mixer['id_formula'] = element[1]
                                    data_mixer['total_batch'] = element[2]
                                    data_mixer['qty_target'] = element[3]
                                    data_mixer['qty_actual'] = element[4]
                                    data_mixer['product_ident'] = element[5]
                                    data_mixer['start_date'] = element[6]
                                    data_mixer['end_date'] = element[7]
                                    // console.log(data_mixer);
                                }

                                // ---- definisi detail mixer
                                if (isMixer < 8) {
                                    let detail_mixer = {};
                                    detail_mixer['tstamp'] = dateTime
                                    detail_mixer['id_rawmate'] = element[0]
                                    detail_mixer['rawmate_name'] = element[1]
                                    detail_mixer['qty_target'] = element[2]
                                    detail_mixer['qty_actual'] = element[3]
                                    // console.log(detail_mixer);
                                    details.push(detail_mixer);
                                }
                            }
                        }
                        mixer['data_mixer'] = data_mixer;
                        mixer['detail_mixer'] = details;

                        //  INSERT MIXERS
                        query.insert('mixers', mixer.data_mixer, function (res) {
                           // console.log(res.msg)
                            // ---- INSERT MIXER DETAILS
                            for (const m in mixer['detail_mixer']) {
                                let detail = mixer['detail_mixer'][m]
                                let d = {};
                                detail['mixer_id'] = res.id
                                query.insert('mixer_details', detail, function (res2) {
                                 //   console.log(res2.msg)
                                });
                            }
                        });
                        
                        //  INSERT CSV_IMPORTS
                        query.insert('csv_imports', data, function (res) {
                           // console.log(res.msg)
                        });

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
   // console.log('===================');
    await insertProcess(dateTime, csvGenerated);


}

il.setInterval(300000).add(loop).run();