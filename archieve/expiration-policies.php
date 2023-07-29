<?php

// Define the expiration policies for TLD groups in an array
$expirationPolicies = array(
    // Generic policy for TLDs without specific policies
    'default' => array(
        'grace' => array('min' => 1, 'max' => 33),
        'restore' => array('min' => 34, 'max' => 64),
        'pending_delete' => array('min' => 65, 'max' => 69),
        'deleted' => array('min' => 70),
    ),
    // Specific policies for TLD groups
    'groups' => array(
        'group1' => array(
            'tlds' => array('ca'),
            'grace' => array('min' => 1, 'max' => 62),
            'pending_delete' => 63,
            'deleted' => array('min' => 64, 'max' => 70),
        ),
        'group2' => array(
            'tlds' => array('energy'),
            'grace' => array('min' => 1, 'max' => 79),
            'pending_delete' => 80,
            'deleted' => 85,
        ),
        'group3' => array(
            'tlds' => array('beer', 'boston', 'casa', 'cooking', 'fashion', 'fishing', 'fit', 'garden', 'horse', 'law', 'miami', 'rodeo', 'surf', 'vip', 'vodka', 'wedding', 'work', 'yoga'),
            'grace' => array('min' => 1, 'max' => 33),
            'restore' => array('min' => 34, 'max' => 79),
            'pending_delete' => array('min' => 80, 'max' => 84),
            'deleted' => 85,
        ),
        'group4' => array(
            'tlds' => array('audio', 'blackfriday', 'christmas', 'click', 'diet', 'flowers', 'game', 'gift', 'guitars', 'help', 'hiphop', 'hiv', 'hosting', 'juegos', 'link', 'lol', 'mom', 'photo', 'pics', 'property','sexy', 'tattoo'),
            'grace' => array('min' => 1, 'max' => 33),
            'restore' => array('min' => 34, 'max' => 214),
            'pending_delete' => array('min' => 215, 'max' => 219),
            'deleted' => 220,
        ),
        // Add more TLD groups as needed
    ),
);
