<?php

namespace SirNoah\Whittendav\PageTypes;

use Page;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\Tab;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SirNoah\Whittendav\Models\Resume\Edu;
use SirNoah\Whittendav\Models\Resume\Exp;
use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;

class ResumePage extends Page
{
    private static string $table_name = "Page_ResumePage";
    private static string $singular_name = "Resume Page";
    private static string $plural_name = "Resume Pages";
    private static string $description = "A page template for personal resume";

    private static array $db = [
        'First'             => 'Varchar(50)',
        'Last'              => 'Varchar(50)',
        'Title'             => 'Varchar(50)',
        // profile section
        'ProfileHeading'    => 'Varchar(50)',
        'Description'       => 'Varchar(750)',
        // Exp section
        'ExpHeading'        => 'Varchar(50)',
        // Contact section
        // Plans to use a cloudflare turnstile to vet user and return contact info when deemed not bot traffic
        'ContactHeading'    => 'Varchar(50)',
        'Email'             => 'Varchar(50)',
        'LinkedIn'          => 'Varchar(150)',
        // Education section
        'EduHeading'        => 'Varchar(50)',
        // Skills section
        'SkillsHeading'     => 'Varchar(50)',
        'SkillList'         => 'HTMLText',
        // Language section
        'LanguageHeading'   => 'Varchar(50)',
        'LangList'          => 'HTMLText',
        // Project section
        'ProjectHeading'    => 'Varchar(50)',
        'ProjectList'       => 'HTMLText',
    ];

    private static array $has_many = [
        'Education'         => Edu::class,
        'Experiences'       => Exp::class,
    ];

    private static array $has_one = [
        'Bust'              => Image::class,
        'Resume'            => File::class,
    ];

    private static array $owns = [
        'Bust',
        'Resume',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'Content',
            'H1',
            'First',
            'Last',
            'Title',
            'ProfileHeading',
            'Description',
            'ExpHeading',
            'ContactHeading',
            'Email',
            'LinkedIn',
            'EduHeading',
            'SkillsHeading',
            'SkillList',
            'LanguageHeading',
            'LangList',
            'ProjectHeading',
            'ProjectList',
            'Education',
            'Experiences',
            'Bust',
            'Resume',
        ]);

        $fields->addFieldToTab('Root.Main', TabSet::create('MainTabSet',
            Tab::create('MainResumeTab', 'Main Resume Fields:',
                TabSet::create('MainResumeTabSections',
                    Tab::create('IntroTab', 'Name',
                        UploadField::create('Bust', 'Bust')
                            ->setAllowedExtensions(['jpg', 'jpeg', 'png'])
                            ->setFolderName('Resume/Images'),
                        TextField::create('First', 'First Name'),
                        TextField::create('Last', 'Last Name'),
                        TextField::create('Title', 'Title'),
                        UploadField::create('Resume', 'Resume')
                            ->setAllowedExtensions(['pdf', 'csv', 'txt', 'xlsx', 'doc', 'docx', 'ppt', 'pptx'])
                            ->setFolderName('Resume/Files'),
                    ),
                    Tab::create('ProfileTab', 'Profile Fields:',
                        TextField::create('ProfileHeading', 'Profile Heading'),
                        TextareaField::create('Description', 'Description'),
                    ),
                    Tab::create('ExperienceTab', 'Experience Fields:',
                        TextField::create('ExpHeading', 'Heading Fields:'),
                        GridField::create('Experiences',
                            'Experiences',
                            $this->Experiences(),
                            GridFieldConfig_RecordEditor::create(10)
                                ->addComponent(GridFieldSortableRows::create('SortOrder'))
                        )
                    ),
                ),


            ),
            Tab::create('SidebarResumeTab', 'Sidebar Fields:',
                TabSet::create('SidebarTabSet',
                    Tab::create('ContactTab', 'Contact Fields:',
                        TextField::create('Email', 'Email'),
                        TextField::create('LinkedIn', 'LinkedIn'),
                    ),
                    Tab::create('EducationTab', 'Education Fields:',
                        TextField::create('EduHeading', 'Heading Fields:'),
                        GridField::create('Education',
                            'Education',
                            $this->Education(),
                            GridFieldConfig_RecordEditor::create(10)
                                ->addComponent(GridFieldSortableRows::create('SortOrder'))
                        )
                    ),
                    Tab::create('SkillsTab', 'Skills Fields:',
                        TextField::create('SkillsHeading', 'Skills Heading:'),
                        HTMLEditorField::create('SkillList', 'Skill List:'),
                    ),
                    Tab::create('LanguageTab', 'Language Fields:',
                        TextField::create('LanguageHeading', 'Language Heading:'),
                        HTMLEditorField::create('LangList', 'Language List:'),
                    ),
                )
            ),
        ),'Metadata');

        return $fields;
    }
}
