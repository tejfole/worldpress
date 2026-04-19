<?php
/**
 * Plugin Name: WorldPress Admin Dashboard
 * Description: Egyszerű admin dashboard oldal WorldPress alapú weboldalakhoz.
 * Version: 1.0.0
 * Author: WorldPress
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('admin_menu', 'worldpress_admin_dashboard_menu');

function worldpress_admin_dashboard_menu(): void
{
    add_menu_page(
        'WorldPress Dashboard',
        'WorldPress Dashboard',
        'manage_options',
        'worldpress-admin-dashboard',
        'worldpress_admin_dashboard_render',
        'dashicons-chart-area',
        2
    );
}

function worldpress_admin_dashboard_render(): void
{
    if (!current_user_can('manage_options')) {
        wp_die(__('Nincs jogosultságod az oldal megtekintéséhez.', 'worldpress-admin-dashboard'));
    }

    $posts = wp_count_posts();
    $pages = wp_count_posts('page');
    $comments = wp_count_comments();
    $users = count_users();

    $post_count = (is_object($posts) && isset($posts->publish)) ? (int) $posts->publish : 0;
    $page_count = (is_object($pages) && isset($pages->publish)) ? (int) $pages->publish : 0;
    $comment_count = (is_object($comments) && isset($comments->approved)) ? (int) $comments->approved : 0;
    $user_count = (is_array($users) && isset($users['total_users'])) ? (int) $users['total_users'] : 0;
    ?>
    <div class="wrap">
        <h1><?php echo esc_html__('WorldPress Admin Dashboard', 'worldpress-admin-dashboard'); ?></h1>
        <p><?php echo esc_html__('Gyors áttekintés a weboldal állapotáról.', 'worldpress-admin-dashboard'); ?></p>
        <table class="widefat striped" style="max-width: 640px;">
            <thead>
                <tr>
                    <th><?php echo esc_html__('Mutató', 'worldpress-admin-dashboard'); ?></th>
                    <th><?php echo esc_html__('Érték', 'worldpress-admin-dashboard'); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo esc_html__('Publikált bejegyzések', 'worldpress-admin-dashboard'); ?></td>
                    <td><?php echo esc_html($post_count); ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Publikált oldalak', 'worldpress-admin-dashboard'); ?></td>
                    <td><?php echo esc_html($page_count); ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Jóváhagyott hozzászólások', 'worldpress-admin-dashboard'); ?></td>
                    <td><?php echo esc_html($comment_count); ?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Felhasználók', 'worldpress-admin-dashboard'); ?></td>
                    <td><?php echo esc_html($user_count); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php
}
