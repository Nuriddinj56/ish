// получим текущее время пользователя и компоненты этого времени
var 
  now = new Date(),
  hour = now.getHours(),
  minute = now.getMinutes(),
  second = now.getSeconds(),
  message = '';

// определим фразу приветствия в зависимости от местного времени пользователя 
if (hour <= 6) {
  message = 'Доброй ночи';
} else if (hour <= 12) {
  message = 'Доброе утро';
} else if (hour <= 18) {
  message = 'Добрый день';
} else {
  message = 'Добрый вечер';
}

// выполним форматирование времени с использованием тернарного оператора
minute = (minute < 10) ? '0' + minute : minute;
second = (second < 10) ? '0' + second : second;
hour = (hour < 10) ? '0' + hour : hour;

message += '';

// выведем приветствие и время в консоль
document.write(message);