const sql = require('mssql')
const perf = require('execution-time')();
var datetime = require('node-datetime');
const {
    Client
} = require('pg')
const conn = require('./pgsqlconnection');

const query = require('./pgsqlquery');

perf.start();

// async function connect() {
//     try {
//         // make sure that any items are correctly URL encoded in the connection string
//         await sql.connect('mssql://sa:root@localhost/testing')
//         // const result = await sql.query `select * from news`
//         // console.dir(result)


//             for (let index = 0; index < 10; index++) {

//                 await new Promise( (resolve, reject) => {
//                     create((r)=>{
//                         resolve(r);
//                     });
//                 })
//             }

//         const results = perf.stop();
//         let second = results.time / 1000;
//         let miliseconds = results.time;
//         console.log('MONGO INSERT 100.000 ROW IN : ' + miliseconds + ' ms')
//         console.log('MONGO INSERT 100.000 ROW IN : ' + second + ' s')
//     } catch (err) {
//         // ... error checks
//         console.log(err.stack)
//     }
// }


// async function create(callback) {
//     const table = new sql.Table('news') // or temporary table, e.g. #temptable
//     table.create = true
//     // table.columns.add('a', sql.Int, {
//     //     nullable: false,
//     //     primary: true
//     // })

//     table.columns.add('device_name', sql.VarChar(sql.MAX), {
//         nullable: true
//     })
//     table.columns.add('value1', sql.Real, {
//         nullable: true
//     })
//     table.columns.add('value2', sql.Real, {
//         nullable: true
//     })
//     table.columns.add('value3', sql.Real, {
//         nullable: true
//     })
//     table.rows.add('DEVICE_1', Math.floor(Math.random() * 100) + 0.6, Math.floor(Math.random() * 100) + 1, 

// Math.floor(Math.random() * 1000) + 1)
//     const request = new sql.Request()
//     request.bulk(table, (err, result) => {
//         // ... error checks
//         if (err)
//             console.log("EEEROR:" + err);
//         else
//             callback(result);
//             // console.log(result);
//     })

// }
async function checkFileImport() {
    return await new Promise((resolve, reject) => {
        conn.client.query('SELECT ticket,wbcat from wbfile order by id desc limit 1', (err, res) => {
            resolve(res.rows);
            reject(err);
        })
    })
}
async function read() {
    try {

        var wbfile = await checkFileImport();

        await sql.connect('mssql://sa:sql@localhost/feedmill')
        const result = await sql.query`select top 1 * from wbfile order by datein desc , timein desc`;
        // const result = await sql.query`select * from wbfile`;
        var dataRespon = result.recordset;
      

        if (dataRespon[0].ticket != wbfile[0].ticket && dataRespon[0].wbcat != wbfile[0].wbcat) {
            for (const iterator of dataRespon) {
                query.insert('wbfile', iterator, function (res) {
                    console.log(res)
                });
            }
        }

       

    } catch (err) {
        // ... error checks
        console.log(err)
    }
}

setInterval(() => {
    read();
},1000)

// connect()