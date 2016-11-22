<?php


namespace AppBundle\Service;


class AjaxMenuConverter
{

    public function convertCategoriesToJSON(array $categories)
    {
        $answer = [];
        foreach ($categories as &$category) {
            if ($category->getParentID() === 0) {
                $parent_id = '#';
            } else {
                $parent_id = strval($category->getParentID());
            }
            $answer[] = [
                'id' => strval($category->getID()),
                'parent' => $parent_id,
                'text' => $category->getName(),
            ];
        }
        $json_answer = json_encode($answer);
        return $json_answer;
    }

}