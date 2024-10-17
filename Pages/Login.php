<?php
include "../Database/Config.php";
include "../Functions/Functions.php";
session_start();
// Check if the user is logged in
if (isset($_SESSION['LoggedIN']) && $_SESSION['LoggedIN'] === true) {
  // check if  the user is an admin or a simple uer
  if ($_SESSION['Admin'] === true) {
      header("Location: AdminDashboard.php");
  } else {
      header("Location:  UserDashboard.php");
  }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['Login']))) {
  $Email = $_POST['Email'];
  $Password = sha1($_POST['Password']);
  $user_check_query = "SELECT * FROM users WHERE Email = '$Email' AND Password = '$Password'";
  $result_user = $conn->query($user_check_query);
  $admin_check_query = "SELECT * FROM admins WHERE Email = '$Email'  AND Password = '$Password'";
  $result_admin = $conn->query($admin_check_query);
  if ($result_user->num_rows > 0) {
    $UserRow = $result_user->fetch_assoc();
    $UserID = $UserRow['UserID'];
    $Name = $UserRow['Name'];
    $Email = $UserRow['Email'];
    $PhoneNumber = $UserRow['PhoneNumber'];
    $_SESSION['UserID'] = $UserID;
    $_SESSION['Name'] = $Name;
    $_SESSION['Email'] = $Email;
    $_SESSION['PhoneNumber'] = $PhoneNumber;
    $_SESSION['LoggedIN'] = true;
    $_SESSION['User'] = true;
    $_SESSION['Admin'] = false;

    header("Location: UserDashboard.php");
    exit();
  }
  if ($result_admin->num_rows > 0) {
    $AdminRow = $result_admin->fetch_assoc();
    $AdminID = $AdminRow['AdminID'];
    $Name = $AdminRow['Name'];
    $Email = $AdminRow['Email'];
    $PhoneNumber = $AdminRow['PhoneNumber'];
    $_SESSION['AdminID'] = $AdminID;
    $_SESSION['Name'] = $Name;
    $_SESSION['Email'] = $Email;
    $_SESSION['PhoneNumber'] = $PhoneNumber;
    $_SESSION['LoggedIN'] = true;
    $_SESSION['Admin'] = true;
    $_SESSION['User'] = false;
    header("Location: AdminDashboard.php");
    exit();
  }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Login</title>
</head>
<body>
  <section class="bg-gray-50 dark:bg-gray-900">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <div
        class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
          <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
            Login
          </h1>
          <form class="space-y-4 md:space-y-6" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div>
              <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
              <input type="email" name="Email" id="email"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="name@company.com" required="">
            </div>
            <div>
              <label for="password"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
              <input type="password" name="Password" id="password" placeholder="••••••••"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required="">
            </div>
        
          
            <input type="submit", value="Login" name ="Login"
              class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800" />
            <p class="text-sm font-light text-gray-500 dark:text-gray-400">
              Don't have an account? <a href="Register.php"
                class="font-medium text-primary-600 hover:underline dark:text-primary-500">Sign Up here</a>
            </p>
          </form>
        </div>
      </div>
    </div>
  </section>
</body>
</html>