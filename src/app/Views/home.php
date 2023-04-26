<div class="container">
    <h1><?= lang('carrera.home') ?></h1>
    <div class="row">
        <?php if (!($numtrainings == 0 && $numqualifyings == 0 && $numraces == 0)): ?>
        <div class="col-md-4">
            <div class="card">
                <h5 class="card-header"><?= lang('carrera.numcompetitions') ?></h5>
                <div class="card-body">
                    <canvas id="competitions_chart"></canvas>
                </div>
            </div>

        </div>
        <?php else: ?>
            <div class="col-md-12">
                <p><?= lang('carrera.nodata'); ?></p>
            </div>
        <?php endif; ?>
        <?php $sitebanner = \App\Controllers\BaseController::getGlobals()['sitebanner'];
        if (!is_null($sitebanner)):
        ?>
        <div class="col-md-4">
            <div class="card">
                <h5 class="card-header"><?= $sitetitle ?></h5>
                <div class="card-body">
                    <?php if (!is_null($tracklength)): ?>
                    <p><?= lang('carrera.tracklength'); ?>: <?= esc($tracklength); ?> m</p>
                    <?php endif; ?>
                    <img src="<?= base_url(
                            'uploads/config/' . $sitebanner) ?>"
                         class="img-fluid">
                </div>
            </div>

        </div>
        <?php endif; ?>
        <?php if (count($wins) > 0): ?>
        <div class="col-md-4">
            <div class="card">
                <h5 class="card-header"><?= lang('carrera.numwins') ?></h5>
                <div class="card-body">
                    <canvas id="wins_chart"></canvas>
                </div>
            </div>

        </div>
        <?php endif; ?>
    </div>

    <script>
        <?php if (!($numtrainings == 0 && $numqualifyings == 0 && $numraces == 0)): ?>
        var ctx = document.getElementById('competitions_chart');
        var cChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['<?= lang('carrera.trainings') ?>',
                    '<?= lang('carrera.qualifyings') ?>', '<?= lang('carrera.races') ?>'],
                datasets: [{
                    label: '<?= lang('carrera.numcompetitions') ?>',
                    data: [<?= $numtrainings ?>, <?= $numqualifyings ?>, <?= $numraces ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            }
        });
        <?php endif; ?>

        <?php if (count($wins) > 0): ?>
        var wtx = document.getElementById('wins_chart');
        var lblw = [
            <?php foreach ($wins as $win): ?>
            '<?= esc($win['player']['name']) ?>',
            <?php endforeach; ?>
        ];
        var dataw = [
            <?php foreach ($wins as $win): ?>
            '<?= esc($win['id']) ?>',
            <?php endforeach; ?>
        ];
        var wChart = new Chart(wtx, {
            type: 'pie',
            data: {
                labels: lblw,
                datasets: [{
                    label: '<?= lang('carrera.numwins') ?>',
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
            }
        });
        <?php endif; ?>
    </script>

</div>