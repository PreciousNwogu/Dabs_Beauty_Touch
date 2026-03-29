<?php
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$services = App\Models\Service::orderBy('id')->get();
foreach ($services as $s) {
    $dp = $s->discount_price !== null ? $s->discount_price+0 : 'null';
    echo "['name'=>".json_encode($s->name).",'slug'=>".json_encode($s->slug).",'base_price'=>".($s->base_price+0).",'discount_price'=>".$dp.",'description'=>".json_encode($s->description).",'category'=>".json_encode($s->category).",'is_active'=>".($s->is_active?'true':'false').",'for_kids'=>".($s->for_kids?'true':'false')."],\n";
}
