

document.getElementById('ron0').addEventListener('click', function(){ajax2(1, 1);})

document.getElementById('rof0').addEventListener('click', function(){ajax2(1, 2);})

document.getElementById('rsb0').addEventListener('click', function(){ajax2(1, 3);})

var imeNumber = document.getElementById('currentIme0').value;
alert(imeNumber);
var timer = 0;

function finit(ime) {
    window.ref = window.setInterval(function() { draww(ime); }, 5000);
}

function draww(ime) {
    ajax(ime);
    clearInterval(window.ref);
    finit(ime);
}

function ajax2(n, m) {
    let xhr2 = new XMLHttpRequest();
    xhr2.open("POST", "./onoffControl.php");
    xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    var dat = '';
    dat += 'id='+String(n)+'&mode='+String(m)+'&ime='+String(imeNumber);
    alert(dat);
    xhr2.send(dat);
    xhr2 = null;
    dat = null;
}

function ajax(ime) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "./currentStatus.php?ime="+String(ime));
    xhr.addEventListener("load", ajax_callback);
    xhr.send();
    xhr = null;
}

function ajax_callback(e) {
    var i;
    var xhr = e.target;
    var array = JSON.parse(xhr.responseText);

    for(i=0; i<1; i+=1){
        var rev = 'rev'+String(i);
        var loc = 'loc'+String(i);
        var stt = 'stt'+String(i);
        var ime = 'ime'+String(i);
        var tmp = 'tmp'+String(i);
        var rsi = 'rsi'+String(i);
        var stx = '';
        var tmx = String(parseInt(array[i][4]*0.1))+'.'+String(array[i][4]%10)+'℃';

        var rsx = String(parseInt(array[i][5]))+'dbm';

        if(array[i][2] == 1){
            document.getElementById(stt).className='stt_nor'
            stx = 'Run';
        }
        else if(array[i][2] == 2){
            document.getElementById(stt).className='stt_afl'
            stx = 'AC Fail';
        }
        else if(array[i][2] == 3){
            document.getElementById(stt).className='stt_ecb'
            stx = 'ELCB';
        }
        else if(array[i][2] == 4){
            document.getElementById(stt).className='stt_rof'
            stx = 'Relay Off';
        }
        else{
            document.getElementById(stt).className='stt_stb'
            stx = 'Unknown';
        }
        document.getElementById(rev).innerHTML = array[i][6];
        document.getElementById(ime).innerHTML = array[i][1];
        document.getElementById(stt).innerHTML = stx;
        document.getElementById(tmp).innerHTML = tmx;
        document.getElementById(rsi).innerHTML = rsx;
        document.getElementById(loc).innerHTML = array[i][7];
    }
    e = null;
    i = null;
    xhr = null;
    array = null;
    rev = null;
    stt = null;
    ime = null;
    tmp = null;
    rsi = null;
    stx = null;
    tmx = null;
    rsx = null;
    loc = null;

    timer = timer + 1;
    if(timer > 120){
        location.reload();
        var dt = new Date();
        var d = dt.toFormat('YYYY-MM-DD HH24:MI:SS');
        console.log('[' + d + '] ');
        dt = null;
        d = null;
    }
}
