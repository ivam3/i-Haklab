<!-- Modal -->
<div id="csv-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <p class="modal-title"><?php echo $setUp->getString('export'); ?></p>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="admin-panel/view/analytics/save-csv.php" method="post" id="csvform" class="form row">
            <div class="form-group col-sm-6">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-calendar-range"></i></span>
                    <input readonly name="logsince" type="text" id="logsince" class="form-control" placeholder="<?php echo $setUp->getString('start_date'); ?>">
                </div>
            </div>
            <div class="form-group col-sm-6">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-calendar-range"></i></span>
                    <input readonly name="loguntil" type="text" id="loguntil" class="form-control" placeholder="<?php echo $setUp->getString('end_date'); ?>">
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <div class="d-grid gap-2">
          <a href="#" class="btn btn-primary disabled" id="getcsv"><i class="bi bi-download"></i> <?php echo $setUp->getString('download'); ?></a>
        </div>
      </div>
    </div>
  </div>
</div>