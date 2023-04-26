<div class="container">
    <h1><?= lang('carrera.championship') ?></h1>
    <?php if (count($championships) > 0): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header"><?= lang('carrera.filter') ?></h5>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <select id="playersfilter" name="playersfilter" multiple="multiple" class="form-select">
                                <?php foreach ($players as $player): ?>
                                    <option value="<?= esc($player['id']) ?>"
                                        <?php if (in_array($player['id'], $filter)) echo 'selected'; ?>><?= esc($player['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <br>
                        <button onclick="(function(){
                                var selected = [];
                                for (var option of document.getElementById('playersfilter').options)
                                {
                                    if (option.selected) {
                                        selected.push(option.value);
                                    }
                                }
                                location.href = '<?= base_url('index.php/championship/index') ?>/' + selected.join();
                                return false;
                            })();return false;"
                            id="filterplayer" class="btn btn-primary"><?= lang('carrera.filter') ?></button>
                        <a href="<?= base_url('championship/index') ?>" class="btn btn-outline-dark">
                            <?= lang('carrera.clearfilter') ?>
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php foreach ($championships as $year => $championship): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header"><?= esc($year) ?></h5>
                <div class="card-body">
                    <?php if (! empty($championship['players']) && is_array($championship['players'])) : ?>
                        <table class="table">
                            <tr>
                                <th><?= lang('carrera.pos') ?></th>
                                <th><?= lang('carrera.name') ?></th>
                                <th><?= lang('carrera.username') ?></th>
                                <th><?= lang('carrera.races') ?></th>
                                <th><?= lang('carrera.wins') ?></th>
                                <th><?= lang('carrera.points') ?></th>
                                <th><?= lang('carrera.diff') ?></th>
                            </tr>
                            <script>
                                var lbln = [];
                                var dataw = [];
                                var datap = [];
                            </script>

                            <?php foreach ($championship['players'] as $player): ?>
                                <tr>
                                    <td><?= esc($player['pos']) ?></td>
                                    <td>
                                        <a href="<?= base_url('index.php/players/details/' . esc($player['id'])) ?>">
                                                <?= esc($player['name']) ?>
                                        </a>
                                    </td>
                                    <td><?= esc($player['username']) ?></td>
                                    <td><?= esc($player['races']) ?></td>
                                    <td><?= esc($player['wins']) ?></td>
                                    <td><b><?= esc($player['points']) ?></b></td>
                                    <td><?= esc($player['diff']) ?></td>
                                </tr>
                                <script>
                                    lbln.push("<?= esc($player['name']) ?>");
                                    dataw.push(<?= esc($player['wins']) ?>);
                                    datap.push(<?= esc($player['points']) ?>);
                                </script>
                            <?php endforeach; ?>
                        </table>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <h5 class="card-header"><?= lang('carrera.wins') ?></h5>
                                    <div class="card-body">
                                        <canvas id="wins_chart<?= esc($year) ?>"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <h5 class="card-header"><?= lang('carrera.points') ?></h5>
                                    <div class="card-body">
                                        <canvas id="points_chart<?= esc($year) ?>"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            var ctx = document.getElementById('wins_chart<?= esc($year) ?>');
                            var cChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: lbln,
                                    datasets: [{
                                        data: dataw,
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(153, 102, 255, 0.2)',
                                            'rgba(255, 159, 64, 0.2)'
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)'
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    plugins: {
                                        legend: {
                                            display: false
                                        },
                                        tooltips: {
                                            enabled: false
                                        }
                                    }

                                }
                            });
                            var ctx1 = document.getElementById('points_chart<?= esc($year) ?>');
                            var cChart1 = new Chart(ctx1, {
                                type: 'bar',
                                data: {
                                    labels: lbln,
                                    datasets: [{
                                        data: datap,
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(153, 102, 255, 0.2)',
                                            'rgba(255, 159, 64, 0.2)'
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)'
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    plugins: {
                                        legend: {
                                            display: false
                                        },
                                        tooltips: {
                                            enabled: false
                                        }
                                    }

                                }
                            });
                        </script>
                    <?php else : ?>
                        <p><?= lang('carrera.compnotraining') ?></p>
                    <?php endif ?>

                </div>
            </div>

        </div>
    </div>
    <?php endforeach; ?>
    <?php else: ?>
        <div class="col-md-12">
            <p><?= lang('carrera.nodata'); ?></p>
        </div>
    <?php endif; ?>

</div>