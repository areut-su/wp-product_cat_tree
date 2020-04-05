<?php

class CatTree
{
    /**
     * @param WP_Term[][] $cats
     */
    private $cats = [];
    private $level = 0;
    private $level_start;
    private $result = [];
    private $funcUrl;

    /**
     * @param        $cats
     * @param int    $level_start
     * @param string $funcUrl
     *
     * @return static
     * @throws Exception
     */
    static function create($cats, $level_start = 1, $funcUrl = 'get_category_link')
    {
        $m              = new static();
        $m->level_start = $level_start;
        if (!function_exists($funcUrl))
        {
            throw new \Exception('function "get_category_link" not found');
        }
        $m->funcUrl = $funcUrl;


        $m->cats = static::catsIndexByParent($cats);


        return $m;
    }

    /**
     * @return array
     */
    function makeTree()
    {

        $result[] = '<div class="product-short-description">';
        $this->outTree(0);
        $result[] = '</div>';

        return $this->result;

    }


    /**
     * @param           $parent_id
     */
    private function outTree($parent_id)
    {
        $this->level;
        $cats_by_parrent = isset($this->cats[$parent_id]) ? $this->cats[$parent_id] : null;

        if (null !== $cats_by_parrent)
        {
            $this->addEcho('<ul>');
//            echo "<ul>";
            //Если категория с таким parent_id существует
            foreach ($cats_by_parrent as $key => $c)
            { //Обходим ее
                /**
                 * Выводим категорию
                 *  $level * 25 - отступ, $level - хранит текущий уровень вложености (0,1,2..)
                 */

                $this->addEcho('<li class="bullet-checkmark">' .
                               '<a href="' . call_user_func($this->funcUrl, $c->term_id) . '">' . $c->name . '</a>' .
                               '</li>'
                );
                $this->level++; //Увеличиваем уровень вложености
                //Рекурсивно вызываем этот же метод, но с новым $parent_id и $level
                $this->outTree($c->term_id);
                $this->level--; //Уменьшаем уровень вложености
            }
            $this->addEcho('</ul>');
        }

    }

    /**
     * @param WP_Term[] $cats
     *
     * @return WP_Term[][]
     */
    public static function catsIndexByParent($cats): array
    {
        $catIndex = [];
        foreach ($cats as $key => $c)
        {
            $catIndex[$c->parent][$c->term_id] = $c;
        }

        return $catIndex;
    }

    private function addEcho($data)
    {

        if ($this->level >= $this->level_start)
        {
            $this->result[] = $data;
        }

    }
}