<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
class TestController extends Controller
{
    public function index(Request $request){
        $process = new Process("python3 /home/Classify.py");
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return response()->json($process->getOutput());
    }
}
