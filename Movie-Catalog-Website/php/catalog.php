<?php
//starting a session
//allowing back button to be clicked
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
?>
<DOCTYPE html>
<html lang="en">
    <!--Page header-->
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!--Title of the page -->
        <title>Greatest Ganster Movies</title>
        <!-- link to the css stylesheet-->
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <!--Link to the javascript script  -->
        <script src="../javascript/catalog.js" defer></script>
    </head>
    <!--Page body-->
    <body>
        <!--Page header div, with sub divs for styling-->
        <div class='page_header'>
            <div class='sub_header'>
                <div class='h1_container'>
                    <h1>Greatest Movies in the <span>Gangster Genre</span></h1>
                </div>
            </div>
        </div>
        <!--Introduction div with text -->
        <div class='intro'>
            <p>The Gangster movie genre can trace its origins back to early 20th century. With 
                the passing of the <span>Volstead Act in 1920</span>, the sale of alchohol was banned in the United States.
                This left room for members of the underworld to start trading in illegal bootleg liqour. This coupled with the Great Depresion starting in 1929,
                saw an unprecedented increase in crime throughout the U.S. Gangsters like <span>Al Capone, John Dilinger, Bonnie and Clyde</span> became household names,
                with their exploits extensively covered in national newspapers. The movies followed shortly after with Mervyn LeRoy's <span>Little Caesar</span> being released in 1931,
                loosely based on the life of <span>Al Capone</span>, the film traced the rise and fall of an upstart mobster. This model set the format for much of the genre moving forward.
                It has since broadened to cover a wider subsection of crime, and has gone international, with many directors approaching the gangster flick genre in 
                increasingly unique and interesting ways. Here is a list of some of my favourites.</p>
        </div>
        <!--Div wih sorting buttons in a form -->
        <div id='sorting'>
            <form action="catalog.php" method="post">
                <input class="sort_button" type="submit" name="sort_best" value="Sort by My Favourite" />
                <input class="sort_button" type="submit" name="sort_title" value="Sort by Title" />
                <input class="sort_button" type="submit" name="sort_year" value="Sort by Year" />
            </form>
        </div>
        <!--Div with searching textbox and button in a form -->
        <div id='searching'>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method = "post">
                <label for="search">Search for Title</label>
                <input type="text" placeholder="Search for Title" name='search' required="true" value=<?php echo $tester;?>>
                <input type="submit" value="Search" name="submit">
                <span class="error" id="error">* Please only enter letters(Godfather uses an i)</span>
            </form>
        </div>
        <!--Outer container div -->
        <div class="container">
        <!--Headings for the movies details -->
        <div class='heading'>Title</div>
        <div class='heading'>Director</div>
        <div class='heading'>Length(minutes)</div>
        <div class='heading'>Imdb Rating</div>
        <div class='heading'>Year</div>
        <div class='heading' id='image'>Image</div>
        <!--PHP code -->
        <?php
            //declaring variables
            //getting the xml file
            $filename = "../xml/catalog.xml";
            $catalog = simplexml_load_file($filename) or die("catlog.xml not found");
            $movies = $catalog->children();
            $movie_count = 0;
            //array for storing movie objects
            $movies_array = array();
            //boolean variables for sorting button clicks
            $titlesort = FALSE;
            $yearsort = FALSE;
            $bestsort = FALSE;
            //variables for movie objects
            $title1;
            $title2;
            //Class for movies
            class Movie{
                //movie fields
                public $title;
                public $director;
                public $length;
                public $rating;
                public $year;
                public $image;
                //Constructor for initialising a movie object
                function __construct($title,$director,$length,$rating,$year,$image){
                    $this->title=$title;
                    $this->director=$director;
                    $this->length=$length;
                    $this->rating=$rating;
                    $this->year=$year;
                    $this->image=$image;
                }
                //function that returns all the movies details to then be echoed for display
                function display_list(){
                    $part1="<div class='item' id='title' onclick='mv1_details()'>$this->title</div>\n";
                    $part2="<div class='item' id='director'>$this->director</div>\n";
                    $part3="<div class='item' id='length'>$this->length</div>\n";
                    $part4="<div class='item' id='rating'>$this->rating</div>\n";
                    $part5="<div class='item' id='year'>$this->year</div>\n";
                    $part6="<div class='item' id='image'><img src='$this->image'></div>\n";
                    return $part1.$part2.$part3.$part4.$part5.$part6;

                }
                //funtion that returns a movie title
                function get_title(){
                    return $this->title;
                }
                //funtion that returns a movie director
                function get_director(){
                    return $this->director;
                }
                //funtion that returns a movie length
                function get_length(){
                    return $this->length;
                }
                //funtion that returns a movie rating
                function get_rating(){
                    return $this->rating;
                }
                //funtion that returns a movie release year
                function get_year(){
                    return $this->year;
                }
                //funtion that returns a movie image
                function get_image(){
                    return $this->image;
                }

            }
            //go through the movies in the xml file and create Movie objects, adding them to a movies array
            foreach($catalog as $movie){
                $m = new Movie($movie->title,$movie->director,$movie->length,$movie->rating,$movie->year,$movie->image);
                array_push($movies_array, $m);
                $movie_count++;
            }
            //if someone clicks search button set bool to true
            $queryclicked = isset($_POST['search']);
            //if someone clicks sort_title button set titlesort bool to true
            if(isset($_POST['sort_title'])){
                $titlesort = TRUE;
            }
            //if someone clicks sort_year button set yearsort bool to true
            if(isset($_POST['sort_year'])){
                $yearsort = TRUE;
            }
            //if someone clicks sort_best button set bestsort bool to true
            if(isset($_POST['sort_best'])){
                $bestsort = TRUE;
            }
            //if someone hasnt clicked any sort button display the movies in the default order
            if($titlesort == FALSE && $yearsort == FALSE && $bestsort == FALSE && !(isset($_POST['search']))){
                foreach($movies_array as $movie){
                    echo $movie->display_list();
                 }
            }
            //if someone clicks sort_title button 
            if($titlesort==TRUE && !(isset($_POST['search']))){
                //sort the movies array alphabetically by title
                usort($movies_array,
                 function($first, $second){
                    return strcmp($first->title, $second->title);
                });
                //display the sorted movies
                foreach($movies_array as $movie){
                    echo $movie->display_list();
                } 

            }
            //if someone clicks year_sort button 
            if($yearsort==TRUE && !(isset($_POST['search']))){
                //sort the movies array numerically by year
                usort($movies_array,
                 function($first, $second)
                {
                    return strcmp($first->year, $second->year);
                });
                //display the sorted movies
                foreach($movies_array as $movie){
                    echo $movie->display_list();
                } 

            }
            //if someone clicks best_sort button
            if($bestsort==TRUE && !(isset($_POST['search']))){
                //display the movies as they are
                foreach($movies_array as $movie){
                    echo $movie->display_list();
                } 
            }
            //variable for storing a title error
            $title_error="";
            //if someone clicks the search button
            if(isset($_POST['search'])){
                $item = $_POST['search'];
                //check that the text entry doesn't contain non alphabetical characters
                if (preg_match('/[^a-z A-Z]/', $item)){
                    //if non letters are used set the title error
                    $title_error = "only letters are allowed";
                    //unhide the error message span
                    echo '<style>.error{visibility: visible ;}</style>';
                    //redisplay the movies list
                    foreach($movies_array as $movie){
                        echo $movie->display_list();
                    }
                } 
                else{
                    //convert the text entered to lowercase
                    $item = strtolower($item);
                    $count = 1;
                    //set found bool to false
                    $found = FALSE;
                    //loop through all the movies
                    for($i=1;$i<=20;$i++){
                        // get the movie by its id
                        $results=$catalog->xpath("//movie[@id='mv$i']");
                        //checking if the item searched exists
                        foreach($results as $result){
                            //make the movies title lowercase
                            $lower = strtolower($result->title);
                            //if the lowercase entry and movie title match set found to true
                            if($lower===$item){
                                $found =TRUE;
                                //create a new object of the movie that was found
                                $title1 = clone($result);
                            }
                        }
                    }
                    //If the movie is found display it by itself, hide the sort buttons
                    if($found== TRUE){
                            echo '<style>.sort_button{visibility: hidden ;}</style>';
                            echo "<div class='item'><a href='details.php'>$title1->title</a></div>\n";
                            echo "<div class='item'><a href='details.php'>$title1->director</a></div>\n";
                            echo "<div class='item'><a href='details.php'>$title1->length</a></div>\n";
                            echo "<div class='item'><a href='details.php'>$title1->rating</a></div>\n";
                            echo "<div class='item'><a href='details.php'>$title1->year</a></div>\n";
                            $image = $title1->image;
                            echo "<div class='item' id='image_page2'><a href='details.php'><img src='$image'></a></div>\n";
                    }
                }
            }
            //get the movies title and save it to the session, so the next page can access the name
            $interim = $title1->title;
            $title2 = (string)($interim);
            $_SESSION['search'] = $title2;
        ?>
        <!--closing container div-->
        </div>
        <?php
        //if the movie is found add a back button
        if($found == TRUE){
            echo "<button id='page1'>Page1</button>";
        }
        //if the search button is clicked and found is false and title error is still empty
        if(isset($_POST['search']) && $found == false && $title_error == ""){
            //hide the sort button and display an error message
            echo '<style>.sort_button{visibility: hidden ;}</style>';
            echo "<div class='not_found'><h2>Movie Not Found Please Search Again</h2></div>";
            //add a back button
            echo "<button id='page1'>Page1</button>";
        }
            ?>
    </body>
</html>