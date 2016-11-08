
var page = require('webpage').create();
page.open('https://www.jirareports.com/html/published.html?link=3jrv36anh8p1k1apjhcs6miruj', function(status) {
    console.log("Status: " + status);
    if(status === "success") {
        page.render('example.png');
    }
    phantom.exit();
});
alert("Done");

