<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- tailwind css link  -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h3 class="text-2xl font-bold mb-4 text-center">Forgot Password</h3>
        <div class="mb-6">
            <h4 class="text-xl text-center">Welcome back to Cosmetic Admin Panel!</h4>
        </div>
        <div class="mb-4">
            <p class="text-red-500 text-center"><?php if($msg){ echo $msg; } ?></p>
        </div>
        <form class="space-y-4" method="post" action="">
            <input type="email" name="email" class="w-full p-2 border rounded" placeholder="Email" required>
            <input type="text" name="contactno" class="w-full p-2 border rounded" placeholder="Mobile Number" required maxlength="10" pattern="[0-9]+">
            <button type="submit" name="submit" class="w-full p-2 bg-blue-500 text-white rounded">Reset</button>
            <div class="text-center">
                <a href="index.php" class="text-blue-500 hover:underline">Already have an account</a>
            </div>
        </form>
    </div>

    <!-- JavaScript for menu toggle functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuLeft = document.getElementById('cbp-spmenu-s1');
            const showLeftPush = document.getElementById('showLeftPush');
            const body = document.body;

            showLeftPush.onclick = function() {
                menuLeft.classList.toggle('active');
                body.classList.toggle('cbp-spmenu-push-toright');
                menuLeft.classList.toggle('cbp-spmenu-open');
                disableOther('showLeftPush');
            };

            function disableOther(button) {
                if (button !== 'showLeftPush') {
                    showLeftPush.classList.toggle('disabled');
                }
            }
        });
    </script>
</body>
</html>