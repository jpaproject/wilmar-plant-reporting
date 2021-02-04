 const {
     Client
 } = require('pg')

 const client = new Client({
     user: 'postgres',
     host: 'localhost',
     database: 'jpa_malindo',
     password: 'root',
     port: 5432,
 })

 client.connect(function (err) {
     if (err) {
         console.log(err)
         process.exit(1);

     } else {
         console.log('Postgre Connected !')
     };
 })

 module.exports.client = client;