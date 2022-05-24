<!-- BUTTON FOR ADDING ITEM'S NAME START -->
<div class='row mt-3 mb-2'>
  <div class='col-md-12' style='padding-right: 22px;'>
    <button type="button" class="btn btn-success btn-xs fa fa-plus pull-right " data-toggle="modal" data-target="#modal-items" style="background-color:#b90e2b; outline:none;" onclick="ajax_html('<?php echo base_url() ?>inventory/add_item/','adding_items');"> Add Items</button>
  </div>
</div>
<!-- BUTTON FOR ADDING ITEM'S NAME END -->

<div class="table-responsive">
  <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
    <div class="row">
      <div class="col-sm-12 pl-1 pr-1">
        <table class="table table-bordered dataTable" id="dataTable_1" width="100%" cellspacing="0" role="grid" ; aria-describedby="dataTable_info" style="width: 100%; ">
          <thead align='center'>
            <tr role="row">
              <th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: auto;">#Sr</th>
              <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width:auto;">Name</th>
              <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width:auto;">Item Type</th>
              <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: auto;">Description</th>
              <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: auto;">Action</th>
            </tr>
          </thead>
          <!-- <tfoot align='center'>
                    <tr>
                       <th rowspan="1" colspan="1">Sr#</th>
                       <th rowspan="1" colspan="1">Name</th>
                       <th rowspan="1" colspan="1">Item Type</th>
                       <th rowspan="1" colspan="1">Description</th>
                       <th rowspan="1" colspan="1">Action</th>
                    </tr>
                  </tfoot> -->
          <tbody align='center'>
            <?php
            $counter = 0;
            foreach ($items as $item) {
              $counter++;
              // $toolplaza_name = $this->db->get_where('toolplaza',array('id' =>$row['toolplaza']))->row()->name;
              // $support = $this->db->get_where('supporting_document',array('mtr_id' => $row['id']))->result_array();
            ?>
              <tr role="row" class="odd">
                <td><?php echo $counter; ?></td>
                <td><?php echo $item['name']; ?></td>
                <td><?php
                    if ($item['item_type'] == 1) {
                      echo "Marketing & Promotional Type";
                    } elseif ($item['item_type'] == 2) {
                      echo "Event & stagging Equipment";
                    } elseif ($item['item_type'] == 3) {
                      echo "Electronic Equipment";
                    } elseif ($item['item_type'] == 4) {
                      echo "Support Room Equipment";
                    } elseif ($item['item_type'] == 5) {
                      echo "Cashup Room Equipment";
                    } elseif ($item['item_type'] == 6) {
                      echo "Control Room Equipment";
                    } elseif ($item['item_type'] == 7) {
                      echo "Power Supply Equipment";
                    } elseif ($item['item_type'] == 8) {
                      echo "Lane Equipment";
                    } elseif ($item['item_type'] == 9) {
                      echo "Booth Equipment";
                    } elseif ($item['item_type'] == 10) {
                      echo "Consumeables";
                    } elseif ($item['item_type'] == 11) {
                      echo "Furniture";
                    } elseif ($item['item_type'] == 12) {
                      echo "IT Assets";
                    } elseif ($item['item_type'] == 13) {
                      echo "Tools";
                    }
                    ?>
                </td>
                <td><?php echo $item['description']; ?></td>
                <?php if ($this->session->userdata('role') == 1) { ?>
                  <td>
                    <span class="btn btn-success btn-xs btn-labeled fas fa-edit" id="cancel_reason" name="item_edit" onclick="ajax_html('<?php echo base_url() . 'inventory/items_edit/' . $item['id']; ?>','edit_item_contents');" data-toggle="modal" data-target="#items-edit">&nbsp;Edit</span>
                    &nbsp
                    <span class="btn btn-danger btn-xs  fas fa-trash-alt" onclick="delete_confirm_tab('Really want to delete This','<?php echo base_url() . 'inventory/items/delete/' . $item['id']; ?>')">
                      Delete</span>
                    <?php if (!empty($item['img'])) { ?>
                      <a href="<?php echo base_url() ?>uploads/inventory_item_pics/<?php echo $item['img']; ?>" style="background-color: #6c757d" class="btn-info btn-xs fa fa-paperclip" target="__blank"> View Attachment</a>
                    <?php } ?>
                  </td>
                <?php  } ?>
              </tr>
            <?php } ?>

          </tbody>
        </table>
      </div><!-- col-sm-12 END -->
    </div><!-- row END -->

  </div><!-- dataTable wrapper END -->
</div>

<!-- Sub Modal for Add Item's Name START -->
<div class="modal fade" id="modal-items" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Item </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="adding_items">
        </div>
      </div>
      <!--div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div-->
    </div>
  </div>
</div><!-- Sub Modal for Add Item's Name END -->

<!-- Sub Modal for Add Item's Name START -->
<div class="modal fade" id="items-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Item </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="edit_item_contents">
        </div>
      </div>
      <!--div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div-->
    </div>
  </div>
</div><!-- Sub Modal for Add Item's Name END -->

<script>
  $(document).ready(function() {
    $('#dataTable_1').DataTable();
  })
</script>