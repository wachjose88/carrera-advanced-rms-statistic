<div class="container">
    <h1><?= esc($title) ?></h1>
    <?php if(isset($success)) {?>
        <div class='alert alert-success mt-2'>
            <?= $success ?>
        </div>
    <?php }?>

    <form method="post" action="<?= base_url('config') ?>" enctype="multipart/form-data">

        <div class="form-group">
            <label for="title"><?= lang('carrera.configtitle') ?></label>
            <input type="text" name="title" class="form-control"
                value="<?php if (!is_null($configtitle)) echo esc($configtitle['value']); ?>">
        </div>
        <?php if(isset($validation) && $validation->getError('title')) {?>
            <div class='alert alert-danger mt-2'>
                <?= $error = $validation->getError('title'); ?>
            </div>
        <?php }?><br>
        <div class="form-group">
            <label for="banner"><?= lang('carrera.configbanner') ?></label>
            <input type="file" name="banner" class="form-control">

        </div>
        <?php if(isset($validation) && $validation->getError('banner')) {?>
            <div class='alert alert-danger mt-2'>
                <?= $error = $validation->getError('banner'); ?>
            </div>
        <?php }?>
        <?php if (!is_null($configbanner)) : ?>
        <div class="row">
            <div class="col-md-3">
                <img src="<?= base_url('uploads/config/' . esc($configbanner['value'])) ?>" class="img-fluid">
            </div>
        </div>
        <?php endif; ?>
        <br>
        <div class="form-group">
            <button type="submit" class="btn btn-primary"><?= lang('carrera.configsave') ?></button>
        </div>

    </form>

</div>