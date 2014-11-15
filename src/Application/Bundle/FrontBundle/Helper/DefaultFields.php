<?php

namespace Application\Bundle\FrontBundle\Helper;

use Doctrine\ORM\EntityManager;
use Application\Bundle\FrontBundle\Entity\Users;

class DefaultFields
{

	private $defaultOrder = array();
	private $em;

	public function __construct()
	{
		
	}

	public function getDefaultOrder()
	{
		$this->defaultOrder['audio'] = array(
			"Media_Type" => array("title" => 'Media Type', 'field' => "record.mediaType", "is_required" => 1, "hidden" => 0),
			"Project_Name" => array("title" => 'Project Name', 'field' => "record.project", "is_required" => 1, "hidden" => 0),
			"Unique_Id" => array("title" => 'Unique Id', 'field' => "record.uniqueId", "is_required" => 1, "hidden" => 0),
			"Location" => array("title" => 'Location', 'field' => "record.location", "is_required" => 1, "hidden" => 0),
			"Format" => array("title" => 'Format', 'field' => "record.format", "is_required" => 1, "hidden" => 0),
			"Title" => array("title" => 'Title', 'field' => "record.title", "is_required" => 1, "hidden" => 0),
			"Collection_Name" => array("title" => 'Collection Name', 'field' => "record.collectionName", "is_required" => 1, "hidden" => 0),
			"Description" => array("title" => 'Description', 'field' => "record.description", "is_required" => 0, "hidden" => 0),
			"Commercial" => array("title" => 'Commercial', 'field' => "record.commercial", "is_required" => 0, "hidden" => 0),
			"Disk_Diameter" => array("title" => 'Disk Diameter', 'field' => "diskDiameters", "is_required" => 0, "hidden" => 0),
			"Reel_Diameter" => array("title" => 'Reel Diameter', 'field' => "record.reelDiameters", "is_required" => 0, "hidden" => 0),
			"Media_Diameter" => array("title" => 'Media Diameter', 'field' => "mediaDiameters", "is_required" => 0, "hidden" => 0),
			"Base" => array("title" => 'Base', 'field' => "bases", "is_required" => 0, "hidden" => 0),
			"Content_Duration" => array("title" => 'Content Duration', 'field' => "record.contentDuration", "is_required" => 0, "hidden" => 0),
			"Media_Duration" => array("title" => 'Media Duration', 'field' => "mediaDuration", "is_required" => 0, "hidden" => 0),
			"Creation_Date" => array("title" => 'Creation Date', 'field' => "record.creationDate", "is_required" => 0, "hidden" => 0),
			"Content_Data" => array("title" => 'Content Data', 'field' => "record.contentDate", "is_required" => 0, "hidden" => 0),
			"Review" => array("title" => 'Review', 'field' => "record.isReview", "is_required" => 0, "hidden" => 0),
			"Recording_Speed" => array("title" => 'Recording Speed', 'field' => "recordingSpeed", "is_required" => 0, "hidden" => 0),
			"Tape_Thickness" => array("title" => 'Tape Thickness', 'field' => "tapeThickness", "is_required" => 0, "hidden" => 0),
			"Slides" => array("title" => 'Slides', 'field' => "slides", "is_required" => 0, "hidden" => 0),
			"Track_Type" => array("title" => 'Track Type', 'field' => "trackTypes", "is_required" => 0, "hidden" => 0),
			"Mono_Stereo" => array("title" => 'Mono or Stereo', 'field' => "monoStereo", "is_required" => 0, "hidden" => 0),
			"Noice_Reduction" => array("title" => 'Noice Reduction', 'field' => "noiceReduction", "is_required" => 0, "hidden" => 0),
			"Gener_Terms" => array("title" => 'Description', 'field' => "record.genreTerms", "is_required" => 0, "hidden" => 0),
			"Contributor" => array("title" => 'Contributor', 'field' => "record.contributor", "is_required" => 0, "hidden" => 0),
			"Gerneration" => array("title" => 'Gerneration', 'field' => "record.generation", "is_required" => 0, "hidden" => 0),
			"Part" => array("title" => 'Part', 'field' => "record.part", "is_required" => 0, "hidden" => 0),
			"Copyrights" => array("title" => 'Copyrights', 'field' => "record.copyrightRestrictions", "is_required" => 0, "hidden" => 0),
			"Duplicates" => array("title" => 'Duplicates', 'field' => "record.duplicatesDerivatives", "is_required" => 0, "hidden" => 0),
			"Related_Meterial" => array("title" => 'Related Meterial', 'field' => "record.relatedMaterial", "is_required" => 0, "hidden" => 0),
			"Condition_Note" => array("title" => 'Condition Note', 'field' => "record.conditionNote", "is_required" => 0, "hidden" => 0)
		);

		$this->defaultOrder['video'] = array(
			"Media_Type" => array("title" => 'Media Type', 'field' => "record.mediaType", "is_required" => 1, "hidden" => 0),
			"Project_Name" => array("title" => 'Project Name', 'field' => "record.project", "is_required" => 1, "hidden" => 0),
			"Unique_Id" => array("title" => 'Unique Id', 'field' => "record.uniqueId", "is_required" => 1, "hidden" => 0),
			"Location" => array("title" => 'Location', 'field' => "record.location", "is_required" => 1, "hidden" => 0),
			"Format" => array("title" => 'Format', 'field' => "record.format", "is_required" => 1, "hidden" => 0),
			"Title" => array("title" => 'Title', 'field' => "record.title", "is_required" => 1, "hidden" => 0),
			"Collection_Name" => array("title" => 'Collection Name', 'field' => "record.collectionName", "is_required" => 1, "hidden" => 0),
			"Description" => array("title" => 'Description', 'field' => "record.description", "is_required" => 0, "hidden" => 0),
			"Commercial" => array("title" => 'Commercial', 'field' => "record.commercial", "is_required" => 0, "hidden" => 0),
			"Cassette_Size" => array("title" => 'Cassette Size', 'field' => "cassetteSize", "is_required" => 0, "hidden" => 0),
			"Reel_Diameter" => array("title" => 'Reel Diameter', 'field' => "record.reelDiameters", "is_required" => 0, "hidden" => 0),
			"Content_Duration" => array("title" => 'Content Duration', 'field' => "record.contentDuration", "is_required" => 0, "hidden" => 0),
			"Media_Duration" => array("title" => 'Media Duration', 'field' => "mediaDuration", "is_required" => 0, "hidden" => 0),
			"Creation_Date" => array("title" => 'Creation Date', 'field' => "record.creationDate", "is_required" => 0, "hidden" => 0),
			"Content_Data" => array("title" => 'Content Data', 'field' => "record.contentDate", "is_required" => 0, "hidden" => 0),
			"Review" => array("title" => 'Review', 'field' => "record.isReview", "is_required" => 0, "hidden" => 0),
			"Format_Version" => array("title" => 'Format Version', 'field' => "formatVersion", "is_required" => 0, "hidden" => 0),
			"Recording_Speed" => array("title" => 'Recording Speed', 'field' => "recordingSpeed", "is_required" => 0, "hidden" => 0),
			"Recording_Standard" => array("title" => 'Recording Standards', 'field' => "recordingStandard", "is_required" => 0, "hidden" => 0),
			"Gener_Terms" => array("title" => 'Description', 'field' => "record.genreTerms", "is_required" => 0, "hidden" => 0),
			"Contributor" => array("title" => 'Contributor', 'field' => "record.contributor", "is_required" => 0, "hidden" => 0),
			"Gerneration" => array("title" => 'Gerneration', 'field' => "record.generation", "is_required" => 0, "hidden" => 0),
			"Part" => array("title" => 'Part', 'field' => "record.part", "is_required" => 0, "hidden" => 0),
			"Copyrights" => array("title" => 'Copyrights', 'field' => "record.copyrightRestrictions", "is_required" => 0, "hidden" => 0),
			"Duplicates" => array("title" => 'Duplicates', 'field' => "record.duplicatesDerivatives", "is_required" => 0, "hidden" => 0),
			"Related_Meterial" => array("title" => 'Related Meterial', 'field' => "record.relatedMaterial", "is_required" => 0, "hidden" => 0),
			"Condition_Note" => array("title" => 'Condition Note', 'field' => "record.conditionNote", "is_required" => 0, "hidden" => 0)
		);

		$this->defaultOrder['film'] = array(
			"Media_Type" => array("title" => 'Media Type', 'field' => "record.mediaType", "is_required" => 1, "hidden" => 0),
			"Project_Name" => array("title" => 'Project Name', 'field' => "record.project", "is_required" => 1, "hidden" => 0),
			"Unique_Id" => array("title" => 'Unique Id', 'field' => "record.uniqueId", "is_required" => 1, "hidden" => 0),
			"Location" => array("title" => 'Location', 'field' => "record.location", "is_required" => 1, "hidden" => 0),
			"Format" => array("title" => 'Format', 'field' => "record.format", "is_required" => 1, "hidden" => 0),
			"Print_Type" => array("title" => 'Print Type', 'field' => "printType", "is_required" => 1, "hidden" => 0),
			"Title" => array("title" => 'Title', 'field' => "record.title", "is_required" => 1, "hidden" => 0),
			"Collection_Name" => array("title" => 'Collection Name', 'field' => "record.collectionName", "is_required" => 1, "hidden" => 0),
			"Description" => array("title" => 'Description', 'field' => "record.description", "is_required" => 0, "hidden" => 0),
			"Commercial" => array("title" => 'Commercial', 'field' => "record.commercial", "is_required" => 0, "hidden" => 0),
			"Reel_Core" => array("title" => 'Reel or Core', 'field' => "reelCore", "is_required" => 0, "hidden" => 0),
			"Reel_Diameter" => array("title" => 'Reel Diameter', 'field' => "record.reelDiameters", "is_required" => 0, "hidden" => 0),
			"Footage" => array("title" => 'Footage', 'field' => "footage", "is_required" => 0, "hidden" => 0),
			"Media_Diameter" => array("title" => 'Media Diameter', 'field' => "mediaDiameter", "is_required" => 0, "hidden" => 0),
			"Base" => array("title" => 'Base', 'field' => "bases", "is_required" => 0, "hidden" => 0),
			"Color" => array("title" => 'Color', 'field' => "colors", "is_required" => 0, "hidden" => 0),
			"Sound" => array("title" => 'Sound', 'field' => "sound", "is_required" => 0, "hidden" => 0),
			"Content_Duration" => array("title" => 'Content Duration', 'field' => "record.contentDuration", "is_required" => 0, "hidden" => 0),
			"Creation_Date" => array("title" => 'Creation Date', 'field' => "record.creationDate", "is_required" => 0, "hidden" => 0),
			"Content_Date" => array("title" => 'Content Data', 'field' => "record.contentDate", "is_required" => 0, "hidden" => 0),
			"Review" => array("title" => 'Review', 'field' => "record.isReview", "is_required" => 0, "hidden" => 0),
			"Frame_Rate" => array("title" => 'Frame Rate', 'field' => "frameRate", "is_required" => 0, "hidden" => 0),
			"Acid_Detection_Strip" => array("title" => 'Acid Detection Strip', 'field' => "acidDetectionStrip", "is_required" => 0, "hidden" => 0),
			"Shrinkage" => array("title" => 'Shrinkage', 'field' => "shrinkage", "is_required" => 0, "hidden" => 0),
			"Gener_Terms" => array("title" => 'Description', 'field' => "record.genreTerms", "is_required" => 0, "hidden" => 0),
			"Contributor" => array("title" => 'Contributor', 'field' => "record.contributor", "is_required" => 0, "hidden" => 0),
			"Gerneration" => array("title" => 'Gerneration', 'field' => "record.generation", "is_required" => 0, "hidden" => 0),
			"Part" => array("title" => 'Part', 'field' => "record.part", "is_required" => 0, "hidden" => 0),
			"Copyrights" => array("title" => 'Copyrights', 'field' => "record.copyrightRestrictions", "is_required" => 0, "hidden" => 0),
			"Duplicates" => array("title" => 'Duplicates', 'field' => "record.duplicatesDerivatives", "is_required" => 0, "hidden" => 0),
			"Related_Meterial" => array("title" => 'Related Meterial', 'field' => "record.relatedMaterial", "is_required" => 0, "hidden" => 0),
			"Condition_Note" => array("title" => 'Condition Note', 'field' => "record.conditionNote", "is_required" => 0, "hidden" => 0)
		);

		return json_encode($this->defaultOrder);
	}

	/**
	 *  Get Field settings
	 */
	public function getFieldSettings(Users $user, EntityManager $em)
	{
		$settings = $em->getRepository('ApplicationFrontBundle:UserSettings')->findOneBy(array('user' => $user->getId()));
		if ($settings)
		{
			$viewSettings = $settings->getViewSetting();
		}
		else
		{
			$viewSettings = $this->getDefaultOrder();
		}
		$userViewSettings = json_decode($viewSettings, true);

		return $userViewSettings;
	}

	/**
	 * Get record related info
	 *
	 * @param  integer $projectId
	 * @return array
	 */
	public function getData($mediaType, EntityManager $em, Users $user, $projectId = null)
	{
		$data['mediaTypeId'] = $mediaType;
		$data['projectId'] = $projectId;
		$data['userId'] = $user->getId();
		$mediaTypes = $em->getRepository('ApplicationFrontBundle:MediaTypes')->findAll();

		foreach ($mediaTypes as $media)
		{
			$data['mediaTypesArr'][] = array($media->getId() => $media->getName());
		}

		$projects = $em->getRepository('ApplicationFrontBundle:Projects')->findAll();

		foreach ($projects as $project)
		{
			$data['projectsArr'][] = array($project->getId() => $project->getName());
		}

		$data['mediaType'] = $em->getRepository('ApplicationFrontBundle:MediaTypes')->findOneBy(array('id' => $data['mediaTypeId']));

		return $data;
	}

	public function recordDatatableView($records, $columnOrder)
	{
		$tableView = array();

		foreach ($records as $mainIndex => $value)
		{
			foreach ($columnOrder as $key => $row)
			{
				$type = $row['title'];
				if ($type == 'checkbox_Col')
					$tableView[$mainIndex][] = '<span style="float:left;min-width:20px;max-width:20px;"><input type="checkbox" name="record_checkbox[]" class="checkboxes" onclick="" value="' . $value['record']['id'] . '" /></span>';
				if ($type == 'Project_Name')
					$tableView[$mainIndex][] = '<span style="float:left;min-width:150px;max-width:150px;">' . $value['projectTitle'] . '</span>';
				else if ($type == 'Unique_ID')
					$tableView[$mainIndex][] = '<span style="float:left;min-width:150px;max-width:150px;"><a href="#">' . $value['record']['uniqueId'] . '</span>';
				else if ($type == 'Title')
					$tableView[$mainIndex][] = '<span style="float:left;min-width:150px;max-width:150px;"><a href="#">' . $value['record']['title'] . '</span>';
				else if ($type == 'Collection_Name')
					$tableView[$mainIndex][] = '<span style="float:left;min-width:150px;max-width:150px;"><a href="#">' . $value['record']['collectionName'] . '</span>';
				else if ($type == 'Location')
					$tableView[$mainIndex][] = '<span style="float:left;min-width:150px;max-width:150px;"><a href="#">' . $value['record']['location'] . '</span>';
			}
		}
		return $tableView;
	}

	public function getRecordArray(EntityManager $em, $record_id)
	{
		$row = $em->getRepository('ApplicationFrontBundle:Records')->findOneBy(array('id' => $record_id));

		$data = array();

		$data['id'] = $row->getId();
		$data['s_title'] = ($row->getTitle()) ? $row->getTitle() : "";
		$data['title'] = ($row->getTitle()) ? $row->getTitle() : "";
		$data['s_description'] = ($row->getDescription()) ? $row->getDescription() : "";
		$data['description'] = ($row->getDescription()) ? $row->getDescription() : "";
		$data['s_collection_name'] = ($row->getCollectionName()) ? $row->getCollectionName() : "";
		$data['collection_name'] = ($row->getCollectionName()) ? $row->getCollectionName() : "";
		$data['s_creation_date'] = ($row->getCreationDate()) ? $row->getCreationDate() : "";
		$data['creation_date'] = ($row->getCreationDate()) ? $row->getCreationDate() : "";
		$data['s_content_date'] = ($row->getContentDate()) ? $row->getContentDate() : "";
		$data['content_date'] = ($row->getContentDate()) ? $row->getContentDate() : "";
		$data['unique_id'] = ($row->getUniqueId()) ? $row->getUniqueId() : "";
		$data['s_media_type'] = ($row->getMediaType()->getName()) ? $row->getMediaType()->getName() : "";
		$data['media_type'] = ($row->getMediaType()->getName()) ? $row->getMediaType()->getName() : "";
		$data['s_genre_terms'] = ($row->getGenreTerms()) ? $row->getGenreTerms() : "";
		$data['genre_terms'] = ($row->getGenreTerms()) ? $row->getGenreTerms() : "";
		$data['s_contributor'] = ($row->getContributor()) ? $row->getContributor() : "";
		$data['contributor'] = ($row->getContributor()) ? $row->getContributor() : "";
		$data['location'] = ($row->getLocation()) ? $row->getLocation() : "";
		$data['s_format'] = ($row->getFormat()->getName()) ? $row->getFormat()->getName() : "";
		$data['format'] = ($row->getFormat()->getName()) ? $row->getFormat()->getName() : "";
		$data['is_review'] = ($row->getIsReview()) ? $row->getIsReview() : "";
		$data['commercial'] = 1;
		$data['reel_diameter'] = ($row->getReelDiameters()) ? $row->getReelDiameters()->getName() : "";
		$data['s_reel_diameter'] = ($row->getReelDiameters()) ? $row->getReelDiameters()->getName() : "";
		$data['content_duration'] = ($row->getContentDuration()) ? $row->getContentDuration() : "";
		$data['part'] = ($row->getPart()) ? $row->getPart() : "";
		$data['generation'] = ($row->getGeneration()) ? $row->getGeneration() : "";

		if ($row->getMediaType()->getId() == 1)
		{
			$data['disk_diameter'] = ($row->getAudioRecord()->getDiskDiameters()) ? $row->getAudioRecord()->getDiskDiameters()->getName() : "";
			$data['base'] = ($row->getAudioRecord()->getBases()) ? $row->getAudioRecord()->getBases()->getName() : "";
			$data['s_base'] = ($row->getAudioRecord()->getBases()) ? $row->getAudioRecord()->getBases()->getName() : "";
			$data['media_diameter'] = ($row->getAudioRecord()->getMediaDiameters()) ? $row->getAudioRecord()->getMediaDiameters()->getName() : "";
			$data['media_duration'] = ($row->getAudioRecord()->getMediaDuration()) ? $row->getAudioRecord()->getMediaDuration() : "";
			$data['recording_speed'] = ($row->getAudioRecord()->getRecordingSpeed()) ? $row->getAudioRecord()->getRecordingSpeed()->getName() : "";
			$data['tape_thickness'] = ($row->getAudioRecord()->getTapeThickness()) ? $row->getAudioRecord()->getTapeThickness()->getName() : "";
			$data['slides'] = ($row->getAudioRecord()->getSlides()) ? $row->getAudioRecord()->getSlides()->getName() : "";
			$data['track_type'] = ($row->getAudioRecord()->getTrackTypes()) ? $row->getAudioRecord()->getTrackTypes()->getName() : "";
			$data['mono_stereo'] = ($row->getAudioRecord()->getMonoStereo()) ? $row->getAudioRecord()->getMonoStereo()->getName() : "";
			$data['noice_reduction'] = ($row->getAudioRecord()->getNoiceReduction()) ? $row->getAudioRecord()->getNoiceReduction()->getName() : "";
		}

		return $data;
	}

}
