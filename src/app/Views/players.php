<div class="container">
    <h1><?= lang('carrera.players') ?></h1>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header"><?= lang('carrera.players') ?></h5>
                <div class="card-body">
                    <?php if (! empty($players) && is_array($players)) : ?>
                        <table class="table">
                            <tr>
                                <th><?= lang('carrera.name') ?></th>
                                <th><?= lang('carrera.username') ?></th>
                                <th><?= lang('carrera.numplayertrainings') ?></th>
                                <th><?= lang('carrera.numplayerqualifyings') ?></th>
                                <th><?= lang('carrera.numplayerraces') ?></th>
                            </tr>

                            <?php foreach ($players as $player): ?>
                                <tr>
                                    <td>
                                        <a href="<?= base_url('index.php/players/details/' . esc($player['id'])) ?>">
                                                <?= esc($player['name']) ?>
                                        </a>
                                    </td>
                                    <td><?= esc($player['username']) ?></td>
                                    <td><?= esc($player['nums']['trainingwins']) ?>/<?= esc($player['nums']['trainings']) ?></td>
                                    <td><?= esc($player['nums']['qualifyingwins']) ?>/<?= esc($player['nums']['qualifyings']) ?></td>
                                    <td><?= esc($player['nums']['racewins']) ?>/<?= esc($player['nums']['races']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>

                    <?php else : ?>
                        <p><?= lang('carrera.noplayers') ?></p>
                    <?php endif ?>

                </div>
            </div>

        </div>
    </div>

</div>