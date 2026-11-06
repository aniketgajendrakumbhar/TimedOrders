<?php
include "db.php";
$message = "";
if (isset($_POST["register"])) {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $mobile = trim($_POST["mobile"]);
    if ($name != "" && $email != "" && $mobile != "") {
        $stmt = mysqli_prepare($conn, "INSERT INTO customers (name,email,mobile) VALUES (?,?,?)");
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $mobile);
        if (mysqli_stmt_execute($stmt)) $message = "Registration successful!";
        else $message = "Could not save registration.";
    } else $message = "Please fill all fields.";
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Register | TimedOrders</title><link rel="stylesheet" href="style.css"></head><body>
<header class="topbar"><a class="brand" href="index.php"><span class="brand-mark">T</span> TimedOrders</a><nav><a href="index.php">Home</a><a href="restaurants.php">Restaurants</a><a href="cart.php">Cart</a><a href="orders.php">Orders</a></nav></header>
<main class="page-wrap narrow"><p class="eyebrow">JOIN TIMEDORDERS</p><h1>Create your account</h1><p class="muted">Enter sample details to register.</p>
<?php if($message!="") { ?><div class="success"><?php echo htmlspecialchars($message); ?></div><?php } ?>
<form method="post" class="form-card" onsubmit="return validateForm()">
<label>Full name</label><input type="text" name="name" id="name" placeholder="Your name"><span id="nameError" class="error"></span>
<label>Email address</label><input type="text" name="email" id="email" placeholder="name@example.com"><span id="emailError" class="error"></span>
<label>Mobile number</label><input type="text" name="mobile" id="mobile" maxlength="10" placeholder="10 digit mobile number"><span id="mobileError" class="error"></span>
<p id="helpText" class="help-text">Tip: Select a field to see a small help message.</p>
<button class="primary-button" type="submit" name="register">Register</button></form></main><footer>© 2026 TimedOrders</footer>
<script>
function validateForm() {
    let name=document.getElementById("name").value.trim();
    let email=document.getElementById("email").value.trim();
    let mobile=document.getElementById("mobile").value.trim();
    let valid=true;
    document.getElementById("nameError").textContent="";
    document.getElementById("emailError").textContent="";
    document.getElementById("mobileError").textContent="";
    if(!/^[A-Za-z ]{3,}$/.test(name)) { document.getElementById("nameError").textContent="Enter a name with at least 3 letters."; valid=false; }
    if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { document.getElementById("emailError").textContent="Enter a valid email."; valid=false; }
    if(!/^[0-9]{10}$/.test(mobile)) { document.getElementById("mobileError").textContent="Enter a 10 digit mobile number."; valid=false; }
    return valid;
}
document.getElementById("name").onfocus=()=>document.getElementById("helpText").textContent="Enter your full name using letters.";
document.getElementById("email").onfocus=()=>document.getElementById("helpText").textContent="Enter an email in name@example.com format.";
document.getElementById("mobile").onfocus=()=>document.getElementById("helpText").textContent="Enter 10 digits without spaces.";
</script></body></html>