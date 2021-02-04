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
        conn.client.query('SELECT ticket from feedmills order by id desc limit 1', (err, res) => {
            resolve(res.rows);
            reject(err);
        })
    })
}
async function read() {
    try {

        var wbfile = await checkFileImport();

        await sql.connect('mssql://sa:sql@localhost/feedmill')
        const result = await sql.query`use feedmill
        select top 1 a.ticket, a.itemno, a.datein, a.dateout, a.timein, a.timeout, a.nett, a.jumlah_bag ,a.potongan, a.nett - a.potongan as 'nett_potong'
        from(
        select a.ticket, a.itemno, a.datein, a.dateout, a.timein, a.timeout, a.nett, b.jumlah_bag,
        case when  b.jumlah_bag >=1 and   b.jumlah_bag<=19 then 0
        when  b.jumlah_bag >=1 and   b.jumlah_bag<=19 then 0
        when  b.jumlah_bag >=20 and   b.jumlah_bag<=80 then 10
        when  b.jumlah_bag >=81 and   b.jumlah_bag<=150 then 20
        when  b.jumlah_bag >=151 and   b.jumlah_bag<=230 then 30
        when  b.jumlah_bag >=231 and   b.jumlah_bag<=300 then 40
        when  b.jumlah_bag >=301 and   b.jumlah_bag<=400 then 50
        when  b.jumlah_bag >=401 and   b.jumlah_bag<=460 then 60
        when  b.jumlah_bag >=461 and   b.jumlah_bag<=540 then 70
        when  b.jumlah_bag >=541 and   b.jumlah_bag<=699 then 80
        when  b.jumlah_bag >=700 and   b.jumlah_bag<=1000 then 80
        else 0 end as 'potongan'
        from wbfile a, t_barcode b
        where a.barcode = b.barcode and a.statusax = 'Y' and a.flag = 'Y'
        ) a order by datein desc , timein desc ;`;
        // const result = await sql.query`select * from wbfile`;
        var dataRespon = result.recordset;
        console.log(dataRespon[0].ticket + '==' + wbfile[0].ticket);

        if (dataRespon[0].ticket != wbfile[0].ticket) {
            for (const iterator of dataRespon) {
                query.insert('feedmills', iterator, function (res) {
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