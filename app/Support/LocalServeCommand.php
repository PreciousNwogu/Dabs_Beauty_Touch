<?php

namespace App\Support;

use Illuminate\Foundation\Console\ServeCommand as BaseServeCommand;
use Illuminate\Support\Collection;
use Symfony\Component\Process\Process;

class LocalServeCommand extends BaseServeCommand
{
    protected function serverCommand()
    {
        $tmp = UploadTempDir::ensure();
        $command = parent::serverCommand();
        array_splice($command, 1, 0, [
            '-d', 'upload_tmp_dir='.$tmp,
            '-d', 'sys_temp_dir='.$tmp,
            '-d', 'upload_max_filesize=128M',
            '-d', 'post_max_size=160M',
            '-d', 'memory_limit=512M',
            '-d', 'max_execution_time=300',
            '-d', 'max_input_time=300',
        ]);

        return $command;
    }

    protected function startProcess($hasEnvironment)
    {
        $tmp = UploadTempDir::ensure();

        $process = new Process($this->serverCommand(), public_path(), (new Collection($_ENV))->mapWithKeys(function ($value, $key) use ($hasEnvironment) {
            if ($this->option('no-reload') || ! $hasEnvironment) {
                return [$key => $value];
            }

            return in_array($key, static::$passthroughVariables, true) ? [$key => $value] : [$key => false];
        })->merge([
            'PHP_CLI_SERVER_WORKERS' => $this->phpServerWorkers,
            'TMP' => $tmp,
            'TEMP' => $tmp,
            'TMPDIR' => $tmp,
        ])->all());

        $this->trap(fn () => [SIGTERM, SIGINT, SIGHUP, SIGUSR1, SIGUSR2, SIGQUIT], function ($signal) use ($process) {
            if ($process->isRunning()) {
                $process->stop(10, $signal);
            }

            exit;
        });

        $process->start($this->handleProcessOutput());

        return $process;
    }
}
