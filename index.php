<?php
// Since this is served through the webserver and not websocket server, we'll
// pretend it's the main site as an example.  Let's set the user up with a
// session, as if they're authenticated.

session_start();

$client = @$_SERVER['HTTP_CLIENT_IP'];
$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
$ip = filter_var($client, FILTER_VALIDATE_IP) ? $client : filter_var($forward, FILTER_VALIDATE_IP) ? $forward : $_SERVER['REMOTE_ADDR'];


/*AuthController::setCookies([
    'userid' => $_SESSION['userid'],
    'sessionid' => session_id()
]);*/

// Requesting session info
if (!empty($_POST)) {
    $result = ['success'=>false];
    // User is not logged in, nothing to send.
    if (empty($_SESSION)) {
        die(json_encode($result));
    }
    // If the requesting IP matches the session IP
    if ($_SESSION['ip'])
    // If the user ID matches the session user ID
    if (!empty($_POST['userid']) && $_POST['userid'] == $_SESSION['userid']) {
        // Return the session ID
        if (!empty($_POST['sessionid'] && $_POST['sessionid'] == session_id())) {
            //
        }
    }
}

// A legitimate logged-in user.
$_SESSION['userid'] = 3;
?>
<html>
<head>
    <title>Example</title>
</head>
<body>
    <div style="max-height:700px;background-color:#eee;overflow-y:scroll;padding:0.5em;" id="chat-container">
        <tt id="log"></tt>
        <input id="chatbar" type="text" style="width:100%;margin-top:0.5em;" disabled="1">
    </div>
    <div style="background-color:#c9c9c9;margin-top:1em;padding:0.2em;">
        <tt><?php
            var_dump($_SESSION);
            echo "<br>";
            var_dump(session_id());
            echo "<br>";
            var_dump($_COOKIES);
        ?></tt>
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
    <script>
        var g_session = '<?= session_id() ?>';
    </script>
</body>
</html>