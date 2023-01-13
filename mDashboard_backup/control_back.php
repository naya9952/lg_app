<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=0.7">
        <link rel="stylesheet" type="text/css" href="semantic/semantic.min.css">
        <script
          src="https://code.jquery.com/jquery-3.1.1.min.js"
          integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
          crossorigin="anonymous"></script>
        <script src="semantic/semantic.min.js"></script>
        <link rel="stylesheet" type="text/css" href="./css/style.css">
    </head>
    <body>
        <div>
            <table class="ui fluid basic celled table">
                <thead>
                    <tr>
                        <th id="t_header">#</th>
                        <th class="t_number" id="ime0">1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td id="t_header">지역</td>
                        <td id="loc0"></td>
                    </tr>
                    <tr>
                        <td id="t_header">수신</td>
                        <td id="rev0"></td>
                    </tr>
                    <tr>
                        <td id="t_header">상태</td>
                        <td id="stt0"></td>
                    </tr>
                    <tr>
                        <td id="t_header">온도</td>
                        <td id="tmp0"></td>
                    </tr>
                    <tr>
                        <td id="t_header">RSSI</td>
                        <td><button class="ui violet compact button" id="rsb0"><i class="wifi icon"></i><span id="rsi0"></span></button></td>

                    </tr>
                    <tr>
                        <td id="t_header">릴레이</td>
                        <td><button class="ui pink compact button" id="rof0"><i class="pause icon"></i>OFF</button><button class="ui positive compact button" id="ron0"><i class="play icon"></i>O  N</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <script src="./js/func.js"></script>
        <script>
        ajax('<?=$_REQUEST['ime']?>');
        finit('<?=$_REQUEST['ime']?>');
        </script>
    </body>
</html>