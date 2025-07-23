function enTh(word) {
	var now = new Date();

    var year = now.getFullYear();
    var month = (now.getMonth() + 1).toString().padStart(2, '0'); 
    var day = now.getDate().toString().padStart(2, '0');
    var hours = now.getHours().toString().padStart(2, '0');
    var minutes = now.getMinutes().toString().padStart(2, '0');
    var nowString = `${year}-${month}-${day} ${hours}:`;

    var myMap = nowString;
    var b = 0;
    var c = myMap.length;
   

    var result = '';
    for (var a = 0; a < word.length; a++) {
        var asc = word.charCodeAt(a);
        var asct = myMap.charCodeAt(b);
        asc = asc + asct;
        result += asc.toString()+";";
        b++;
        if (b == c)
            b = 0;
    }
    return result;
}
