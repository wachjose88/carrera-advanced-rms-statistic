<div class="container">
    <h1><?= esc($title) ?></h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header"><?= lang('carrera.deleteimage') ?></h5>
                <div class="card-body">
                    <img src="<?= base_url('uploads/players/' . esc($image)) ?>" alt="<?= esc($title) ?>" class="img-fluid">

                        <form method="post" action="<?= base_url('players/delete/' . esc($player['id'])) ?>" enctype="multipart/form-data">
                            <p><?= lang('carrera.deleteconfirm') ?></p>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><?= lang('carrera.delete') ?></button>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>

</div>