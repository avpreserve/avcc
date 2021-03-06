<?php
/**
 * AVCC
 * 
 * @category AVCC
 * @package  Application
 * @author   Nouman Tayyab <nouman@weareavp.com>
 * @author   Rimsha Khalid <rimsha@weareavp.com>
 * @license  AGPLv3 http://www.gnu.org/licenses/agpl-3.0.txt
 * @copyright Audio Visual Preservation Solutions, Inc
 * @link     http://avcc.weareavp.com
 */
namespace Application\Bundle\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\Bundle\FrontBundle\Entity\DiskDiameters as DiskDiameters;
use Application\Bundle\FrontBundle\Entity\MediaDiameters as MediaDiameters;
use Application\Bundle\FrontBundle\Entity\Bases as Bases;
use Application\Bundle\FrontBundle\Entity\RecordingSpeed as RecordingSpeed;
use Application\Bundle\FrontBundle\Entity\TapeThickness as TapeThickness;
use Application\Bundle\FrontBundle\Entity\TrackTypes as TrackTypes;
use Application\Bundle\FrontBundle\Entity\MonoStereo as MonoStereo;

/**
 * AudioRecords
 *
 * @ORM\Table(name="audio_records")
 * @ORM\Entity(repositoryClass="Application\Bundle\FrontBundle\Entity\AudioRecordsRepository")
 *
 */
class AudioRecords
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Application\Bundle\FrontBundle\Entity\DiskDiameters
     *
     * @ORM\ManyToOne(targetEntity="Application\Bundle\FrontBundle\Entity\DiskDiameters")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="disk_diameter_id", referencedColumnName="id")
     *   
     * })
     * 
     */
    private $diskDiameters = null;

    /**
     * @var \Application\Bundle\FrontBundle\Entity\MediaDiameters
     *
     * @ORM\ManyToOne(targetEntity="Application\Bundle\FrontBundle\Entity\MediaDiameters")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="media_diameter_id", referencedColumnName="id")
     * })
     */
    private $mediaDiameters = null;

    /**
     * @var \Application\Bundle\FrontBundle\Entity\Bases
     *
     * @ORM\ManyToOne(targetEntity="Application\Bundle\FrontBundle\Entity\Bases")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="base_id", referencedColumnName="id")
     * })
     */
    private $bases = null;

    /**
     * @var integer
     *
     * @ORM\Column(name="media_duration", type="integer", nullable = true)
     */
    private $mediaDuration;

    /**
     * @var \Application\Bundle\FrontBundle\Entity\RecordingSpeed
     *
     * @ORM\ManyToOne(targetEntity="Application\Bundle\FrontBundle\Entity\RecordingSpeed")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="recording_speed_id", referencedColumnName="id")
     * })
     */
    private $recordingSpeed = null;

    /**
     * @var \Application\Bundle\FrontBundle\Entity\TapeThickness
     *
     * @ORM\ManyToOne(targetEntity="Application\Bundle\FrontBundle\Entity\TapeThickness")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tape_thickness_id", referencedColumnName="id")
     * })
     */
    private $tapeThickness = null;

    /**
     * @var \Application\Bundle\FrontBundle\Entity\Sides
     *
     * @ORM\ManyToOne(targetEntity="Application\Bundle\FrontBundle\Entity\Slides")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="side_id", referencedColumnName="id")
     * })
     */
    private $slides = null;

    /**
     * @var \Application\Bundle\FrontBundle\Entity\TrackTypes
     *
     * @ORM\ManyToOne(targetEntity="Application\Bundle\FrontBundle\Entity\TrackTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="track_type_id", referencedColumnName="id")
     * })
     */
    private $trackTypes = null;

    /**
     * @var \Application\Bundle\FrontBundle\Entity\MonoStereo
     *
     * @ORM\ManyToOne(targetEntity="Application\Bundle\FrontBundle\Entity\MonoStereo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="mono_stero_id", referencedColumnName="id")
     * })
     */
    private $monoStereo = null;

    /**
     * @var \Application\Bundle\FrontBundle\Entity\NoiceReduction
     *
     * @ORM\ManyToOne(targetEntity="Application\Bundle\FrontBundle\Entity\NoiceReduction")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="noice_reduction_id", referencedColumnName="id")
     * })
     */
    private $noiceReduction = null;

    /**
     * @var \Application\Bundle\FrontBundle\Entity\Records
     *
     * @ORM\OneToOne(targetEntity="Application\Bundle\FrontBundle\Entity\Records", cascade={"all","merge","persist","refresh","remove"}, inversedBy="audioRecord")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="record_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * })
     */
    private $record;

    /**
     * Get Id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set disk diameter.
     *
     * @param \Application\Bundle\FrontBundle\Entity\DiskDiameters $diskDiameters
     *
     * @return \Application\Bundle\FrontBundle\Entity\AudtioRecords
     */
    public function setDiskDiameters(DiskDiameters $diskDiameters = null)
    {
        $this->diskDiameters = $diskDiameters;

        return $this;
    }

    /**
     * Get disk diameter.
     *
     * @return \Application\Bundle\FrontBundle\Entity\DiskDiameters
     */
    public function getDiskDiameters()
    {
        return $this->diskDiameters;
    }

    /**
     * Set media diameter.
     *
     * @param \Application\Bundle\FrontBundle\Entity\MediaDiameters $mediaDiameters
     *
     * @return \Application\Bundle\FrontBundle\Entity\AudtioRecords
     */
    public function setMediaDiameters(MediaDiameters $mediaDiameters = null)
    {
        $this->mediaDiameters = $mediaDiameters;

        return $this;
    }

    /**
     * Get media diameter.
     *
     * @return \Application\Bundle\FrontBundle\Entity\MediaDiameters
     */
    public function getMediaDiameters()
    {
        return $this->mediaDiameters;
    }

    /**
     * Set base.
     *
     * @param \Application\Bundle\FrontBundle\Entity\Bases $bases
     *
     * @return \Application\Bundle\FrontBundle\Entity\AudtioRecords
     */
    public function setBases(Bases $bases = null)
    {
        $this->bases = $bases;

        return $this;
    }

    /**
     * Get base.
     *
     * @return \Application\Bundle\FrontBundle\Entity\Bases
     */
    public function getBases()
    {
        return $this->bases;
    }

    /**
     * Set media duration.
     *
     * @param string $mediaDuration
     *
     * @return \Application\Bundle\FrontBundle\Entity\AudioRecords
     */
    public function setMediaDuration($mediaDuration)
    {
        $this->mediaDuration = $mediaDuration;

        return $this;
    }

    /**
     * Get media duration.
     *
     * @return integer
     */
    public function getMediaDuration()
    {
        return $this->mediaDuration;
    }

    /**
     * Set recording speed.
     *
     * @param \Application\Bundle\FrontBundle\Entity\RecordingSpeed $recordingSpeed
     *
     * @return \Application\Bundle\FrontBundle\Entity\AudtioRecords
     */
    public function setRecordingSpeed(RecordingSpeed $recordingSpeed = null)
    {
        $this->recordingSpeed = $recordingSpeed;

        return $this;
    }

    /**
     * Get recording speed.
     *
     * @return \Application\Bundle\FrontBundle\Entity\RecordingSpeed
     */
    public function getRecordingSpeed()
    {
        return $this->recordingSpeed;
    }

    /**
     * Set tape thickness.
     *
     * @param \Application\Bundle\FrontBundle\Entity\TapeThickness $tapeThickness
     *
     * @return \Application\Bundle\FrontBundle\Entity\AudtioRecords
     */
    public function setTapeThickness(TapeThickness $tapeThickness = null)
    {
        $this->tapeThickness = $tapeThickness;

        return $this;
    }

    /**
     * Get tapeThickness
     *
     * @return \Application\Bundle\FrontBundle\Entity\TapeThickness
     */
    public function getTapeThickness()
    {
        return $this->tapeThickness;
    }

    /**
     * Set slide.
     *
     * @param \Application\Bundle\FrontBundle\Entity\Slides $slides
     *
     * @return \Application\Bundle\FrontBundle\Entity\AudtioRecords
     */
    public function setSlides(Slides $slides = null)
    {
        $this->slides = $slides;

        return $this;
    }

    /**
     * Get slide
     *
     * @return \Application\Bundle\FrontBundle\Entity\Slides
     */
    public function getSlides()
    {
        return $this->slides;
    }

    /**
     * Set track type.
     *
     * @param \Application\Bundle\FrontBundle\Entity\TrackTypes $trackTypes
     *
     * @return \Application\Bundle\FrontBundle\Entity\AudtioRecords
     */
    public function setTrackTypes(TrackTypes $trackTypes = null)
    {
        $this->trackTypes = $trackTypes;

        return $this;
    }

    /**
     * Get track type
     *
     * @return \Application\Bundle\FrontBundle\Entity\TrackTypes
     */
    public function getTrackTypes()
    {
        return $this->trackTypes;
    }

    /**
     * Set mono stereo.
     *
     * @param \Application\Bundle\FrontBundle\Entity\MonoStero $monoStereo
     *
     * @return \Application\Bundle\FrontBundle\Entity\AudtioRecords
     */
    public function setMonoStereo(MonoStereo $monoStereo = null)
    {
        $this->monoStereo = $monoStereo;

        return $this;
    }

    /**
     * Get mono stereo.
     *
     * @return \Application\Bundle\FrontBundle\Entity\MonoStero
     */
    public function getMonoStereo()
    {
        return $this->monoStereo;
    }

    /**
     * Set noice reduction.
     *
     * @param \Application\Bundle\FrontBundle\Entity\NoiceReduction $noiceReduction
     *
     * @return \Application\Bundle\FrontBundle\Entity\AudtioRecords
     */
    public function setNoiceReduction(NoiceReduction $noiceReduction = null)
    {
        $this->noiceReduction = $noiceReduction;

        return $this;
    }

    /**
     * Get NoiceReduction.
     *
     * @return \Application\Bundle\FrontBundle\Entity\NoiceReduction
     */
    public function getNoiceReduction()
    {
        return $this->noiceReduction;
    }

    /**
     * Set record.
     *
     * @param \Application\Bundle\FrontBundle\Entity\Records $r
     *
     * @return \Application\Bundle\FrontBundle\Entity\AudtioRecords
     */
    public function setRecord(Records $r)
    {
        $this->record = $r;

        return $this;
    }

    /**
     * Get record.
     *
     * @return \Application\Bundle\FrontBundle\Entity\Records
     */
    public function getRecord()
    {
        return $this->record;
    }

}
