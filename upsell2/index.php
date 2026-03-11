<?php
$account_id = '2e8fc70c-53af-4f29-af7e-e4d40fc994f9';
$dominio    = 'ganhossonline.site';
$players    = [
    '68cd7151c9c4c158bda6018d',  // player do upsell2
];

foreach ($players as $pid) {
    $cache = __DIR__ . "/player_cache_{$pid}.js";
    if (!file_exists($cache)) {
        $url = "https://scripts.converteai.net/{$account_id}/players/{$pid}/v4/player.js";
        $ctx = stream_context_create([
            'http' => [
                'method'  => 'GET',
                'header'  => implode("\r\n", [
                    "Referer: https://{$dominio}/",
                    "Origin: https://{$dominio}",
                    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'Accept: */*',
                ]),
                'ignore_errors' => true,
            ],
            'ssl' => ['verify_peer' => false, 'verify_peer_name' => false],
        ]);
        $js = @file_get_contents($url, false, $ctx);
        if ($js) file_put_contents($cache, $js);
    }
}

header('Content-Type: text/html; charset=UTF-8');
readfile(__DIR__ . '/index.html');
