<?php


namespace AppBundle\Service;


class AjaxMenuConverter
{

    public function convertCategoriesToJSON(array $categories, $opened_node_id)
    {
        $answer = [];
        foreach ($categories as &$category) {
            if ($category->getParent() === null) {
                $parent_id = '#';
            } else {
                $parent_id = strval($category->getParent()->getID());
            }
            $is_opened = ($opened_node_id == $category->getID());
            $answer[] = [
                'id' => strval($category->getID()),
                'parent' => $parent_id,
                'text' => $category->getName(),
                'state' => ['selected' => $is_opened],
            ];
        }
        $json_answer = json_encode($answer);
        return $json_answer;
    }

}