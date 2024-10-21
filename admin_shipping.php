<?php

include 'config.php';

session_start();

$staffid = $_SESSION['staffid'];

if(!isset($staffid)){
   header('location:login.php');
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shipping</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>
<?php include 'admin_header.php'; ?>

<!-- <body class="hold-transition skin-blue sidebar-mini"> -->
<div class="wrapper">

  <!-- Content Wrapper. Contains page content -->
  <!-- <div class="content-wrapper"> -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Shipping Information
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
             <!--  <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> New</a> -->
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
<!--                   <th>Photo</th>
 -->                   
                  <th class="hidden"></th>

                  <th>Date</th>
                  <th>Buyer Name</th>
                  <th>Telephone Number</th>
                  <th>Status Payment</th>
                  <th>Address</th>
                  <th>Tracking Number</th>
                  <th>Shipping Status</th>

                  <th>Tools</th>
                  <th>Ref</th>

                </thead>
                <tbody>
                  <?php

                      $now = date('Y-m-d');
                      $shipping = mysqli_query($conn, "SELECT *, orders.id AS ordersid FROM orders");
                       if(mysqli_num_rows($shipping) > 0){
                       while($fetch_shipping = mysqli_fetch_assoc($shipping)){
                        echo "
                          <tr>
                                                      <td class='hidden'></td>

                            <td>".date('M d, Y', strtotime($fetch_shipping['placed_on']))."</td>
                            <td>".$fetch_shipping['name']."</td>
                                <td>".$fetch_shipping['number']."</td>

                            <td>".$fetch_shipping['payment_status']."</td>
                                                            <td>".$fetch_shipping['address']."</td>

                            <td>".$fetch_shipping['tracknum']."</td>
                            <td>".$fetch_shipping['shipping_status']."</td>


                            <td>
                            
                           <button class='btn btn-success btn-sm edit btn-flat' data-id='".$fetch_shipping['id']."'><i class='fa fa-edit'></i> Edit</button>

                            </td>
                            <td> 

                            <form method='POST' class='form-inline' action='shipping_print.php?id=".$fetch_shipping['id']."'>
                 <button type='submit' class='btn btn-success btn-sm btn-flat' name='print'><span class='glyphicon glyphicon-print'></span> Print</button>
                </form>

                            </td>
                          </tr>
                        ";
                      }
                    }
                    

                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
     
  </div>
    <?php include 'shipping_modal.php'; ?>

</div>
<!-- ./wrapper -->

<?php include 'scripts.php'; ?>
<script>
$(function(){

  $(document).on('click', '.edit', function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.delete', function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.photo', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.status', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    getRow(id);
  });

});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'shipping_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.ordersid').val(response.id);
      $('#address').val(response.address);
      $('#shipping_status').val(response.shipping_status);
      $('#edit_name').val(response.name);
      $('#edit_lastname').val(response.lastname);
      $('#edit_address').val(response.address);
      $('#edit_contact').val(response.contact_info);
      $('.name').html(response.name);
    }
  });
}
</script>
</body>
</html>
