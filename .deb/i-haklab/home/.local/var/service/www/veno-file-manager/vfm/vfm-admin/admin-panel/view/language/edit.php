<form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?section=translations&action=update">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <?php echo $setUp->getString("edit"); ?>: <span class="badge bg-secondary"><?php echo $editlang; ?></span>
                </div>
                <div class="col-md-6 text-end">
                    <div class="btn-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-arrow-repeat"></i> <?php echo $setUp->getString("save_settings"); ?>
                    </button>
                    <?php
                    if ($editlang !== "en") {
                        echo '<a href="?section=translations&action=update&remove='.$editlang.'" class="btn btn-danger delete"><i class="bi bi-trash"></i> '.$setUp->getString("remove_language").'</a>';
                    } ?>
                    </div>
                </div>
            </div>
            <input type="hidden" class="form-control" name="thenewlang" value="<?php echo $editlang; ?>">
        </div>
        <div class="card-body">
            <div class="row">
            <?php
            $index = 0;
            foreach ($baselang as $key => $voce) { ?>
                <div class="col-sm-6 mb-3">
                    <label class="form-label"><?php echo $key; ?></label>
                    <?php
                    if (array_key_exists($key, $_TRANSLATIONSEDIT)) {
                        $tempval = $_TRANSLATIONSEDIT[$key];
                    } else {
                        $tempval = "";
                    } ?>
                    <input type="text" class="form-control" name="<?php echo $key; ?>" value="<?php echo stripslashes($tempval); ?>" placeholder="<?php echo stripslashes($baselang[$key]); ?>">
                </div>
                <?php
            } ?>
            </div> <!-- row -->
        </div>
        <div class="card-footer">
            <?php require dirname(dirname(__FILE__)).'/save-settings.php'; ?>
        </div>
    </div>
</form>