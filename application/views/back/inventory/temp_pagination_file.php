<tbody>
    <?php
    $counter = 0;
    $index = 0;
    foreach ($installs as $install) {
        $counter++;
    ?>
        <tr role="row" class="odd">
            <td class="sorting_1">
                <input type="checkbox" onchange="console.log(this.getAttribute('value'))" name="selection" id="ischecked" class="selection" value=<?php echo $install['id']; ?>>
                <?php echo $counter; ?>
            </td>
            <td>
                <a href="#" onclick="show_asset('<?php echo base_url() . 'inventory/selected_install/list/' . $install['id']; ?>','display_selected_install');" data-toggle="modal" data-target="#inventoryModal">
                    <?php
                    echo $itemNames[$index];
                    ?>
                </a>
            </td>
            <!-- <td>  <?php
                        if ($item[0]['item_type'] == 1) {
                            echo "Marketing & Promotional Type";
                        } elseif ($item[0]['item_type'] == 2) {
                            echo "Event & stagging Equipment";
                        } elseif ($item[0]['item_type'] == 3) {
                            echo "Electronic Equipment";
                        } elseif ($item[0]['item_type'] == 4) {
                            echo "Support Room Equipment";
                        } elseif ($item[0]['item_type'] == 5) {
                            echo "Cashup Room Equipment";
                        } elseif ($item[0]['item_type'] == 6) {
                            echo "Control Room Equipment";
                        } elseif ($item[0]['item_type'] == 7) {
                            echo "Power Supply Equipment";
                        } elseif ($item[0]['item_type'] == 8) {
                            echo "Lane Equipment";
                        } elseif ($item[0]['item_type'] == 9) {
                            echo "Booth Equipment";
                        } elseif ($item[0]['item_type'] == 10) {
                            echo "Consumeables";
                        } elseif ($item[0]['item_type'] == 11) {
                            echo "Furniture";
                        } elseif ($item[0]['item_type'] == 12) {
                            echo "IT Assets";
                        } elseif ($item[0]['item_type'] == 13) {
                            echo "Tools";
                        }
                        ?></td> -->
            <td><?php echo $install['serial_no'] ?></td>
            <td>
                <?php
                if ($install['transaction_type'] == "0") {
                    echo "Brand New";
                } elseif ($install['transaction_type'] == "1") {
                    echo "Checked Out";
                } elseif ($install['transaction_type'] == "2") {
                    echo "Checked In";
                } elseif ($install['transaction_type'] == "3") {
                    echo "Installed";
                } elseif ($install['transaction_type'] == "4") {
                    echo "Repairing Mode";
                } elseif ($install['transaction_type'] == "5") {
                    echo "Repaired";
                } elseif ($install['transaction_type'] == "6") {
                    echo "Retired";
                } elseif ($install['transaction_type'] == "9") {
                    echo "Re Installed";
                } elseif ($install['transaction_type'] == "10") {
                    echo "Faulty";
                } elseif ($install['transaction_type'] == "11") {
                    echo $faulty_comp_name . " Faulty";
                } elseif ($install['transaction_type'] == "12") {
                    echo $faulty_comp_name . " Replaced";
                } elseif ($install['transaction_type'] == "13") {
                    echo $faulty_comp_name . " Repairing Mode";
                } elseif ($install['transaction_type'] == "14") {
                    echo $faulty_comp_name . " Reinstalled";
                } elseif ($install['transaction_type'] == "15") {
                    echo $faulty_comp_name . " Retired";
                }
                ?>
            </td>
            <td>
                <?php
                echo $siteNames[$index];
                ?>
            </td>
            <td>
                <?php
                echo $locationNames[$index];
                $index++;
                ?>
            </td>
        <?php } ?>
        </tr>
</tbody>