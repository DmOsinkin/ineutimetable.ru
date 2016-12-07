var date = new Date();
var options = {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    weekday: 'long'
};


document.write("TODO: <u>(не) четная неделя</u><br>");
document.write(date.toLocaleString("ru", options));