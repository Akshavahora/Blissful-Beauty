<?php

session_start();

// Database connection
require_once('../dbconnection/connection.php');

// Get the product ID from the URL
$product_id = isset($_GET['id']) ? $_GET['id'] : null;
$product = null;

if (!$product_id) {
    die("Invalid product ID.");
}

// Fetch the product details along with its shades
$sel = "SELECT * FROM product p INNER JOIN product_shades ps ON p.P_Id = ps.product_id WHERE p.P_Id ='$product_id'";
$query = mysqli_query($conn, $sel);

// Fetch the product details
$product = mysqli_fetch_assoc($query);

// Reset the query result and fetch all shades
mysqli_data_seek($query, 0);
$shades = mysqli_fetch_all($query, MYSQLI_ASSOC);

function getColorNameFromAPI($hex)
{
    $hex = ltrim($hex, '#'); // Remove # if present
    $url = "https://www.thecolorapi.com/id?hex=$hex";

    $response = file_get_contents($url);
    if ($response) {
        $data = json_decode($response, true);
        return $data['name']['value'] ?? "Unknown Color";
    }
    return "Unknown Color";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .product-gradient {
            background: linear-gradient(120deg, #f0fdfa 0%, #fdf2f8 100%);
            min-height: 100vh;
        }

        .product-card {
            box-shadow: 0 8px 32px 0 rgba(16, 185, 129, 0.10);
            border-radius: 2rem;
            border: 2px solid #e0e7ef;
            background: #fff;
            transition: box-shadow 0.2s, border-color 0.2s;
        }

        .product-card:hover {
            box-shadow: 0 12px 40px 0 rgba(16, 185, 129, 0.18);
            border-color: #14b8a6;
        }

        .product-image {
            border-radius: 1.5rem;
            box-shadow: 0 4px 16px 0 rgba(16, 185, 129, 0.10);
            border: 2px solid #e0e7ef;
            background: #fff;
            transition: box-shadow 0.2s, border-color 0.2s, transform 0.2s;
        }

        .product-image:hover {
            box-shadow: 0 8px 32px 0 rgba(16, 185, 129, 0.18);
            border-color: #14b8a6;
            transform: scale(1.03);
        }

        .shade-option {
            position: relative;
            border: 2px solid #e5e7eb;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .shade-option.selected,
        .shade-option:focus {
            border-color: #14b8a6 !important;
            box-shadow: 0 0 0 2px #99f6e4;
        }

        .shade-tooltip {
            display: none;
            position: absolute;
            left: 50%;
            top: 110%;
            transform: translateX(-50%);
            background: #fff;
            color: #0d9488;
            padding: 0.25rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.9rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            z-index: 10;
            white-space: nowrap;
        }

        .shade-option:hover .shade-tooltip {
            display: block;
        }

        .back-to-top {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 50;
            background: #14b8a6;
            color: #fff;
            border-radius: 9999px;
            padding: 0.8rem 1.1rem;
            box-shadow: 0 4px 16px 0 rgba(16, 185, 129, 0.18);
            font-size: 1.5rem;
            cursor: pointer;
            transition: background 0.2s, transform 0.2s;
        }

        .back-to-top:hover {
            background: #0d9488;
            transform: scale(1.08);
        }
    </style>
</head>

<body class="product-gradient s">
    <main class="container mx-auto py-12 flex flex-col items-center min-h-screen">
        <div class="w-full max-w-5xl product-card p-8 flex flex-col md:flex-row gap-10">
            <!-- Product Image Section -->
            <div class="w-full md:w-1/2 flex flex-col gap-4 items-center justify-center">
                <div class="grid grid-cols-2 gap-4">
                    <img id="product-img-1" class="w-44 h-44 md:w-64 md:h-64 product-image object-cover" src='../admin/components/uploads/<?php echo $product['image_1']; ?>' alt="Product Image">
                    <img id="product-img-2" class="w-44 h-44 md:w-64 md:h-64 product-image object-cover" src='../admin/components/uploads/<?php echo $product['image_2']; ?>' alt="Product Image">
                    <img id="product-img-3" class="w-44 h-44 md:w-64 md:h-64 product-image object-cover" src='../admin/components/uploads/<?php echo $product['image_3']; ?>' alt="Product Image">
                    <img id="product-img-4" class="w-44 h-44 md:w-64 md:h-64 product-image object-cover" src='../admin/components/uploads/<?php echo $product['image_4']; ?>' alt="Product Image">
                </div>
            </div>
            <!-- Product Details -->
            <div class="w-full md:w-1/2 flex flex-col justify-center mt-6 md:mt-0">
                <h1 class="text-3xl md:text-3xl font-extrabold text-teal-700 mb-4"><?php echo isset($product['P_Name']) ? $product['P_Name'] : 'No Name'; ?></h1>
                <p class="text-gray-700 mb-4 text-lg md:text-xl font-medium"><?php echo isset($product['P_Description']) ? $product['P_Description'] : 'No Description'; ?></p>
                <p class="text-gray-500 mb-2 text-lg">Category: <span class="font-bold text-pink-500"><?php echo isset($product['P_Category']) ? $product['P_Category'] : 'Uncategorized'; ?></span></p>
                <p class="text-3xl md:text-4xl font-extrabold text-teal-600 mt-2 mb-6">₹<?php echo isset($product['P_Price']) ? $product['P_Price'] : '0.00'; ?></p>
                <!-- Shades Selection -->
                <div class="mt-4">
                    <label class="text-lg font-semibold text-gray-700">Available Shades:</label>
                    <div class="flex flex-wrap mt-2 gap-2" id="shade-swatches">
                        <?php foreach ($shades as $shade) :
                            $hexColor = $shade['shade'];
                            $colorName = getColorNameFromAPI($hexColor);
                        ?>
                            <div class="shade-option cursor-pointer rounded-full w-12 h-12 flex items-center justify-center border-2 border-gray-300 relative focus:outline-none"
                                style="background-color: <?php echo $hexColor; ?>;"
                                title="<?php echo $colorName; ?>"
                                data-shade-id="<?php echo $shade['id']; ?>"
                                data-shade-color="<?php echo $shade['shade']; ?>"
                                data-img1="<?php echo $shade['image_1']; ?>"
                                data-img2="<?php echo $shade['image_2']; ?>"
                                data-img3="<?php echo $shade['image_3']; ?>"
                                data-img4="<?php echo $shade['image_4']; ?>"
                                tabindex="0">
                                <span class="shade-tooltip"><?php echo $colorName; ?></span>
                                <span class="hidden checkmark text-white text-xl"><i class="fas fa-check-circle"></i></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-2 text-sm text-gray-600" id="selected-shade-label"></div>
                </div>
                <!-- Buttons -->
                <div class="mt-8">
                    <button
                        onclick="addToCart(
                            '<?php echo $product['P_Id']; ?>',
                            '<?php echo addslashes($product['P_Name']); ?>',
                            '<?php echo $product['P_Price']; ?>',
                            selectedShadeId,  
                            selectedShadeColor,  // Pass selected shade color
                            document.getElementById('product-img-1').src, 
                            document.getElementById('product-img-2').src, 
                            document.getElementById('product-img-3').src, 
                            document.getElementById('product-img-4').src
                        )"
                        class="add-to-cart bg-teal-500 hover:tracking-wide text-xl inline-flex items-center justify-center text-white rounded-lg cursor-pointer py-3 px-8 font-bold shadow transition-all duration-200">
                        <i class="fas fa-shopping-bag mr-2"></i>Add to Bag
                    </button>
                </div>
            </div>
        </div>
        <!-- Back to Top Button -->
        <button onclick="window.scrollTo({top: 0, behavior: 'smooth'});" class="back-to-top" title="Back to Top"><i class="fas fa-arrow-up"></i></button>
    </main>
</body>

<script>
    // Function to add a product to the cart
    function addToCart(productId, productName, productPrice, shadeProductId, shadeColor, img1, img2, img3, img4) {
        if (!shadeProductId) {
            alert("Please select a shade before adding to the cart!");
            return;
        }

        const cart = JSON.parse(localStorage.getItem('cart')) || [];

        // Check if the same product + shade already exists
        const existingProduct = cart.find(item => item.shade_product_id === shadeProductId);

        if (existingProduct) {
            existingProduct.quantity += 1; // Increase quantity if the same shade is selected again
        } else {
            cart.push({
                id: productId,
                name: productName,
                price: productPrice,
                shade_product_id: shadeProductId, // Store shade product ID instead of color
                shade_color: shadeColor, // Store shade color for display
                images: [img1, img2, img3, img4],
                quantity: 1
            });
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        alert(`${productName} (Shade: ${shadeColor}) added to cart!`);
        updateCartCount();
    }


    // Function to update cart count
    function updateCartCount() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const cartCountElement = document.querySelector('.cart-count');
        if (cartCountElement) {
            cartCountElement.textContent = cart.reduce((total, item) => total + item.quantity, 0);
        }
    }

    // Initialize cart count on page load
    updateCartCount();

    document.addEventListener("DOMContentLoaded", function() {
        // Shade swatch selection logic
        let firstShade = document.querySelector(".shade-option");
        if (firstShade) {
            firstShade.click(); // Simulate a click to apply the default selection
        }
        document.querySelectorAll('.shade-option').forEach(shade => {
            shade.addEventListener('click', function(event) {
                document.querySelectorAll('.shade-option').forEach(s => {
                    s.classList.remove('selected');
                    s.querySelector('.checkmark').classList.add('hidden');
                });
                this.classList.add('selected');
                this.querySelector('.checkmark').classList.remove('hidden');
                selectedShadeId = this.getAttribute('data-shade-id');
                selectedShadeColor = this.getAttribute('data-shade-color');
                // Update selected shade label
                document.getElementById('selected-shade-label').textContent = 'Selected Shade: ' + this.title;
                // Change product images
                changeProductImages(
                    this.getAttribute('data-img1'),
                    this.getAttribute('data-img2'),
                    this.getAttribute('data-img3'),
                    this.getAttribute('data-img4'),
                    selectedShadeId,
                    selectedShadeColor
                );
            });
        });
    });
    let selectedShadeId = null; // Default shade selection
    let selectedShadeColor = null;

    function changeProductImages(img1, img2, img3, img4, shadeProductId, shadeColor) {
        const images = [
            document.getElementById("product-img-1"),
            document.getElementById("product-img-2"),
            document.getElementById("product-img-3"),
            document.getElementById("product-img-4")
        ];

        const newImages = [img1, img2, img3, img4];

        images.forEach((img, index) => {
            img.style.opacity = 0; // Start fade-out
            setTimeout(() => {
                img.src = "../admin/components/uploads/" + newImages[index]; // Change the image
                img.style.opacity = 1; // Fade-in effect
            }, 300); // Delay to match animation
        });

        // Store selected shade product ID
        selectedShadeId = shadeProductId;
        selectedShadeColor = shadeColor;

        // Highlight selected shade
        document.querySelectorAll('.shade-option').forEach(shade => {
            shade.classList.remove('border-black', 'border-2');
            shade.classList.add('border-gray-300');
        });

        event.target.classList.remove('border-gray-300');
        event.target.classList.add('border-black', 'border-2');
    }
</script>

</html>