<?php include('includes/header.php'); ?>
            
            <div class="main-content-inner">
                <div class="row">
                    
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h4 class="header-title">Faulty Eqipment List</h4>
                                    </div>
                                    <!-- <div class="col-md-4">
                                        <select class="form-control required" name="toll_plaza" id="toll_plaza">
                                            <option value="">Choose Site</option>
                                            <?php foreach($tollplaza as $row){?>
                                            <option value="<?php echo $row['id']?>"><?php echo $row['name'];?></option>
                                            <?php } ?>
                                        </select>
                                    </div> -->
                                </div>
                                <div class='list' id='list' style="margin-top: 3%;">
                                <!-- code to show datatable list Start -->
                                <style>
  .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
  .toggle.ios .toggle-handle { border-radius: 20px; }
  .toggle.ios { width: 60.0781px !important;
    height: 30px !important;}
    .btn{
        padding: 0.375rem 0.95rem !important;
        font-size: 1rem !important;
        line-height: 1 !important;
    }
    .toggle-off{
        background-color: #e31515 !important;
        color: white !important;
    }
    .toggle-on{
        background-color: #0f9b0f !important;
        color: white !important;
    }
</style>                     
<div class="data-tables datatable-dark">
    <table id="dataTableFaultyEquipment" class="text-center">
        <thead class="text-capitalize">
            <tr>
                <th>No</th>
                <th>Item Name </th>
                <th>Site</th>
                <th>Location</th>
                <th>Estimate Cost</th>
                 <th>Faulty Date</th>
                <th>OMC</th>
                <th width="15%">Comment</th>
                <!-- <th width="30%">Action</th> -->
                
            </tr>
        </thead>
        <tbody>
            <?php if($faulty_data){
                // echo "<pre>"; print_r($faulty_data);
                $counter = 0;
                $index = 0;
                $subitemIndex = 0;
                foreach($faulty_data as $row){
                      $counter++;
            ?>
             <tr>
                <td><?php echo $counter;?></td>
                <td><?php
                if($row['is_sub_item']==1){
                    echo $subitem_name[$subitemIndex]." of ".$item_name[$index];
                    $subitemIndex++;
                }
                else{echo $item_name[$index];} 
                 ?></td>
                <td> <?php echo $site_name[$index];?></td>
                <td> <?php echo $location_name[$index];?></td>
                <td><?php echo $row['est_cost'] ?></td>
                <td><?php echo $row['faulty_date']?></td>
                <td> <?php echo $row['faulty_time_omc']; ?></td>
                <td> <?php echo $row['comments']; ?> </td>
            </tr> 
            <?php  
            $index++;  
            }
            }
            ?>
           
        </tbody>
    </table>
                                <!-- code to show datatable list End -->
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Dark table end -->
                </div>
            </div>
        </div>
        <script>
    $(document).ready(function(){
        $('#dataTableFaultyEquipment').DataTable();
    })
    </script>


        <!-- footer area start-->
   <?php include('includes/footer.php')?>      