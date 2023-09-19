<?php
//starting a session
//allowing back button to be clicked
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
//Getting the title of the movie that was found on the previous page
$title12 =$_SESSION["search"];
?>
<DOCTYPE html>
<html lang="en">
    <!--Page header -->
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!--Page title -->
        <title>Greatest Ganster Movies</title>
        <!-- link to the css stylesheet-->
        <link rel="stylesheet" type="text/css" href="../css/design.css">
        <!--Link to the javascript script-->
        <script src="../javascript/catalog.js" defer></script>
    </head>
    <!--Page body -->
    <body>
        <!--Page heading divs for styling -->
        <div class='page_header'>
            <div class='sub_header'>
                <div class='h1_container'>
                    <h1>Greatest Movies in the <span>Gangster Genre</span></h1>
                </div>
            </div>
        </div>
        <!--Outer container div  -->
        <div class='container'>
        <?php
            //getting the xml file data
            $filename = "../xml/catalog.xml";
            $catalog = simplexml_load_file($filename);
            //get the movie that matches the title specified
            $title1_id = $catalog->xpath("//movie[title='$title12']");
            //foreach field of the movie found echo its contents to a list with spans for styling the particulars
            foreach($title1_id as $movie){
                echo "<ul><li><div class='div1'>Title: <span>$movie->title</span></div></li>\n";
                echo "<li><div class='div1'>Director: <span>$movie->director</span></div></li>\n";
                echo "<li><div class='div1'>Film Duration: <span>$movie->length</span></div></li>\n";
                echo "<li><div class='div1'>IMDB Rating: <span>$movie->rating</span></div></li>\n";
                echo "<li><div class='div1'>Year Released: <span>$movie->year</span></div></li></ul>\n";
                $image = $movie->image;
                echo "<div class='div2'><img src='$image' alt='$movie->alt'></div>\n";
                echo "<div class='div3' id='blurb'><p>$movie->blurb (From Wikipedia)</p>\n";
                echo "<em><a href='$movie->link'>Wikipedia Page</a></em></div>";
            }
            ?>
        <!--End of the container div-->
        </div>
            <?php
                //adding the button to return to page 1
                echo "<button id='page1'>Page1</button>";
                ?>
    </body>
</html>