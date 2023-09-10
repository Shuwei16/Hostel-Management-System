<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PythonController extends Controller
{
    public function execute()
    {
        // Execute the Python script
        $process = new Process(['python', 'App\Python\test.py']);
        $process->run();

        // Check if the process was successful
        if ($process->isSuccessful()) {
            return redirect()->back()->with('success', 'Python script executed successfully!');
        } else {
            throw new ProcessFailedException($process);
        }
    }
}
