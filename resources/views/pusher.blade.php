<!DOCTYPE html>
<head>
  <title>Pusher Test</title>
  <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('05c1d7b28caa907a92e6', {
      cluster: 'ap2'
    });

    var channel = pusher.subscribe('chat');
    channel.bind('NewMessage', function(data) {
      alert(JSON.stringify(data));
    });
  </script>
</head>
<body>
  <h1>Pusher Test</h1>
  <p>
    Try publishing an event to channel <code>chat</code>
    with event name <code>NewMessage</code>.
  </p>
</body>