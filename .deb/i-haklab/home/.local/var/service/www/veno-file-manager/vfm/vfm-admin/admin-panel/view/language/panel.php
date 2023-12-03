<div class="row">
    <div class="col-sm-6">
        <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?section=translations&action=edit">
            <div class="card">
                <div class="card-header">
                    <?php print $setUp->getString("edit_language"); ?>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <div class="input-group input-group-lg">
                            <select class="form-select" name="editlang">
                            <?php
                            $translations = $admin->getLanguages();
                            foreach ($translations as $key => $lingua) { ?>
                                <option value="<?php echo $key; ?>"
                                <?php
                                if ($key == $thelang) {
                                    echo "selected";
                                } ?> >
                                <?php echo $lingua; ?>
                                </option>
                                <?php
                            } ?>
                            </select>
                            <button class="btn btn-primary" type="submit"><i class="bi bi-pencil-square"></i> 
                                <?php print $setUp->getString("edit"); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php require 'langlist.php';
    $available_languages = array_keys($translations);
    foreach ($available_languages as $value) {
        unset($languages[$value]);
    }
    ?>
    <div class="col-sm-6">
        <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?section=translations&action=edit">
            <div class="card">
                <div class="card-header">
                    <?php echo $setUp->getString("new_language"); ?>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <div class="input-group input-group-lg">
                        <select class="form-select" name="newlang">
                            <?php
                            foreach ($languages as $key => $value) {
                                echo '<option value="'.$key.'">'.$value.'</option>';
                            }
                            ?>
                        </select>
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-plus-lg"></i> 
                            <?php echo $setUp->getString("add"); ?>
                        </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
