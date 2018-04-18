<html>
    <head>
        <title>SampRconExample</title>
    </head>
    <body>
        <?php
        /**
        * @author Edward McKnight (EM-Creations.co.uk)
        */
        
        require("SampRcon.class.php"); // Require or include the SampRcon class file

        $query = new SampRcon("127.0.0.1", 7777, "changeme1"); // Create the SampRcon object
        
        if ($query->connect()) { // Attempt to the SA-MP server and if the connection was successful run the code below
            echo "Connected<br /><br />";

            print_r($query->kick(0)); // Print the output of kicking ID 0 from the server
            print_r($query->getServerVariables()); // Print the server variables array
            $query->gmx(); // GMX the server
            $query->setTime("13:00"); // Set the server's time
            $query->setURL("http://em-creations.co.uk"); // Set the server's URL
            $query->setMapname("My Test Map"); // Set the server's map name
            $query->setHostName("My Test Server"); // Set the server's host name        
        } else {
            echo "Server did not respond!<br />";
        }
        $query->close(); // Close the connection
        ?>
    </body>
</html>