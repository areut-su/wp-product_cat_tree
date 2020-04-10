<?php
/**
 * Plugin Name: WP Product Cat Tree
 * Description: Выводит дерево  категорий (product_cat) в цикле  Wp
 * use [PRODUCT_CAT_TREE level=1 post_id =1111] or [PRODUCT_CAT_TREE] or product_cat_tree_print(['level'=>1])
 * Author:      areut
 * Author URI:  https://github.com/
 * Version:     0.1
 * License:     MIT
 *  use [PRODUCT_CAT_TREE level=1]
 *  or [PRODUCT_CAT_TREE]
 *
 */

add_shortcode('PRODUCT_CAT_TREE', 'product_cat_tree_print');

/**
 *
 * @param array $atts
 *   product_cat_tree_print(['level'=>1,'post_id'=>3793]);
 */
function product_cat_tree_print($atts)
{

    if (!class_exists('CatTree'))
    {
        include(__DIR__ . DIRECTORY_SEPARATOR . 'CatTree.php');
    }
    $level = isset($atts['level']) ? $atts['level'] : 1;

    $post_id = isset($atts['post_id']) ? $atts['level'] : get_the_ID();

    try
    {
        $m = [];
        if (!empty($post_id))
        {


            $m = CatTree::create(
                get_categories(
                    [
                        'taxonomy' => 'product_cat',
                        'object_ids' => $post_id,
                    ]
                ), $level);
        }
    }
    catch (Exception $e)
    {
        echo '<pre>';
        echo $e->getMessage();
        echo '</pre>';
    }
    return implode($m->makeTree());
}
