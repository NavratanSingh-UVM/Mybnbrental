import './bootstrap';
require('./bootstrap');
var pusher = new Pusher("APP_KEY");
var channel = pusher.subscribe("APPL");
channel.bind("new-price", (data) => {
  // add new price into the APPL widget
});
var context = { title: "Pusher" };
var handler = () => {
  console.log(`My name is ${this.title}`);
};
channel.bind("new-comment", handler, context);