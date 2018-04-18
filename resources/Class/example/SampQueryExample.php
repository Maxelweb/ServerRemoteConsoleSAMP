<html>
    <head>
        <title>SampQueryExample</title>
    </head>
    <body>
        <?php
        /**
        * @author Edward McKnight (EM-Creations.co.uk)
        */
        
        require("SampQuery.class.php"); // Require or include the SampQuery class file
        
        $query = new SampQuery("127.0.0.1", 7777); // Create the SampQuery object
        
        if ($query->connect()) { // Attempt to the SA-MP server and if the connection was successful run the code below
            echo "Connected<br /><br />";
            
            print_r($query->getInfo()); // Print the array returned by getInfo
            echo "<br /><br />";
            
            print_r($query->getBasicPlayers()); // Print the array returned by getBasicPlayers
            echo "<br /><br />";
            
            print_r($query->getDetailedPlayers()); // Print the array returned by getDetailedPlayers
            echo "<br /><br />";
            
            print_r($query->getRules()); // Print the array returned by getRules
            echo "<br /><br />";
            
            print_r($query->getPing()); // Print the value returned by getPing
            echo "<br /><br />";
        } else {
            echo "Server did not respond!<br />";
        }
        $query->close(); // Close the connection
        ?>
    </body>
</html>