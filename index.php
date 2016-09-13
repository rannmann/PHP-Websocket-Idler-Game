<html>
<head>
    <title>Example</title>
</head>
<body>
    <div style="max-height:700px;background-color:#eee;overflow-y:scroll;" id="chat-container">
        <tt id="log"></tt>
        <input id="chatbar" type="text" style="width:100%" disabled="1">
    </div>
    <script>
        // Override console.log to display in DOM for this example.
        (function () {
            var old = console.log;
            var logger = document.getElementById('log');
            console.log = function (message) {
                if (typeof message == 'object') {
                    logger.innerHTML += (JSON && JSON.stringify ? JSON.stringify(message) : message) + '<br />';
                } else {
                    logger.innerHTML += message + '<br />';
                }
            }
        })();
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="public/js/idler.js"></script>
</body>
</html>