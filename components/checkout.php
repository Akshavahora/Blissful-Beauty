<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function debug_log($msg)
{
    file_put_contents(__DIR__ . '/checkout_debug.log', $msg . PHP_EOL, FILE_APPEND);
}

session_start();

if (!isset($_SESSION['Id'])) {
    echo "<script>alert('User Not Logged In. Please Login'); window.location.href = 'login.php';</script>";
    exit;
}

$user_Id = $_SESSION['Id'];
$cart = [];

if (isset($_POST['cart_data'])) {
    $cart_data = $_POST['cart_data'];
    debug_log('Cart Data JSON: ' . $cart_data);
    $cart = json_decode($cart_data, true);
}

$total_price = 0;
if (is_array($cart)) {
    foreach ($cart as $item) {
        if (isset($item['price']) && isset($item['quantity'])) {
            $total_price += floatval($item['price']) * intval($item['quantity']);
        }
    }
}
debug_log("Total Price: $total_price");

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['place_order'])) {
    include '../dbconnection/connection.php';
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $Full_Name = $_POST['Full_Name'];
    $Email = $_POST['Email'];
    $Phone = $_POST['Phone'];
    $Address_type = $_POST['Address_type'];
    $Shipping_Address = $_POST['Shipping_Address'];
    $Zip_Code = $_POST['Zip_Code'];
    $City = $_POST['City'];
    $Payment_Method = $_POST['Payment_Method'];

    $address_query = "INSERT INTO address (user_id, Full_Name, Email, Phone, Address_type, Shipping_Address, City, Zip_Code)
        VALUES ('$user_Id', '$Full_Name', '$Email', '$Phone', '$Address_type', '$Shipping_Address', '$City', '$Zip_Code')";

    if ($conn->query($address_query)) {
        $address_id = $conn->insert_id;
        debug_log("Address inserted ID: $address_id");
    } else {
        debug_log("Address insert error: " . $conn->error);
        die("Error inserting address: " . $conn->error);
    }

    $Payment_Id = uniqid('PAY_');
    $Created_Date = date('Y-m-d H:i:s');

    $payment_query = "INSERT INTO payment (Payment_Id, Total_Price, Status, Created_Date)
        VALUES ('$Payment_Id', '$total_price', 'Pending', '$Created_Date')";

    if ($conn->query($payment_query)) {
        debug_log("Payment inserted with ID: $Payment_Id");
    } else {
        debug_log("Payment insert error: " . $conn->error);
        die("Error inserting payment: " . $conn->error);
    }

    $order_query = "INSERT INTO `order` (User_Id, Address_Id, Payment_Id, Total_Price, Status)
        VALUES ('$user_Id', '$address_id', '$Payment_Id', '$total_price', 'Pending')";

    if ($conn->query($order_query)) {
        $order_id = $conn->insert_id;
        debug_log("Order created with ID: $order_id");

        foreach ($cart as $item) {
            if (isset($item['Product_Id']) && isset($item['price']) && isset($item['quantity'])) {
                $product_id = $item['Product_Id'];
                $price = floatval($item['price']);
                $quantity = intval($item['quantity']);

                $order_item_query = "INSERT INTO order_item (Order_Id, Product_Id, Price, Qty)
                    VALUES ('$order_id', '$product_id', '$price', '$quantity')";

                if (!$conn->query($order_item_query)) {
                    debug_log("Order item insert error: " . $conn->error);
                    die("Error inserting order item: " . $conn->error);
                }
            }
        }

        echo "<script>
            localStorage.removeItem('cart');
            alert('Order Placed Successfully');
            window.location.href = 'shop.php'; // Redirect to success page
        </script>";
    } else {
        debug_log("Order insert error: " . $conn->error);
        die("Error inserting order: " . $conn->error);
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <script src="https://cdn.tailwindcss.com/3.4.1"></script>
    <style>
        body {
            background: linear-gradient(120deg, #f0fdfa 0%, #e0f2f1 100%);
            min-height: 100vh;
        }

        .step-indicator .w-8.h-8 {
            font-size: 1.2rem;
            font-weight: bold;
            border: 2px solid #14b8a6;
        }

        .step-indicator.active .w-8.h-8 {
            background: #14b8a6 !important;
            border-color: #14b8a6;
        }

        .step-indicator .w-8.h-8.bg-green-500 {
            background: #22c55e !important;
            border-color: #22c55e;
        }

        .checkout-card {
            background: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px 0 rgba(20, 184, 166, 0.10);
            border: 2px solid #e0e7ef;
        }

        .order-summary-card {
            background: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px 0 rgba(20, 184, 166, 0.10);
            border: 2px solid #14b8a6;
        }

        .checkout-input {
            font-size: 1.1rem;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            border: 1.5px solid #e5e7eb;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .checkout-input:focus {
            border-color: #14b8a6;
            box-shadow: 0 0 0 2px #99f6e4;
            outline: none;
        }

        .checkout-label {
            font-weight: 600;
            color: #0f172a;
        }

        .checkout-btn {
            background: #14b8a6;
            color: #fff;
            font-weight: bold;
            border-radius: 0.75rem;
            padding: 0.75rem 2rem;
            font-size: 1.1rem;
            transition: background 0.2s, transform 0.2s;
            box-shadow: 0 2px 8px rgba(20, 184, 166, 0.10);
        }

        .checkout-btn:hover {
            background: #0f766e;
            transform: scale(1.03);
        }

        .modal-icon {
            font-size: 3rem;
        }
    </style>
</head>

<body>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            if (cart.length === 0) {
                alert('Your cart is empty! Redirecting to shopping page.');
                window.location.href = 'shop.php';
            }
        });
    </script>

    <div class="container mx-auto py-12 flex flex-col items-center min-h-screen">
        <div class="flex flex-col md:flex-row gap-12 w-full max-w-6xl">
            <div class="w-full md:w-2/3">
                <form id="checkoutForm" class="checkout-card p-10" method="POST">
                    <input type="hidden" name="cart_data" id="cartData">
                    <div class="flex justify-between mb-10">
                        <div class="text-center step-indicator active" data-step="1">
                            <div class="w-8 h-8 bg-teal-400 text-white rounded-full flex items-center justify-center mx-auto">1</div>
                            <span class="text-sm mt-1 font-bold text-teal-700">Shipping</span>
                        </div>
                        <div class="text-center step-indicator" data-step="2">
                            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center mx-auto">2</div>
                            <span class="text-sm mt-1 font-bold text-teal-700">Payment</span>
                        </div>
                        <div class="text-center step-indicator" data-step="3">
                            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center mx-auto">3</div>
                            <span class="text-sm mt-1 font-bold text-teal-700">Review</span>
                        </div>
                    </div>

                    <div class="checkout-step active" data-step="1">
                        <h2 class="text-2xl font-bold mb-6 text-teal-700">Shipping Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="checkout-label block mb-2">Full Name</label>
                                <input type="text" name="Full_Name" required class="checkout-input w-full">
                            </div>
                            <div>
                                <label class="checkout-label block mb-2">Email</label>
                                <input type="email" name="Email" required class="checkout-input w-full">
                            </div>
                            <div>
                                <label class="checkout-label block mb-2">Phone</label>
                                <input type="tel" name="Phone" required class="checkout-input w-full">
                            </div>
                            <div>
                                <label class="checkout-label block mb-2">Address Type</label>
                                <input type="text" name="Address_type" required class="checkout-input w-full">
                            </div>
                            <div class="md:col-span-2">
                                <label class="checkout-label block mb-2">Shipping Address</label>
                                <input type="text" name="Shipping_Address" required class="checkout-input w-full">
                            </div>
                            <div>
                                <label class="checkout-label block mb-2">City</label>
                                <input type="text" name="City" required class="checkout-input w-full">
                            </div>
                            <div>
                                <label class="checkout-label block mb-2">ZIP Code</label>
                                <input type="text" name="Zip_Code" required class="checkout-input w-full">
                            </div>
                            <div class="md:col-span-2">
                                <label class="checkout-label block mb-2">Payment Method</label>
                                <select name="Payment_Method" required class="checkout-input w-full" onchange="updatePaymentForm()">
                                    <option value="" disabled selected>Select Payment Method</option>
                                    <option value="cash_on_delivery">Cash on Delivery</option>
                                    <option value="credit_card">Credit Card</option>
                                    <option value="debit_card">Debit Card</option>
                                </select>
                            </div>
                        </div>
                        <button type="button" onclick="nextStep(2)" class="checkout-btn mt-8 w-full flex items-center justify-center gap-2"><i class="fas fa-arrow-right"></i>Continue to Payment</button>
                    </div>

                    <div class="checkout-step hidden" data-step="2">
                        <h2 class="text-2xl font-bold mb-6 text-teal-700">Payment Information</h2>
                        <div id="payment-form" class="space-y-6">
                            <!-- Payment form will be dynamically updated here -->
                        </div>
                        <div class="flex gap-4 mt-8">
                            <button type="button" onclick="prevStep()" class="checkout-btn w-1/2 bg-gray-200 text-gray-700 hover:bg-gray-300"><i class="fas fa-arrow-left"></i>Back</button>
                            <button type="button" onclick="nextStep(3)" class="checkout-btn w-1/2 flex items-center justify-center gap-2"><i class="fas fa-arrow-right"></i>Review Order</button>
                        </div>
                    </div>

                    <div class="checkout-step hidden" data-step="3">
                        <h2 class="text-2xl font-bold mb-6 text-teal-700">Review Your Order</h2>
                        <div class="mb-8">
                            <h3 class="font-semibold mb-2">Shipping Details:</h3>
                            <p id="review-shipping" class="text-gray-700"></p>
                        </div>
                        <div class="mb-8">
                            <h3 class="font-semibold mb-2">Payment Details:</h3>
                            <p id="review-payment" class="text-gray-700"></p>
                        </div>
                        <div class="flex gap-4 mt-8">
                            <button type="button" onclick="prevStep()" class="checkout-btn w-1/2 bg-gray-200 text-gray-700 hover:bg-gray-300"><i class="fas fa-arrow-left"></i>Back</button>
                            <button type="submit" name="place_order" class="checkout-btn w-1/2 flex items-center justify-center gap-2 bg-teal-500 hover:bg-teal-600"><i class="fas fa-check"></i>Place Order</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="w-full md:w-1/3">
                <div class="order-summary-card p-8 sticky top-8">
                    <h2 class="text-2xl font-bold mb-6 text-teal-700">Order Summary</h2>
                    <div id="order-summary" class="space-y-6 mb-8">
                        <!-- Order summary will be dynamically updated here -->
                    </div>
                    <div class="space-y-2 mb-8">
                        <div class="flex justify-between font-bold text-lg">
                            <span>Total</span>
                            <span id="total">₹0.00</span>
                        </div>
                    </div>
                    <div class="flex justify-center gap-4 text-gray-400 text-2xl">
                        <i class="fas fa-lock"></i>
                        <i class="fab fa-cc-visa"></i>
                        <i class="fab fa-cc-mastercard"></i>
                        <i class="fab fa-cc-amex"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="successModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-10 rounded-2xl text-center max-w-md shadow-2xl">
            <i class="fas fa-check-circle text-teal-500 modal-icon mb-4"></i>
            <h2 class="text-3xl font-bold mb-2 text-teal-600">Order Successful!</h2>
            <p class="text-gray-700 mb-4">Thank you for your purchase.</p>
            <button class="checkout-btn bg-blue-600 hover:bg-blue-700"><a href="./shop.php">Continue Shopping <i class="fa fa-arrow-right ml-2"></i></a></button>
        </div>
    </div>

    <div id="errorModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-10 rounded-2xl text-center max-w-md shadow-2xl">
            <i class="fas fa-exclamation-circle text-red-500 modal-icon mb-4"></i>
            <h2 class="text-3xl font-bold mb-2 text-red-600">Error</h2>
            <p id="errorMessage" class="text-gray-700 mb-4">Please fill in all required fields.</p>
            <button onclick="closeErrorModal()" class="checkout-btn bg-red-600 hover:bg-red-700">OK</button>
        </div>
    </div>

    <script>
        let currentStep = 1;

        function updateProgressIndicator(step) {
            document.querySelectorAll('.step-indicator').forEach(indicator => {
                const indicatorStep = parseInt(indicator.dataset.step);
                const circle = indicator.querySelector('div');

                if (indicatorStep === step) {
                    circle.classList.add('bg-teal-400');
                    circle.classList.remove('bg-gray-200');
                } else if (indicatorStep < step) {
                    circle.classList.add('bg-teal-500');
                    circle.classList.remove('bg-gray-200', 'bg-teal-400');
                } else {
                    circle.classList.add('bg-gray-200');
                    circle.classList.remove('bg-teal-400', 'bg-teal-500');
                }
            });
        }

        function showStep(step) {
            document.querySelectorAll('.checkout-step').forEach(stepElement => {
                stepElement.classList.toggle('hidden', parseInt(stepElement.dataset.step) !== step);
                stepElement.classList.toggle('active', parseInt(stepElement.dataset.step) === step);
            });
            updateProgressIndicator(step);
        }

        function nextStep(next) {
            if (validateStep(currentStep)) {
                const paymentMethod = document.querySelector('[name="Payment_Method"]').value;
                if (paymentMethod === 'cash_on_delivery') {
                    currentStep = 3;
                } else {
                    currentStep = next;
                }
                showStep(currentStep);

                if (currentStep === 3) {
                    document.getElementById('review-shipping').textContent =
                        `Name: ${document.querySelector('[name="Full_Name"]').value}\n` +
                        `Address: ${document.querySelector('[name="Shipping_Address"]').value}\n` +
                        `City: ${document.querySelector('[name="City"]').value}\n` +
                        `ZIP Code: ${document.querySelector('[name="Zip_Code"]').value}`;

                    document.getElementById('review-payment').textContent =
                        paymentMethod === 'cash_on_delivery' ? 'Cash on Delivery' : `Card ending in ${document.querySelector('[name="Card_Number"]').value.slice(-4)}`;
                }
            } else {
                showErrorModal('Please fill in all required fields.');
            }
        }

        function prevStep() {
            currentStep = Math.max(1, currentStep - 1);
            showStep(currentStep);
        }

        function validateStep(step) {
            let isValid = true;
            const currentStepElement = document.querySelector(`[data-step="${step}"]`);

            currentStepElement.querySelectorAll('input[required], select[required]').forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('border-red-500');
                    isValid = false;
                } else {
                    input.classList.remove('border-red-500');
                }
            });

            return isValid;
        }

        function showErrorModal(message) {
            document.getElementById('errorMessage').textContent = message;
            document.getElementById('errorModal').classList.remove('hidden');
        }

        function closeErrorModal() {
            document.getElementById('errorModal').classList.add('hidden');
        }

        function loadCart() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const orderSummary = document.getElementById('order-summary');
            const cartDataInput = document.getElementById('cartData');
            let grandTotal = 0;

            if (cart.length === 0) {
                orderSummary.innerHTML = '<p>Your cart is empty.</p>';
                document.getElementById('total').textContent = '₹0.00';
                return;
            }

            // Store cart data in hidden input
            cartDataInput.value = JSON.stringify(cart);

            orderSummary.innerHTML = '';
            cart.forEach((product, index) => {
                const total = (product.price * product.quantity).toFixed(2);
                grandTotal += parseFloat(total);

                orderSummary.innerHTML +=
                    `<div class="flex items-center">
                    <img src="${product.images[0]}" alt="Product" class="w-16 h-16 rounded-md object-cover">
                    <div class="ml-3">
                        <h3 class="font-medium">${product.name}</h3>
                        <input type="hidden" name="cart[${index}][Product_Id]" value="${product.id}">
                        <input type="hidden" name="cart[${index}][name]" value="${product.name}">
                        <input type="hidden" name="cart[${index}][price]" value="${product.price}">
                        <input type="hidden" name="cart[${index}][quantity]" value="${product.quantity}">
                        <input type="hidden" name="cart[${index}][images][]" value="${product.images[0]}">
                        <div class="shade-option cursor-pointer border-2 border-gray-300 hover:border-black rounded-full w-12 h-12 mr-2"
       style="background-color: ${product.shade_color}">
  </div>
                        <p class="text-sm text-gray-600">₹${product.price} × ${product.quantity}</p>
                    </div>
                    <div class="ml-auto text-right">
                        <p class="font-semibold">₹${total}</p>
                    </div>
                </div>`;
            });

            document.getElementById('total').textContent = `₹${grandTotal.toFixed(2)}`;
        }

        function updatePaymentForm() {
            const paymentMethod = document.querySelector('[name="Payment_Method"]').value;
            const paymentForm = document.getElementById('payment-form');

            if (paymentMethod === 'cash_on_delivery') {
                paymentForm.innerHTML = '<p>You have selected Cash on Delivery.</p>';
            } else {
                paymentForm.innerHTML = `
                <div>
                    <label class="block text-sm font-medium mb-2">Name on Card</label>
                    <input type="text" name="Card_Name" required class="w-full p-2 border rounded-md focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Card Number</label>
                    <input type="text" name="Card_Number" required class="w-full p-2 border rounded-md focus:ring-2 focus:ring-teal-500">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Expiration Date</label>
                        <input type="text" name="Expiration_Date" required class="w-full p-2 border rounded-md focus:ring-2 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">CVV</label>
                        <input type="text" name="Cvv" required class="w-full p-2 border rounded-md focus:ring-2 focus:ring-teal-500">
                    </div>
                </div>
            `;
            }
        }

        document.addEventListener('DOMContentLoaded', loadCart);
    </script>

    <!-- Back to Top Button -->
    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'});" id="backToTopBtn" class="fixed bottom-8 right-8 z-50 bg-teal-500 text-white p-4 rounded-full shadow-lg hover:bg-teal-600 transition-all duration-200 hidden" title="Back to Top"><i class="fas fa-arrow-up"></i></button>
    <script>
        window.addEventListener('scroll', function() {
            const btn = document.getElementById('backToTopBtn');
            if (window.scrollY > 300) {
                btn.classList.remove('hidden');
            } else {
                btn.classList.add('hidden');
            }
        });
    </script>
</body>

</html>