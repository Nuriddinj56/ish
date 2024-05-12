window.onload = function(){
 window.setInterval(function(){
      var now = new Date();
       var clock = document.getElementById("clock");
     clock.innerHTML = now.toLocaleTimeString();
 }, 1000);
};

function showTime() {
  var monthsArr = ["Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", 
  "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря"];

  var daysArr = ["Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"];

  var dateObj = new Date();

  var year = dateObj.getFullYear();
  var month = dateObj.getMonth();
  var numDay = dateObj.getDate();
  var day = dateObj.getDay();
  var hour = dateObj.getHours();
  var minute = dateObj.getMinutes();
  var second = dateObj.getSeconds();

  if (minute < 10) minute = "0" + minute;

  if (second < 10) second = "0" + second;

  var out = "<font color='#FFF'>" + daysArr[day] + "</font> " + numDay + " <font color='#FFF'>" + monthsArr[month]
          + " </font>" + year + "";

  return out;
}
document.write(showTime());