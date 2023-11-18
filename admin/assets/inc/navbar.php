<!DOCTYPE html>
<html>

<head>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .nav1 {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 10vh;
    }

    .navbar {
      width: 98vw;
      height: 7.5vh;
      margin: 0 auto;
      position: relative;
      display: flex;
      background-color: #363062;
      backdrop-filter: blur(20px);
      border-radius: 10px;
      align-items: center;
      box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
      z-index: 3;
    }

    .logo {
      position: absolute;
      color: white;
      width: 100px;
      height: 40px;
      justify-content: center;
      align-items: center;
      display: flex;
      border-radius: 10px 0 0 10px;
    }

    .logo_img {
      margin-top: 3px;
      margin-left: 10px;
      width: 100px;
      height: 40px;
      cursor: pointer;
    }

    .links {
      position: relative;
      width: 98%;
      display: flex;
      justify-content: flex-end;
      align-items: center;
    }

    .links ul {
      margin: 0;
      display: flex;
      gap: 20px;
      list-style-type: none;
    }

    .links li {
      position: relative;
    }

    .links li a {
      color: white;
      font-size: 20px;
      text-decoration: none;
    }

    .dropdown-content1 {
      display: none;
      position: absolute;
      background-color: rgb(138, 138, 138);
      backdrop-filter: blur(20px);
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.307);
      z-index: 2;
      border-radius: 5px;
      top: 100%;
      right: 0; 
    }

    .dropdown-content1 a {
      padding: 12px 16px;
      text-decoration: none;
      display: block;
      color: #ffffff;
      transition: background-color 0.3s;
      border-radius: 5px;
    }

    .dropdown-content1 a:hover {
      background-color: #555;
      backdrop-filter: blur(20px);
    }

    .dropdown img {
      width: 27px; /* Increased profile icon size */
      height: 27px; /* Increased profile icon size */
      cursor: pointer;
    }
    
    .user-profile {
      margin-right: 15px;
      border-radius: 10px;
    }

  </style>
</head>

<body>
  <div class="nav1">
    <div class="navbar">
      <div class="logo"><img src="assets/img/logo.png" alt="Logo" class="logo_img" onclick="navigateTo('emp-dashboard.php')"></div>
      <div class="links">
        <ul>
          <li><a href="emp-dashboard.php">Dashboard</a></li>
          <li class="dropdown">
            <a href="#" onclick="toggleDropdown('trainDropdown')"> Trains </a>
            <div id="trainDropdown" class="dropdown-content1">
              <a href="emp-add-train.php">Add Trains</a>
              <a href="emp-manage-train.php">Manage Trains</a>
            </div>
          </li>
          <li><a href="emp-manage-passengers.php">Passengers</a></li>
          <li><a href="emp-tickets.php">Reservations</a></li>
          <li><a href="emp-manage-users.php">Users</a></li>
          <li class="user-profile">
            <div class="dropdown">
              <img src="assets/img/profile.png" class="profile-image" onclick="toggleDropdown('profileDropdown')">
              <div id="profileDropdown" class="dropdown-content1">
                <a href="emp-profile.php">My Profile</a>
                <a href="emp-logout.php">Logout</a>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <script>
    function toggleDropdown(dropdownId) {
      var dropdownContent = document.getElementById(dropdownId);
      dropdownContent.style.display = (dropdownContent.style.display === "block") ? "none" : "block";
    }

    function navigateTo(url) {
      window.location.href = url;
    }
  </script>

</body>

</html>