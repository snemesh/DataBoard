var express = require('express');
var request = require('request');
var app = express();

app.get('/:id', function (req, res) {//u9fsyc4mz9g
    request('https://www.jirareports.com/secure/report/publish/open?link='+req.params.id, function(err, response, body){
        res.send(body);
    })
});

app.listen(3000, function () {
    console.log('Example app listening on port 3000 use http://localhost:3000/:id as example http://localhost:3000/u9fsyc4mz9g !');
});

