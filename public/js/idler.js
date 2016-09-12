var conn = new WebSocket('ws://ws.firepowered.dev:8080');
conn.onopen = function(e) {
    console.log("Connection established!");
};

conn.onmessage = function(e) {
    console.log(e.data);
    console.log(e);
};