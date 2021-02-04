var fs = require('fs');
var stream = fs.createWriteStream("./logs_cloud/my_file.txt");
stream.once('open', function (fd) {
    // stream.write("My first row\n");
    // stream.write("My second row\n");
    stream.write("My second row\n");
    stream.end();
});