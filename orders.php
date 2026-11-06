<?php
include "db.php";

// Delete an order when the Delete button is submitted.
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_order"])) {
    $order_id = (int) $_POST["order_id"];

    if ($order_id > 0) {
        $stmt = mysqli_prepare($conn, "DELETE FROM orders WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $order_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Refresh the page without resubmitting the delete request.
    header("Location: orders.php");
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM orders ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Orders | TimedOrders</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="topbar">
    <a class="brand" href="index.php"><span class="brand-mark">T</span> TimedOrders</a>
    <nav>
        <a href="index.php">Home</a>
        <a href="restaurants.php">Restaurants</a>
        
        <a href="cart.php">Cart</a>
        <a href="register.php">Sign up</a>
        <a href="orders.php">Orders</a>
    </nav>
</header>

<main class="page-wrap">
    <p class="eyebrow">ORDER HISTORY</p>
    <h1>Your orders</h1>
    <p class="muted">View your orders and remove an order if it is no longer needed.</p>

    <div class="table-wrap">
        <table>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Items</th>
                <th>Total</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            <?php if ($result && mysqli_num_rows($result) > 0) { ?>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo (int) $row["id"]; ?></td>
                        <td><?php echo htmlspecialchars($row["customer_name"]); ?></td>
                        <td><?php echo htmlspecialchars($row["items"]); ?></td>
                        <td>₹<?php echo htmlspecialchars($row["total"]); ?></td>
                        <td><?php echo htmlspecialchars($row["order_date"]); ?></td>
                        <td>
                            <form method="post" onsubmit="return confirm('Are you sure you want to delete this order?');">
                                <input type="hidden" name="order_id" value="<?php echo (int) $row["id"]; ?>">
                                <button type="submit" name="delete_order" class="remove-button">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr><td colspan="6" class="empty-message">No orders found yet.</td></tr>
            <?php } ?>
        </table>
    </div>

    <a class="small-button" href="menu.php">Order more food</a>
</main>
<footer>© 2026 TimedOrders</footer>
</body>
</html>
