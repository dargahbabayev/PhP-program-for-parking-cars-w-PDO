<?php include("inside.php");  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" ></script>
<title>PDO ÜYELİK SİSTEMİ</title>
</head>
<body>
<?php 
@$operation=$_GET["operation"];
@$id=$_GET["id"];
switch($operation):
case "add":
park::add($con);
break;
case "add_last":
  park::add_last($con);
break;
case "delete":
  park::delete($con,$id);
break;
case "change":
  park::change($con,$id);

break;
case "change_last":
  park::change_last($con);
break;

  default:
?>

<div class="container-fluid">
	<div class="row">
    	<div class="col-md-8 mx-auto mt-4" >
        	<table class="table table-bordered table-striped text-center bg-white ">
        	<thead>
          <tr> <th class="col-md-8 font-weight-bold btn btn-info"><a href="index.php?operation=add">New Car</a> </th>  </tr>
            <tr>
            <th class="font-weight-bold">PLAGUE</th>
            <th class="font-weight-bold">Money</th>
            <th class="font-weight-bold">Given D</th>
            <th class="font-weight-bold">Expire D</th>
            <th class="font-weight-bold">Debt D</th>
            <th class="font-weight-bold">Edit</th>
            <th class="font-weight-bold">Delete</th>            
            </tr>
            </thead>
            <tbody>
          <?php park::list($con) ?>
            </tbody>
            </table>
        </div>
    
    </div>
</div>

<?php break;
endswitch;
  ?>
</body>
</html>