// Chatbox
var chat = new WebSocket('ws://localhost:8080/chat');

chat.onopen = function(e) {
    //var msgs = JSON.parse(e.data);
    console.log("Connected to chat!");
    //
    $('#chatbar').prop('disabled', false);
    $('#chatbar').prop('placeholder', 'Your message');
    chat.send(JSON.stringify({
        isApi: true,
        session: g_session
    }));
};

chat.onmessage = function(e) {
    var msg = JSON.parse(e.data);
    if (Array.isArray(msg)) {
        msg.forEach(function (m) {
            console.log(formatMessage(m));
        });
    } else {
        console.log(formatMessage(msg));
    }
    updateScroll();
};

function updateScroll() {
    var element = document.getElementById("chat-container");
    element.scrollTop = element.scrollHeight;
}
function formatMessage(raw) {
    var date = new Date(raw.timestamp * 1000);
    var hours = date.getHours();
    var minutes = '0' + date.getMinutes();
    if (raw.msg.match(/^\/me /i)) {
        var name = '* ' + raw.user + ''
        raw.msg = raw.msg.replace(/^\/me /i, '');
    } else {
        var name = '&lt;' + raw.user + '&gt;'
    }
    return '[' + hours + ':' + minutes.substr(-2) + '] ' + name + ' ' + raw.msg
}

$('#chatbar').keypress(function(event) {
    if (event.which == 13) {
        chat.send('/chat ' + $('#chatbar').val());
        $('#chatbar').val('');
    }
});