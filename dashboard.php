<?php require_once 'includes/header.php'; ?>

<?php 

$sql = "SELECT * FROM product WHERE status = 1";
$query = $connect->query($sql);
$countProduct = $query->num_rows;

$orderSql = "SELECT * FROM orders WHERE order_status = 1";
$orderQuery = $connect->query($orderSql);
$countOrder = $orderQuery->num_rows;

$totalRevenue = "";
while ($orderResult = $orderQuery->fetch_assoc()) {
	$totalRevenue += $orderResult['paid'];
}

$lowStockSql = "SELECT * FROM product WHERE quantity <= 3 AND status = 1";
$lowStockQuery = $connect->query($lowStockSql);
$countLowStock = $lowStockQuery->num_rows;

$userwisesql = "SELECT users.username , SUM(orders.grand_total) as totalorder FROM orders INNER JOIN users ON orders.user_id = users.user_id WHERE orders.order_status = 1 GROUP BY orders.user_id";
$userwiseQuery = $connect->query($userwisesql);
$userwieseOrder = $userwiseQuery->num_rows;

$connect->close();

?>

<!-- Page Header -->
<div style="background: white; padding: 32px; border-radius: 12px; margin-bottom: 24px; border: 1px solid var(--gray-200); box-shadow: var(--shadow-sm);">
    <div class="row">
        <div class="col-md-8">
            <h1 style="margin: 0; font-size: 28px; font-weight: 600; color: var(--gray-900);">
                <i class="fa fa-dashboard" style="color: var(--primary-600);"></i> Dashboard Overview
            </h1>
            <p style="margin: 8px 0 0 0; color: var(--gray-600); font-size: 16px;">
                Welcome back! Here's what's happening with your inventory today.
            </p>
        </div>
        <div class="col-md-4 text-right">
            <div style="color: var(--gray-500); font-size: 14px;">
                <i class="fa fa-calendar"></i> <?php echo date('l, F d, Y'); ?>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row">
    <?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card" style="border-left: 4px solid var(--success-500);">
            <div class="stat-icon" style="color: var(--success-500);">
                <i class="fa fa-cube"></i>
            </div>
            <div class="stat-number" style="color: var(--success-600);"><?php echo $countProduct; ?></div>
            <div class="stat-label">Total Products</div>
            <div style="margin-top: 16px;">
                <a href="product.php" class="btn btn-success btn-sm">
                    <i class="fa fa-eye"></i> View Products
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="stat-card" style="border-left: 4px solid var(--danger-500);">
            <div class="stat-icon" style="color: var(--danger-500);">
                <i class="fa fa-exclamation-triangle"></i>
            </div>
            <div class="stat-number" style="color: var(--danger-600);"><?php echo $countLowStock; ?></div>
            <div class="stat-label">Low Stock Items</div>
            <div style="margin-top: 16px;">
                <a href="product.php" class="btn btn-danger btn-sm">
                    <i class="fa fa-warning"></i> Check Stock
                </a>
            </div>
        </div>
    </div>
    <?php } ?>
    
    <div class="col-md-3 col-sm-6">
        <div class="stat-card" style="border-left: 4px solid var(--primary-500);">
            <div class="stat-icon" style="color: var(--primary-500);">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="stat-number" style="color: var(--primary-600);"><?php echo $countOrder; ?></div>
            <div class="stat-label">Total Orders</div>
            <div style="margin-top: 16px;">
                <a href="orders.php?o=manord" class="btn btn-primary btn-sm">
                    <i class="fa fa-list"></i> View Orders
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="stat-card" style="border-left: 4px solid var(--warning-500);">
            <div class="stat-icon" style="color: var(--warning-500);">
                <i class="fa fa-money"></i>
            </div>
            <div class="stat-number" style="color: var(--warning-600);">
                NPR <?php echo $totalRevenue ? number_format($totalRevenue) : '0'; ?>
            </div>
            <div class="stat-label">Total Revenue</div>
            <div style="margin-top: 16px;">
                <a href="report.php" class="btn btn-warning btn-sm">
                    <i class="fa fa-bar-chart"></i> View Reports
                </a>
            </div>
        </div>
    </div>
</div>


<!-- Recent Activity Section -->
<div style="margin-top: 32px;">
    <div class="row">
        <div class="col-md-12">
            <div style="background: white; padding: 24px; border-radius: 12px; border: 1px solid var(--gray-200); box-shadow: var(--shadow-sm);">
                <h3 style="margin: 0 0 16px 0; font-size: 20px; font-weight: 600; color: var(--gray-900);">
                    <i class="fa fa-clock-o" style="color: var(--primary-600);"></i> Quick Actions
                </h3>
                <div class="row">
                    <?php if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
                    <div class="col-md-3 col-sm-6" style="margin-bottom: 16px;">
                        <a href="product.php" class="btn btn-default btn-block" style="padding: 16px; text-align: left;">
                            <i class="fa fa-plus" style="color: var(--success-600); margin-right: 8px;"></i>
                            <strong>Add Product</strong><br>
                            <small style="color: var(--gray-500);">Manage inventory</small>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6" style="margin-bottom: 16px;">
                        <a href="brand.php" class="btn btn-default btn-block" style="padding: 16px; text-align: left;">
                            <i class="fa fa-tags" style="color: var(--primary-600); margin-right: 8px;"></i>
                            <strong>Manage Brands</strong><br>
                            <small style="color: var(--gray-500);">Brand settings</small>
                        </a>
                    </div>
                    <?php } ?>
                    <div class="col-md-3 col-sm-6" style="margin-bottom: 16px;">
                        <a href="orders.php?o=add" class="btn btn-default btn-block" style="padding: 16px; text-align: left;">
                            <i class="fa fa-shopping-cart" style="color: var(--warning-600); margin-right: 8px;"></i>
                            <strong>New Order</strong><br>
                            <small style="color: var(--gray-500);">Create order</small>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6" style="margin-bottom: 16px;">
                        <a href="report.php" class="btn btn-default btn-block" style="padding: 16px; text-align: left;">
                            <i class="fa fa-bar-chart" style="color: var(--danger-600); margin-right: 8px;"></i>
                            <strong>View Reports</strong><br>
                            <small style="color: var(--gray-500);">Analytics</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
	<?php  if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
	<div style="margin-top: 32px;">
		<div class="row">
			<div class="col-md-12">
				<div style="background: white; padding: 24px; border-radius: 12px; border: 1px solid var(--gray-200); box-shadow: var(--shadow-sm);">
					<h3 style="margin: 0 0 20px 0; font-size: 20px; font-weight: 600; color: var(--gray-900);">
						<i class="fa fa-users" style="color: var(--primary-600);"></i> User Performance Overview
					</h3>
					<div class="table-responsive">
						<table class="table" id="userPerformanceTable">
							<thead>
								<tr>
									<th style="width:60%;">Username</th>
									<th style="width:40%;">Total Orders (NPR)</th>
								</tr>
							</thead>
							<tbody>
								<?php while ($orderResult = $userwiseQuery->fetch_assoc()) { ?>
									<tr>
										<td>
											<div style="display: flex; align-items: center;">
												<i class="fa fa-user" style="color: var(--gray-400); margin-right: 8px;"></i>
												<strong><?php echo $orderResult['username']?></strong>
											</div>
										</td>
										<td>
											<span style="color: var(--success-600); font-weight: 600;">
												NPR <?php echo number_format($orderResult['totalorder']); ?>
											</span>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php  } ?>
	
</div> <!--/row-->

<!-- fullCalendar 2.2.5 -->
<script src="assests/plugins/moment/moment.min.js"></script>
<script src="assests/plugins/fullcalendar/fullcalendar.min.js"></script>


<script type="text/javascript">
	$(function () {
			// top bar active
	$('#navDashboard').addClass('active');

      //Date for the calendar events (dummy data)
      var date = new Date();
      var d = date.getDate(),
      m = date.getMonth(),
      y = date.getFullYear();

      $('#calendar').fullCalendar({
        header: {
          left: '',
          center: 'title'
        },
        buttonText: {
          today: 'today',
          month: 'month'          
        }        
      });


    });
</script>

<?php require_once 'includes/footer.php'; ?>