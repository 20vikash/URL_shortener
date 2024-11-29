<?php

$shortUrl = null;

if (isset($_GET["url"])) {
    $url = $_GET["url"];

    $pipe = fopen('./my_pipe', 'w');
    fwrite($pipe, $url);
    fclose($pipe);

    $responsePipe = fopen('./my_response_pipe', 'r');
    $shortUrl = fread($responsePipe, 1024);
    fclose($responsePipe);

    $real_pipe = fopen('./real_input_pipe', 'w');
    fwrite($real_pipe, "rubbish");
    fclose($real_pipe);
}

if (isset($_GET["hash"])) {
    $hash_ = $_GET["hash"];

    $pipe = fopen('./my_pipe', 'w');
    fwrite($pipe, "rubbish");
    fclose($pipe);

    $real_pipe = fopen('./real_input_pipe', 'w');
    fwrite($real_pipe, $hash_);
    fclose($real_pipe);

    $real_responsePipe = fopen('./real_output_pipe', 'r');
    $realUrl = fread($real_responsePipe, 2000);
    fclose($real_responsePipe);

    header("Location: $realUrl");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>URL Shortener</title>
</head>
<body>
    <video class="video-background" autoplay muted loop>
        <source src="v.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    
    <div class="container">
        <h1 class="title">URL SHORTENER</h1>
        <form class="url-form" method="get" action="index.php">
            <input type="url" id="longUrl" placeholder="Enter your long URL" name="url" required>
            <button type="submit">CONVERT</button>
        </form>
        <div class="result">
            <p class="short-url" id="shortUrl">
                <?php if ($shortUrl != null) {
                    ?>
                    <?="https://shortlink.zeal.lol/$shortUrl"?>
                    <? 
                    } else { ?>
                        Your short URL will appear here!
                        <? } ?>
            </p>
            <button class="copy-btn" id="copyBtn" style="display:none;">Copy URL</button>
        </div>
    </div>

    <script>
        document.getElementById('copyBtn').addEventListener('click', function() {
            const shortUrlText = document.getElementById('shortUrl').textContent;
            navigator.clipboard.writeText(shortUrlText).then(() => {
                alert('URL copied to clipboard!');
            }).catch(err => {
                console.error('Error copying URL: ', err);
            });
        });
    </script>
</body>
</html>
