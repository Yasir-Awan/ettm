<div class="row">
  <div class="col-md-12 pr-1">
    <table class="table table-sm">
      <tr class="table-active ">
        <td>
          Video Start Date
        </td>
        <td>
          <?php 
              echo date("F j, Y, g:i:s a", $session[0]['video_start_date']);
            ?>
        </td>
      </tr>
      <tr class="table-primary">
        <td>
          Video End Date
        </td>
        <td>
          <?php 
              if($session[0]['video_end_date']){
                echo date("F j, Y, g:i:s a", $session[0]['video_end_date']);
              }else{
                echo "<span class='badge badge-danger'>Not Assigned</span>";
              }?>
        </td>
      </tr>
      <tr class="table-success">
        <td>
          Class1 (Cars)
        </td>
        <td>
          <?php echo $session[0]['class1'];?>
        </td>
      </tr>
      <tr class="table-warning">
        <td>
          Class2(Wagon, Hiace)
        </td>
        <td>
          <?php echo $session[0]['class2'];?>
        </td>
      </tr>
      <tr class="table-info">
        <td>
          Class3(Bus, Coaster)
        </td>
        <td>
          <?php echo $session[0]['class3'];?>
        </td>
      </tr>
      <tr class="table-danger">
        <td>
          Class4(Tractor Trolly, 2 and 3 Axle Trucks)
        </td>
        <td>
          <?php echo $session[0]['class4'];?>
        </td>
      </tr>
      <tr class="table-primary">
        <td>
          Class5 (3,4,5 and 6 Axle Articulated Trucks)
        </td>
        <td>
          <?php echo $session[0]['class5'];?>
        </td>
      </tr>
      <tr class="table-success">
        <td>
          Comment:
        </td>
        <td>
          <?php echo $session[0]['comment'];?>
        </td>
      </tr>
    </table>

    
  </div>
</div>
                  
                 