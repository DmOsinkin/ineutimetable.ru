var date = new Date();
var options = {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    weekday: 'long'
};


document.write(date.toLocaleString("ru", options));