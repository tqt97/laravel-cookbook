<?php

namespace App\Console\Commands;

use App\Models\Permission;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Throwable;

class GeneratePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:generate-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '🔒 Generate permissions for all models in the application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->newLine();
        $this->info('🔍 Scanning models and generating permissions...');
        $this->newLine();

        // Delete old permissions if exist with foreign key
        try {
            $this->warn("⚠️ Deleting old permissions...\n");
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('model_has_permissions')->truncate();
            DB::table('role_has_permissions')->truncate();
            DB::table('permissions')->truncate();
            DB::statement('ALTER TABLE permissions AUTO_INCREMENT = 1;');
            $this->info("✅ Old permissions deleted successfully.\n");
        } catch (Throwable $e) {
            $this->error('❌ Error deleting permissions: '.$e->getMessage()."\n");

            return;
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        // 3️⃣ get all models
        $modelPath = app_path('Models');
        if (! File::exists($modelPath)) {
            $this->error("❌ Models directory not found.\n");

            return;
        }

        $files = File::files($modelPath);
        $models = [];

        foreach ($files as $file) {
            $modelName = pathinfo($file->getFilename(), PATHINFO_FILENAME);
            if (class_exists("App\\Models\\$modelName")) {
                $models[] = strtolower($modelName);
            }
        }

        if (empty($models)) {
            $this->error("❌ No models found.\n");

            return;
        }

        $this->info("🚀 Start generating permissions...\n");

        $totalModels = count($models);
        $bar = $this->output->createProgressBar($totalModels);
        $bar->start();

        foreach ($models as $index => $model) {
            $bar->advance();

            if (Permission::query()->whereLike('name', "{$model}.%")->exists()) {
                $this->warn("🟡 Permissions for {$model} already exist. Skipping...\n");
            } else {
                $this->call('permissions:generate', ['model' => $model]);
                $this->info("✅ Permissions for {$model} created successfully.\n");
            }
        }

        $bar->finish();
        // $this->newLine();
        $this->info("\n🎉 All permissions generated successfully!\n");
        // $this->newLine();
    }
}
