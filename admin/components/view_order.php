<?php
require_once('../../dbconnection/connection.php');

// Fetch address and latest order for each address
$sel = "SELECT a.address_id, a.Full_Name, a.Email, a.Phone, a.Address_type, a.Shipping_Address, a.City, a.Zip_Code, o.Id
        FROM address a
        LEFT JOIN `order` o ON a.address_id = o.Address_Id
        AND o.Id = (
            SELECT oo.Id FROM `order` oo WHERE oo.Address_Id = a.address_id ORDER BY oo.Created_Date DESC LIMIT 1
        )
        ORDER BY a.address_id DESC";
$res = mysqli_query($conn, $sel);

// Check if the query was successful
if (!$res) {
   die("Query failed: " . mysqli_error($conn));
}

// Start output buffering
ob_start();
?>
<div class="mt-12 mx-2 sm:mx-8">
   <div class="mx-auto glass p-4 sm:p-8 rounded-2xl shadow-2xl fade-in w-full max-w-5xl">
      <h2 class="text-3xl font-extrabold text-center text-teal-700 mb-2 tracking-wide flex items-center justify-center gap-2">
         <i class="fas fa-shopping-bag"></i> Users Orders
      </h2>
      <hr class="border-t-2 border-teal-400 w-24 mx-auto mb-6">
      <!-- Desktop Table -->
      <div class="hidden md:block w-full">
         <table class="w-full">
            <thead class="bg-teal-100 font-semibold text-teal-800">
               <tr>
                  <th class="px-2 py-2 md:px-4 md:py-3 text-left text-xs md:text-base">Id</th>
                  <th class="px-2 py-2 md:px-4 md:py-3 text-left text-xs md:text-base">Full Name</th>
                  <th class="px-2 py-2 md:px-4 md:py-3 text-left text-xs md:text-base">Email</th>
                  <th class="px-2 py-2 md:px-4 md:py-3 text-left text-xs md:text-base">Phone</th>
                  <th class="px-2 py-2 md:px-4 md:py-3 text-left text-xs md:text-base">Address</th>
                  <th class="px-2 py-2 md:px-4 md:py-3 text-left text-xs md:text-base">City</th>
                  <th class="px-2 py-2 md:px-4 md:py-3 text-center text-xs md:text-base">Action</th>
               </tr>
            </thead>
            <tbody id="table-body" class="divide-y divide-teal-100">
               <?php mysqli_data_seek($res, 0);
               while ($row = mysqli_fetch_assoc($res)) : ?>
                  <tr class="bg-white/60 hover:bg-teal-50 transition-all duration-150">
                     <td class="px-2 py-2 md:px-4 md:py-3 truncate-text font-medium text-gray-700 text-xs md:text-base"><?php echo $row['address_id']; ?></td>
                     <td class="px-2 py-2 md:px-4 md:py-3 truncate-text font-semibold text-gray-800 text-xs md:text-base"><?php echo $row['Full_Name']; ?></td>
                     <td class="px-2 py-2 md:px-4 md:py-3 truncate-text text-blue-600 hover:text-blue-800 text-xs md:text-base"><?php echo $row['Email']; ?></td>
                     <td class="px-2 py-2 md:px-4 md:py-3 truncate-text text-gray-600 text-xs md:text-base"><?php echo $row['Phone']; ?></td>
                     <td class="px-2 py-2 md:px-4 md:py-3 truncate-text text-gray-700 text-xs md:text-base"><?php echo $row['Shipping_Address']; ?></td>
                     <td class="px-2 py-2 md:px-4 md:py-3 truncate-text font-medium text-gray-800 text-xs md:text-base"><?php echo $row['City']; ?></td>
                     <td class="px-2 py-2 md:px-4 md:py-3 text-center text-xs md:text-base">
                        <?php if (!empty($row['Id'])): ?>
                           <a href="manage_order.php?order_id=<?php echo $row['Id']; ?>"
                              class="view-btn inline-flex items-center gap-2 px-3 py-1 md:px-4 md:py-2 bg-teal-600 text-white rounded-lg font-semibold shadow hover:bg-teal-700 transition-all duration-150 hover:scale-105 text-xs md:text-base">
                              <i class="fas fa-eye"></i> View Order
                           </a>
                        <?php else: ?>
                           <span class="inline-flex items-center gap-2 px-3 py-1 md:px-4 md:py-2 bg-gray-300 text-gray-500 rounded-lg font-semibold shadow cursor-not-allowed text-xs md:text-base">
                              <i class="fas fa-eye-slash"></i> No Order
                           </span>
                        <?php endif; ?>
                     </td>
                  </tr>
               <?php endwhile; ?>
            </tbody>
         </table>
      </div>
      <!-- Mobile Cards -->
      <div class="block md:hidden space-y-4">
         <?php mysqli_data_seek($res, 0);
         while ($row = mysqli_fetch_assoc($res)) : ?>
            <div class="bg-white/80 rounded-xl shadow p-4 flex flex-col gap-2">
               <div class="flex justify-between"><span class="font-bold text-teal-700">Id:</span> <span><?php echo $row['address_id']; ?></span></div>
               <div class="flex justify-between"><span class="font-bold text-teal-700">Full Name:</span> <span><?php echo $row['Full_Name']; ?></span></div>
               <div class="flex justify-between"><span class="font-bold text-teal-700">Email:</span> <span class="text-blue-600"><?php echo $row['Email']; ?></span></div>
               <div class="flex justify-between"><span class="font-bold text-teal-700">Phone:</span> <span><?php echo $row['Phone']; ?></span></div>
               <div class="flex justify-between"><span class="font-bold text-teal-700">Address:</span> <span><?php echo $row['Shipping_Address']; ?></span></div>
               <div class="flex justify-between"><span class="font-bold text-teal-700">City:</span> <span><?php echo $row['City']; ?></span></div>
               <div class="flex justify-end mt-2">
                  <?php if (!empty($row['Id'])): ?>
                     <a href="manage_order.php?order_id=<?php echo $row['Id']; ?>"
                        class="view-btn inline-flex items-center gap-2 px-3 py-1 bg-teal-600 text-white rounded-lg font-semibold shadow hover:bg-teal-700 transition-all duration-150 hover:scale-105 text-xs">
                        <i class="fas fa-eye"></i> View Order
                     </a>
                  <?php else: ?>
                     <span class="inline-flex items-center gap-2 px-3 py-1 bg-gray-300 text-gray-500 rounded-lg font-semibold shadow cursor-not-allowed text-xs">
                        <i class="fas fa-eye-slash"></i> No Order
                     </span>
                  <?php endif; ?>
               </div>
            </div>
         <?php endwhile; ?>
      </div>
   </div>
</div>

<?php
$content = ob_get_clean();
include("./aside.php");
?>

<style>
   .glass {
      background: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border: 1.5px solid rgba(20, 184, 166, 0.15);
      box-shadow: 0 8px 32px 0 rgba(20, 184, 166, 0.10);
   }

   .fade-in {
      animation: fade-in 1s;
   }

   @keyframes fade-in {
      from {
         opacity: 0;
         transform: translateY(30px);
      }

      to {
         opacity: 1;
         transform: translateY(0);
      }
   }

   .view-btn {
      border: none;
      outline: none;
      cursor: pointer;
   }

   .view-btn:active {
      transform: scale(0.97);
   }

   .truncate-text {
      max-width: 150px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
   }

   @media (max-width: 768px) {
      .truncate-text {
         max-width: 100px;
      }

      table {
         font-size: 0.875rem;
      }

      .px-4 {
         padding-left: 0.5rem;
         padding-right: 0.5rem;
      }

      .py-3 {
         padding-top: 0.5rem;
         padding-bottom: 0.5rem;
      }
   }

   @media (max-width: 640px) {
      .truncate-text {
         max-width: 80px;
      }

      .view-btn {
         padding: 0.5rem 0.75rem;
         font-size: 0.75rem;
      }
   }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>