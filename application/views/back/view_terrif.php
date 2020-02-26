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
    <table id="" class="table">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Description</th>
                <th>Rates</th>
                
                
            </tr>
        </thead>
        <tbody>
            <?php if($terrif){
                $counter = 0;
                    
            ?>
             <tr>
                <td>1</td>
                <td><?php echo $terrif[0]['class_1_description'];?></td>
                <td><?php echo $terrif[0]['class_1_value'];?></td>
               
            </tr>
            <tr>
                <td>2</td>
                <td><?php echo $terrif[0]['class_2_description'];?></td>
                <td><?php echo $terrif[0]['class_2_value'];?></td>
               
            </tr> 
            <tr>
                <td>3</td>
                <td><?php echo $terrif[0]['class_3_description'];?></td>
                <td><?php echo $terrif[0]['class_3_value'];?></td>
               
            </tr> 
            <tr>
                <td>4</td>
                <td><?php echo $terrif[0]['class_4_description'];?></td>
                <td><?php echo $terrif[0]['class_4_value'];?></td>
               
            </tr> 
            <tr>
                <td>5</td>
                <td><?php echo $terrif[0]['class_5_description'];?></td>
                <td><?php echo $terrif[0]['class_5_value'];?></td>
               
            </tr> 
            <tr>
                <td>6</td>
                <td><?php echo $terrif[0]['class_6_description'];?></td>
                <td><?php echo $terrif[0]['class_6_value'];?></td>
               
            </tr> 
            <tr>
                <td>7</td>
                <td><?php echo $terrif[0]['class_7_description'];?></td>
                <td><?php echo $terrif[0]['class_7_value'];?></td>
               
            </tr> 
            <tr>
                <td>8</td>
                <td><?php echo $terrif[0]['class_8_description'];?></td>
                <td><?php echo $terrif[0]['class_8_value'];?></td>
               
            </tr> 
            <tr>
                <td>9</td>
                <td><?php echo $terrif[0]['class_9_description'];?></td>
                <td><?php echo $terrif[0]['class_9_value'];?></td>
               
            </tr> 
            <tr>
                <td>10</td>
                <td><?php echo $terrif[0]['class_10_description'];?></td>
                <td><?php echo $terrif[0]['class_10_value'];?></td>
               
            </tr>  
           <?php } ?>
        </tbody>
    </table>
    <script>
    $(document).ready(function(){

        $('#dataTable4').DataTable();
    })
    </script>