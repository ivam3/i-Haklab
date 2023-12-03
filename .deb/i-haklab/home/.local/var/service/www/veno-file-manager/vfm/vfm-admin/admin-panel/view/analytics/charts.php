<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header">
                <strong><?php print $setUp->getString("main_activities"); ?></strong>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="list-group mb-3" id="mainLegend"></div>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="canvas-holder">
                            <canvas class="chart" id="pie" width="400" height="400"></canvas>
                            <div class="showdata"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="row">
            <?php
            if ($range && $range > 1) { ?>
                <div class="col-12" id="chart-ranger">
                    <div class="card mb-3"> 
                        <div class="card-header with-border">
                            <i class="bi bi-graph-up"></i> 
                            <strong><?php print $setUp->getString("trendline"); ?></strong>
                        </div>
                        <div class="canvas-range-holder">
                            <canvas class="chart" id="ranger" width="800" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <?php
            } else { ?>
            <div class="col-lg-4" id="chart-download">
                <div class="card mb-3">
                    <div class="card-header border-info">
                        <i class="bi bi-download"></i> 
                        <strong><?php print $setUp->getString("downloads"); ?></strong> <span class="num-down"></span>
                    </div>
                    <div class="card-body">
                        <div class="canvas-holder">
                            <canvas class="chart" id="polar-down" width="400" height="400"></canvas>
                            <div class="showdata screen-down"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4" id="chart-upload">
                <div class="card mb-3">
                    <div class="card-header border-success">
                        <i class="bi bi-plus-lg"></i> 
                        <strong><?php print $setUp->getString("add"); ?></strong> <span class="num-up"></span>
                    </div>
                    <div class="card-body">
                        <div class="canvas-holder">
                            <canvas class="chart" id="polar-up" width="400" height="400"></canvas>
                            <div class="showdata screen-up"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4" id="chart-play">
                <div class="card mb-3">
                    <div class="card-header border-warning">
                        <i class="bi bi-play-circle"></i> 
                        <strong><?php print $setUp->getString("play"); ?> <span class="num-play"></span></strong>
                    </div>
                    <div class="card-body">
                        <div class="canvas-holder"> 
                            <canvas class="chart" id="polar-play" width="400" height="400"></canvas>
                            <div class="showdata screen-play"></div>
                        </div>
                    </div>
                </div>
            </div>
                <?php
            } ?>
        </div> <!-- row -->
    </div>
</div> <!-- row -->
