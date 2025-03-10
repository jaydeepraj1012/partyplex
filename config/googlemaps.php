<?php

return [
    /*
     * Google Maps API Key
     */
    'api_key' => env('GOOGLE_MAPS_API_KEY', ''),

    /*
     * Default map center coordinates
     */
    'default_lat' => env('GOOGLE_MAPS_DEFAULT_LAT', 40.7128),
    'default_lng' => env('GOOGLE_MAPS_DEFAULT_LNG', -74.0060),

    /*
     * Default zoom level
     */
    'default_zoom' => env('GOOGLE_MAPS_DEFAULT_ZOOM', 10),

    /*
     * Map options
     */
    'map_options' => [
        'mapTypeId' => 'roadmap',
        'zoomControl' => true,
        'mapTypeControl' => true,
        'scaleControl' => true,
        'streetViewControl' => true,
        'rotateControl' => true,
        'fullscreenControl' => true,
        'gestureHandling' => 'auto',
    ],

    /*
     * Marker options
     */
    'marker_options' => [
        'animation' => 'DROP',
        'draggable' => true,
    ],
]; 