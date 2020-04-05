<?php
if (PHP_SAPI !== 'cli')
{
    die();
}

function urlTest($id)
{
    return $id;
}

function test_product_cat_tree()
{
    // create test file  with JSON_UNESCAPED_UNICODE
    // json_encode($allCat, JSON_UNESCAPED_UNICODE);
    $fileCat = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'test_cats.json');
    $fileCat = json_decode($fileCat);
    include_once(__DIR__ . DIRECTORY_SEPARATOR . 'CatTree.php');
    try
    {
        $m = CatTree::create($fileCat, 1, 'urlTest');
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
    }
    print_r($m->makeTree());
}

test_product_cat_tree();

