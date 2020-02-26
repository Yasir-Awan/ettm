<div class="row">
  <div class="col-md-12">
      <?php if($this->page_data['location'][0]['type'] == 1){?>
          <span class="badge badge-info" style="font-size:14px">Name</span> : <span class="badge badge-secondary" style="font-size:14px"><?php echo $location[0]['name']?></span><br/><br/>
          <span class="badge badge-info" style="font-size:14px">Address</span> : <span class="badge badge-secondary" style="font-size:14px"><?php echo $location[0]['address']?></span><br/><br/>
          <?php if($info_data){?>
          <span class="badge badge-info" style="font-size:14px">Total Traffic(<span class="badge badge-success" style="font-size:14px"><?php echo date("F, Y",strtotime($info_data['date']))?></span>)</span> : <span class="badge badge-secondary" style="font-size:14px"><?php echo $info_data['traffic']?></span><br/><br/>
          <span class="badge badge-info" style="font-size:14px">Total Revenue(<span class="badge badge-success" style="font-size:14px"><?php echo date("F, Y",strtotime($info_data['date']))?></span>)</span> : <span class="badge badge-secondary" style="font-size:14px"><?php echo $info_data['revenue']?></span><br/><br/>
          <?php } ?>
          <span class="badge badge-info" style="font-size:14px">Chainage</span> : <span class="badge badge-secondary" style="font-size:14px"><?php echo $location[0]['chainage']?></span><br/>
          
     <?php }elseif($this->page_data['location'][0]['type'] == 2){ ?>
          <span class="badge badge-info" style="font-size:14px">Name</span> : <span class="badge badge-secondary" style="font-size:14px"><?php echo $location[0]['name']?></span><br/><br/>
          <span class="badge badge-info" style="font-size:14px">Address</span> : <span class="badge badge-secondary" style="font-size:14px"><?php echo $location[0]['address']?></span><br/><br/>
          <?php if($info_data){?>
          <span class="badge badge-info" style="font-size:14px">Total Traffic(<span class="badge badge-success" style="font-size:14px"><?php echo date("F, Y",strtotime($info_data['date']))?></span>)</span> : <span class="badge badge-secondary" style="font-size:14px"><?php echo $info_data['traffic']?></span><br/><br/>
          <span class="badge badge-info" style="font-size:14px">Total Revenue(<span class="badge badge-success" style="font-size:14px"><?php echo date("F, Y",strtotime($info_data['date']))?></span>))</span> : <span class="badge badge-secondary" style="font-size:14px"><?php echo $info_data['revenue']?></span><br/><br/>
          <?php } ?>
          <span class="badge badge-info" style="font-size:14px">Chainage</span> : <span class="badge badge-secondary" style="font-size:14px"><?php echo $location[0]['chainage']?></span><br/>
          



    <?php  } ?>
  </div>
</div>
