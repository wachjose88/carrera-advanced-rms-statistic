<div class="container">
    <h1><?= lang('carrera.cars') ?></h1>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header"><?= lang('carrera.cars') ?></h5>
                <div class="card-body">
                    <?php if (! empty($cars) && is_array($cars)) : ?>
                        <table class="table">
                            <tr>
                                <th><?= lang('carrera.name') ?></th>
                                <th><?= lang('carrera.number') ?></th>
                                <th><?= lang('carrera.numplayertrainings') ?></th>
                                <th><?= lang('carrera.numplayerqualifyings') ?></th>
                                <th><?= lang('carrera.numplayerraces') ?></th>
                            </tr>

                            <?php foreach ($cars as $car): ?>
                                <tr>
                                    <td>
                                        <a href="<?= base_url('index.php/cars/details/' . esc($car['id'])) ?>">
                                                <?= esc($car['name']) ?>
                                        </a>
                                    </td>
                                    <td><?= esc($car['number']) ?></td>
                                    <td><?= esc($car['nums']['trainingwins']) ?>/<?= esc($car['nums']['trainings']) ?></td>
                                    <td><?= esc($car['nums']['qualifyingwins']) ?>/<?= esc($car['nums']['qualifyings']) ?></td>
                                    <td><?= esc($car['nums']['racewins']) ?>/<?= esc($car['nums']['races']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>

                    <?php else : ?>
                        <p><?= lang('carrera.nocars') ?></p>
                    <?php endif ?>

                </div>
            </div>

        </div>
    </div>

</div>