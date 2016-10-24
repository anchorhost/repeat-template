<?php
/**  
* Plugin Name: Repeat Template
* Plugin URI: https://anchor.host/
* Description: Daily repeat template with basic file logging.
* Version: 1.0
* Author: Austin Ginder
* Author URI: https://austinginder.com/
**/

register_activation_hook( __FILE__, 'repeat_template_activation_function' );
function repeat_template_activation_function() {

    // This will run when the plugin is activated
    $schedule_time = mktime(16,00,0, date('n'), date('j')+1, date('Y'));

    // Schedule event to run daily at 6am EST
    wp_schedule_event( $schedule_time, 'daily', 'repeat_template_daily_task' );
}

register_deactivation_hook( __FILE__, 'repeat_template_task_deactivation_function' );
function repeat_template_task_deactivation_function() {
    // This will run when the plugin is deactivated
    wp_clear_scheduled_hook('repeat_template_daily_task');
}

// Hook our function repeat_template_task() into the action repeat_template_daily_task
add_action( 'repeat_template_daily_task', 'repeat_template_task' );

function repeat_template_task() {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/repeat_template/logs/'.date('Y.m.d G:i:s').' task started.log', $log_time . PHP_EOL);

    // place before any script you want to calculate time
    $time_start = microtime(true);

    // Run custom task here
   
    // place after any script you want to calculate time
    $time_end = microtime(true);

    //dividing with 60 will give the execution time in minutes other wise seconds
    $execution_time = ($time_end - $time_start);

    //execution time of the script
    echo $log_time = "Total Execution Time: ".round($execution_time)." Sec\n";

    // Log to file
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/repeat_template/logs/'.date('Y.m.d G:i:s').'.log', $log_time . PHP_EOL);
    echo $_SERVER['DOCUMENT_ROOT'] . '/repeat_template/logs/'.date('Y.m.d G:i:s').'.log';
}
