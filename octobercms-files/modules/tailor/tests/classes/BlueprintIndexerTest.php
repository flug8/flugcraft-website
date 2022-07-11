<?php

use Tailor\Classes\Blueprint;
use Tailor\Classes\BlueprintIndexer;

class BlueprintIndexerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Blueprint::setExternalBasePath(base_path('modules/tailor/tests/fixtures/blueprints'));
    }

    /**
     * testListingBlueprints
     */
    public function testListingBlueprints()
    {
        $sections = BlueprintIndexer::instance()->listSections();
        $this->assertCount(5, $sections);

        $mixins = BlueprintIndexer::instance()->listMixins();
        $this->assertCount(11, $mixins);

        $globals = BlueprintIndexer::instance()->listGlobals();
        $this->assertCount(1, $globals);
    }
}
