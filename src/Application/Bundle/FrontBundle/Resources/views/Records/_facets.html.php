<form id='formSearch' name='formSearch' method='post'>
    <nav id="facet_sidebar" class="sidebar light">

        <ul>
            <?php $facetData = $app->getSession()->get('facetData');
            ?>
            <li class="title">Filters</li>
            <?php if ($facetData): ?>
                <li>
                    <?php
                    if (isset($facetData['mediaType']) && $facetData['mediaType'] != '') {
                        ?>
                        <div id="mediaType_main" class="chekBoxFacet">
                            <div class="filter-fileds"><b>Media Type</b></div>
                            <?php
                            foreach ($facetData['mediaType'] as $value) {
                                $id = time() . rand(0, 1000);
                                ?>
                                <div class="btn-img" id="facet_media_<?php echo $id; ?>" ><span class="search_keys"><?php echo html_entity_decode($value); ?></span><i class="icon-remove delFilter" style="float: right;cursor: pointer;" data-elementId="<?php echo 'mediaType_' . str_replace(' ', '_', strtolower($value)); ?>" data-type="mediaType"></i></div>
                            <?php } ?>
                        </div>
                    <div class="clearfix"></div>
                    
                        <?php } ?>                      
                    <?php
                    if (isset($facetData['format']) && $facetData['format'] != '') {
                        ?>
                        <div id="mediaType_main" class="chekBoxFacet">
                            <div class="filter-fileds"><b>Format</b></div>
                            <?php
                            foreach ($facetData['format'] as $value) {
                                $id = time() . rand(0, 1000);
                                ?>
                                <div class="btn-img" id="facet_media_<?php echo $id; ?>" ><span class="search_keys"><?php echo html_entity_decode($value); ?></span><i class="icon-cancel delFilter" style="float: right;cursor: pointer;" data-elementId="<?php echo 'format_' . str_replace(' ', '_', strtolower($value)); ?>" data-type="format"></i></div>
                            <?php } ?>
                        </div>
                    <div class="clearfix"></div><br />
                        <?php } ?>  
                    <?php
                    if (isset($facetData['commercial']) && $facetData['commercial'] != '') {
                        ?>
                        <div id="mediaType_main" class="chekBoxFacet">
                            <div class="filter-fileds"><b>Commercial / Unique</b></div>
                            <?php
                            foreach ($facetData['commercial'] as $value) {
                                $id = time() . rand(0, 1000);
                                ?>
                                <div class="btn-img" id="facet_media_<?php echo $id; ?>" ><span class="search_keys"><?php echo html_entity_decode($value); ?></span><i class="icon-remove delFilter" style="float: right;cursor: pointer;" data-elementId="<?php echo 'commercial_' . str_replace(' ', '_', strtolower($value)); ?>" data-type="commercial"></i></div>
                            <?php } ?>
                        </div>
                    <div class="clearfix"></div><br />
                        <?php } ?>  
                    <?php
                    if (isset($facetData['base']) && $facetData['base'] != '') {
                        ?>
                        <div id="mediaType_main" class="chekBoxFacet">
                            <div class="filter-fileds"><b>Base</b></div>
                            <?php
                            foreach ($facetData['base'] as $value) {
                                $id = time() . rand(0, 1000);
                                ?>
                                <div class="btn-img" id="facet_media_<?php echo $id; ?>" ><span class="search_keys"><?php echo html_entity_decode($value); ?></span><i class="icon-remove delFilter" style="float: right;cursor: pointer;" data-elementId="<?php echo 'base_' . str_replace(' ', '_', strtolower($value)); ?>" data-type="base"></i></div>
                            <?php } ?>
                        </div>
                    <div class="clearfix"></div><br />
                        <?php } ?>  
                    <?php
                    if (isset($facetData['collectionName']) && $facetData['collectionName'] != '') {
                        ?>
                        <div id="mediaType_main" class="chekBoxFacet">
                            <div class="filter-fileds"><b>Collection Name</b></div>
                            <?php
                            foreach ($facetData['collectionName'] as $value) {
                                $id = time() . rand(0, 1000);
                                ?>
                                <div class="btn-img" id="facet_media_<?php echo $id; ?>" ><span class="search_keys"><?php echo html_entity_decode($value); ?></span><i class="icon-remove delFilter" style="float: right;cursor: pointer;" data-elementId="<?php echo 'collectionName_' . str_replace(' ', '_', strtolower($value)); ?>" data-type="collectionName"></i></div>
                            <?php } ?>
                        </div>
                    <div class="clearfix"></div><br />
                        <?php } ?>
                    <?php
                    if (isset($facetData['recordingStandard']) && $facetData['recordingStandard'] != '') {
                        ?>
                        <div id="mediaType_main" class="chekBoxFacet">
                            <div class="filter-fileds"><b>Recording Standard</b></div>
                            <?php
                            foreach ($facetData['recordingStandard'] as $value) {
                                $id = time() . rand(0, 1000);
                                ?>
                                <div class="btn-img" id="facet_media_<?php echo $id; ?>" ><span class="search_keys"><?php echo html_entity_decode($value); ?></span><i class="icon-remove delFilter" style="float: right;cursor: pointer;" data-elementId="<?php echo 'recordingStandard_' . str_replace(' ', '_', strtolower($value)); ?>" data-type="recordingStandard"></i></div>
                            <?php } ?>
                        </div>
                    <div class="clearfix"></div><br />
                        <?php } ?>
                    <?php
                    if (isset($facetData['printType']) && $facetData['printType'] != '') {
                        ?>
                        <div id="mediaType_main" class="chekBoxFacet">
                            <div class="filter-fileds"><b>Print Type</b></div>
                            <?php
                            foreach ($facetData['printType'] as $value) {
                                $id = time() . rand(0, 1000);
                                ?>
                                <div class="btn-img" id="facet_media_<?php echo $id; ?>" ><span class="search_keys"><?php echo html_entity_decode($value); ?></span><i class="icon-remove delFilter" style="float: right;cursor: pointer;" data-elementId="<?php echo 'printType_' . str_replace(' ', '_', strtolower($value)); ?>" data-type="printType"></i></div>
                            <?php } ?>
                        </div>
                    <div class="clearfix"></div><br />
                        <?php } ?>  
                    <?php
                    if (isset($facetData['project']) && $facetData['project'] != '') {
                        ?>
                        <div id="mediaType_main" class="chekBoxFacet">
                            <div class="filter-fileds"><b>Project</b></div>
                            <?php
                            foreach ($facetData['project'] as $value) {
                                $id = time() . rand(0, 1000);
                                ?>
                                <div class="btn-img" id="facet_media_<?php echo $id; ?>" ><span class="search_keys"><?php echo html_entity_decode($value); ?></span><i class="icon-remove delFilter" style="float: right;cursor: pointer;" data-elementId="<?php echo 'project_' . str_replace(' ', '_', strtolower($value)); ?>" data-type="project"></i></div>
                            <?php } ?>
                        </div>
                    <div class="clearfix"></div><br />
                        <?php } ?>  
                    <?php
                    if (isset($facetData['reelDiameter']) && $facetData['reelDiameter'] != '') {
                        ?>
                        <div id="mediaType_main" class="chekBoxFacet">
                            <div class="filter-fileds"><b>Reel Diameter</b></div>
                            <?php
                            foreach ($facetData['reelDiameter'] as $value) {
                                $id = time() . rand(0, 1000);
                                ?>
                                <div class="btn-img" id="facet_media_<?php echo $id; ?>" ><span class="search_keys"><?php echo html_entity_decode($value); ?></span><i class="icon-remove delFilter" style="float: right;cursor: pointer;" data-elementId="<?php echo 'reelDiameter_' . str_replace(' ', '_', strtolower($value)); ?>" data-type="reelDiameter"></i></div>
                            <?php } ?>
                        </div>
                    <div class="clearfix"></div><br />
                        <?php } ?>
                    <?php
                    if (isset($facetData['discDiameter']) && $facetData['discDiameter'] != '') {
                        ?>
                        <div id="mediaType_main" class="chekBoxFacet">
                            <div class="filter-fileds"><b>Disc Diameter</b></div>
                            <?php
                            foreach ($facetData['discDiameter'] as $value) {
                                $id = time() . rand(0, 1000);
                                ?>
                                <div class="btn-img" id="facet_media_<?php echo $id; ?>" ><span class="search_keys"><?php echo html_entity_decode($value); ?></span><i class="icon-remove delFilter" style="float: right;cursor: pointer;" data-elementId="<?php echo 'discDiameter_' . str_replace(' ', '_', strtolower($value)); ?>" data-type="discDiameter"></i></div>
                            <?php } ?>
                        </div>
                    <div class="clearfix"></div><br />
                        <?php } ?>
                    <?php
                    if (isset($facetData['acidDetection']) && $facetData['acidDetection'] != '') {
                        ?>
                        <div id="mediaType_main" class="chekBoxFacet">
                            <div class="filter-fileds"><b>Acid Detection</b></div>
                            <?php
                            foreach ($facetData['acidDetection'] as $value) {
                                $id = time() . rand(0, 1000);
                                ?>
                                <div class="btn-img" id="facet_media_<?php echo $id; ?>" ><span class="search_keys"><?php echo html_entity_decode($value); ?></span><i class="icon-remove delFilter" style="float: right;cursor: pointer;" data-elementId="<?php echo 'acidDetection_' . str_replace(' ', '_', strtolower($value)); ?>" data-type="acidDetection"></i></div>
                            <?php } ?>
                        </div>
                    <div class="clearfix"></div><br />
                        <?php } ?>
                    <div class="clearfix"></div>
                </li>
                <?php endif; ?>
            <li>
                <a class="dropdown-toggle" href="#">Keyword</a>
                <div data-role="dropdown" class="chekBoxFacet">
                    <div data-role="input-control" class="input-control text">
                        <input type="text" id="keywordSearch" value="" />
                    </div>
                    <div class="button-dropdown">
                        <button type="button" class="dropdown-toggle">
                            <span id="limit_field_text">Search</span>
                        </button>
                        <ul class="dropdown-menu" data-role="dropdown">
                            <li><a href="javascript://;" class="customToken" data-fieldName="Title"  data-columnName="title" style="font-size: 14px!important;">Title</a></li>
                            <li><a href="javascript://;" class="customToken" data-fieldName="Description"  data-columnName="description" style="font-size: 14px!important;">Description</a></li>
                            <li><a href="javascript://;" class="customToken" data-fieldName="Collection Name"  data-columnName="collection_name" style="font-size: 14px!important;">Collection Name</a></li>
                            <li><a href="javascript://;" class="customToken" data-fieldName="Creation Date"  data-columnName="creation_date" style="font-size: 14px!important;">Creation Data</a></li>
                            <li><a href="javascript://;" class="customToken" data-fieldName="Content Date"  data-columnName="content_date" style="font-size: 14px!important;">Content Date</a></li>
                            <li><a href="javascript://;" class="customToken" data-fieldName="Genre Terms"  data-columnName="genre_terms" style="font-size: 14px!important;">Genre Terms</a></li>
                            <li><a href="javascript://;" class="customToken" data-fieldName="Contributor"  data-columnName="contributor" style="font-size: 14px!important;">Contributor</a></li>
                        </ul>
                    </div> <br /><br />
                    <div class="button primary" id="addKeyword">Add Keyword</div>
                </div>
            </li>
<?php if (count($facets['mediaType']) > 0): ?>
                <li>
                    <a class="dropdown-toggle" href="#">Media Type</a>
                    <ul data-role="dropdown" <?php echo isset($facetData['mediaType']) ? 'style="display:block"' : 'style="display:none"'; ?>>
    <?php foreach ($facets['mediaType'] as $mediaType): ?>
                            <li><a href="javascript://"><label for="<?php echo 'mediaType_'.str_replace(' ', '_', strtolower($mediaType['media_type'])) ?>"><input id='<?php echo 'mediaType_'.str_replace(' ', '_', strtolower($mediaType['media_type'])) ?>' <?php echo (isset($facetData['mediaType']) && in_array($mediaType['media_type'], $facetData['mediaType'])) ? 'checked="checked"' : '' ?> type="checkbox" class="facet_checkbox" name="mediaType[]" value="<?php echo $mediaType['media_type'] ?>" /><?php echo $mediaType['media_type'] ?> (<?php echo $mediaType['total'] ?>)</label></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
<?php endif; ?>
            <?php if (count($facets['formats']) > 0): ?>
                <li>
                    <a class="dropdown-toggle" href="#">Format</a>
                    <ul data-role="dropdown" <?php if (isset($facetData['format'])): ?> style="display:block" <?php endif; ?>>
    <?php foreach ($facets['formats'] as $format): ?>
                            <li><a href="javascript://"><label for="<?php echo 'format_'.str_replace(' ', '_', strtolower($format['format'])) ?>"><input id='<?php echo 'format_'.str_replace(' ', '_', strtolower($format['format'])) ?>' <?php echo (isset($facetData['format']) && in_array($format['format'], $facetData['format'])) ? 'checked="checked"' : '' ?> type="checkbox" class="facet_checkbox" name="format[]" value="<?php echo $format['format'] ?>" /><?php echo $format['format'] ?> (<?php echo $format['total'] ?>)</label></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
<?php endif; ?>
            <?php if (count($facets['commercialUnique']) > 0): ?>
                <li>
                    <a class="dropdown-toggle" href="#">Commercial/Unique</a>
                    <ul  data-role="dropdown" <?php if (isset($facetData['commercial'])): ?> style="display:block" <?php endif; ?>>
    <?php foreach ($facets['commercialUnique'] as $cOrU): ?>
                            <?php if ($cOrU['commercial'] != ''): ?>
                                <li><a href="javascript://"><label for="<?php echo 'commercial_'.str_replace(' ', '_', strtolower($cOrU['commercial'])) ?>"><input id='<?php echo 'commercial_'.str_replace(' ', '_', strtolower($cOrU['commercial'])) ?>' <?php echo (isset($facetData['commercial']) && in_array($cOrU['commercial'], $facetData['commercial'])) ? 'checked="checked"' : '' ?> type="checkbox" class="facet_checkbox" name="commercial[]" value="<?php echo $cOrU['commercial'] ?>" /><?php echo $cOrU['commercial'] ?> (<?php echo $cOrU['total'] ?>)</label></a></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </li>
<?php endif; ?>
            <?php if (count($facets['bases']) > 0): ?>
                <li>
                    <a class="dropdown-toggle" href="#">Base</a>
                    <ul  data-role="dropdown" <?php if (isset($facetData['base'])): ?> style="display:block" <?php endif; ?>>
    <?php foreach ($facets['bases'] as $base): ?>
                            <?php if ($base['base'] != ''): ?>
                                <li><a href="javascript://"><label for="<?php echo 'base_'.str_replace(' ', '_', strtolower($base['base'])) ?>"><input id='<?php echo 'base_'.str_replace(' ', '_', strtolower($base['base'])) ?>' <?php echo (isset($facetData['base']) && in_array($base['base'], $facetData['base'])) ? 'checked="checked"' : '' ?> type="checkbox" class="facet_checkbox" name="base[]" value="<?php echo $base['base'] ?>" /><?php echo $base['base'] ?> (<?php echo $base['total'] ?>)</label></a></li>
                            <?php endif ?>
                        <?php endforeach ?>
                    </ul>
                </li>
<?php endif; ?>
            <?php if (count($facets['collectionNames']) > 0): ?>
                <li>
                    <a class="dropdown-toggle" href="#">Collection Name</a>
                    <ul  data-role="dropdown" <?php if (isset($facetData['collectionName'])): ?> style="display:block" <?php endif ?>>
    <?php foreach ($facets['collectionNames'] as $collectionName): ?>
                            <?php if ($collectionName['collection_name'] != ''): ?>
                                <li><a href="javascript://"><label for="<?php echo 'collectionName_'.str_replace(' ', '_', strtolower($collectionName['collection_name'])) ?>"><input id='<?php echo 'collectionName_'.str_replace(' ', '_', strtolower($collectionName['collection_name'])) ?>' <?php echo (isset($facetData['collectionName']) && in_array($collectionName['collection_name'], $facetData['collectionName'])) ? 'checked="checked"' : '' ?> type="checkbox" class="facet_checkbox" name="collectionName[]" value="<?php echo $collectionName['collection_name'] ?>" /><?php echo $collectionName['collection_name'] ?> (<?php echo $collectionName['total'] ?>)</label></a></li>
                            <?php endif ?>
                        <?php endforeach ?>
                    </ul>
                </li>
<?php endif; ?>
            <?php if (count($facets['recordingStandards']) > 0): ?>
                <li>
                    <a class="dropdown-toggle" href="#">Recording Standard</a>
                    <ul  data-role="dropdown" <?php if (isset($facetData['recordingStandard'])): ?> style="display:block" <?php endif ?>>
    <?php foreach ($facets['recordingStandards'] as $recordingStandard): ?>
                            <?php if ($recordingStandard['recording_standard'] != ''): ?>
                                <li><a href="javascript://"><label for="<?php echo 'recordingStandard_'.str_replace(' ', '_', strtolower($recordingStandard['recording_standard'])) ?>"><input id='<?php echo 'recordingStandard_'.str_replace(' ', '_', strtolower($recordingStandard['recording_standard'])) ?>' <?php echo (isset($facetData['recordingStandard']) && in_array($recordingStandard['recording_standard'], $facetData['recordingStandard'])) ? 'checked="checked"' : '' ?> type="checkbox" class="facet_checkbox" name="recordingStandard[]" value="<?php echo $recordingStandard['recording_standard'] ?>" /><?php echo $recordingStandard['recording_standard'] ?> (<?php echo $recordingStandard['total'] ?>)</label></a></li>
                            <?php endif ?>
                        <?php endforeach; ?>
                    </ul>
                </li>
<?php endif; ?>
            <?php if (count($facets['printTypes']) > 0): ?>
                <li>
                    <a class="dropdown-toggle" href="#">Print Type</a>
                    <ul  data-role="dropdown" <?php if (isset($facetData['printType'])): ?> style="display:block" <?php endif ?>>
    <?php foreach ($facets['printTypes'] as $printType): ?>
                            <?php if ($printType['print_type']): ?>
                                <li><a href="javascript://"><label for="<?php echo 'printType_'.str_replace(' ', '_', strtolower($printType['print_type'])) ?>"><input id='<?php echo 'printType_'.str_replace(' ', '_', strtolower($printType['print_type'])) ?>' <?php echo (isset($facetData['printType']) && in_array($printType['print_type'], $facetData['printType'])) ? 'checked="checked"' : '' ?> type="checkbox" class="facet_checkbox" name="printType[]" value="<?php echo $printType['print_type'] ?>" /><?php echo $printType['print_type'] ?> (<?php echo $printType['total'] ?>)</label></a></li>
                            <?php endif ?>
                        <?php endforeach ?>
                    </ul>
                </li>
<?php endif; ?>
            <?php if (count($facets['projectNames']) > 0): ?>
                <li>
                    <a class="dropdown-toggle" href="#">Project Name</a>
                    <ul  data-role="dropdown" <?php if (isset($facetData['project'])): ?> style="display:block" <?php endif ?>>
    <?php foreach ($facets['projectNames'] as $projectName): ?>
                            <?php if ($projectName['project']): ?>
                                <li><a href="javascript://"><label for="<?php echo 'project_'.str_replace(' ', '_', strtolower($projectName['project'])) ?>"><input id='<?php echo 'project_'.str_replace(' ', '_', strtolower($projectName['project'])) ?>' <?php echo (isset($facetData['project']) && in_array($projectName['project'], $facetData['project'])) ? 'checked="checked"' : '' ?> type="checkbox" class="facet_checkbox" name="project[]" value="<?php echo $projectName['project'] ?>" /><?php echo $projectName['project'] ?> (<?php echo $projectName['total'] ?>)</label></a></li>
                            <?php endif ?>
                        <?php endforeach; ?>
                    </ul>
                </li>
<?php endif; ?>
            <?php if (count($facets['reelDiameters']) > 0): ?>
                <li>
                    <a class="dropdown-toggle" href="#">Reel Diameter</a>
                    <ul  data-role="dropdown" <?php if (isset($facetData['reelDiameter'])): ?> style="display:block" <?php endif ?>>
    <?php foreach ($facets['reelDiameters'] as $reelDiameter): ?>
                            <?php if ($reelDiameter['reel_diameter']): ?>
                                <li><a href="javascript://"><label for="<?php echo 'reelDiameter_'.str_replace(' ', '_', strtolower($reelDiameter['reel_diameter'])) ?>"><input id='<?php echo 'reelDiameter_'.str_replace(' ', '_', strtolower($reelDiameter['reel_diameter'])) ?>' <?php echo (isset($facetData['reelDiameter']) && in_array($reelDiameter['reel_diameter'], $facetData['reelDiameter'])) ? 'checked="checked"' : '' ?> type="checkbox" class="facet_checkbox" name="reelDiameter[]" value="<?php echo $reelDiameter['reel_diameter'] ?>" /><?php echo $reelDiameter['reel_diameter'] ?> (<?php echo $reelDiameter['total'] ?>)</label></a></li>
                            <?php endif ?>
                        <?php endforeach ?>
                    </ul>
                </li>
<?php endif; ?>
            <?php if (count($facets['discDiameters']) > 0): ?>
                <li>
                    <a class="dropdown-toggle" href="#">Disc Diameter</a>
                    <ul  data-role="dropdown" <?php if (isset($facetData['discDiameter'])): ?> style="display:block" <?php endif ?>>
    <?php foreach ($facets['discDiameters'] as $discDiameter): ?>
                            <?php if ($discDiameter['disk_diameter'] != ''): ?>
                                <li><a href="javascript://"><label for="<?php echo 'diskDiameter_'.str_replace(' ', '_', strtolower($discDiameter['disk_diameter'])) ?>"><input id='<?php echo 'diskDiameter_'.str_replace(' ', '_', strtolower($discDiameter['disk_diameter'])) ?>' <?php echo (isset($facetData['discDiameter']) && in_array($discDiameter['disk_diameter'], $facetData['discDiameter'])) ? 'checked="checked"' : '' ?> type="checkbox" class="facet_checkbox" name="discDiameter[]" value="<?php echo $discDiameter['disk_diameter'] ?>" /><?php echo $discDiameter['disk_diameter'] ?> (<?php echo $discDiameter['total'] ?>)</label></a></li>
                            <?php endif ?>
                        <?php endforeach; ?>
                    </ul>
                </li>
<?php endif; ?>
            <?php if (count($facets['acidDetection']) > 0): ?>
                <li>
                    <a class="dropdown-toggle" href="#">Acid Detection Strip</a>
                    <ul  data-role="dropdown" <?php if (isset($facetData['acidDetection'])): ?> style="display:block" <?php endif ?>>
    <?php foreach ($facets['acidDetection'] as $strip): ?>
                            <?php if ($strip['acid_detection']): ?>
                                <li><a href="javascript://"><label for="<?php echo 'acidDetection_'.str_replace(' ', '_', strtolower($strip['acid_detection'])) ?>"><input id='<?php echo 'acidDetection_'.str_replace(' ', '_', strtolower($strip['acid_detection'])) ?>' <?php echo (isset($facetData['acidDetection']) && in_array($strip['acid_detection'], $facetData['acidDetection'])) ? 'checked="checked"' : '' ?> type="checkbox" class="facet_checkbox" name="acidDetection[]" value="<?php echo $strip['acid_detection'] ?>" /><?php echo $strip['acid_detection'] ?> (<?php echo $strip['total'] ?>)</label></a></li>
                            <?php endif ?>
                        <?php endforeach; ?>
                    </ul>
                </li>
<?php endif; ?>
            <li class="chekBoxFacet">
                <span id="is_review_check" style="cursor: default;">
<?php $review_check = 0 ?>
                    <?php if (isset($facetData['is_review'])): ?>
                        <?php $review_check = $facetData['is_review'] ?>
                    <?php endif; ?>
                    <input type="hidden" id="is_review_check_state" name="is_review_check" value="<?php echo $review_check ?>" <?php echo (isset($facetData['is_review']) && $facetData['is_review'] == $review_check) ? 'checked="checked"' : '' ?> />
                </span>
                Review
            </li>
        </ul>
    </nav>
<?php
$parentFacet = '';
$totalChecked = 0;
$keyword = "";
if (isset($facetData['parent_facet']) && !empty($facetData['parent_facet'])):
    $parentFacet = $facetData['parent_facet'];
endif;
if (isset($facetData['total_checked']) && !empty($facetData['total_checked'])):
    $totalChecked = $facetData['total_checked'];
endif;
if (isset($facetData['facet_keyword_search']) && !empty($facetData['facet_keyword_search'])):
    $keyword = $facetData['facet_keyword_search'];
endif;
?>
    <input type="hidden" value="<?php echo $parentFacet; ?>" name="parent_facet" id="parent_facet" />
    <input type="hidden" value="<?php echo $totalChecked; ?>" name="total_checked" id="total_checked"/>
    <input type="hidden" value="<?php echo $keyword; ?>" name="facet_keyword_search" id="facet_keyword_search"/>
</form>


