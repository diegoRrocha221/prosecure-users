<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://prosecurelsp.com/assets/stylesheet/bootstrap.min.css" rel="stylesheet">
    <style>
        .custom-navbar {
            background-color: #2C3E50;
        }

        .navbar-brand img {
            max-height: 40px; /* ajuste a altura conforme necessário */
        }

        .navbar-warning {
            color: #fff;
        }
    </style>

</head>

<body>
<nav id="navbar" class="navbar navbar-expand-lg navbar-dark custom-navbar">
    <a class="navbar-brand" href="#">
        <img src="../../images/logo.png" alt="Logo">
    </a>

    <div class="collapse navbar-collapse justify-content-end">
        <a href="#" class="btn btn-warning navbar-warning" id="capture">Download</a>
    </div>
</nav>
<div class="container">
    <?php
    require "../controllers/database_connection.php";
    function getPlanPrice($id){
        $db = new DatabaseConnection();
        $conn = $db->getConnection();
    $sql = "SELECT price FROM plans WHERE id = '$id'";
    $result = $conn->query($sql);
    $price = 0;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $price = $row['price'];
        }
    }
    return $price;
    }
    $db = new DatabaseConnection();
    $conn = $db->getConnection();
    $master = $_GET['muid'];
    $invoice = $_GET['inuid'];
    $name = "";
    $lname = "";
    $email = "";
    $plans = "";
    $street = "";
    $city = "";
    $state = "";
    $additional = "";
    $total = "";
    $due = "";
    $status = "";
    $is_trial = "";
    $sql = "SELECT * FROM master_accounts WHERE reference_uuid = '$master'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $name = $row['name'];
            $lname = $row['lname'];
            $email = $row['email'];
            $plans = $row['purchased_plans'];
            $street = $row['street'];
            $city = $row['city'];
            $state = $row['state'];
            $additional = $row['additional_info'];
        }
    }
    $sql = "SELECT * FROM invoices WHERE id = '$invoice'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $is_trial = $row['is_trial'];
            $total = $row['total'];
            $due = $row['due_date'];
            $status = $row['is_paid'];
        }
    }
    $fullName = $name." ".$lname;
    $fullStreet = $additional. " ".$street." ". $city. " /".$state;
    $isPaid = $status === '1' ? 'Paid' : 'Pending';

    ?>

    <div class="card">
        <div class="card-header">
            Invoice
            <strong><?php echo $due; ?></strong>
            <span class="float-right"> <strong>Status:</strong> <?php echo $isPaid; ?></span>

        </div>

        <div class="card-body">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <h6 class="mb-3">From:</h6>
                    <div >
                        <img style="background-color: #2C3E50" width="200px" height="70px" src="../../images/logo.png">
                    </div>
                    <div>3032 E Commercial Blvd #96
                        Ft Lauderdale, FL 33308</div>
                    <div>Email: info@prosecurelsp.com</div>
                    <div>Phone: +1 (833) 723-3101</div>
                </div>

                <div class="col-sm-6">
                    <h6 class="mb-3">To:</h6>
                    <div>
                        <strong><?php echo $fullName;?></strong>
                    </div>
                    <div><?php echo $fullStreet; ?></div>
                    <div>Email: <?php echo $email; ?></div>
                </div>



            </div>
            <?php
            $decodedPlans = json_decode($plans, true);

            ?>
            <div class="table-responsive-sm">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th class="center">#</th>
                        <th>Item</th>


                        <th class="right">Unit Cost</th>

                        <th class="right">Total</th>
                    </tr>
                    </thead>
                    <tbody>

                        <?php
                        $table = "";
                        $counter = 0;
                        $total = 0;
                        foreach ($decodedPlans as $plan) {
                        $table .= '<tr>';
                        $table .= '<td class="center">'.$counter.'</td>';
                        $table .= '<td class="left strong">'.$plan['plan_name'].'</td>';
                        $table .= '<td class="right">'.getPlanPrice($plan['plan_id']).'</td>';
                        $table .= '<td class="right">'.getPlanPrice($plan['plan_id']).'</td>';
                        $table .= '</tr>';
                        $counter++;
                        $total += getPlanPrice($plan['plan_id']);
                        }
                        $trial = $status === '1' ? 0.00 : $total;
                        ?>
                        <?php echo $table; ?>


                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-lg-4 col-sm-5">

                </div>

                <div class="col-lg-4 col-sm-5 ml-auto">
                    <table class="table table-clear">
                        <tbody>
                        <tr>
                            <td class="left">
                                <strong>Subtotal</strong>
                            </td>
                            <td class="right">$<?php echo $total; ?></td>
                        </tr>
                        <tr>
                            <td class="left">
                                <strong>Discount</strong>
                            </td>
                            <td class="right">$<?php echo $trial; ?></td>
                        </tr>

                        <tr>
                            <td class="left">
                                <strong>Total</strong>
                            </td>
                            <td class="right">
                                <strong>$<?php $final = $total - $trial; echo $final; ?></strong>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>

            </div>

        </div>
    </div>
</div>

<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.14.0/pdf-lib.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.js"></script>

<script>
    document.getElementById('capture').addEventListener('click', function () {
        document.getElementById('navbar').style.display="none";
        setTimeout(function () {
            take();
        }, 1500);
    });
    function take(){
        html2pdf(document.body, {
            margin: 10,
            filename: 'invoice.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        });
        setTimeout(function () {
            document.getElementById('navbar').style.display="flex";
        }, 1500);

    }
</script>

</body>

</html>
