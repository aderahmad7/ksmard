var X = XLSX;
function fixdata(data) {
    var o = "", l = 0, w = 10240;
    for (; l < data.byteLength / w; ++l)
        o += String.fromCharCode.apply(null, new Uint8Array(data.slice(l * w, l * w + w)));
    o += String.fromCharCode.apply(null, new Uint8Array(data.slice(l * w)));
    return o;
}
function to_json(workbook,trans,range) {
    var result = {};
    var sheetName = workbook.SheetNames[0];
    var worksheet = workbook.Sheets[sheetName];
    var col = {"B":"nim"};
    var a = "DEFGHIJKLMNOPQRSTUVWXYZ".split("");
    $.each(a,function(i,l){
        if (worksheet[l+"9"]){
            var val = worksheet[l + "9"].v;
            if(typeof (trans[val]) != "undefined")
                col[l] = trans[val];
        }
    });

    var next = true;
    var r = 12;
    var bobot;
    while (next) {
        var temp = {};
        var nim = "";
        $.each(col,function(c,name){
            var value;
            if (worksheet[c + r])
                value = worksheet[c + r].v;
            else
                value = "0";
            
            if(name == "nim"){
//                value = value.replace(/\s/g, '');
                nim = value;
            }else if (name == "krsdtNilaiTotal"){
                total = Number(value);
                $.each(range,function(ind,val){
                    if(total >= Number(val.nlmkrRentangSkorMin)  && total < Number(val.nlmkrRentangSkorMax))
                    { 
                        bobot = val.nlmkrBobot;
                    }
                });
                temp["krsdtBobotNilai"] = bobot;
                temp[name] = value;
            }else
                temp[name] = value;
        });
        result[nim] = temp;
        r++;
        if (!worksheet["B" + r])
            next = false;
    }
    return result;
}
function process_wb(wb,trans,range) {
    var output = "";
    output = JSON.stringify(to_json(wb,trans,range), 2, 2);
    if (out.innerText === undefined)
        out.textContent = output;
    else
        out.innerText = output;
    if (typeof console !== 'undefined')
        console.log("output", new Date());
}
//var xlf = document.getElementById('xlf');
function handleFile(id,translation,range,callback) {
    var xlf = document.getElementById(id);

    var files = xlf.files;
    var f = files[0];
    var result = [];
    {
        var reader = new FileReader();
        var name = f.name;
        reader.onload = function (e) {
            var data = e.target.result;
            var arr = fixdata(data);
            wb = X.read(btoa(arr), {type: 'base64'});
            result = to_json(wb,translation,range);
            callback(result);
        };
        reader.readAsArrayBuffer(f);
    }
}
//if (xlf.addEventListener) xlf.addEventListener('change', handleFile, false);