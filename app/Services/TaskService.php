<?php

namespace App\Services;

use App\Models\Task;

class TaskService
{
    public function getTasksTree($tasks)
    {
        $treeviewData = [];

        $tasks = array_shift($tasks);

        $parents = array_values(array_filter(
            $tasks,
            function ($task) {
                return $task['parent_id'] === null;
            }
        ));

        foreach ($parents as $parentId => $parent) {
            $treeviewData[$parentId][] = [
                'id' => $parent['id'],
                'title' => $parent['title'],
                'description' => $parent['description'],
                'parent_id' => null,
                'company_id' => $parent['company_id'],
                'children' => $this->setTasksChildren($tasks, $parent['id']),
            ];
        }

        return $treeviewData;
    }

    protected function setTasksChildren($tasks, $parent_id)
    {
        $treeviewData = [];

        $parents = array_values(array_filter(
            $tasks,
            function ($task) use ($parent_id) {
                return $task['parent_id'] === $parent_id;
            }
        ));

        foreach ($parents as $parentId => $parent) {
            $treeviewData[$parentId][] = [
                'id' => $parent['id'],
                'title' => $parent['title'],
                'description' => $parent['description'],
                'parent_id' => $parent['parent_id'],
                'company_id' => $parent['company_id'],
                //'children' => $this->setTasksChildren($tasks, $parent['id']),
            ];
        }
        return $treeviewData;
    }

    public function createTask($parent, $children)
    {
        $parentTask = new Task();
        $parentTask = $parent;

        $parentTask->save();

        foreach ($children as $child) {
            $childTask = new Task();
            $childTask->title = $child['title'];
            $childTask->parent_id = $parentTask->id;
            $childTask->description = (array_key_exists('description', $child) ? $child['description'] : null);
            $childTask->company_id = $parentTask->company_id;

            $childTask->save();
        }

        $tasksList = Task::where('id', $parentTask->id)->orWhere('parent_id', $parentTask->id)->get();

        $tasksTree = $this->getTasksTree((array)$tasksList);
        return $tasksTree;
    }
}
