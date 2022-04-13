
<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/6.6.1/firebase-app.js"></script>

<script src="https://www.gstatic.com/firebasejs/6.6.1/firebase-database.js"></script>

 
<!-- include firebase database -->
 <!-- <script src="https://www.gstatic.com/firebasejs/7.14.2/firebase-database.js"></script> -->

 
<script>
    // Your web app's Firebase configuration
    var firebaseConfig = {
    apiKey: "AIzaSyDwtlb_L5gKWpb4pleRyqxPu3s740jTkDo",
    authDomain: "my-test-project-1fe3a.firebaseapp.com",
    projectId: "my-test-project-1fe3a",
    storageBucket: "my-test-project-1fe3a.appspot.com",
    messagingSenderId: "222495373420",
    appId: "1:222495373420:web:ad424127d4e4c928770049"
  };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);

    var myName = prompt("Enter your name");

    function sendMessage() {
        // get message
        var message = document.getElementById("message").value;
 
        // save in database
        firebase.database().ref("messages").push().set({
            "sender": myName,
            "message": message
        });
 
        // prevent form from submitting
        return false;
    }

    // listen for incoming messages
    firebase.database().ref("messages").on("child_added", function (snapshot) {
        var html = "";
        // give each message a unique ID
        html += "<li id='message-" + snapshot.key + "'>";
        // show delete button if message is sent by me
        if (snapshot.val().sender == myName) {
            html += "<button data-id='" + snapshot.key + "' onclick='deleteMessage(this);'>";
                html += "Delete";
            html += "</button>";
        }
        html += snapshot.val().sender + ": " + snapshot.val().message;
        html += "</li>";
 
        document.getElementById("messages").innerHTML += html;
    });
    function deleteMessage(self) {
    // get message ID
    var messageId = self.getAttribute("data-id");
 
    // delete message
    firebase.database().ref("messages").child(messageId).remove();
}
 
// attach listener for delete message
firebase.database().ref("messages").on("child_removed", function (snapshot) {
    // remove message node
    document.getElementById("message-" + snapshot.key).innerHTML = "This message has been removed";
});

</script>


<form onsubmit="return sendMessage();">
    <input id="message" placeholder="Enter message" autocomplete="off">
 
    <input type="submit">
</form>

<ul is="messages"></ul>
     
