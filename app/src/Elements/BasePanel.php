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
        'Heading'               => 'Varchar(255)',
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

        $mainTab->insertAfter('Title', $endBaseFields);

        $fields->addFieldsToTab("Root.Settings",
            [
                UploadField::create("BackgroundImage", "Background Image")
                    ->setFolderName('Backgrounds'),
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
