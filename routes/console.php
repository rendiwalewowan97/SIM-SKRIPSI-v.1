<?php
use Illuminate\Support\Facades\Artisan;
Artisan::command('app:name', fn()=> $this->comment(config('app.name')));
