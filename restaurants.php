<?php
$restaurants = array(
    array("name"=>"Burger House","type"=>"Burgers","rating"=>4.3,"time"=>"25-30 min","image"=>"https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=700&q=80","foods"=>"burger, cheeseburger, fries, veg burger"),
    array("name"=>"Pizza Corner","type"=>"Pizza","rating"=>4.5,"time"=>"30-35 min","image"=>"https://images.unsplash.com/photo-1513104890138-7c749659a591?w=700&q=80","foods"=>"pizza, cheese pizza, margherita, garlic bread"),
    array("name"=>"South Spice","type"=>"South Indian","rating"=>4.2,"time"=>"20-25 min","image"=>"https://images.pexels.com/photos/5560763/pexels-photo-5560763.jpeg?w=700","foods"=>"dosa, idli, vada, uttapam, sambar"),
    array("name"=>"Sweet Treats","type"=>"Desserts","rating"=>4.6,"time"=>"20-30 min","image"=>"https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=700&q=80","foods"=>"cake, brownie, pastry, ice cream"),
    array("name"=>"Biryani Blues","type"=>"Biryani","rating"=>4.7,"time"=>"30-40 min","image"=>"https://images.unsplash.com/photo-1589302168068-964664d93dc0?w=700&q=80","foods"=>"biryani, chicken biryani, veg biryani, pulao"),
    array("name"=>"Wok Express","type"=>"Chinese","rating"=>4.1,"time"=>"25-35 min","image"=>"https://images.unsplash.com/photo-1512058564366-18510be2db19?w=700&q=80","foods"=>"fried rice, noodles, manchurian, momos"),
    array("name"=>"The Sandwich Spot","type"=>"Sandwiches","rating"=>4.0,"time"=>"20-25 min","image"=>"https://images.unsplash.com/photo-1528735602780-2552fd46c7af?w=700&q=80","foods"=>"sandwich, cheese sandwich, grilled sandwich"),
    array("name"=>"Crispy Chicken","type"=>"Chicken","rating"=>4.4,"time"=>"25-35 min","image"=>"https://images.unsplash.com/photo-1626645738196-c2a7c87a8f58?w=700&q=80","foods"=>"fried chicken, chicken wings, nuggets, burger"),
    array("name"=>"Healthy Bowl","type"=>"Healthy","rating"=>4.3,"time"=>"20-30 min","image"=>"https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=700&q=80","foods"=>"salad, rice bowl, paneer bowl, healthy food"),
    array("name"=>"Rolls & More","type"=>"Rolls","rating"=>4.2,"time"=>"20-30 min","image"=>"https://images.unsplash.com/photo-1626700051175-6818013e1d4f?w=700&q=80","foods"=>"roll, paneer roll, egg roll, wrap"),
    array("name"=>"Cafe Coffee Day","type"=>"Cafe","rating"=>4.1,"time"=>"15-25 min","image"=>"https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=700&q=80","foods"=>"coffee, cold coffee, sandwich, burger"),
    array("name"=>"Tandoori Kitchen","type"=>"North Indian","rating"=>4.5,"time"=>"30-40 min","image"=>"https://images.unsplash.com/photo-1546833999-b9f581a1996d?w=700&q=80","foods"=>"paneer tikka, naan, dal makhani, roti, thali")
);
$sort = $_GET["sort"] ?? "name";
if ($sort == "rating") {
    usort($restaurants, function($a,$b) { return $b["rating"] <=> $a["rating"]; });
} else {
    usort($restaurants, function($a,$b) { return strcmp($a["name"],$b["name"]); });
}
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Restaurants | TimedOrders</title><link rel="stylesheet" href="style.css"></head><body>
<header class="topbar"><a class="brand" href="index.php"><span class="brand-mark">T</span> TimedOrders</a><nav><a href="index.php">Home</a><a href="restaurants.php">Restaurants</a><a href="register.php">Sign up</a><a href="cart.php">Cart</a><a href="orders.php">Orders</a></nav></header>
<main class="page-wrap"><p class="eyebrow">FIND YOUR FAVOURITE</p><h1>Restaurants near you</h1><p class="muted">Search by restaurant name, food name or cuisine.</p>
<div class="search-box" style="max-width:560px;margin:22px 0"><input id="restaurantSearch" type="text" placeholder="Try biryani, dosa, pizza, noodles..."><button type="button" onclick="searchPlaces()">Search</button></div>
<form class="sort-form" method="get">Sort by: <select name="sort"><option value="name" <?php if($sort=="name") echo "selected"; ?>>Name (A-Z)</option><option value="rating" <?php if($sort=="rating") echo "selected"; ?>>Rating</option></select><button class="small-button" type="submit">Sort</button></form>
<div class="restaurant-grid" id="restaurantGrid">
<?php foreach($restaurants as $r) { ?>
<article class="restaurant-card" data-search="<?php echo htmlspecialchars(strtolower($r["name"]." ".$r["type"]." ".$r["foods"]), ENT_QUOTES); ?>"><div class="restaurant-image"><img src="<?php echo htmlspecialchars($r["image"]); ?>" alt="<?php echo htmlspecialchars($r["name"]); ?>"><small>POPULAR</small></div><div class="card-content"><h3><?php echo htmlspecialchars($r["name"]); ?></h3><p>⭐ <?php echo $r["rating"]; ?> · <?php echo htmlspecialchars($r["time"]); ?></p><p class="muted"><?php echo htmlspecialchars($r["type"]); ?></p><a class="small-button" href="menu.php?restaurant=<?php echo urlencode($r['name']); ?>">View menu</a></div></article>
<?php } ?>
</div><p id="noResults" class="empty-message" style="display:none">No matching restaurants or food found. Try another search.</p></main><footer>© 2026 TimedOrders</footer>
<script>
function searchPlaces(){let term=document.getElementById('restaurantSearch').value.trim().toLowerCase();let cards=document.querySelectorAll('.restaurant-card');let count=0;cards.forEach(function(card){let show=card.dataset.search.includes(term);card.style.display=show?'':'none';if(show)count++;});document.getElementById('noResults').style.display=count===0?'block':'none';}
document.getElementById('restaurantSearch').addEventListener('input',searchPlaces);
</script></body></html>