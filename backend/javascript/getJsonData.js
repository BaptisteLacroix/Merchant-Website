// read the json and isert the data into the html page

function getJsonData() {
    // Read the datat from the json file : ../assets/json/productInformayions.json
    var xmlhttp = new XMLHttpRequest();
    var url = "../assets/json/productInformayions.json";

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(JSON.parse(this.responseText))
            var myArr = JSON.parse(this.responseText);
            myFunction(myArr);
        }
    }
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

function myFunction(arr) {
    var out = "";
    var i;
    for(i = 0; i < arr.length; i++) {
        out += '<a href="' + arr[i].url + '">' +
        arr[i].display + '</a><br>';
    }
    console.log(out)
    document.getElementById("id01").innerHTML = out;
}
