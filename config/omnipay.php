<?php

return array(

    /** The default gateway name */
    'gateway' => 'PayPal_Express',

    /** The default settings, applied to all gateways */
    'defaults' => array(
        'testMode' => true,
    ),

    /** Gateway specific parameters */
    'gateways' => array(
        'PayPal_Express' => array(
            'username' => '',
            'landingPage' => array('billing', 'login'), 
        ),
    ),

);
