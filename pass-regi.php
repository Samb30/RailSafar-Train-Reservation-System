<?php
session_start();



if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_POST['email']) && isset($_POST['password'])) {
    // Database connection parameters
    $host = "localhost"; // Replace with your database host
    $dbname = "dbms"; // Replace with your database name
    $username = "root"; // Replace with your database username
    $password = ""; // Replace with your database password

    try {
      // Create a PDO instance
      $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

      // Set the PDO error mode to exception
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // Your user-provided email and password
      $userEmail = $_POST['email']; // Make sure to validate/sanitize user input
      $userPassword = $_POST['password']; // Make sure to validate/sanitize user input

      // Prepare the SQL query with placeholders
      $stmt = $db->prepare("SELECT userID, userUname FROM users_details WHERE userEmail = ? AND userPwd = ?");
      $stmt->bindParam(1, $userEmail);
      $stmt->bindParam(2, $userPassword);

      // Execute the query
      $stmt->execute();

      // Check if a row was found (valid login)
      if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $current_user = $row['userUname'];

        // Set the session variable for the authenticated user
        $_SESSION['username'] = $current_user;
        header("Location: pass-dashboard1.php");
        exit();
      } else {
        // Unsuccessful login, display an error message
        echo "Invalid email or password. Please try again.";
      }
    } catch (PDOException $e) {
      // Handle database connection or query errors here
      echo "Error: " . $e->getMessage();
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
  }
}

if (isset($_POST['pass_register'])) {

  $host = "localhost"; // e.g., "localhost"
  $dbname = "dbms";
  $username = "root";
  $password = "";

  $mysqli = new mysqli($host, $username, $password, $dbname);

  if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
  }

  // User registration data
  $pass_fname = $_POST['pass_fname'];
  $pass_lname = $_POST['pass_lname'];
  $pass_phone = $_POST['pass_phone'];
  $pass_addr = $_POST['pass_addr'];
  $pass_dob = $_POST['pass_dob'];
  $pass_uname = $_POST['pass_uname'];
  $pass_email = $_POST['pass_email'];
  $pass_pwd = $_POST['pass_pwd'];
  $pass_gender = $_POST['pass_gender'];

  $pass_birthdate = new DateTime($pass_dob);
  $currentDate = new DateTime();
  $pass_age = $currentDate->diff($pass_birthdate)->y;

  // SQL to insert captured values
  $query = "INSERT INTO users_details (userFname, userLname, userPhone, userAddr, userUname, userEmail, userPwd) VALUES (?,?,?,?,?,?,?)";
  $stmt = $mysqli->prepare($query);
  $stmt->bind_param('sssssss', $pass_fname, $pass_lname, $pass_phone, $pass_addr, $pass_uname, $pass_email, $pass_pwd);

  if ($stmt->execute()) {
    $success = "Created Account. Proceed to Log In.";
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
  } else {
    $err = "Please Try Again or Try Later.";
  }

  // Close the database connection

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device width, initial-scale=1.0">
  <title>Your Web Page Title</title>
  <link rel="stylesheet" href="css/regi.css" type="text/css" />
</head>

<body>
  <section class="user">
    <div class="user_options-container">
      <div class="user_options-text">
        <div class="user_options-unregistered">
          <h2 class="user_unregistered-title">Don't have an account?</h2>
          <button class="user_unregistered-signup" id="signup-button">Sign up</button>
        </div>

        <div class="user_options-registered">
          <h2 class="user_registered-title">Have an account?</h2>

          <button class="user_registered-login" id="login-button">Login</button>
        </div>
      </div>

      <div class="user_options-forms" id="user_options-forms">
        <div class="user_forms-login">
          <h2 class="forms_title">Login</h2>
          <form class="forms_form" method="post">
            <fieldset class="forms_fieldset">
              <div class="forms_field">
                <input type="email" placeholder="Email" name="email" class="forms_field-input" required autofocus />
              </div>
              <div class="forms_field">
                <input type="password" placeholder="Password" name="password" class="forms_field-input" required />
              </div>
            </fieldset>
            <div class="forms_buttons">
              <button type="button" class="forms_buttons-forgot">Forgot password?</button>
              <input type="submit" value="Log In" class="forms_buttons-action">
            </div>
          </form>
        </div>
        <div class="user_forms-signup">
          <h2 class="forms_title">Sign Up</h2>
          <form class="forms_form" method="post">
            <input type="hidden" name="pass_register" value="1">
            <fieldset class="forms_fieldset">
              <div class="forms_field">
                <input type="text" placeholder="First Name" name="pass_fname" class="forms_field-input" required />
              </div>
              <div class="forms_field">
                <input type="text" placeholder="Last Name" name="pass_lname" class="forms_field-input" required />
              </div>
              <div class="forms_field">
                <input type="tel" placeholder="Phone Number" name="pass_phone" class="forms_field-input" required />
              </div>
              <div class="forms_field">
                <input type="text" placeholder="Address" name="pass_addr" class="forms_field-input" required />
              </div>
              <div class="forms_field" style="display:flex;justify-content: space-evenly;">
                <input type="date" style="margin-right: 10px;" placeholder="Birth Date" name="pass_dob" class="forms_field-input" required />
                <input type="text" style="margin-left: 10px;" placeholder="Gender" name="pass_gender" class="forms_field-input" required />
              </div>
              <div class="forms_field">
                <input type="text" placeholder="Username" name="pass_uname" class="forms_field-input" required />
              </div>
              <div class="forms_field">
                <input type="email" placeholder="Email" name="pass_email" class="forms_field-input" required />
              </div>
              <div class="forms_field">
                <input type="password" placeholder="Password" name="pass_pwd" class="forms_field-input" required />
              </div>
            </fieldset>
            <div class="forms_buttons">
              <input type="submit" value="Sign up" class="forms_buttons-action">
            </div>
          </form>
        </div>

      </div>
    </div>
  </section>

  <script>
    /**
     * Variables
     */
    const signupButton = document.getElementById('signup-button'),
      loginButton = document.getElementById('login-button'),
      userForms = document.getElementById('user_options-forms')

    /**
     * Add event listener to the "Sign Up" button
     */
    signupButton.addEventListener('click', () => {
      userForms.classList.remove('bounceRight')
      userForms.classList.add('bounceLeft')
    }, false)

    /**
     * Add event listener to the "Login" button
     */
    loginButton.addEventListener('click', () => {
      userForms.classList.remove('bounceLeft')
      userForms.classList.add('bounceRight')
    }, false)
  </script>
</body>

</html>