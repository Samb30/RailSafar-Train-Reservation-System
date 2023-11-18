<nav class="navbar">
  <div class="logo">
    <img src="./assets1/black_logo.png" alt="Logo">
  </div>
  <div class="navbar-right">
    <ul class="nav-links">
      <li><a href="pass-dashboard1.php">Dashboard</a></li>
      <li><a href="bookings.php">Bookings</a></li>
      <li class="user-profile">
        <div class="dropdown">
          <img src="./assets1/user.png" class="profile-image" onclick="toggleDropdown()">
          <div id="myDropdown" class="dropdown-content1">
            <a><?php
               
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "dbms";

                $conn = new mysqli($servername, $username, $password, $dbname);
                $username = $_SESSION['username'];
                
                echo $username;
                ?><span> <img src="./assets1/green.png" style="scale:0.3;position:absolute;margin-top:0px;"> </span></a>
            <a href="pass-profile.php">My Profile</a>
            <a href="logout.php">Logout</a>
          </div>
        </div>
      </li>
    </ul>
  </div>
</nav>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Get references to the elements
    var dropdownImage = document.querySelector(".dropdown img");
    var dropdownContent = document.getElementById("myDropdown");

    // Add an event listener to show/hide the dropdown content on image hover
    dropdownImage.addEventListener("mouseover", function() {
      dropdownContent.style.display = "block";
    });

    dropdownImage.addEventListener("mouseout", function() {
      dropdownContent.style.display = "none";
    });

    dropdownContent.addEventListener("mouseover", function() {
      dropdownContent.style.display = "block";
    });

    dropdownContent.addEventListener("mouseout", function() {
      dropdownContent.style.display = "none";
    });
  });
</script>