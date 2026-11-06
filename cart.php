<?php
session_start();
include "db.php";
$message = "";
if (isset($_POST["place_order"])) {
    $name = trim($_POST["customer_name"]);
    $items = trim($_POST["items"]);
    $total = floatval($_POST["total"]);
    if ($name != "" && $items != "" && $total > 0) {
        $stmt = mysqli_prepare($conn, "INSERT INTO orders (customer_name, items, total) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssd", $name, $items, $total);
        mysqli_stmt_execute($stmt);
        $message = "Your sample order has been placed successfully!";
    } else {
        $message = "Please add food and enter your name.";
    }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Your Cart | TimedOrders</title><link rel="stylesheet" href="style.css"></head><body>
<header class="topbar"><a class="brand" href="index.php"><span class="brand-mark">T</span> TimedOrders</a><nav><a href="index.php">Home</a><a href="restaurants.php">Restaurants</a><a href="register.php">Sign up</a><a href="orders.php">Orders</a></nav></header>
<main class="page-wrap narrow"><p class="eyebrow">ALMOST THERE</p><h1>Your cart</h1><p class="muted">Review your items before placing a sample order.</p>
<?php if($message!="") { ?><div class="success"><?php echo htmlspecialchars($message); ?> <a href="orders.php">View orders</a></div><?php } ?>
<div id="cartItems" class="cart-box"></div>
<form method="post" id="orderForm" class="form-card" onsubmit="return prepareOrder()">
<label>Your name</label><input type="text" name="customer_name" required placeholder="Enter your name">
<input type="hidden" name="items" id="itemsInput"><input type="hidden" name="total" id="totalInput">
<div class="total-row"><span>Total</span><strong id="totalAmount">₹0</strong></div>
<button class="primary-button" type="submit" name="place_order">Place sample order</button>
</form><a class="text-link" href="menu.php">← Continue shopping</a></main><footer>© 2026 TimedOrders</footer>
<script>
let cart = JSON.parse(sessionStorage.getItem("timedCart") || "[]");
function showCart() {
    let box=document.getElementById("cartItems"), total=0, text="";
    if(cart.length==0) box.innerHTML="<p>Your cart is empty. Visit the menu to add food.</p>";
    else {
        cart.forEach((item,index)=>{
            total += item.price*item.quantity;
            text += "<div class='cart-row'><div><b>"+item.name+"</b><p class='muted'>₹"+item.price+" × "+item.quantity+"</p></div><button type='button' class='remove-button' onclick='removeItem("+index+")'>Remove</button></div>";
        });
        box.innerHTML=text;
    }
    document.getElementById("totalAmount").textContent="₹"+total;
}
function removeItem(index) { cart.splice(index,1); sessionStorage.setItem("timedCart",JSON.stringify(cart)); showCart(); }
function prepareOrder() {
    if(cart.length==0) { alert("Your cart is empty."); return false; }
    let total=cart.reduce((sum,item)=>sum+item.price*item.quantity,0);
    document.getElementById("itemsInput").value=cart.map(item=>item.name+" x "+item.quantity).join(", ");
    document.getElementById("totalInput").value=total;
    sessionStorage.removeItem("timedCart");
    return true;
}
showCart();
</script></body></html>