<?php

namespace App\Console\Commands;

use App\Models\Permission;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class GenerateModelPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:generate {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '🔒 Create permissions for a specific model';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $model = Str::lower($this->argument('model'));
        $modelClass = 'App\\Models\\'.Str::studly($model);

        // Kiểm tra model có tồn tại không
        if (! class_exists($modelClass)) {
            $this->error("❌ Model `{$modelClass}` not found.\n");

            return;
        }

        $permissions = config('permission.permissions_list');

        if (empty($permissions)) {
            $this->error("❌ No permissions found in config/permission.php. Please define `permissions_list`.\n");

            return;
        }

        $this->newLine();
        $this->info("\n🚀 Generating permissions for `{$model}`...");
        $this->newLine();

        if (Permission::query()->whereLike('name', "{$model}.%")->exists()) {
            $this->warn("🟡 Permissions for `{$model}` already exist. Skipping...\n");
            $this->newLine();

            return;
        }

        $total = count($permissions);
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        try {
            DB::transaction(function () use ($permissions, $model, $bar) {
                foreach ($permissions as $permission) {
                    $permissionName = "{$model}.{$permission}";
                    Permission::query()->firstOrCreate(['name' => $permissionName]);
                    $bar->advance();
                }
            });
            $bar->finish();
            $this->newLine(2);
            $this->info("✅ Successfully created `{$total}` permissions for model `{$model}`! 🎉\n");
        } catch (Throwable $e) {
            $this->error("\n❌ Error creating permissions: ".$e->getMessage()."\n");

            return;
        }
    }
}
