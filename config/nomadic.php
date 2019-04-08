<?php

return [
    'global' => [
        'app' => 'ISCC 鹽酥雞協會',
        'subject' => '鹽酥雞名店',
        'unit' => '間',
        'name_of_unit' => '店名',
        'category' => '城市',
        'unit-url' => 'entity',
        'rank'     => '世界排名',
        'range'    => '0.05' 
    ],
    'homepage' => [
        'title' => '鹽酥雞',
        'slogan-1' => '鹽酥雞會讓人覺得幸福，而品嘗到好吃的鹽酥雞更是世界上最幸福的事之一',
        'slogan-2' => '從這裡，你可以找到各地的幸福',
    ],
    // corresponds to template in resources/views
    'community' => [
        'contribute' => [
            'name-notice' => '若有分店，請註明分店名'
        ]
    ],
    'forum' => [
        'enabled' => true,
        'label' => '討論區',
    ],
    'links' => [
        [
            'url' => 'http://www.isccgo.org/',
            'label' => 'ISCC 評比',
        ],
    ],
    'tag-page' => [
        'unit' => '間網友推薦的店'
    ],
    'category-homepage' => [
        'unit-amount' => '間店',
        'checkin-amount' => '次打卡',
        'empty-comment-text' => '這個地區還沒有人留言。',
        'empty-review-text' => '這個地區還沒有人評分。'
    ],
    'info-modal' => [
        'check-in' => '我去過這間',
        'num-of-visit' => '人去過這間店。',
        'write-a-review' => '我要給這間店評分',
    ],
    'map-enabled' => true,
];
