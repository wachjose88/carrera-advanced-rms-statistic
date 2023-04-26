<div class="container">
    <h1><?= lang('carrera.results') ?></h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <h5 class="card-header"><?= lang('carrera.trainings') ?></h5>
                <div class="card-body">
                    <?php if (! empty($trainings) && is_array($trainings)) : ?>
                        <table class="table">
                            <tr>
                                <th><?= lang('carrera.comptitle') ?></th>
                                <th><?= lang('carrera.compdate') ?></th>
                            </tr>

                            <?php foreach ($trainings as $training): ?>
                                <tr>
                                    <td>
                                        <a href="<?= base_url('index.php/results/details/' . esc($training['id'])) ?>">
                                            <?php if (! empty($training['title'])) : ?>
                                                <?= esc($training['title']) ?>
                                            <?php else : ?>
                                                <?= lang('carrera.compnotitle') ?>
                                            <?php endif ?>
                                        </a>
                                    </td>
                                    <td><?= esc($training['time']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>

                    <?php else : ?>
                        <p><?= lang('carrera.compnotraining') ?></p>
                    <?php endif ?>

                </div>
            </div>

        </div>
        <div class="col-md-4">
            <div class="card">
                <h5 class="card-header"><?= lang('carrera.qualifyings') ?></h5>
                <div class="card-body">
                    <?php if (! empty($qualifyings) && is_array($qualifyings)) : ?>
                        <table class="table">
                            <tr>
                                <th><?= lang('carrera.comptitle') ?></th>
                                <th><?= lang('carrera.compdate') ?></th>
                            </tr>

                            <?php foreach ($qualifyings as $qualifying): ?>
                                <tr>
                                    <td>
                                        <a href="<?= base_url('index.php/results/details/' . esc($qualifying['id'])) ?>">
                                            <?php if (! empty($qualifying['title'])) : ?>
                                                <?= esc($qualifying['title']) ?>
                                            <?php else : ?>
                                                <?= lang('carrera.compnotitle') ?>
                                            <?php endif ?>
                                        </a>
                                    </td>
                                    <td><?= esc($qualifying['time']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>

                    <?php else : ?>
                        <p><?= lang('carrera.compnoqualifying') ?></p>
                    <?php endif ?>

                </div>
            </div>

        </div>
        <div class="col-md-4">
            <div class="card">
                <h5 class="card-header"><?= lang('carrera.races') ?></h5>
                <div class="card-body">
                    <?php if (! empty($races) && is_array($races)) : ?>
                        <table class="table">
                            <tr>
                                <th><?= lang('carrera.comptitle') ?></th>
                                <th><?= lang('carrera.compdate') ?></th>
                            </tr>

                            <?php foreach ($races as $race): ?>
                                <tr>
                                    <td>
                                        <a href="<?= base_url('index.php/results/details/' . esc($race['id'])) ?>">
                                            <?php if (! empty($race['title'])) : ?>
                                                <?= esc($race['title']) ?>
                                            <?php else : ?>
                                                <?= lang('carrera.compnotitle') ?>
                                            <?php endif ?>
                                        </a>
                                    </td>
                                    <td><?= esc($race['time']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>

                    <?php else : ?>
                        <p><?= lang('carrera.compnorace') ?></p>
                    <?php endif ?>

                </div>
            </div>

        </div>
    </div>
</div>