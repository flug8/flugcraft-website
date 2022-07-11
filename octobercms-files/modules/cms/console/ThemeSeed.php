<?php namespace Cms\Console;

use File;
use Yaml;
use Cms\Classes\Theme;
use Illuminate\Console\Command;
use Tailor\Classes\BlueprintIndexer;
use SystemException;
use Exception;

/**
 * ThemeSeed imports blueprints and seed files from a theme
 *
 * @package october\system
 * @author Alexey Bobkov, Samuel Georges
 */
class ThemeSeed extends Command
{
     /**
     * @var string signature of console command
     */
    protected $signature = 'theme:seed
        {name : The directory name of the theme.}
        {--root : Copy blueprints to root directory.}';

    /**
     * @var string description of the console command
     */
    protected $description = 'Seeds the specified theme with blueprints and data.';

    /**
     * @var Theme activeTheme used by this command
     */
    protected $activeTheme;

    /**
     * handle executes the console command
     */
    public function handle()
    {
        $this->info('Seeding Theme...');

        $themeName = $this->argument('name');
        $theme = $this->activeTheme = Theme::load($themeName);

        if (!$theme->exists($themeName)) {
            return $this->error(sprintf('The theme %s does not exist.', $themeName));
        }

        $themePath = $theme->getPath();

        // Importing blueprints
        $appBpPath = $this->option('root')
            ? app_path('blueprints')
            : app_path('blueprints/' . $themeName);

        // Import and migrate blueprints
        $themeBpPath = $themePath . '/seeds/blueprints';
        if (File::isDirectory($themeBpPath)) {
            $this->line('Importing Blueprints');
            File::copyDirectory($themeBpPath, $appBpPath);

            BlueprintIndexer::instance()->setNotesCommand($this)->migrate();
        }

        // Importing seed data
        $importFile = $themePath . '/seeds/data.yaml';
        if (File::isFile($importFile)) {
            $this->line('Importing Data');
            $instructions = Yaml::parseFile($importFile);

            try {
                $this->processSeedInstructions($instructions);
            }
            catch (Exception $ex) {
                throw new SystemException("[{$importFile}] " . $ex->getMessage(), 0, $ex);
            }
        }
    }

    /**
     * processSeedInstructions
     */
    protected function processSeedInstructions($instructions)
    {
        if (!is_array($instructions)) {
            return;
        }

        foreach ($instructions as $instruction) {
            $this->processSeedInstruction($instruction);
        }
    }

    /**
     * processSeedInstruction
     */
    protected function processSeedInstruction($instruction)
    {
        $importName = $instruction['name'] ?? 'Import Data';
        $className = $instruction['class'] ?? null;
        $fileName = $instruction['file'] ?? null;
        $attributes = $instruction['attributes'] ?? null;
        $matches = $instruction['matches'] ?? null;

        if (!$className) {
            throw new SystemException("Import script is missing definition for 'class'");
        }
        if (!$fileName) {
            throw new SystemException("Import script is missing definition for 'file'");
        }
        if (!$attributes || !is_array($attributes)) {
            throw new SystemException("Import script is missing definition for 'attributes'");
        }

        if (!class_exists($className)) {
            throw new SystemException("Import class '{$className}' does not exist.");
        }

        $importFile = $this->activeTheme->getPath() . '/' . $fileName;
        if (!File::exists($importFile)) {
            throw new SystemException("Import file '{$fileName}' does not exist.");
        }

        $importModel = new $className;
        $importModel->forceFill($attributes);
        $importModel->importFile($importFile, ['matches' => $matches]);

        $stats = $importModel->getResultStats();
        $this->line("- <info>{$importName}</info>: {$stats->created} Created / {$stats->updated} Updated / {$stats->skippedCount} Skipped");
    }
}
