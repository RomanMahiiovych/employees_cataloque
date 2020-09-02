<?php


namespace App\Services;


use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;

class CheckHierarchyService
{
    public function make($head)
    {
        $level = $this->search($head);

        return $level;
    }

    public function search($person)
    {
        //check if he has any heads and give them
        $heads = $person->employees()->get();

        //we are creating collection for giving index of subordinates in one iteration
        $tempCollection = collect();
        //we are creating finish collection for giving index of subordinates
        $finishCollection = collect();
        $level = 0;
        //first cycle - first children of head
        if (!$heads->isEmpty()) {
            foreach ($heads as $head){
                //save indexes of first children of head in temp collection
                $tempCollection->push($head->pivot->head_id);
            }
        } else {
            return $level;

        }
        //save indexes of first children of head in finish collection
        $finishCollection->push($tempCollection);
        $level++;

        //create cycle for each level - max levels 5
        for($i = 1; $i < 5; $i++){
            $nextLevel  = $this->isNextLevel($tempCollection);
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

    public function isNextLevel($collection)
    {
        $tempCollection = collect();
        foreach ($collection as $item){
            $person = Employee::whereId($item)->first(); //2
            $heads = $person->employees()->get(); //6
            if($heads){
                foreach ($heads as $head){
                    $tempCollection->push($head->pivot->head_id);
                }
            }
        }

        if(!$tempCollection){
            return false;
        }
        return $tempCollection->all();
    }
}
