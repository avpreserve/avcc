<?php if (!$isAjax): ?>
    <?php $view->extend('FOSUserBundle::layout.html.php') ?>
    <?php $view['slots']->start('body') ?>
    <div class="grid">
        <div class="row" id="recordsContainer">
    <?php endif; ?>
        <div class="span3">
            <?php echo $view->render('ApplicationFrontBundle::Records/_facets.html.php', array('facets' => $facets)) ?>
        </div>
        <div class="span9">
            <div class="button-dropdown place-left">
                <button class="dropdown-toggle">Operations</button>
                <ul class="dropdown-menu" data-role="dropdown">

                    <li>
                        <a class="dropdown-toggle" href="#">Add Record</a>
                        <ul class="dropdown-menu" data-role="dropdown">
                            <li><a  href="<?php echo $view['router']->generate('record_new') ?>">Audio</a></li>
                            <li> <a  href="<?php echo $view['router']->generate('record_film_new') ?>">Film</a></li>
                            <li><a  href="<?php echo $view['router']->generate('record_video_new') ?>">Video</a></li>
                        </ul>
                    </li>


                </ul>
            </div>



            <div>
                <table class="table hovered bordered" id="records">
                    <thead>
                        <tr>
                            <?php foreach ($columns as $column => $value) { ?>
                                <?php if ($column == 'checkbox_Col') { ?>
                                    <th id="<?php echo $value ?>"><input type="checkbox" name="selectAll" /></th> 
                                <?php } else { ?>      
                                    <th id="<?php echo $value ?>"><?php echo str_replace('_', ' ', $column) ?></th>
                                <?php } ?>      
                            <?php } ?>                                               
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <?php $view['slots']->start('view_javascripts') ?>
            <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.js"></script>
            <script type="text/javascript" src="<?php echo $view['assets']->getUrl('js/records.js') ?>"></script> 

            <script type="text/javascript">
                $(window).load(function () {
                    var record = new Records();
                    record.setAjaxSource('<?php echo $view['router']->generate('record_dataTable') ?>');
                    record.initDataTable();
                });


            </script>
            <?php
            $view['slots']->stop();
            ?>

        </div>    
    <?php if (!$isAjax): ?>    
        </div>      
    </div>
    <?php
    $view['slots']->stop();
    ?>
    <?php
endif;
?>