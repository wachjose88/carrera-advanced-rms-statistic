<div class="container">
    <?php if (! empty($competition['title'])) : ?>
        <h1><?= esc($competition['title']) ?></h1>
    <?php else : ?>
        <h1><?= lang('carrera.compnotitle') ?></h1>
    <?php endif ?>

    <ul>
        <li><?= esc($competition['time']) ?></li>
        <li><?= esc($mode) ?></li>
        <?php if (! empty($duration)) : ?>
            <li><?= esc($duration) ?></li>
        <?php endif ?>
        <?php if (! is_null($tracklength)) : ?>
            <li><?= lang('carrera.tracklength') ?>: <?= esc($tracklength) ?> m</li>
        <?php endif ?>
        <?php if (! is_null($complength)) : ?>
            <li><?= lang('carrera.complength') ?>:
                <?= esc($complength) ?> m</li>
        <?php endif ?>
    </ul>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header"><?= lang('carrera.result') ?></h5>
                <div class="card-body">
                    <?php if (! empty($players) && is_array($players)) : ?>
                        <table class="table">
                            <tr>
                                <th><?= lang('carrera.rank') ?></th>
                                <th><?= lang('carrera.name') ?></th>
                                <th><?= lang('carrera.car') ?></th>
                                <?php if ($usebestlap) : ?>
                                    <th><?= lang('carrera.time') ?></th>
                                    <th><?= lang('carrera.laptime') ?></th>
                                <?php else : ?>
                                    <th><?= lang('carrera.laptime') ?></th>
                                    <th><?= lang('carrera.time') ?></th>
                                <?php endif ?>
                                <th><?= lang('carrera.diff') ?></th>
                            </tr>

                            <?php foreach ($players as $player): ?>
                                <tr class="table-active">
                                    <td><?= esc($player['rank']) ?></td>
                                    <td>
                                        <a href="<?= base_url('players/details/' . esc($player['player']['id'])) ?>">
                                            <?= esc($player['player']['name']) ?>
                                            (<?= esc($player['player']['username']) ?>)
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('index.php/cars/details/' . esc($player['car']['id'])) ?>">
                                            <?= esc($player['car']['name']) ?>
                                            (<?= esc($player['car']['number']) ?>)
                                        </a>
                                    </td>
                                    <?php if ($usebestlap) : ?>
                                        <td><?= esc($player['time']) ?></td>
                                        <td><?= esc($player['bestlap']) ?></td>
                                    <?php else : ?>
                                        <td><?= esc($player['bestlap']) ?></td>
                                        <td><?= esc($player['time']) ?></td>
                                    <?php endif ?>
                                    <td><?= esc($player['diff']) ?></td>

                                </tr>
                                <tr>
                                    <th colspan="3" class="text-end">
                                        <?= lang('carrera.speedreal') ?></th>
                                    <?php if ($usebestlap) : ?>
                                        <td><?= esc($player['speedreal']) ?> km/h</td>
                                        <td><?= esc($player['bestlapspeedreal']) ?> km/h</td>
                                    <?php else : ?>
                                        <td><?= esc($player['bestlapspeedreal']) ?> km/h</td>
                                        <td><?= esc($player['speedreal']) ?> km/h</td>
                                    <?php endif ?>
                                </tr>
                                <?php if ($player['car']['scale'] != 0 && !is_null($player['car']['scale'])): ?>
                                    <tr>
                                        <th colspan="3" class="text-end"><?= lang('carrera.speedscaled') ?></th>
                                        <?php if ($usebestlap) : ?>
                                            <td>
                                                <?= esc($player['speedscaled']) ?> km/h
                                            </td>
                                            <td>
                                                <?= esc($player['bestlapspeedscaled']) ?> km/h
                                            </td>
                                        <?php else : ?>
                                            <td>
                                                <?= esc($player['bestlapspeedscaled']) ?> km/h
                                            </td>
                                            <td>
                                                <?= esc($player['speedscaled']) ?> km/h
                                            </td>
                                        <?php endif ?>
                                    </tr>
                                <?php endif ?>
                            <?php endforeach; ?>
                        </table>
                    <?php endif ?>

                </div>
            </div>

        </div>
    </div>

</div>

<?php if (! empty($players) && is_array($players)) : ?>
<?php foreach ($players as $player): ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header"><?= lang('carrera.details') ?>:
                    <?= esc($player['player']['name']) ?>
                    (<?= esc($player['player']['username']) ?>)</h5>
                <div class="card-body">
                        <?php if (! empty($player['laps']) && is_array($player['laps'])) : ?>
                        <table class="table table-hover">
                            <tr>
                                <th><?= lang('carrera.lap') ?></th>
                                <th><?= lang('carrera.time') ?></th>
                                <th><?= lang('carrera.laptime') ?></th>
                                <th><?= lang('carrera.lapspeedreal') ?></th>
                                <?php if ($player['car']['scale'] != 0 && !is_null($player['car']['scale'])): ?>
                                <th><?= lang('carrera.lapspeedscaled') ?></th>
                                <?php endif; ?>
                                <th><?= lang('carrera.fuel') ?></th>
                                <th><?= lang('carrera.pit') ?></th>
                            </tr>
                                <?php $lic = 0; ?>
                                <?php $pits = 0; ?>
                                <?php foreach ($player['laps'] as $lap): ?>
                                <tr>
                                    <td><?= $lic ?></td>
                                    <td><?= esc($lap['timef']) ?></td>
                                    <td><?= esc($lap['laptimef']) ?></td>
                                    <td><?= esc($lap['lapspeedreal']) ?> km/h</td>

                                    <?php if ($player['car']['scale'] != 0 && !is_null($player['car']['scale'])): ?>
                                        <td><?= esc($lap['lapspeedscaled']) ?> km/h</td>
                                    <?php endif; ?>
                                    <td><?= esc($lap['fuelinp']) ?>%</td>
                                    <?php if ($lap['pit'] == 0) : ?>
                                        <td><?= lang('carrera.out') ?></td>
                                    <?php else : ?>
                                        <td><?= lang('carrera.in') ?></td>
                                        <?php $pits++; ?>
                                    <?php endif ?>
                                </tr>
                                <?php $lic++; ?>
                                <?php endforeach; ?>
                            <tr>
                                <th><?= lang('carrera.sums') ?></th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th><?= esc($player['speedreal']); ?> km/h</th>
                                <?php if ($player['car']['scale'] != 0 && !is_null($player['car']['scale'])): ?>
                                    <th><?= esc($player['speedscaled']); ?> km/h</th>
                                <?php endif ?>
                                <th>&nbsp;</th>
                                <th><?= $pits ?></th>
                            </tr>
                        </table>
                    <?php endif ?>
                </div>
            </div>

        </div>
    </div>

</div>
<?php endforeach; ?>
<?php endif ?>