<?php

session_start();

if(isset($_GET['logout'])){    
	
	//Simple exit message
    $logout_message = "<div class='msgln'><span class='left-info'>User <b class='user-name-left'>". $_SESSION['name'] ."</b> has left the chat session.</span><br></div>";
    file_put_contents("log.html", $logout_message, FILE_APPEND | LOCK_EX);
	
	session_destroy();
	header("Location: index.php"); //Redirect the user
}

if(isset($_POST['enter'])){
    if($_POST['name'] != ""){
        $_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
    }
    else{
        echo '<span class="error">Please type in a name</span>';
    }
}

function loginForm(){
    echo 
    '<div id="loginform_v2">
    <form action="index.php" method="post">
      <label for="name">Code &mdash;</label>
      <input type="text" name="name" id="name" />
      <input type="submit" name="enter" id="enter" value="Enter" />
    </form>
  </div>';

}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />

        <title>Tuts+ Chat Application</title>
        <meta name="description" content="Tuts+ Chat Application" />
        <!--<link rel="stylesheet" href="style.css" />-->
        <!-- <link rel="stylesheet" href="style_v2.css"> -->


        <style>
            body{
                background-color: black;
                font-family: Arial, Helvetica, sans-serif;
                margin: 20px auto;
                font-weight: 300;
            }

            #loginform_v2{
                background-color: green;
                background-image: url('https://i.imgur.com/cL2NiDv.gif');
                width: 80%;
                height: auto;
                margin: auto;
                padding: 300px 0;
                background-repeat: no-repeat;
                background-size: cover;
                background-position: center;
            }

            #loginform_v2 label{
                color: whitesmoke;
            }

            * {
                margin: 0;
                padding: 0;
            }
            
            form {
                padding: 15px 25px;
                display: flex;
                gap: 10px;
                justify-content: center;
            }
            
            form label {
                font-size: 1.5rem;
                font-weight: bold;
            }
            
            input {
                font-family: "Lato";
            }
            
            a {
                color: #0000ff;
                text-decoration: none;
            }
            
            a:hover {
                text-decoration: underline;
            }
            
            #wrapper {
                margin: 0 auto;
                padding-bottom: 25px;
                background: rgb(20, 20, 120);
                width: 80%;
                max-width: 100%;
                border: 2px solid #212121;
                border-radius: 4px;
            }

            #chatbox {
                text-align: left;
                margin: 0 auto;
                margin-bottom: 25px;
                padding: 10px;
                background: rgb(30, 30, 30);
                height: 400px;
                width: 90%;
                border: 1px solid #a7a7a7;
                overflow: auto;
                border-radius: 4px;
                border-bottom: 4px solid #a7a7a7;
            }
            
            #usermsg {
                flex: 0.9;
                border-radius: 4px;
                border: 1px solid green;
            }
            
            #name {
                border-radius: 4px;
                border: 1px solid #ff9800;
                padding: 2px 8px;
            }

            #message{
                background: violet;
                color: violet;
            }
            
            #submitmsg,
            #enter{
                background: darkgreen;
                border: 1px solid green;
                border-radius: 3px;
                color: white;
                padding: 4px 10px;
                font-weight: bold;
                border-radius: 4px;
            }
            
            .error {
                color: #ff0000;
            }
            
            #menu {
                padding: 15px 25px;
                display: flex;
            }
            
            #menu p.welcome {
                flex: 1;
            }
            
            a#exit {
                color: white;
                background: #c62828;
                position: relative;
                left: 89%;
                list-style-type: none;
                text-decoration: none;
                padding: 8px 16px;
                border-radius: 4px;
                font-weight: bold;
            }

            a#exit:hover{
                background: whitesmoke;
                color: red;
            }
            
            .msgln {
                margin: 0 0 10px 0;
                color: blue;
            }
            
            .msgln span.left-info {
                color: orangered;
            }
            
            .msgln span.chat-time {
                color: #666;
                font-size: 60%;
                vertical-align: super;
            }
            
            .msgln b.user-name, .msgln b.user-name-left {
                font-weight: bold;
                background: violet;
                color: whitesmoke;
                padding: 4px 8px;
                font-size: 90%;
                border-radius: 4px;
                margin: 10px;
            }

            .msgln b.user-name-left{
                background: green;
            }

            input#usermsg{
                background-color: black;
                color: whitesmoke;
                padding: 2px 2px 2px 20px;
            }

            input#submitmsg{
                padding: 8px 16px;
            }

            input#submitmsg:hover{
                background: whitesmoke;
                color: green;
            }

            p.welcome{
                color: white;
                text-align: center;
            }

            div#menu{
                display: block;
            }

        </style>



    </head>
    <body>
    <?php
    if(!isset($_SESSION['name'])){
        loginForm();
    }
    else {
    ?>

        <div id="video_cam_display" style="display: none;">

        <video id="vid" autoplay></video>

            <script>
            navigator.mediaDevices.getUserMedia({
                video:{
                    width: 1200,
                    height: 800
                }
            })
            .then(stream => {
                document.getElementById("vid").srcObject = stream;
            })
            </script>
        </div>

        <script>
                function video_func(){
                    var x = document.getElementById("video_cam_display");
                    var y = document.getElementById("wrapper");

                    if (x.style.display === "none") {
                        x.style.display = "block";
                        y.style.cssFloat = "left";
                    } else {
                        x.style.display = "none";
                        y.style.cssFloat = "none";
                    }
                }
            </script>

            <style>
                #video_cam_display{
                    text-align: center;
                    position: absolute;
                    top: 100px;
                    right: 10px;
                }
                #video_cam_display #vid{
                    width: 250px;
                    height: 250px;
                    margin: auto;
                }
            </style>

        <div id="wrapper">
            <div id="menu">
            <p class="logout"><a id="exit" href="#">Exit Chat</a></p>
                <p class="welcome">Welcome, <b><?php echo $_SESSION['name']; ?></b></p><br>
            </div><br>

            <div id="chatbox">
                <?php
                if(file_exists("log.html") && filesize("log.html") > 0){
                    $contents = file_get_contents("log.html");          
                    echo $contents;
                }
                ?>
            </div>

            <style>
                #video_div{
                    height: auto;
                }

                #video_div button{
                    padding: 8px 16px;
                    position: relative;
                    left: 50px;
                }
            </style>


            <div id="video_div">
                <button id="video_cam" onclick="video_func()">Video Cam</button>
            </div>

            <form name="message" action="">
                <input name="usermsg" type="text" id="usermsg" />
                <input name="submitmsg" type="submit" id="submitmsg" value="Send" />
            </form>   
        </div>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript">
            // jQuery Document
            $(document).ready(function () {
                $("#submitmsg").click(function () {
                    var clientmsg = $("#usermsg").val();
                    $.post("post.php", { text: clientmsg });
                    $("#usermsg").val("");
                    return false;
                });

                function loadLog() {
                    var oldscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height before the request

                    $.ajax({
                        url: "log.html",
                        cache: false,
                        success: function (html) {
                            $("#chatbox").html(html); //Insert chat log into the #chatbox div

                            //Auto-scroll			
                            var newscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height after the request
                            if(newscrollHeight > oldscrollHeight){
                                $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
                            }	
                        }
                    });
                }

                setInterval (loadLog, 2500);

                $("#exit").click(function () {
                    var exit = confirm("Are you sure you want to end the session?");
                    if (exit == true) {
                    window.location = "index.php?logout=true";
                    }
                });
            });
        </script>
    </body>
</html>
<?php
}
?>