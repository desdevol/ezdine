//Get age according to current year
var ic = document.getElementById("ic").innerHTML; //Get the ic number
var icYear = ic.substring(0,2); //Get year in 2 digits eg.99

var currentTime = new Date();
var currentYear = currentTime.getYear()-100; //-100 because year 2000 returns 100
if(icYear > currentYear){
	icFullYear = "19"+icYear;
}
else{
	icFullYear = "20"+icYear;
}

var age = currentTime.getFullYear() - icFullYear;
document.getElementById("age").innerHTML = age;

//Clock js
function showTime(){
    var currentTime = new Date();
    var d = currentTime.getDate();
    var m = currentTime.getMonth();
    var y = currentTime.getFullYear();
    var h = currentTime.getHours(); // 0 - 23
    var m = currentTime.getMinutes(); // 0 - 59
    var s = currentTime.getSeconds(); // 0 - 59
    var session = "AM";
    
    if(h == 0){
        h = 12;
    }
    
    if(h > 12){
        h = h - 12;
        session = "PM";
    }
    
    h = (h < 10) ? "0" + h : h;
    m = (m < 10) ? "0" + m : m;
    s = (s < 10) ? "0" + s : s;
    
    var time =h + ":" + m + ":" + s + " " + session;
    var date =d + "-" + m + "-" + y;

    
    setTimeout(showTime, 1000);
    
}

showTime();