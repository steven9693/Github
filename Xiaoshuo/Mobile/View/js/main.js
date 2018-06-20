function FonHen_JieMa(u){
    var tArr = u.split("*");
    var str = '';
    for(var i=0,n=tArr.length;i<n;i++){
        str += String.fromCharCode(tArr[i]);
    }
    return str;
}