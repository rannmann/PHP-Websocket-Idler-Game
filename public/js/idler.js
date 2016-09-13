var conn = new WebSocket('ws://ws.firepowered.dev:8080');
conn.onopen = function(e) {
    console.log("Connection established!");
    $('#chatbar').prop('disabled', false);
    $('#chatbar').prop('placeholder', 'Your Message');
};

conn.onmessage = function(e) {
    console.log(e.data);
    updateScroll();
};

// Chatbox
function updateScroll(){
    var element = document.getElementById("chat-container");
    element.scrollTop = element.scrollHeight;
}
$('#chatbar').keypress(function(event) {
    if (event.which == 13) {
        conn.send('/chat ' + $('#chatbar').val());
        $('#chatbar').val('');
    }
});