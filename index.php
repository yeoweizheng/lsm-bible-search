<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Holy Bible Recovery Version</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" 
            integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <style>
            body{
                font-family: Georgia, "Times New Roman", Times, serif;
            }
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script>
            $(function(){
                $("#showRef").change(function(){
                    if(this.checked){
                        $(".verseRef").show();
                    } else {
                        $(".verseRef").hide();
                    }
                });
            });
        </script>
    </head>
    <body>
        <a name="top"></a>
        <?php
            $response = "";
            if(isset($_GET["verses"])){
                $urlInput = "https://api.lsm.org/recver.php?String=" . urlencode(filter_var(trim($_GET["verses"]), FILTER_SANITIZE_STRING)) . "&Out=json";
                //Perform HTTP GET request
                $cSession = curl_init();
                curl_setopt($cSession, CURLOPT_URL, $urlInput);
                curl_setopt($cSession, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($cSession);
                curl_close($cSession);
            }
        ?>
        <div class="container p-0">
            <div class="card">
                <div class="card-header">
                    <h5 class="text-center m-0">Holy Bible Recovery Version</h5> </div>
                <div class="card-body">
                    <form class="form-inline" style="justify-content: center;" autocomplete="off" method="get">
                        <div class="form-group row w-100">
                            <div class="col-sm-10 p-1 mb-1">
                                <input class="form-control w-100" type="text" name="verses" id="verses" placeholder="eg. 1 pet 2:2-3, 1:8" required>
                            </div>
                            <div class="col-sm-2 p-1 mb-1">
                                <input class="form-control btn btn-outline-dark w-100" type="submit" value="Search">
                            </div>
                        </div>
                    </form>
                    <div class="card-body p-1">
                    <?php
                        if ($response != "") {
                            $data = json_decode($response);
                            $verseRef = $data->detected;
                            $verses = $data->verses;
                            $message = $data->message;
                            $copyright = $data->copyright;
                            print("<h6 class='font-weight-bold'>" . trim($verseRef) . "</h6>");
                            print("<label class='checkbox-inline font-italic'><input type='checkbox' id='showRef'> Show references</label>");
                            foreach($verses as $verse) {
                                $ref = $verse->ref;
                                print("<p class='font-weight-bold verseRef' style='margin-bottom: 0px; display: none;'>" . $verse->ref . "</p>");
                                $verseText = trim($verse->text);
                                $verseText = str_replace("[", "<span class='font-italic'>", $verseText);
                                $verseText = str_replace("]", "</span>", $verseText);
                                print("<p>" . $verseText . "</p>");
                            }
                            print("<p class='font-italic'>");
                            if(strlen($message) >= 2) print(trim($message) . "<br>");
                            print(trim($copyright));
                            print("</p>");
                            print("<a class='badge badge-light' href='#top'>Back to top</a>");
                        }
                    ?>
                    </div>
                </div>
                <div class="card-footer text-center" style="line-height: 1">
                    <small>Telegram version available at <a href="https://t.me/rcvbiblebot">https://t.me/rcvbiblebot</a></small>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" 
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" 
                integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script>
            $(function(){
                $("#verses").focus();
            });
        </script>
    </body>
</html>
