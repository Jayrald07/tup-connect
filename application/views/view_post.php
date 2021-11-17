<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post</title>
</head>
<style>
    .container {
        display: grid;
        grid-template-columns: 1fr 4fr;
    }

    ul {
        padding: 0;
        margin: 0
    }

    ul li a {
        text-decoration: none;
        padding: 10px;
        display: block;
    }
    .btn{
	    cursor: pointer;
        color: #0000EE;
    }
    #box{
        width: 500px;
        background: #f1f1f1;
        box-shadow: 0 0 5px black;
        border-radius: 8px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
        padding: 10px;
        text-align: center;
        display: none;
    }
    #box span{
        display: block;
    }
    #box p{
        display: inline-block;
    }
    #box1{
        width: 500px;
        background: #f1f1f1;
        box-shadow: 0 0 5px black;
        border-radius: 8px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
        padding: 10px;
        text-align: center;
        display: none;
    }
    #box1 span{
        display: block;
    }
    #box1 p{
        display: inline-block;
    }
</style>

<body>
    <div class="container">
        <aside>
            <ul>
                <li><a href="./lobby">Lobby</a></li>
                <li><a href="./fw">Freedom Wall</a></li>
                <li><a href="./forum">Forum</a></li>
            </ul>
        </aside>
        <main>
            <h1><?php echo ucfirst($type); ?> Posts</h1>
            <a href="<?php echo $type; ?>/create">Create Post</a>
            <?php foreach ($posts as $post) : ?>
                <section>
                    <p><?php echo $post["post_text"]; ?></p>
                    <small><?php echo $post["date_time_stamp"]; ?></small><br />
                    <a href="./remove/<?php echo $post["post_id"]; ?>" target="_self">Delete</a>
                    <a onclick="pop()" class ="btn" >Report</a>
                    <a onclick="pop1()" class ="btn">Report User</a>
                    <?php if ($type != 'fw') { ?>
                        <a href="./<?php echo $type; ?>/edit/<?php echo $post["post_id"];  ?>">Edit</a>
                    <?php } ?>

                    <div id="box">
                        <form method="POST" action="./<?php echo $type; ?>/report/<?php echo $post["post_id"];  ?>">
                            <span>Report Post</span><br>
                            <input type="radio" name="report_description" value="Sexual Content">Sexual Content<br>
                            <input type="radio" name="report_description" value="Malicious Content">Malicious Content<br>
                            <input type="radio" name="report_description" value="Terrorism">Terrorism<br>
                            <input type="radio" name="report_description" value="Racism">Racism<br>
                            <input type="submit" name="report" />
                        </form>
                    </div>

                    <div id="box1">
                        <form method="POST" action="./<?php echo $type; ?>/user_report" >
                            <span>Report User</span><br>
                            <input type="radio" name="report_description" value="Sexual Content">Sexual Content<br>
                            <input type="radio" name="report_description" value="Malicious Content">Malicious Content<br>
                            <input type="radio" name="report_description" value="Terrorism">Terrorism<br>
                            <input type="radio" name="report_description" value="Racism">Racism<br>
                            <input type="submit" name="report" />
                        </form>
                    </div>
                </section>
                <hr />
            <?php endforeach ?>
        </main>
    </div>
   
    <script type="text/javascript">
		var c = 0;
        var d = 0;
		function pop(){
			if(c == 0){
				document.getElementById("box").style.display = "block";
				c = 1;
			}
			else{
				document.getElementById("box").style.display = "none";
				c = 0;
			}
		}

        function pop1(){
            if(d == 0){
				document.getElementById("box1").style.display = "block";
				d = 1;
			}
			else{
				document.getElementById("box1").style.display = "none";
				d = 0;
			}
        }
	</script>
</body>

</html>