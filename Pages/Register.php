<?php
include "../Database/Config.php";
include "../Functions/Functions.php";



// check if the Register button is clicked or not
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['Register']))) {
  $Email = $_POST['Email'];
  $PhoneNumber = $_POST['PhoneNumber'];
  $UserExists =  CheckUserExists($Email, $PhoneNumber, $conn);
  if ($UserExists) {
    echo "<script>alert('Email Or Phone Number Already Used')</script>";
    die();
  }



  // get the values from the form
  $ChoosePassword = $_POST['Password'];
  $ConfirmPassword = $_POST['ConfirmPassword'];
  $PasswordMatched = CheckPasswordAndConfirmPassword($ChoosePassword, $ConfirmPassword);
  if ($PasswordMatched) {
    // Loop until a unique user ID is found
    do {
      $UserID = generateUserId();

      // Check if user ID already exists in the database
      $check_query = "SELECT * FROM users WHERE UserID = '$UserID' LIMIT 1"; // Adjust table name and column
      $result = $conn->query($check_query);
      $check_query2 = "SELECT * FROM admins WHERE AdminID = '$UserID' LIMIT 1"; // Adjust table name and column
      $result2 = $conn->query($check_query2);
      
    } while ($result->num_rows > 0 AND $result2->num_rows > 0); // If exists, generate a new one
    
    $Name = $_POST['Name'];
    $UserType = $_POST['UserType'];
    $ConfirmPassword = sha1($ConfirmPassword);


    //Generate OTP
    $OTP = rand(999999, 111111);
    $To = $Email;
    $Subject = "OTP for Registration";
    $Message = "$Name Your OTP is $OTP and this system was developed by Mohammad Mahfuz Rahman";
    $EmailSent = SendEmail($To, $Subject,  $Message);
    if ($EmailSent) {
      session_start();
      $_SESSION['OTP'] = $OTP;
      $_SESSION['UserID'] = $UserID;
      $_SESSION['Name'] = $Name;
      $_SESSION['Email'] = $Email;
      $_SESSION['PhoneNumber'] = $PhoneNumber;
      $_SESSION['UserType'] = $UserType;
      $_SESSION['ConfirmPassword'] = $ConfirmPassword;
      header("Location: ./OtpPage.php");
      exit();
    }
    else {
      echo "<script>alert('Could Not Connect To Server Right Now')</script>";
    }


  } else {
    echo "<script>alert('Password and Confirm Password does not match')</script>";
  }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Register</title>
</head>
<body>
  <section class="bg-gray-50 dark:bg-gray-900">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <div
        class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
          <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
            Registration
          </h1>
          <form class="space-y-4 md:space-y-6" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

          <div>
              <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
              <input type="text" name="Name" id="name"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Full Name" required="">
            </div>


            <div>
              <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
              <input type="email" name="Email" id="email"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="name@company.com" required="">
            </div>


            <div>
              <label for="PhoneNumber" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contact</label>
              <input type="text" name="PhoneNumber" id="PhoneNumber"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Phone Number" required="" maxlength="11">
            </div>


            <div>
              <label for="UserType" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">UserType</label>
              <input type="text" name="UserType" id="UserType"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="User/Admin" required="">
            </div>



            <div>
              <label for="password"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
              <input type="password" name="Password" id="password" placeholder="••••••••"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required="">
            </div>

            <div>
              <label for="confirm-password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm
                password</label>
              <input type="password" name="ConfirmPassword" id="confirm-password" placeholder="••••••••"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required="">
            </div>

            

            <input type="submit" name="Register" value="Submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800" />
            <p class="text-sm font-light text-gray-500 dark:text-gray-400"> Already have an account? <a href="Login.php" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Login here</a></p>
          </form>
        </div>
      </div>
    </div>
  </section>
</body>
</html>