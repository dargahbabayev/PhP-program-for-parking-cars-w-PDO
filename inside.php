<?php
try {
   $con = new PDO("mysql:host=localhost;dbname=parking;charset=utf8", "root", "");
   $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
   die($e->getMessage());
};
?>

<?php

class park
{

   public static function list($data)
   {

      $myquery = "select * from cars";
      $result = $data->prepare($myquery);
      $carsCount = $result->rowCount();
      $result->execute();

      while ($row = $result->fetch(PDO::FETCH_ASSOC)) :
         $date1 = date_create($row['Expired']);
         $date2 = date_create($row['Givend']);
         //$date3 = date_create("Today " . date("Y/m/d"));
         $now = new DateTime();
         if ($date1 < $now) {
            $diff = date_diff($now, $date1);
            $diff = $diff->format("%d days");
            $diff = intval($diff);
            echo "  <tr>
           <td>" . $row['Plague'] . "</td>
           <td>" . $row['Money'] . "</td>
           <td>" . $row['Givend'] . "</td>
           <td>" . $row['Expired'] . "</td>
           <td class='text-danger'>" . $diff . "</td>
           <td><a class='btn btn-warning' href='index.php?operation=change&id=" . $row['id'] . "' >Edit </a></td>
           <td><a class='btn btn-danger' href='index.php?operation=delete&id=" . $row['id'] . "' >Delete </a></td> 
             </tr>";

         }else {
            echo "  <tr>
            <td>" . $row['Plague'] . "</td>
            <td>" . $row['Money'] . "</td>
            <td>" . $row['Givend'] . "</td>
            <td>" . $row['Expired'] . "</td>
            <td>" . '0' . "</td>
            <td><a class='btn btn-warning' href='index.php?operation=change&id=" . $row['id'] . "' >Edit </a></td>
            <td><a class='btn btn-danger' href='index.php?operation=delete&id=" . $row['id'] . "' >Delete </a></td> 
                     </tr>";
         }

      endwhile;
   }
   public static function add($data)
   {
      echo '  <form action="index.php?operation=add_last" method="POST">
      <table class="table  table-bordered " style="text-align:center">
      <thead>
        <tr>
            <th colspan="12">Add New Car</th>
        </tr>
      </thead>

          <tbody>
        <tr>
            <th colspan="4"></th>
            <th colspan="4">Plague</th>
            <th colspan="4" style="text-align:left;"><input name="plague" type="text" /></th>
        </tr>

        <tr>
            <th colspan="4"></th>
            <th colspan="4">Money</th>
            <th colspan="4" style="text-align:left;"><input name="money" type="number" /></th>
        </tr>
        <tr>
            <th colspan="4"></th>
            <th colspan="4">Given Date</th>
            <th colspan="4" style="text-align:left;"><input name="givend" type="date" /></th>
        </tr>


   

        <tr>
            <th colspan="12"><input type="submit" name="buton" class="btn btn-success" value="ADD"></th>

        </tr>

    </tbody>


         </table>
             </form>';
   }
   public static function add_last($data)
   {
      if ($_POST["buton"]) :
         $plague = htmlspecialchars($_POST["plague"]);
         $money = htmlspecialchars($_POST["money"]);
         $givend = htmlspecialchars($_POST["givend"]);
         if(empty($plague)|| empty($money)|| empty($givend)):
            echo "Fill all tables";
            header("refresh:2 url=index.php?operation=add");
         else:
            $expired = date('Y-m-d', strtotime($givend . ' + ' . $money . ' days'));
            $myquery = "insert into cars (Plague,Money,Givend,Expired) VALUES('$plague',$money,'$givend','$expired')";
            $result = $data->prepare($myquery);
            $result->execute();
            echo '<div class=" alert text-success"> Sucsesfully Add :) WAIT FORWARDING  </div>';
            header("refresh:2 url=index.php");
         endif;
      endif;
   }
   public static function delete($data,$id) {
      $deleteid=$id;
      $myquery="delete from cars where id=$deleteid";
      $result=$data->prepare($myquery);
     // $result->bind_param(1,$deleteid,PDO::PARAM_INT);
      $result->execute();
      echo '<div class="alert text-warning"> DELETED :) ERROR FORWARDING  </div>';
      header("refresh:2 url=index.php ");

    /*
      echo "ERROR";
      header("refresh:2 url=index.php");
   
        */ 
   }
   public static function change($data,$id)
   {
   $editedid=$id;
   $myquery="select * from cars where id=$editedid";
   $result=$data->prepare($myquery);
   $result->execute();
 $row=$result->fetch(PDO::FETCH_ASSOC);
      echo '  <form action="index.php?operation=change_last" method="POST">
      <input type="hidden" name="id" value='.$row["id"].'>
      <table class="table  table-bordered " style="text-align:center">
      <thead>
        <tr>
            <th colspan="12">Add New Car</th>
        </tr>
      </thead>
   
          <tbody>
        <tr>
            <th colspan="4"></th>
            <th colspan="4">Plague</th>
            <th colspan="4" style="text-align:left;"><input name="plague" type="text"  value='.$row["Plague"].' /></th>
        </tr>
   
        <tr>
            <th colspan="4"></th>
            <th colspan="4">Money</th>
            <th colspan="4" style="text-align:left;"><input name="money" type="number"  value='.$row["Money"].' /></th>
        </tr>
        <tr>
            <th colspan="4"></th>
            <th colspan="4">Given Date</th>
            <th colspan="4" style="text-align:left;"><input name="givend" type="date" value='.$row["Givend"].' /></th>
        </tr>
   
   
   
   
        <tr>
        
            <th colspan="12"><input type="submit" name="buton" class="btn btn-success" value="Edit"></th>
   
        </tr>
   
    </tbody>
   
   
         </table>
             </form>';
 
}
public static function change_last($data){
$id=htmlspecialchars($_POST['id']);
$plague=htmlspecialchars($_POST['plague']);
$money=htmlspecialchars($_POST['money']);
$givend=htmlspecialchars($_POST['givend']);
$expired = date('Y-m-d', strtotime($givend . ' + ' . $money . ' days'));
if(empty($plague)|| empty($money)|| empty($givend)):
   echo "Fill all tables";
   header("refresh:2 url=index.php");
else:
   $myquery = "UPDATE cars SET Plague='$plague', Money=$money, Givend='$givend',Expired='$expired' where id=$id ";
   $result = $data->prepare($myquery);
   $result->execute();
   echo '<div class=" alert text-success"> Sucsesfully Edit :) WAIT FORWARDING  </div>';
   header("refresh:2 url=index.php");
endif;


}

  
         
   





}



?>