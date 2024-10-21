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
   <title>dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>

 <?php include 'admin_header.php'; ?>
 <!-- Content Wrapper. Contains page content -->
  <!-- <div class="content-wrapper"> -->


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sales History
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <div class="pull-right">
                <form method="POST" class="form-inline" action="print_sales.php">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right col-sm-8" id="reservation" name="date_range">
                  </div>
                  <button type="submit" class="btn btn-success btn-sm btn-flat" name="print"><span class="glyphicon glyphicon-print"></span> Print</button>
                </form>
              </div>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th class="hidden"></th>
                  <th>Date</th>
                  <th>Buyer Name</th>
                  <th>Product List</th>
<!--                   <th>Transaction#</th>
 -->                  <th>Amount</th>
<!--                   <th>Full Details</th>
 -->                </thead>
                <tbody>
                  <?php
                      $sales = mysqli_query($conn,"SELECT *, sum(total_price) as total,  orders.id AS ordersid FROM orders LEFT JOIN customer ON orders.user_id=customer.id GROUP BY placed_on,user_id") or die('query failed');
                    if(mysqli_num_rows($sales) > 0){
                    while($fetch_sales = mysqli_fetch_assoc($sales)){

                      
                        // $stmt = $conn->prepare("SELECT * FROM details LEFT JOIN products ON products.id=details.product_id WHERE details.sales_id=:id");
                        // $stmt->execute(['id'=>$row['salesid']]);
                        // $total = 0;
                        // foreach($stmt as $details){
                        //   // $subtotal = $details['total'];
                        // }
                        echo "
                          <tr>
                            <td class='hidden'></td>
                            <td>".date('M d, Y', strtotime($fetch_sales['placed_on']))."</td>
                            <td>".$fetch_sales['name']."</td>
                            <td>".$fetch_sales['total_products']."</td>

                            <td>RM ".number_format($fetch_sales['total'], 2)."</td>
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
     
  <!-- </div>
  	<?php include 'includes/footer.php'; ?>
    <?php include '../includes/profile_modal.php'; ?>

</div> -->
<!-- ./wrapper -->

<?php include 'scripts.php'; ?>
<!-- Date Picker -->
<script>
$(function(){
  //Date picker
  $('#datepicker_add').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd'
  })
  $('#datepicker_edit').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd'
  })

  //Timepicker
  $('.timepicker').timepicker({
    showInputs: false
  })

  //Date range picker
  $('#reservation').daterangepicker()
  //Date range picker with time picker
  $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
  //Date range as a button
  $('#daterange-btn').daterangepicker(
    {
      ranges   : {
        'Today'       : [moment(), moment()],
        'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month'  : [moment().startOf('month'), moment().endOf('month')],
        'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
      startDate: moment().subtract(29, 'days'),
      endDate  : moment()
    },
    function (start, end) {
      $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
    }
  )
  
});
</script>
<script>
$(function(){
  $(document).on('click', '.transact', function(e){
    e.preventDefault();
    $('#transaction').modal('show');
    var id = $(this).data('id');
    $.ajax({
      type: 'POST',
      url: 'transact.php',
      data: {id:id},
      dataType: 'json',
      success:function(response){
        $('#placed_on').html(response.date);
        $('#total_quantity').html(response.transaction);
        $('#detail').prepend(response.list);
        $('#total').html(response.total);
      }
    });
  });

  $("#transaction").on("hidden.bs.modal", function () {
      $('.prepend_items').remove();
  });
});
</script>

<script src="js/admin_script.js"></script>

</body>
</html>
