<?php
	
	//Start session
global $con;
session_start();

    //Set page title
    $pageTitle = 'Dashboard';

    //PHP INCLUDES
    include 'connect.php';
    include 'Includes/functions/functions.php'; 
    include 'Includes/templates/header.php';

    //TEST IF THE SESSION HAS BEEN CREATED BEFORE

    if(isset($_SESSION['username_restaurant_qRewacvAqzA']) && isset($_SESSION['password_restaurant_qRewacvAqzA']))
    {
    	include 'Includes/templates/navbar.php';

    	?>

            <script type="text/javascript">

                var vertical_menu = document.getElementById("vertical-menu");


                var current = vertical_menu.getElementsByClassName("active_link");

                if(current.length > 0)
                {
                    current[0].classList.remove("active_link");   
                }
                
                vertical_menu.getElementsByClassName('dashboard_link')[0].className += " active_link";

            </script>

            <!-- TOP 4 CARDS -->
            
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <div class="panel panel-green ">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-sm-3">
                                    <i class="fa fa-users fa-4x"></i>
                                </div>
                                <div class="col-sm-9 text-right">
                                    <div class="huge"><span><?php echo countItems("client_id","clients")?></span></div>
                                    <div>Tổng khách hàng</div>
                                </div>
                            </div>
                        </div>
                        <a href="clients.php">
                            <div class="panel-footer">
                                <span class="pull-left">Chi tiết</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-sm-3">
                                    <i class="fas fa-utensils fa-4x"></i>
                                </div>
                                <div class="col-sm-9 text-right">
                                    <div class="huge"><span><?php echo countItems("menu_id","menus")?></span></div>
                                    <div>Tổng thực đơn</div>
                                </div>
                            </div>
                        </div>
                        <a href="menus.php">
                            <div class="panel-footer">
                                <span class="pull-left">Chi tiết</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                
<!--                <div class=" col-sm-6 col-lg-3">-->
<!--                    <div class="panel panel-red">-->
<!--                        <div class="panel-heading">-->
<!--                            <div class="row">-->
<!--                                <div class="col-sm-3">-->
<!--                                    <i class="far fa-calendar-alt fa-4x"></i>-->
<!--                                </div>-->
<!--                                <div class="col-sm-9 text-right">-->
<!--                                    <div class="huge"><span>32</span></div>-->
<!--                                    <div>Tổng cuộc hẹn</div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <a href="#">-->
<!--                            <div class="panel-footer">-->
<!--                                <span class="pull-left">Chi tiết</span>-->
<!--                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>-->
<!--                                <div class="clearfix"></div>-->
<!--                            </div>-->
<!--                        </a>-->
<!--                    </div>-->
<!--                </div>-->
                <div class=" col-sm-6 col-lg-3">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-sm-3">
                                    <i class="fas fa-pizza-slice fa-4x"></i>
                                </div>
                                <div class="col-sm-9 text-right">
                                    <div class="huge"><span><?php echo countItems("order_id","placed_orders")?></span></div>
                                    <div>Tổng số món đặt</div>
                                </div>
                            </div>
                        </div>
<!--                        <a href="#">-->
<!--                            <div class="panel-footer">-->
<!--                                <span class="pull-left">Chi tiết</span>-->
<!--                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>-->
<!--                                <div class="clearfix"></div>-->
<!--                            </div>-->
<!--                        </a>-->
                    </div>
                </div>
            </div>

            <!-- START ORDERS TABS -->

            <div class="card" style = "margin: 20px 10px">

                <!-- TABS BUTTONS -->

                <div class="card-header tab" style="padding:0px;">
                    <button class="tablinks_orders active" onclick="openTab(event, 'recent_orders','tabcontent_orders','tablinks_orders')">Đặt món gần đây</button>
                    <button class="tablinks_orders" onclick="openTab(event, 'completed_orders','tabcontent_orders','tablinks_orders')">Đặt món thành công</button>
                    <button class="tablinks_orders" onclick="openTab(event, 'canceled_orders','tabcontent_orders','tablinks_orders')">Huỷ đặt món</button>
                </div>

                <!-- TABS CONTENT -->
                
                <div class="card-body">
                    <div class='responsive-table'>

                        <!-- RECENT ORDERS -->

                        <table class="table X-table tabcontent_orders" id="recent_orders" style="display:table">
                            <thead>
                                <tr>
                                    <th>
                                        Thời gian tạo
                                    </th>
                                    <th>
                                        Menu
                                    </th>
                                    <th>
                                        Tổng chi phí
                                    </th>
                                    <th>
                                        ID Khách hàng
                                    </th>
                                    <th>
                                        Quản lí
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                    $stmt = $con->prepare("SELECT * 
                                                    FROM placed_orders po , clients c
                                                    where 
                                                        po.client_id = c.client_id
                                                    and canceled = 0
                                                    and delivered = 0
                                                    order by order_time;
                                                    ");
                                    $stmt->execute();
                                    $placed_orders = $stmt->fetchAll();
                                    $count = $stmt->rowCount();
                                    
                                    
                                    if($count == 0)
                                    {

                                        echo "<tr>";
                                            echo "<td colspan='5' style='text-align:center;'>";
                                                echo "List of your recent orders will be presented here";
                                            echo "</td>";
                                        echo "</tr>";
                                    }
                                    else
                                    {

                                        foreach($placed_orders as $order)
                                        {
                                            echo "<tr>";
                                                echo "<td>";
                                                    echo $order['order_time'];
                                                echo "</td>";
                                                echo "<td>";
                                                    
                                                    $stmtMenus = $con->prepare("SELECT menu_name, quantity, menu_price
                                                            from menus m, in_order in_o
                                                            where m.menu_id = in_o.menu_id
                                                            and order_id = ?");
                                                    $stmtMenus->execute(array($order['order_id']));
                                                    $menus = $stmtMenus->fetchAll();

                                                    $total_price = 0;

                                                    foreach($menus as $menu)
                                                    {
                                                        echo "<span style = 'display:block'>".$menu['menu_name']."</span>";

                                                        $total_price += ($menu['menu_price']*$menu['quantity']);
                                                    }

                                                echo "</td>";
                                                echo "<td>";
                                                    echo $total_price."$";
                                                echo "</td>";
                                                echo "<td>";
                                                    ?>
                                                        <button class="btn btn-info btn-sm rounded-0" type="button" data-toggle="modal" data-target="#<?php echo "client_".$order['client_id']; ?>" data-placement="top">
                                                            <?php echo $order['client_id']; ?>
                                                        </button>

                                                        <!-- Client Modal -->

                                                        <div class="modal fade" id="<?php echo "client_".$order['client_id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Thông tin khách hàng</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <ul>
                                                                            <li><span style="font-weight: bold;">Họ tên: </span> <?php echo $order['client_name']; ?></li>
                                                                            <li><span style="font-weight: bold;">SDT: </span><?php echo $order['client_phone']; ?></li>
                                                                            <li><span style="font-weight: bold;">E-mail: </span><?php echo $order['client_email']; ?></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php
                                                echo "</td>";
                                                
                                                echo "<td>";
                                                    
                                                    $cancel_data = "cancel_order".$order["order_id"];
                                                    $deliver_data = "deliver_order".$order["order_id"];
                                                    ?>
                                                    <ul class="list-inline m-0">

                                                        <!-- Deliver Order BUTTON -->
                                                        
                                                        <li class="list-inline-item" data-toggle="tooltip" title="Deliver Order">
                                                            <button class="btn btn-info btn-sm rounded-0" type="button" data-toggle="modal" data-target="#<?php echo $deliver_data; ?>" data-placement="top">
                                                                <i class="fas fa-truck"></i>
                                                            </button>

                                                            <!-- DELIVER MODAL -->
                                                            <div class="modal fade" id="<?php echo $deliver_data; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $deliver_data; ?>" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Đặt giao hàng</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Đánh dấu đơn hàng là đã giao?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
                                                                            <button type="button" data-id = "<?php echo $order['order_id']; ?>" class="btn btn-info deliver_order_button">
                                                                                Vâng
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </li>

                                                        <!-- CANCEL BUTTON -->

                                                        <li class="list-inline-item" data-toggle="tooltip" title="Cancel Order">
                                                            <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="modal" data-target="#<?php echo $cancel_data; ?>" data-placement="top">
                                                                <i class="fas fa-calendar-times"></i>
                                                            </button>

                                                            <!-- CANCEL MODAL -->
                                                            <div class="modal fade" id="<?php echo $cancel_data; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $cancel_data; ?>" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Huỷ đặt món</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="form-group">
                                                                                <label>Lí do huỷ</label>
                                                                                <textarea class="form-control" id="cancellation_reason_order_<?php echo $order['order_id'] ?>" required="required"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Không</button>
                                                                            <button type="button" data-id = "<?php echo $order['order_id']; ?>" class="btn btn-danger cancel_order_button">
                                                                                Huỷ đặt
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </li>
                                                    </ul>
                                                    <?php
                                                echo "</td>";
                                            echo "</tr>";
                                        }
                                    }

                                ?>

                            </tbody>
                        </table>

                        <!-- COMPLETED ORDERS -->

                        <table class="table X-table tabcontent_orders" id="completed_orders">
                            <thead>
                                <tr>
                                    <th>
                                        Thời gian tạo
                                    </th>
                                    <th>
                                        Menu
                                    </th>
                                    <th>
                                        Khách hàng
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                    $stmt = $con->prepare("SELECT * 
                                                    FROM placed_orders po , clients c
                                                    where 
                                                        po.client_id = c.client_id
                                                        and
                                                        delivered = 1
                                                        and
                                                        canceled = 0
                                                    order by order_time;
                                                    ");
                                    $stmt->execute();
                                    $rows = $stmt->fetchAll();
                                    $count = $stmt->rowCount();
                                    
                                    

                                    if($count == 0)
                                    {

                                        echo "<tr>";
                                            echo "<td colspan='5' style='text-align:center;'>";
                                                echo "List of your completed orders will be presented here";
                                            echo "</td>";
                                        echo "</tr>";
                                    }
                                    else
                                    {

                                        foreach($rows as $row)
                                        {
                                            echo "<tr>";
                                                echo "<td>";
                                                    echo $row['order_time'];
                                                echo "</td>";
                                                echo "<td>";

                                                    $stmtMenus = $con->prepare("SELECT menu_name, quantity
                                                            from menus m, in_order in_o
                                                            where m.menu_id = in_o.menu_id
                                                            and order_id = ?");
                                                    $stmtMenus->execute(array($order['order_id']));
                                                    $menus = $stmtMenus->fetchAll();
                                                    foreach($menus as $menu)
                                                    {
                                                        echo "<span style = 'display:block'>".$menu['menu_name']."</span>";
                                                    }

                                                echo "</td>";
                                                echo "<td>";
                                                    echo $row['client_name'];
                                                echo "</td>";
                                                
                                            echo "</tr>";
                                        }
                                    }

                                ?>

                            </tbody>
                        </table>

                        <!-- CANCELED ORDERS -->

                        <table class="table X-table tabcontent_orders" id="canceled_orders">
                            <thead>
                                <tr>
                                    <th>
                                        Thời gian tạo
                                    </th>
                                    <th>
                                        Khách hàng
                                    </th>
                                    <th>
                                        Lí do huỷ
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                    $stmt = $con->prepare("SELECT * 
                                                    FROM placed_orders po , clients c
                                                    where 
                                                        po.client_id = c.client_id
                                                    and 
                                                        canceled = 1
                                                    order by order_time;
                                                    ");
                                    $stmt->execute();
                                    $rows = $stmt->fetchAll();
                                    $count = $stmt->rowCount();

                                    if($count == 0)
                                    {

                                        echo "<tr>";
                                            echo "<td colspan='5' style='text-align:center;'>";
                                                echo "List of your canceled orders will be presented here";
                                            echo "</td>";
                                        echo "</tr>";
                                    }
                                    else
                                    {

                                        foreach($rows as $row)
                                        {
                                            echo "<tr>";
                                                echo "<td>";
                                                    echo $row['order_time'];
                                                echo "</td>";
                                                echo "<td>";
                                                    echo $row['client_name'];
                                                echo "</td>";
                                                echo "<td>";
                                                    
                                                    echo $row['cancellation_reason'];
                                                        
                                                echo "</td>";
                                            echo "</tr>";
                                        }
                                    }

                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- END ORDERS TABS -->

            <!-- START RESERVATIONS TABS -->

            <div class="card" style = "margin: 20px 10px">

                <!-- TABS BUTTONS -->

                <div class="card-header tab" style="padding:0px;">
                    <button class="tablinks_reservations active" onclick="openTab(event, 'recent_reservations','tabcontent_reservations','tablinks_reservations')">Đặt bàn gần đây</button>
                    <button class="tablinks_reservations" onclick="openTab(event, 'completed_reservations','tabcontent_reservations','tablinks_reservations')">Đặt bàn thành công</button>
                    <button class="tablinks_reservations" onclick="openTab(event, 'canceled_reservations','tabcontent_reservations','tablinks_reservations')">Huỷ đặt bàn</button>
                </div>

                <!-- TABS CONTENT -->
                
                <div class="card-body">
                    <div class='responsive-table'>

                        <!-- RECENT RESERVATIONS -->

                        <table class="table X-table tabcontent_reservations" id="recent_reservations" style="display:table">
                            <thead>
                                <tr>
                                    <th>
                                        Tạo thời gian
                                    </th>
                                    <th>
                                        Ngày giờ đặt bàn
                                    </th>
                                    <th>
                                        Số lượng khách
                                    </th>
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                        Quản lí
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                    $stmt = $con->prepare("SELECT * 
                                                    FROM reservations
                                                    where 
                                                        selected_time > ? and canceled = 0
                                                    ");
                                    $timestamp = time();
                                    $formatted_time = date('y-m-d h:i:s', $timestamp);
                                    $stmt->execute(array($formatted_time));
                                    $reservations = $stmt->fetchAll();
                                    $count = $stmt->rowCount();
                                    
                                    
                                    if($count == 0)
                                    {

                                        echo "<tr>";
                                            echo "<td colspan='5' style='text-align:center;'>";
                                                echo "List of your upcoming reservations will be presented here";
                                            echo "</td>";
                                        echo "</tr>";
                                    }
                                    else
                                    {

                                        foreach($reservations as $reservation)
                                        {
                                            echo "<tr>";
                                                echo "<td>";
                                                    echo $reservation['date_created'];
                                                echo "</td>";
                                                echo "<td>";
                                                    echo $reservation['selected_time'];
                                                echo "</td>";
                                                echo "<td>";
                                                    echo $reservation['nbr_guests'];
                                                echo "</td>";
                                                echo "<td>";
                                                    echo $reservation['table_id'];
                                                echo "</td>";
                                                echo "<td>";
                                                    
                                                    $cancel_data_reservation = "cancel_reservation".$reservation["reservation_id"];
                                                    $liberate_data = "liberate_table".$reservation["reservation_id"];
                                                    ?>
                                                    <ul class="list-inline m-0">

                                                        <!-- Liberate Table BUTTON -->
                                                        
                                                        <li class="list-inline-item" data-toggle="tooltip" title="Liberate Table">
                                                            <button class="btn btn-info btn-sm rounded-0" type="button" data-toggle="modal" data-target="#<?php echo $liberate_data; ?>" data-placement="top">
                                                                <i class="far fa-check-circle"></i>
                                                            </button>

                                                            <!-- LIBERATE MODAL -->
                                                            <div class="modal fade" id="<?php echo $liberate_data; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $liberate_data; ?>" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Thông tin</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Bàn trống ?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
                                                                            <button type="button" data-id = "<?php echo $reservation['reservation_id']; ?>" class="btn btn-info liberate_table_button">
                                                                                Vâng
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </li>

                                                        <!-- CANCEL BUTTON -->

                                                        <li class="list-inline-item" data-toggle="tooltip" title="Cancel Reservation">
                                                            <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="modal" data-target="#<?php echo $cancel_data_reservation; ?>" data-placement="top">
                                                                <i class="fas fa-calendar-times"></i>
                                                            </button>

                                                            <!-- CANCEL MODAL -->
                                                            <div class="modal fade" id="<?php echo $cancel_data_reservation; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $cancel_data_reservation; ?>" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Huỷ đặt bàn</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="form-group">
                                                                                <label>Lí do huỷ đặt bàn</label>
                                                                                <textarea class="form-control" id="cancellation_reason_reservation_<?php echo $order['order_id'] ?>" required="required"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Không</button>
                                                                            <button type="button" data-id = "<?php echo $reservation['reservation_id']; ?>" class="btn btn-danger cancel_order_button">
                                                                                Huỷ đặt bàn
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </li>
                                                    </ul>
                                                    <?php
                                                echo "</td>";
                                            echo "</tr>";
                                        }
                                    }

                                ?>

                            </tbody>
                        </table>

                        <!-- COMPLETED RESERVATIONS -->

                        <table class="table X-table tabcontent_reservations" id="completed_reservations">
                            <thead>
                                <tr>
                                    <th>
                                        Ngày tạo
                                    </th>
                                    <th>
                                        Ngày đặt
                                    </th>
                                    <th>
                                        ID
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                    $stmt = $con->prepare("SELECT * 
                                                    FROM reservations
                                                    where 
                                                        selected_time < ?
                                                        and
                                                        canceled = 0
                                                    order by selected_time;
                                                    ");
                                    $timestamp = time();
                                    $formatted_time = date('y-m-d h:i:s', $timestamp);
                                    $stmt->execute(array($formatted_time));
                                    $rows = $stmt->fetchAll();
                                    $count = $stmt->rowCount();
                                    
                                    

                                    if($count == 0)
                                    {

                                        echo "<tr>";
                                            echo "<td colspan='5' style='text-align:center;'>";
                                                echo "List of your completed reservations will be presented here";
                                            echo "</td>";
                                        echo "</tr>";
                                    }
                                    else
                                    {

                                        foreach($rows as $row)
                                        {
                                            echo "<tr>";
                                                echo "<td>";
                                                    echo $row['date_created'];
                                                echo "</td>";
                                                echo "<td>";
                                                    echo $row['selected_time'];
                                                echo "</td>";
                                                echo "<td>";
                                                    echo $row['table_id'];
                                                echo "</td>";
                                            echo "</tr>";
                                        }
                                    }

                                ?>

                            </tbody>
                        </table>

                        <!-- CANCELED RESERVATIONS -->

                        <table class="table X-table tabcontent_reservations" id="canceled_reservations">
                            <thead>
                                <tr>
                                    <th>
                                        Tạo ngày đặt bàn
                                    </th>
                                    <th>
                                        Lí do huỷ đặt bàn
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                    $stmt = $con->prepare("SELECT * 
                                                    FROM reservations
                                                    where 
                                                        canceled = 1
                                                    order by date_created;
                                                    ");
                                    $stmt->execute();
                                    $rows = $stmt->fetchAll();
                                    $count = $stmt->rowCount();

                                    if($count == 0)
                                    {

                                        echo "<tr>";
                                            echo "<td colspan='5' style='text-align:center;'>";
                                                echo "List of your canceled reservations will be presented here";
                                            echo "</td>";
                                        echo "</tr>";
                                    }
                                    else
                                    {

                                        foreach($rows as $row)
                                        {
                                            echo "<tr>";
                                                echo "<td>";
                                                    echo $row['date_created'];
                                                echo "</td>";
                                                echo "<td>";
                                                    echo $row['cancellation_reason'];
                                                echo "</td>";
                                            echo "</tr>";
                                        }
                                    }

                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- END RESERVATIONS TABS -->

        <?php

    	include 'Includes/templates/footer.php';

    }
    else
    {
    	header("Location: index.php");
    	exit();
    }

?>

<!-- JS SCRIPTS -->

<script type="text/javascript">
    
    // WHEN DELIVER ORDER BUTTON IS CLICKED

    $('.deliver_order_button').click(function()
    {

        var order_id = $(this).data('id');
        var do_ = 'Deliver_Order';

        $.ajax({
            url: "ajax_files/dashboard_ajax.php",
            type: "POST",
            data:{do_:do_,order_id:order_id,},
            success: function (data) 
            {
                $('#deliver_order'+order_id).modal('hide');
                swal("Order Delivered","The order has been marked as delivered", "success").then((value) => 
                {
                    window.location.replace("dashboard.php");
                });
                
            },
            error: function(xhr, status, error) 
            {
                alert('AN ERROR HAS BEEN OCCURRED WHILE TRYING TO PROCESS YOUR REQUEST!');
            }
          });
    });

    // WHEN CANCEL ORDER BUTTON IS CLICKED

    $('.cancel_order_button').click(function()
    {

        var order_id = $(this).data('id');
        var cancellation_reason_order = $('#cancellation_reason_order_'+order_id).val();

        var do_ = 'Cancel_Order';


        $.ajax(
        {
            url: "ajax_files/dashboard_ajax.php",
            type: "POST",
            data:{order_id:order_id, cancellation_reason_order:cancellation_reason_order, do_:do_},
            success: function (data) 
            {
                $('#cancel_order'+order_id).modal('hide');
                swal("Order Canceled","The order has been canceled successfully", "success").then((value) => 
                {
                    window.location.replace("dashboard.php");
                });
            },
            error: function(xhr, status, error) 
            {
                alert('AN ERROR HAS BEEN OCCURRED WHILE TRYING TO PROCESS YOUR REQUEST!');
            }
        });
    });

    // WHEN LIBERATE TABLE BUTTON IS CLICKED

    $('.liberate_table_button').click(function() {
        var reservation_id = $(this).data('id');
        console.log('Reservation ID: ' + reservation_id);
        var do_ = 'Liberate_Table';

        $.ajax({
            url: "ajax_files/dashboard_ajax.php",
            type: "POST",
            data: { do_: do_, reservation_id: reservation_id },
            success: function(data) {
                $('#' + 'liberate_table' + reservation_id).modal('hide');
                swal("Table Liberated", "The table has been marked as liberated", "success").then((value) => {
                    window.location.replace("dashboard.php");
                });

            },
            error: function(xhr, status, error) {
                alert('AN ERROR HAS BEEN OCCURRED WHILE TRYING TO PROCESS YOUR REQUEST!');
            }
        });
    });

    // WHEN CANCEL RESERVATION BUTTON IS CLICKED

    $('.cancel_reservation_button').click(function() {
        var reservation_id = $(this).data('id');
        var cancellation_reason_reservation = $('#cancellation_reason_reservation_' + reservation_id).val();
        var do_ = 'Cancel_Reservation';

        $.ajax({
            url: "ajax_files/dashboard_ajax.php",
            type: "POST",
            data: { reservation_id: reservation_id, cancellation_reason_reservation: cancellation_reason_reservation, do_: do_ },
            success: function(data) {
                $('#' + 'cancel_reservation' + reservation_id).modal('hide');
                swal("Reservation Canceled", "The reservation has been canceled successfully", "success").then((value) => {
                    window.location.replace("dashboard.php");
                });
            },
            error: function(xhr, status, error) {
                alert('AN ERROR HAS BEEN OCCURRED WHILE TRYING TO PROCESS YOUR REQUEST!');
            }
        });
    });

</script>