<?php
session_start();
require_once("../dbconnection/connection.php");

$searchTerm = isset($_GET['query']) ? trim($_GET['query']) : '';
$displayTerm = $searchTerm;

error_log("Search Term: " . $searchTerm);

$hero = '<section class="relative flex flex-col items-center justify-center h-48 md:h-56 bg-gradient-to-br from-teal-100 via-white to-teal-200 mb-8 shadow-sm rounded-b-3xl animate-fade-in">
    <div class="absolute inset-0 bg-gradient-to-br from-black/10 via-transparent to-teal-200/30 rounded-b-3xl"></div>
    <div class="relative z-10 flex flex-col items-center justify-center h-full w-full text-center">
        <span class="inline-flex items-center justify-center bg-white shadow-lg rounded-full w-16 h-16 mb-4"><i class="fas fa-search text-3xl text-teal-600"></i></span>
        <h1 class="text-3xl md:text-4xl font-extrabold text-black drop-shadow mb-2 animate-fade-in">Search Results</h1>
        <p class="text-lg text-teal-700 animate-fade-in delay-200">' . ($displayTerm ? 'for "' . htmlspecialchars($displayTerm) . '"' : 'Find your favorite products') . '</p>
        <button onclick="closeSearchResults()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-3xl bg-white rounded-full p-2 shadow-md z-50 focus:outline-none"><i class="fas fa-times"></i></button>
    </div>
</section>';

echo '<div id="searchResultsContainer">';

if (!empty($searchTerm)) {
    $sql = "SELECT DISTINCT p.P_Id, p.P_Name, p.P_Price, p.P_Description, 
            (SELECT ps.image_1 FROM product_shades ps WHERE ps.product_id = p.P_Id LIMIT 1) as image_1
            FROM product p 
            WHERE p.P_Name LIKE ? OR p.P_Description LIKE ? 
            LIMIT 8";

    if ($stmt = $conn->prepare($sql)) {
        $searchTerm = "%{$searchTerm}%";
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($stmt->error) {
            error_log("SQL Error: " . $stmt->error);
        }

        echo $hero;
        echo '<section class="min-h-screen bg-gradient-to-br from-teal-50 via-white to-teal-100 px-2 md:px-0 animate-fade-in-up">
                <div class="container mx-auto px-2 md:px-8 py-8 md:py-16">';
        if ($result->num_rows > 0) {
            echo '<div class="box-container grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 md:gap-12 animate-fade-in-up mt-6">';
            while ($row = $result->fetch_assoc()) {
                $productId = htmlspecialchars($row["P_Id"]);
                $productName = htmlspecialchars($row["P_Name"]);
                $price = htmlspecialchars($row["P_Price"]);
                $image = htmlspecialchars($row["image_1"] ?? 'default-product.jpg');

                echo '<div class="product" data-id="' . $productId . '">
                        <div class="box p-6 md:p-8 bg-white overflow-hidden shadow-xl rounded-2xl border border-opacity-20 text-center relative hover:shadow-2xl hover:scale-105 hover:border-teal-600 border transition-all duration-300 cursor-pointer animate-fade-in-up flex flex-col h-full mb-6">
                        <button type="button"
                        class="fas fa-heart absolute top-4 right-4 rounded-full h-10 w-10 text-2xl text-black flex items-center justify-center wishlist-button transition-all duration-200"
                        data-id="' . $productId . '"
                        data-name="' . $productName . '"
                        data-price="' . $price . '"
                        data-image="../admin/components/uploads/' . $image . '"
                        ></button>

                            <a href="product.php?id=' . $productId . '" class="fas fa-eye absolute top-4 left-4 rounded-full h-10 w-10 text-2xl text-black flex items-center justify-center  transition-all duration-200"></a>
                            <div class="image-container flex items-center justify-center h-40 md:h-48 p-2 mb-4">
                                <img class="max-w-full max-h-full rounded-lg shadow object-contain h-full w-auto" src="../admin/components/uploads/' . $image . '" alt="' . $productName . '">
                            </div>
                            <h3 class="text-xl md:text-2xl h-20 text-black font-semibold mt-2 mb-1">' . $productName . '</h3>
                            <p class="text-teal-600 text-2xl md:text-3xl mt-2 font-bold">₹' . $price . '</p>
                        </div>
                    </div>';
            }
            echo '</div>';
        } else {
            echo '<div class="flex flex-col items-center justify-center h-64 mt-12 animate-fade-in-up">
                    <img src="../Images/empty-box.png" alt="No Products" class="w-32 h-32 mx-auto mb-4 opacity-70">
                    <p class="text-gray-500 text-lg text-center mt-2">No products found matching your search.</p>
                  </div>';
        }
        echo '</div></section>';
        $stmt->close();
    } else {
        echo $hero;
        echo '<section class="min-h-screen bg-gradient-to-br from-teal-50 via-white to-teal-100 flex flex-col justify-center items-center px-2 md:px-0 animate-fade-in-up">
                <div class="container mx-auto px-2 md:px-8 py-8 md:py-16">
                    <div class="flex flex-col items-center justify-center h-64 mt-12 animate-fade-in-up">
                        <i class="fas fa-exclamation-triangle text-6xl text-red-300 mb-4"></i>
                        <p class="text-red-500 text-lg text-center">Error preparing the search query.</p>
                    </div>
                </div></section>';
    }
} else {
    echo $hero;
    echo '<section class="min-h-screen bg-gradient-to-br from-teal-50 via-white to-teal-100 flex flex-col justify-center items-center px-2 md:px-0 animate-fade-in-up">
            <div class="container mx-auto px-2 md:px-8 py-8 md:py-16">
                <div class="flex flex-col items-center justify-center h-64 mt-12 animate-fade-in-up">
                    <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-lg text-center">Enter at least 2 characters to search.</p>
                </div>
            </div></section>';
}

echo '</div>'; // Close searchResultsContainer
$conn->close();
?>

<script>
    function closeSearchResults() {
        document.getElementById('searchResultsContainer').style.display = 'none';
        const main = document.querySelector('main');
        if (main) main.style.display = 'block';
        document.body.style.overflow = 'auto';
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.wishlist-button').forEach(button => {
            button.addEventListener('click', (event) => {
                event.preventDefault();
                const isLoggedIn = <?php echo isset($_SESSION['Email']) ? 'true' : 'false'; ?>;

                if (!isLoggedIn) {
                    alert('Please log in first to add products to your wishlist.');
                    window.location.href = 'login.php';
                    return;
                }

                // Read data attributes directly from the button
                const productId = parseInt(button.getAttribute('data-id'));
                const productName = button.getAttribute('data-name');
                const productPrice = parseFloat(button.getAttribute('data-price'));
                const productImage = button.getAttribute('data-image');

                // Debug: Log values
                console.log({
                    productId,
                    productName,
                    productPrice,
                    productImage
                });

                // Add to localStorage
                const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
                const exists = wishlist.find(item => Number(item.id) === productId);

                if (!exists) {
                    wishlist.push({
                        id: productId,
                        name: productName,
                        price: productPrice,
                        image: productImage
                    });
                    localStorage.setItem('wishlist', JSON.stringify(wishlist));
                    alert(`${productName} added to your wishlist.`);
                } else {
                    alert(`${productName} is already in your wishlist.`);
                }
            });
        });
    });
</script>