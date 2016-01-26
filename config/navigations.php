<?php defined('BASEPATH') or exit('No direct script access allowed');

$config['navigations'] = array(
	array(
		'name' => 'logo',
		'label' => 'Pinet',
		'logo' => 'logo.png',
		'controller' => 'Welcome'
	),
    array(
        'name' => 'user_account_settings',
        'label' => 'User and Account Settings',
        'logo' => 'user_account_settings.png',
        'controller' => 'Account',
        'method' => 'index',
        'subnavi' => array(
            array(
                'name' => 'account_summary',
                'label' => 'Account Summary',
                'controller' => 'Account',
                'method' => 'summary_details'
            ),
            array(
                'name' => 'change_password',
                'label' => 'Change Password',
                'controller' => 'Account',
                'method' => 'change_password'
            ),
            array(
                'name' => 'reset_password',
                'label' => 'Reset Password',
                'controller' => 'Account',
                'method' => 'reset_password'
            )
        )
    ),
	array(
		'name' => 'ibox',
		'label' => 'iBox Status',
                   'logo' => 'ibox_status.png',
		'controller' => 'IBox',
		'method' => 'index'
	),
	array(
		'name' => 'network_settings',
		'label' => 'Network Settings',
	 	'logo' => 'network_settings.png',
		'controller' => 'Network',
        'method' => 'index',
        'subnavi' => array(
            array(
                'name' => 'lan_settings',
                'label' => 'LAN Settings',
                'controller' => 'Network',
                'method' => 'lan'
            ),
            array(
                'name' => 'wlan_settings',
                'label' => 'WLAN Settings',
                'controller' => 'Network',
                'method' => 'wlan'
            ),
            array(
                'name' => 'ibox_basic_settings',
                'label' => 'iBox Basic Settings',
                'controller' => 'Network',
                'method' => 'ibox_basic'
            )
        )
	),
	array(
		'name' => 'captive_portal_settings',
		'label' => 'Captive Portal Settings',
	 	'logo' => 'ibox_settings.png',
		'controller' => 'Captive',
		'method' => 'index',
        'subnavi' => array(
            array(
                'name' => 'walled_garden_settings',
                'label' => 'Walled Garden Settings',
                'controller' => 'Captive',
                'method' => 'walled_garden'
            ),
            array(
                'name' => 'blacklist_settings',
                'label' => 'Blacklist Settings',
                'controller' => 'Captive',
                'method' => 'blacklist'
            ),
            array(
                'name' => 'portal_page_settings',
                'label' => 'Portal Page Settings',
                'controller' => 'Captive',
                'method' => 'portal'
            ),
            array(
                'name' => 'sns_settings',
                'label' => 'SNS Settings',
                'controller' => 'Captive',
                'method' => 'sns'
            )
        )
	),
	array(
		'name' => 'ibox_maintenance',
		'label' => 'iBox Maintenance',
	 	'logo' => 'ibox_maintence.png',
		'controller' => 'Maintenance',
        'method' => 'index',
        'subnavi' => array(
            array(
                'name' => 'ibox_app_settings',
                'label' => 'iBox App Settings',
                'controller' => 'Maintenance',
                'method' => 'ibox_app'
            ),
            array(
                'name' => 'task_scheduler',
                'label' => 'Task Scheduler',
                'controller' => 'Maintenance',
                'method' => 'task_scheduler'
            )
        )
	),
    array(
        'name' => 'business_management',
        'label' => 'Business Management',
        'logo' => 'ibox_business_management.png',
        'controller' => 'Business',
        'method' => 'index',
        'subnavi' => array(
            array(
                'name' => 'ibox_status_summary',
                'label' => 'iBox Status Summaries',
                'controller' => 'Business',
                'method' => 'ibox_status_summary'
            ),
            array(
                'name' => 'ibox_login_summary',
                'label' => 'iBox Login Summaries',
                'controller' => 'Business',
                'method' => 'ibox_login_summary'
            ),
            array(
                'name' => 'visitor_loyalties_summary',
                'label' => 'Visitor Loyalties',
                'controller' => 'Business',
                'method' => 'visitor_loyalties_summary'
            ),
            array(
                'name' => 'repeating_visitors_summary',
                'label' => 'Repeating Visitors',
                'controller' => 'Business',
                'method' => 'repeating_visitors_summary'
            )
        )
    ),
    array(
        'name' => 'system_management',
        'label' => 'System Management',
        'logo' => 'system_management.png',
        'controller' => 'Admin',
        'method' => 'index',
        'subnavi' => array(
            array(
                'name' => 'user_management',
                'label' => 'User Management',
                'controller' => 'Admin',
                'method' => 'user'
            ),
            array(
                'name' => 'ibox_management',
                'label' => 'iBox Management',
                'controller' => 'Admin',
                'method' => 'ibox'
            )
        )
    )
);
