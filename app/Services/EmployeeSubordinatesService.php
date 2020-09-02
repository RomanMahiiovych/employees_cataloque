<?php


namespace App\Services;


use App\Models\Employee;

class EmployeeSubordinatesService
{
    public function make($subordinates)
    {
        $level = $this->searchChildrenLevel($subordinates);

        return $level;
    }

    public function searchChildrenLevel($person)
    {
        $children = $person->heads()->get();

        //we are creating collection for giving index of subordinates in one iteration
        $tempCollection = collect();
        //we are creating finish collection for giving index of subordinates
        $finishCollection = collect();
        $level = 0;
        //first cycle - first children of head
        if (!$children->isEmpty()) {
            foreach ($children as $child){
                //save indexes of first children of head in temp collection
                $tempCollection->push($child->pivot->employee_id);
            }
        } else {
            return $level;

        }
        //save indexes of first children of head in finish collection
        $finishCollection->push($tempCollection);
        $level++;

        //create cycle for each level - max levels 5
        for($i = 1; $i < 5; $i++){
            $nextLevel  = $this->isNextChildrenLevel($tempCollection);  //6
            $finishCollection->push($nextLevel);
            $tempCollection = $nextLevel;

            if($nextLevel){
                $level++;
            }
            else {
                break;
            }
        }

        return $level;
    }

    public function isNextChildrenLevel($collection)
    {
        $tempCollection = collect();
        foreach ($collection as $item){
            $person = Employee::whereId($item)->first(); //2
            $children = $person->heads()->get(); //6
            if($children){
                foreach ($children as $child){
                    $tempCollection->push($child->pivot->employee_id);
                }
            }
        }

        if(!$tempCollection){
            return false;
        }
        return $tempCollection->all();
    }
}
