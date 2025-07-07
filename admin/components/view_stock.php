<?php
require_once('../../dbconnection/connection.php');


// Fetch data from the database
$sel = "SELECT p.P_Id, p.P_Name, sum(s.quantity) FROM stock s inner join product p on s.product_id = p.P_Id  group by s.product_id";
$res = mysqli_query($conn, $sel);

// Start output buffering
ob_start();
?>
<div class="mt-12 mx-4 sm:mx-12">
    <div class="mx-auto p-6 rounded-lg shadow-md overflow-x-auto">
        <h2 class="text-2xl text-center font-bold mb-4">Stock Table</h2>

        <div class="w-full border border-gray-300 rounded-lg overflow-hidden">
            <div class="grid grid-cols-6 md:grid-cols-3 bg-gray-200 font-semibold">
                <div class="px-4 py-2">Id</div>
                <div class="px-4 py-2">Name</div>
                <div class="px-4 py-2">Product</div>
              
            </div>

            <div id="table-body" class="divide-y divide-gray-300">
                <?php while ($row = mysqli_fetch_row($res)) : ?>
                    <div class="grid grid-cols-6 md:grid-cols-3 text-sm md:text-base">
                        <div class="px-2 md:px-4 py-2"><?php echo $row[0]; ?></div>
                        <div class="px-2 md:px-4 py-2 truncate"><?php echo $row[1]; ?></div>
                        <div class="px-2 md:px-4 py-2 truncate"><?php echo $row[2]; ?></div>
                       
                        
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Editing -->


<?php
$content = ob_get_clean();
include("./aside.php");
?>

<style>
    @media (max-width: 768px) {
        .grid-cols-6 {
            grid-template-columns: repeat(3, 1fr);
        }
        .grid-cols-8 {
            grid-template-columns: repeat(4, 1fr);
        }
        .truncate {
            white-space: normal;
        }
    }

    @media (max-width: 480px) {
        .grid-cols-6, .grid-cols-8 {
            grid-template-columns: 1fr;
        }
    }
</style>


