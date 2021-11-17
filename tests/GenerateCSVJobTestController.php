<?php

namespace SilverStripe\GridFieldQueuedExport\Tests;

use SilverStripe\Control\Controller;
use SilverStripe\Dev\TestOnly;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridFieldExportButton;
use SilverStripe\GridfieldQueuedExport\Forms\GridFieldQueuedExportButton;

class GenerateCSVJobTestController extends Controller implements TestOnly
{
    private static $allowed_actions = ['Form'];

    /**
     * @return string
     */
    public function Link($action = null)
    {
        return 'jobtest/';
    }

    /**
     * @param bool $emailCSV
     * @return Form
     */
    public function Form($emailCSV = false)
    {
        // Get records
        $records = GenerateCSVJobTestRecord::get();

        // Set config
        $config = GridFieldConfig_RecordEditor::create();
        $config->removeComponentsByType(GridFieldExportButton::class);
        $config->addComponent($exportButton = new GridFieldQueuedExportButton('buttons-after-left'));
        $exportButton->setEmailCSV($emailCSV);
        $fields = new GridField('MyGridfield', 'My Records', $records, $config);
        /** @skipUpgrade */
        return Form::create($this, 'Form', new FieldList($fields), new FieldList());
    }
}
