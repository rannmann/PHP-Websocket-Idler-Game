<html>
<head>
    <title>Example</title>
</head>
<body>
    <div>
        <tt id="log"></tt>
    </div>
    <script>
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
    <script src="public/js/idler.js"></script>
</body>
</html>