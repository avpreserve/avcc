<div id="bulkEdit" class="">
    <div id="editProcessing"></div>
    <form method="post" name="frmBulkEdit" action="" id="frmBulkEdit">
        <div class="bulkEditFields mCustomScrollbar" style="height: 390px;">  
            <input type="hidden" name="records" id="records" value="<?php echo $selectedrecords; ?>"/>
            <?php $isMediaDisable = $disableFields['mediaType']; ?>
            <?php $isFormatDisable = $disableFields['format']; ?>
            <input type="hidden" name="mediaDisable" id="mediaDisable" value="<?php echo $isMediaDisable; ?>"/>
            <input type="hidden" name="formatDisable" id="formatDisable" value="<?php echo $isFormatDisable; ?>"/>
            <input type="hidden" name="mediaTypeId" id="mediaTypeId" value="<?php echo $mediaTypeId; ?>"/>
            <div id="bulk_process">
                <div class="modal-body" id="bulk_edit_body" style="font-size: 12px;">
                    <fieldset>
                        <div id="mediatype_lbl" class="col-lg-6" style="">
                            <label for="mediaType" class="required">Media Type</label>
                            <div data-role="input-control" class="input-control">
                                <?php // $selected?>
                                <select class="size4 disabled" name="mediaType" id="mediaType" disabled="disabled">
                                    <?php foreach ($relatedFields['mediaTypes'] as $mediaType) { ?>
                                        <option value="<?php echo $mediaType->getId(); ?>"><?php echo $mediaType->getName() ?></option>
                                    <?php } ?>
                                </select> 
                            </div>
                        </div>
                        <div id="format_lbl" class="col-lg-6" style="">
                            <label for="format" >Format</label>
                            <div data-role="input-control" class="input-control">
                                <select class="size4" name="format" id="format" <?php echo ($isMediaDisable) ? 'disabled="disabled"' : ''; ?>>
                                    <option value=""></option>                                    
                                </select> 
                            </div>
                        </div>
                        <div id="project_lbl" class="col-lg-6" style="">
                            <label for="project">Project Name</label>
                            <div data-role="input-control" class="input-control">
                                <select class="size4" name="project" id="project">
                                    <option value=""></option>
                                    <?php foreach ($relatedFields['projects'] as $project) { ?>
                                        <option value="<?php echo $project->getId(); ?>"><?php echo $project->getName() ?></option>
                                    <?php } ?>
                                </select>                                                       
                            </div>
                        </div>
                        <div id="location_lbl" class="col-lg-6" style="">
                            <label for="location" >Location</label> 
                            <div data-role="input-control" class="input-control">
                                <input type="text" class="size4" name="location" id="location">                                
                            </div>
                        </div>
                        <div id="title_lbl" class="col-lg-6" style="">
                            <label for="title" class="required">Title</label>
                            <div data-role="input-control" class="input-control">
                                <input type="text" class="size4" name="title" id="title">                                
                            </div>
                        </div>
                        <div id="collectionName_lbl" class="col-lg-6" style="">
                            <label for="collectionName">Collection Name</label>
                            <div data-role="input-control" class="input-control">
                                <input type="text" class="size4" name="collectionName" id="collectionName">                                
                            </div>
                        </div>
                        <div id="description_lbl" class="col-lg-6" style="">
                            <label for="description">Description</label>
                            <div data-role="input-control" class="input-control">
                                <input type="text" class="size4" name="description" id="description">                                
                            </div>
                        </div>
                        <div id="commercial_lbl" class="col-lg-6" style="">
                            <label for="commercial">Commercial</label>
                            <div data-role="input-control" class="input-control">
                                <select class="size4" name="commercial" id="commercial">
                                    <option value=""></option>
                                    <?php foreach ($relatedFields['commercial'] as $commercial) { ?>
                                        <option value="<?php echo $commercial->getId(); ?>"><?php echo $commercial->getName() ?></option>
                                    <?php } ?>
                                </select>                                                       
                            </div>
                        </div>                    
                        <?php
                        if (!$isMediaDisable) {
                            if ($mediaTypeId == 1) {
                                ?>
                                <div id="diskDiameters_lbl" class="col-lg-6" style="display: block;">
                                    <label for="diskDiameters">Disk Diameter</label>
                                    <div data-role="input-control" class="input-control">
                                        <select class="size4" name="diskDiameters" id="diskDiameters">
                                            <option value=""></option>
                                            <?php foreach ($relatedFields['diskDiameters'] as $diskDiameter) { ?>
                                                <option value="<?php echo $diskDiameter->getId(); ?>"><?php echo $diskDiameter->getName() ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div id="reelDiameters_lbl" class="col-lg-6" style="display: block;">
                                    <label for="reelDiameters">Reel Diameter </label>               
                                    <div data-role="input-control" class="input-control">
                                        <select class="size4" name="reelDiameters" id="reelDiameters">
                                            <?php foreach ($relatedFields['reelDiameters'] as $reelDiameter) { ?>
                                                <option value="<?php echo $reelDiameter->getId(); ?>"><?php echo $reelDiameter->getName() ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div id="mediaDiameters_lbl" class="col-lg-6" style="display: block;">
                                    <label for="mediaDiameters">Media Diameter</label>
                                    <div data-role="input-control" class="input-control">
                                        <select class="size4" name="mediaDiameters" id="mediaDiameters">
                                            <?php foreach ($relatedFields['mediaDiameters'] as $mediaDiameter) { ?>
                                                <option value="<?php echo $mediaDiameter->getId(); ?>"><?php echo $mediaDiameter->getName() ?></option>
                                            <?php } ?>                                      
                                        </select>                                            
                                    </div>
                                </div>
                                <div id="bases_lbl" class="col-lg-6" style="display: block;">
                                    <label for="bases">Base</label>
                                    <div data-role="input-control" class="input-control">
                                        <select class="size4" name="bases" id="bases"> 
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div id="mediaDuration_lbl" class="col-lg-6" style="">
                                    <label for="mediaDuration">Media Duration</label> 
                                    <div data-role="input-control" class="input-control">
                                        <input type="text" class="size4" name="mediaDuration" id="mediaDuration"> 
                                    </div>
                                </div>
                                <div id="recordingSpeed_lbl" class="col-lg-6" style="display: block;">
                                    <label for="recordingSpeed">Recording Speed</label>
                                    <div data-role="input-control" class="input-control">
                                        <select class="size4" name="recordingSpeed" id="recordingSpeed">  
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div id="tapeThickness_lbl" class="col-lg-6" style="display: block;">
                                    <label for="tapeThickness">Tape Thickness</label> 
                                    <div data-role="input-control" class="input-control">
                                        <select class="size4" name="tapeThickness" id="tapeThickness">
                                            <?php foreach ($relatedFields['tapeThickness'] as $tapeThickness) { ?>
                                                <option value="<?php echo $tapeThickness->getId(); ?>"><?php echo $tapeThickness->getName() ?></option>
                                            <?php } ?> 
                                        </select>
                                    </div>
                                </div>
                                <div id="slides_lbl" class="col-lg-6" style="">
                                    <label for="slides">Sides</label>                
                                    <div data-role="input-control" class="input-control">
                                        <select class="size4" name="slides" id="slides">
                                            <option value=""></option>
                                            <?php foreach ($relatedFields['sides'] as $side) { ?>
                                                <option value="<?php echo $side->getId(); ?>"><?php echo $side->getName() ?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>
                                </div>
                                <div id="trackTypes_lbl" class="col-lg-6" style="display: block;">
                                    <label for="trackTypes">Track Type</label> 
                                    <div data-role="input-control" class="input-control">
                                        <select class="size4" name="trackTypes" id="trackTypes">
                                            <?php foreach ($relatedFields['trackTypes'] as $trackType) { ?>
                                                <option value="<?php echo $trackType->getId(); ?>"><?php echo $trackType->getName() ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div id="monoStereo_lbl" class="col-lg-6" style="">
                                    <label for="monoStereo">Mono or Stereo</label>                
                                    <div data-role="input-control" class="input-control">
                                        <select class="size4" name="monoStereo" id="monoStereo">
                                            <option value=""></option>
                                            <?php foreach ($relatedFields['monoStereo'] as $monoStereo) { ?>
                                                <option value="<?php echo $monoStereo->getId(); ?>"><?php echo $monoStereo->getName() ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div id="noiceReduction_lbl" class="col-lg-6" style="">
                                    <label for="noiceReduction">Noise Reduction</label>
                                    <div data-role="input-control" class="input-control">
                                        <select class="size4" name="noiceReduction" id="noiceReduction">  
                                            <option value=""></option>
                                            <?php foreach ($relatedFields['noiseReduction'] as $noiseReduction) { ?>
                                                <option value="<?php echo $noiseReduction->getId(); ?>"><?php echo $noiseReduction->getName() ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <?php
                            } elseif ($mediaTypeId == 2) {
                                ?>
                                <div id="reelCore_lbl" class="col-lg-6" style="">
                                    <label for="reelCore">Reel or Core </label>
                                    <div data-role="input-control" class="input-control">
                                        <select class="size4" name="reelCore" id="reelCore">  
                                            <?php foreach ($relatedFields['reelCore'] as $reelCore) { ?>
                                                <option value="<?php echo $reelCore->getId(); ?>"><?php echo $reelCore->getName() ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div id="reelDiameters_lbl" class="col-lg-6" style="display: block;">
                                    <label for="reelDiameters">Reel Diameter</label>                
                                    <div data-role="input-control" class="input-control">
                                        <select class="size4" name="reelDiameters" id="reelDiameters">
                                            <?php foreach ($relatedFields['reelDiameters'] as $reelDiameter) { ?>
                                                <option value="<?php echo $reelDiameter->getId(); ?>"><?php echo $reelDiameter->getName() ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div id="footage_lbl" class="col-lg-6" style="">
                                    <label for="footage">Footage</label> 
                                    <div data-role="input-control" class="input-control">
                                        <input type="number" class="size4" name="footage" id="footage"> 
                                    </div>
                                </div>
                                <div id="mediaDiameter_lbl" class="col-lg-6" style="">
                                    <label for="mediaDiameter">Media Diameter</label> 
                                    <div data-role="input-control" class="input-control">
                                        <input type="number" class="size4" name="mediaDiameter" id="mediaDiameter">                        <span class="has-error text-danger"></span>
                                    </div>
                                </div>
                                <div id="bases_lbl" class="col-lg-6" style="">
                                    <label for="bases">Base</label>
                                    <div data-role="input-control" class="input-control">
                                        <select class="size4" name="bases" id="bases">
                                            <?php foreach ($relatedFields['bases'] as $base) { ?>
                                                <option value="<?php echo $base->getId(); ?>"><?php echo $base->getName() ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div id="colors_lbl" class="col-lg-6" style="">
                                    <label for="colors">Color</label>
                                    <div data-role="input-control" class="input-control">
                                        <select class="size4" name="colors" id="colors">
                                            <?php foreach ($relatedFields['colors'] as $color) { ?>
                                                <option value="<?php echo $color->getId(); ?>"><?php echo $color->getName() ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div id="sound_lbl" class="col-lg-6" style="">
                                    <label for="sound">Sound</label> 
                                    <div data-role="input-control" class="input-control">
                                        <select class="size4" name="sound" id="sound">
                                            <?php foreach ($relatedFields['sounds'] as $sound) { ?>
                                                <option value="<?php echo $sound->getId(); ?>"><?php echo $sound->getName() ?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>
                                </div>
                                <div id="frameRate_lbl" class="col-lg-6" style="">
                                    <label for="frameRate">Frame Rate </label>
                                    <div data-role="input-control" class="input-control">
                                        <select class="size4" name="frameRate" id="frameRate">
                                            <?php foreach ($relatedFields['frameRates'] as $frameRate) { ?>
                                                <option value="<?php echo $frameRate->getId(); ?>"><?php echo $frameRate->getName() ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div id="acidDetectionStrip_lbl" class="col-lg-6" style="">
                                    <label for="acidDetectionStrip">Acid Detection Strip</label> 
                                    <div data-role="input-control" class="input-control">
                                        <select class="size4" name="acidDetectionStrip" id="acidDetectionStrip">
                                            <?php foreach ($relatedFields['acidDetectionStrips'] as $acidDetectionStrip) { ?>
                                                <option value="<?php echo $acidDetectionStrip->getId(); ?>"><?php echo $acidDetectionStrip->getName() ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div id="printType_lbl" class="col-lg-6" style="">
                                    <label for="printType">Print Type</label>
                                    <div data-role="input-control" class="input-control">
                                        <select class="size4" name="printType" id="printType">
                                            <?php foreach ($relatedFields['printTypes'] as $printType) { ?>
                                                <option value="<?php echo $printType->getId(); ?>"><?php echo $printType->getName() ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <?php
                            } elseif ($mediaTypeId == 3) {
                                ?>
                                <div id="cassetteSize_lbl" class="col-lg-6" style="display: block;">
                                    <label for="cassetteSize">Cassette Size</label>
                                    <div data-role="input-control" class="input-control">
                                        <select class="size4" name="cassetteSize" id="cassetteSize">
                                            <?php foreach ($relatedFields['cassetteSizes'] as $cassetteSize) { ?>
                                                <option value="<?php echo $cassetteSize->getId(); ?>"><?php echo $cassetteSize->getName() ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div id="reelDiameters_lbl" class="col-lg-6" style="display: block;">
                                    <label for="reelDiameters">Reel Diameter</label>                
                                    <div data-role="input-control" class="input-control">
                                        <select class="size4" name="reelDiameters" id="reelDiameters">
                                            <?php foreach ($relatedFields['reelDiameters'] as $reelDiameter) { ?>
                                                <option value="<?php echo $reelDiameter->getId(); ?>"><?php echo $reelDiameter->getName() ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div id="formatVersion_lbl" class="col-lg-6" style="display: block;">
                                    <label for="formatVersion">Format Version</label> 
                                    <div data-role="input-control" class="input-control">
                                        <select class="size4" name="formatVersion" id="formatVersion">
                                            <?php foreach ($relatedFields['formatVersions'] as $formatVersion) { ?>
                                                <option value="<?php echo $formatVersion->getId(); ?>"><?php echo $formatVersion->getName() ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div id="mediaDuration_lbl" class="col-lg-6" style="">
                                    <label for="mediaDuration">Media Duration</label> 
                                    <div data-role="input-control" class="input-control">
                                        <input type="text" class="size4" name="mediaDuration" id="mediaDuration"> 
                                    </div>
                                </div>
                                <div id="recordingSpeed_lbl" class="col-lg-6" style="">
                                    <label for="recordingSpeed">Recording Speed</label>
                                    <div data-role="input-control" class="input-control">
                                        <select class="size4" name="recordingSpeed" id="recordingSpeed">
                                            <?php foreach ($relatedFields['recordingSpeed'] as $recordingSpeed) { ?>
                                                <option value="<?php echo $recordingSpeed->getId(); ?>"><?php echo $recordingSpeed->getName() ?></option>
                                            <?php } ?> 
                                        </select>
                                    </div>
                                </div>
                                <div id="recordingStandard_lbl" class="col-lg-6" style="">
                                    <label for="recordingStandard">Recording Standards</label> 
                                    <div data-role="input-control" class="input-control">
                                        <select class="size4" name="recordingStandard" id="recordingStandard">
                                            <?php foreach ($relatedFields['recordingStandards'] as $recordingStandard) { ?>
                                                <option value="<?php echo $recordingStandard->getId(); ?>"><?php echo $recordingStandard->getName() ?></option>
                                            <?php } ?> 
                                        </select> 
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                        <div id="contentDuration_lbl" class="col-lg-6" style="">
                            <label for="contentDuration">Content Duration</label> 
                            <div data-role="input-control" class="input-control">
                                <input type="text" class="size4" name="contentDuration" id="contentDuration">
                            </div>
                        </div>
                        <div id="copyrightRestrictions_lbl" class="col-lg-6" style="">
                            <label for="copyrightRestrictions">Copyrights</label> 
                            <div data-role="input-control" class="input-control">
                                <input type="text" class="size4" maxlength="250" name="copyrightRestrictions" id="copyrightRestrictions">                            
                            </div>
                        </div>
                    </fieldset>
                </div><br />
            </div>
            <div class="clearfix"></div>
        </div><div class="clearfix"></div>
        <div class="modal-footer" id="bulk_edit_footer">
            <button type="button" name="close" id="" class="button bulkEditCloseBtn simplemodal-close">Close</button>
            <button type="button" name="submit" id="submitBulkEdit" class="button primary">Submit</button>
        </div>

    </form>
</div>
<script src="<?php echo $view['assets']->getUrl('js/manage.records.js') ?>"></script>
<script type="text/javascript">
    var baseUrl = '<?php echo $view['router']->generate('record') ?>';
    var selectedFormat = '';
    var selectedMediaType = '';
    var bulkEdit = '<?php echo $view['router']->generate('bulkedit_edit') ?>';
    $(document).ready(function () {
        initialize_records_form();
    });
</script>

