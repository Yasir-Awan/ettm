<tbody>
    <?php
    //  echo "<pre>"; print_r($assets);
    $counter = 0;
    $id = 1;
    //  $previousItem = $assets[0]['name'];
    //  $currentItem;
    foreach ($assets as $asset) {
        $items = $this->db->get_where('assets', array('name' => $asset['name']))->result_array();
        $assetName = $this->db->get_where('items', array('id' => $asset['name']))->result_array();
        // echo "<pre>"; print_r(count($items));
        $counter++;
        // $toolplaza_name = $this->db->get_where('toolplaza',array('id' =>$row['toolplaza']))->row()->name;
        // $support = $this->db->get_where('supporting_document',array('mtr_id' => $row['id']))->result_array();
    ?>
        <?php if (count($items) > 1) { ?>

            <tr role="row" class="odd " id="mainrow<?php echo $counter ?>">
                <td class="sorting_1">
                    <i class="far fa-caret-square-down" data-toggle="collapse" data-parent="tbody<?php echo $counter ?>" data-target="#collapseme" style="cursor:pointer;" onclick="expandCollapse(this,'expanded_asset')">
                        <input type="hidden" data-asdf="asdf" .<?php echo $id ?> id="<?php echo $id ?>" value="<?php echo $asset['name'] ?>">
                        </input>
                    </i>
                    <input style="cursor:pointer;" type="checkbox" onchange="console.log(this.getAttribute('value'))" name="selection" id="ischecked" class="selection" value=<?php echo $asset['id']; ?>>
                    <?php echo $counter; ?>
                </td>
                <td>
                    <a href="#" onclick="show_asset('<?php echo base_url() . 'inventory/selected_asset/list/' . $asset['id']; ?>','display_selected_asset');">
                        <?php
                        echo $assetName[0]['name'];
                        ?>
                    </a>
                </td>
                <td>
                    <?php
                    if ($asset['action_status'] == "0") {
                        echo "Brand New";
                    } elseif ($asset['action_status'] == "1") {
                        echo "Checked Out";
                    } elseif ($asset['action_status'] == "2") {
                        echo "Checked In";
                    } elseif ($asset['action_status'] == "3") {
                        echo "Installed";
                    } elseif ($asset['action_status'] == "4") {
                        echo "Repairing Mode";
                    } elseif ($asset['action_status'] == "5") {
                        echo "Repaired";
                    } elseif ($asset['action_status'] == "6") {
                        echo "Retired";
                    } elseif ($asset['action_status'] == "9") {
                        echo "Re Installed";
                    } elseif ($asset['action_status'] == "10") {
                        echo "Whole Equipment Faulty";
                    } elseif ($asset['action_status'] == "11") {
                        echo $faulty_comp_name . " Faulty";
                    } elseif ($asset['action_status'] == "12") {
                        echo $faulty_comp_name . " Replaced";
                    } elseif ($asset['action_status'] == "13") {
                        echo $faulty_comp_name . " Repairing Mode";
                    } elseif ($asset['action_status'] == "14") {
                        echo $faulty_comp_name . " Reinstalled";
                    } elseif ($asset['action_status'] == "15") {
                        echo $faulty_comp_name . " Retired";
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $site = $this->db->get_where('sites', array('id' => $asset['site']))->result_array();
                    echo $site[0]['name'];
                    ?>
                </td>
                <!-- <td>
                    <?php if ($asset['action_status'] == 1) { ?>
                        <?php if ($asset['checkout_user_type'] == "1") {
                            $checkout_to = $this->db->get_where('admin', array('id' => $asset['checkout_to']))->result_array();
                            echo $checkout_to[0]['fname'] . " " . $checkout_to[0]['lname'];
                        } ?>

                        <?php if ($asset['checkout_user_type'] == "2") {
                            $checkout_to = $this->db->get_where('member', array('id' => $asset['checkout_to']))->result_array();
                            echo $checkout_to[0]['fname'] . " " . $checkout_to[0]['lname'];
                        } ?>

                        <?php if ($asset['checkout_user_type'] == "3") {
                            $checkout_to = $this->db->get_where('tpsupervisor', array('id' => $asset['checkout_to']))->result_array();
                            //echo "<pre>"; print_r($checkout_to);// exit;
                            echo $checkout_to[0]['fname'] . " " . $checkout_to[0]['lname'];
                        } ?>
                    <?php } ?>
                    </td> -->
            </tr>
        <?PHP
            $id++;
        }
        ?>
        <!-- <tbody class="hidebody" style="display:none;"></tbody> -->
        <?php if (count($items) == 1) { ?>
            <tr role="row" class="odd" id="mainrow<?php echo $counter ?>">
                <td class="sorting_1">
                    <input type="checkbox" style="margin-left:15px; cursor:pointer;" onchange="console.log(this.getAttribute('value'))" name="selection" id="ischecked" class="selection " value=<?php echo $asset['id']; ?>>
                    <?php echo $counter; ?>
                </td>
                <td>
                    <a href="#" onclick="show_asset('<?php echo base_url() . 'inventory/selected_asset/list/' . $asset['id']; ?>','display_selected_asset');">
                        <?php
                        $assetName = $this->db->get_where('items', array('id' => $asset['name']))->result_array();
                        echo $assetName[0]['name'];
                        ?>
                    </a>
                </td>
                <td>
                    <?php
                    if ($asset['action_status'] == "0") {
                        echo "Brand New";
                    } elseif ($asset['action_status'] == "1") {
                        echo "Checked Out";
                    } elseif ($asset['action_status'] == "2") {
                        echo "Checked In";
                    } elseif ($asset['action_status'] == "3") {
                        echo "Installed";
                    } elseif ($asset['action_status'] == "4") {
                        echo "Repairing Mode";
                    } elseif ($asset['action_status'] == "5") {
                        echo "Repaired";
                    } elseif ($asset['action_status'] == "6") {
                        echo "Retired";
                    } elseif ($asset['action_status'] == "9") {
                        echo "Re Installed";
                    } elseif ($asset['action_status'] == "10") {
                        echo "Whole Equipment Faulty";
                    } elseif ($asset['action_status'] == "11") {
                        echo $faulty_comp_name . " Faulty";
                    } elseif ($asset['action_status'] == "12") {
                        echo $faulty_comp_name . " Replaced";
                    } elseif ($asset['action_status'] == "13") {
                        echo $faulty_comp_name . " Repairing Mode";
                    } elseif ($asset['action_status'] == "14") {
                        echo $faulty_comp_name . " Reinstalled";
                    } elseif ($asset['action_status'] == "15") {
                        echo $faulty_comp_name . " Retired";
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $site = $this->db->get_where('sites', array('id' => $asset['site']))->result_array();
                    echo $site[0]['name'];
                    ?>
                </td>
                <!-- <td>
                    <?php if ($asset['action_status'] == 1) { ?>
                        <?php if ($asset['checkout_user_type'] == "1") {
                            $checkout_to = $this->db->get_where('admin', array('id' => $asset['checkout_to']))->result_array();
                            echo $checkout_to[0]['fname'] . " " . $checkout_to[0]['lname'];
                        } ?>

                        <?php if ($asset['checkout_user_type'] == "2") {
                            $checkout_to = $this->db->get_where('member', array('id' => $asset['checkout_to']))->result_array();
                            echo $checkout_to[0]['fname'] . " " . $checkout_to[0]['lname'];
                        } ?>

                        <?php if ($asset['checkout_user_type'] == "3") {
                            $checkout_to = $this->db->get_where('tpsupervisor', array('id' => $asset['checkout_to']))->result_array();
                            //echo "<pre>"; print_r($checkout_to);// exit;
                            echo $checkout_to[0]['fname'] . " " . $checkout_to[0]['lname'];
                        } ?>
                      <?php } ?>
                      </td> -->
            </tr>

        <?PHP } ?>
    <?php
        $previousItem = $asset['name'];
    } // loop Ends  
    ?>
</tbody>