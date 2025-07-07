<?php

namespace SirNoah\Whittendav\Elements;

use DNADesign\Elemental\Models\BaseElement;
use DNADesign\Elemental\Models\ElementalArea;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\ToggleCompositeField;
use SilverStripe\ORM\DataList;
use SilverStripe\View\Parsers\HTMLValue;

class BasePanel extends BaseElement
{
    private static $table_name = "Elemental_BasePanel";
    private static $singular_name = "Base Panel";
    private static $plural_name = "Base Panels";
    private static $inline_editable = false;
    private const IMAGE_PATH = '/_resources/themes/whittendav/images/';

    private static $db = [
        'Hide'                  => 'Boolean',
        'RemoveTopPadding'      => 'Boolean',
        'RemoveBottomPadding'   => 'Boolean',
        'BackgroundSize'        => 'Enum("cover,contain,auto,inherit,100%", "cover")',
        'BackgroundRepeat'      => 'Enum("no-repeat,repeat,repeat-x,repeat-y,round,space,inherit", "no-repeat")',
        'BackgroundPosition'    => 'Enum("center,top,bottom,left,right", "center")',
        'Heading'               => 'Varchar(255)',
        'HeadingLevels'         => 'Enum("default,H2,H1,H3", "default")',
        'BackgroundColors'      => 'Enum("transparent,white,black,grey,blue", "transparent")',
        'PanelColorClass'       => 'Enum("text-light,text-dark", "text-light")',
    ];

    private static $has_one = [
        'BackgroundImage'       => Image::class,
    ];

    private static $owns = [
        'BackgroundImage',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'Heading',
            'HeadingLevels',
            'BackgroundColors',
            'BackgroundImage',
            'BackgroundSize',
            'BackgroundRepeat',
            'BackgroundPosition',
        ]);

        // Find the Title field and move it to the beginning
        $mainTab = $fields->findOrMakeTab('Root.Main');

        $flatFields = $fields->flattenFields();
        $flatFields->fieldByName('Title')->setTitle('CMS Title:');

        $endBaseFields = LiteralField::create('EndBaseFields', '<p><strong>Begin Content Fields:</strong></p><hr>');
        $previewBlockField = LiteralField::create('PreviewBlock', '');
        $heading = TextField::create('Heading', 'Panel Heading');
        $headingLevels = DropdownField::create('HeadingLevels', 'Heading Level', $this->getHeadingLevelsList());

        $mainTab->insertAfter('Title', $endBaseFields);
        $mainTab->insertBefore('EndBaseFields', $previewBlockField);
        $mainTab->insertBefore('EndBaseFields', $heading);
        $mainTab->insertBefore('EndBaseFields', $headingLevels);

        $fields->addFieldsToTab("Root.Settings",
            [
                DropdownField::create('PanelColorClass', 'Panel Text Color: ', $this->getPanelColorClassList()),
                DropdownField::create('BackgroundColors', 'Background Color: ', $this->getBackgroundColorsList()),
                UploadField::create("BackgroundImage", "Background Image")
                    ->setFolderName('Backgrounds'),
                DropdownField::create('BackgroundSize', 'Background Size: ', $this->getBackgroundSizeList()),
                DropdownField::create('BackgroundPosition', 'Background Position: ', $this->getBackgroundPositionList()),
                DropdownField::create('BackgroundRepeat', 'Background Repeat: ', $this->BackgroundRepeatList()),
                CheckboxField::create('Hide', 'Hide')
                    ->setDescription('Prevent component from being displayed on the page'),
                CheckboxField::create('RemoveTopPadding', 'Remove Top Padding')
                    ->setDescription('Remove all top padding from component'),
                CheckboxField::create('RemoveBottomPadding', 'Remove Bottom Padding')
                    ->setDescription('Remove all bottom padding from component'),
            ]
        );

        return $fields;
    }

    public function forTemplate($holder = true) {
        if ($this->Hide) {
            return "";
        } else {
            return parent::forTemplate($holder);
        }
    }

    public function getPanelColorClassList()
    {
        return singleton($this->ClassName)->dbObject('PanelColorClass')->enumValues();
    }

    public function getHeadingLevelsList()
    {
        return singleton($this->ClassName)->dbObject('HeadingLevels')->enumValues();
    }

    public function getBackgroundColorsList()
    {
        return singleton($this->ClassName)->dbObject('BackgroundColors')->enumValues();
    }

    public function getBackgroundSizeList()
    {
        return singleton($this->ClassName)->dbObject('BackgroundSize')->enumValues();
    }

    public function getBackgroundPositionList()
    {
        return singleton($this->ClassName)->dbObject('BackgroundPosition')->enumValues();
    }

    public function BackgroundRepeatList()
    {
        return singleton($this->ClassName)->dbObject('BackgroundRepeat')->enumValues();
    }

    public function getBackgroundStyle()
    {
        if ($this->BackgroundImage()->exists()) {
            $bgStyle = 'background-image: url(' . $this->BackgroundImage()->ScaleMaxWidth(1920)->Link() . ');background-size: ' . $this->BackgroundSize . ';background-repeat: '. $this->BackgroundRepeat . ';background-position: '. $this->BackgroundPosition . ';';
        } else {
            switch ($this->BackgroundColors) {
                case 'grey':
                    $color = '#f2f2f2';
                    break;
                case 'blue':
                    $color = '#121f3d';
                    break;
                case 'white':
                    $color = '#fff';
                    break;
                case 'black':
                    $color = '#000';
                    break;
                default:
                    $color = 'transparent';
            }

            $bgStyle = 'background-color:' .  $color . ';';
        }

        return $bgStyle;
    }

    public function FormattedHeading($customClass = '', $aosType = '', $aosDuration = '', $aosDelay = '') {
        if ($this->HeadingLevels === 'default') return false;

        $aos = '';
        if (!empty($aosType) || !empty($aosDuration) || !empty($aosDelay) || !empty($aosOnce) || !empty($customClass)) {
            $aos = sprintf(" data-aos='%s' data-aos-duration='%s' data-aos-delay='%s' class='%s'",
                $aosType,
                $aosDuration,
                $aosDelay,
                $customClass
            );
        }

        $heading = sprintf("<%s%s>%s</%s>",
            $this->HeadingLevels,
            $aos,
            $this->Heading,
            $this->HeadingLevels
        );


        return HTMLValue::create($heading);
    }

    public function FormattedSubHeading($customClass = '', $aosType = '', $aosDuration = '', $aosDelay = '') {
        if ($this->HeadingLevels === 'default') return false;

        $HeadingType = ($this->HeadingLevels == 'H2' ? 'h3' : 'h2');
        $HeadingType = ($this->HeadingLevels == 'H3' ? 'p' : $HeadingType);

        $aos = '';

        if (!empty($aosType) || !empty($aosDuration) || !empty($aosDelay) || !empty($aosOnce)) {
            $aos = sprintf(" data-aos='%s' data-aos-duration='%s' data-aos-delay='%s'",
                $aosType,
                $aosDuration,
                $aosDelay
            );
        }

        $heading = sprintf("<%s%s class='%s'>%s</%s>",
            $HeadingType,
            $aos,
            $customClass,
            $this->Subheading,
            $HeadingType
        );

        return HTMLValue::create($heading);
    }

    public function AnimationDelay($delay, $iteration, $multiple)
    {
        return $delay + (($iteration - 1) * $multiple);
    }

    public function getPreviewHTML($previewImage): string
    {
        $imagePath = self::IMAGE_PATH . htmlspecialchars($previewImage);

        return <<<HTML
        <div class="form-group">
            <label class="form__field-label">Preview of Layout:</label>
            <div class="form__field-holder">
                <img class="mb-3 w-100 mx-auto" src="{$imagePath}" alt="{$previewImage}">
            </div>
        </div>
        HTML;
    }

    public function getToggledPreviewHTML(...$files): ToggleCompositeField
    {
        $html ='';
        $innerHTML = '<div class="form-group">
            <label class="form__field-label"><span style="margin-left:10px;">Layout(s):</span></label>
            <div class="form__field-holder">%s</div>
        </div>';

        foreach ($files as $file) {
            $html .= '<img class="mb-3 w-100 mx-auto" src="'. self::IMAGE_PATH . htmlspecialchars($file) . '">';
        }

        return ToggleCompositeField::create('TogglePanelLayout', 'Panel Preview',
            LiteralField::create(
                'PanelLayout',
                sprintf($innerHTML,$html)
            )
        );
    }

    public function getVideoPreviewHTML($previewImage): ToggleCompositeField
    {
        $videoPath = self::VIDEO_PATH . htmlspecialchars($previewImage);
        $html = <<<HTML
        <div class="form-group">
            <label class="form__field-label"></label>
            <div class="form__field-holder">
                <video muted autoplay loop style="max-width: 100%;">
                    <source src="{$videoPath}" type="video/mp4">
                </video>
            </div>
        </div>
        HTML;

        return ToggleCompositeField::create('TogglePanelLayout', 'Panel Preview ( Video )',
            LiteralField::create(
                'PanelLayout',
                $html
            )
        );
    }

    public function getElements(): DataList
    {
        if ($this->ParentID) {
            $elementalArea = ElementalArea::get()->byID($this->ParentID);
            if ($elementalArea) {
                return $elementalArea->Elements()->exclude('ID', $this->ID);
            }
        }
        return BaseElement::get()->filter('ID', 0);// Return empty list if no elements found
    }
}
