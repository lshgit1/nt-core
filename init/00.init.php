<?php

/**
 * Basci Config, Member
 */

// 기본설정
$config = getConfig();

$is_member = false;
$is_admin  = false;
$is_super  = false;

if($_SESSION['ss_uid']) {
    $member = getMember($_SESSION['ss_uid']);

    if($member['mb_uid']) {
        if(!isNullTime($member['mb_leave']) || !isNullTime($member['mb_block'])) {
            unset($_SESSION['ss_uid']);
            unset($member);
        }

        $is_member = true;

        if($member['mb_admin']) {
            $is_admin = true;

            if($member['mb_admin'] == $config['cf_super_admin'])
                $is_super = true;
        }
    } else {
        unset($_SESSION['ss_uid']);
    }
}