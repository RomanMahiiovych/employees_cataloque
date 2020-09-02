<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\Models\Position;
use App\Services\CheckHierarchyService;
use App\Services\EmployeeService;
use App\Services\EmployeeSubordinatesService;
use App\Services\StoreImageService;
use Illuminate\Http\Request;
use Faker\Generator as Faker;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
//     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', ['employees' => $employees]);
    }

    /**
     * Show the form for creating a new resource.
     *
//     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = Employee::get();
        $positions = Position::get();
        return view('employees.add', ['employees' => $employees, 'positions' => $positions]);
    }

    /**
     * Store a newly created resource in storage.
     *
//     * @param \Illuminate\Http\Request $request
//     * //     * @return \Illuminate\Http\Response
     * @param Faker $faker
//     * @return \Illuminate\Http\RedirectResponse
     */
        public function store(EmployeeRequest $request, Faker $faker, EmployeeService $employeeService, StoreImageService $imageService, CheckHierarchyService $checkHierarchyService)
    {
        //check if head has less than 5 subordinates
        //change number at variable
        $head = Employee::where('name', $request->head)->first();
        $level = $checkHierarchyService->make($head);

        if($level < 5) {
            //change number at id from select
            //get out this to service
            $employee = $employeeService->make($request, $faker);
        }
        else {
            return back()->with('status', 'Choose another head! His level of subordinates is '. $level)->withInput($request->all());
        }

        $imageService->make($employee);

        //check employee from create
        $employee->employees()->attach($head->id);
        return redirect()->route('employees.index')->with('status', 'Employee created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
//     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::whereId($id)->first();
        $head = $employee->employees()->first();

        return view('employees.edit', [
            'photo' => $employee->photo,
            'type_photo' => $employee->type_photo,
            'name' => $employee->name,
            'position' => $employee->position,
            'date_of_employment' => $employee->date_of_employment,
            'phone' => $employee->phone_number,
            'email' => $employee->email,
            'salary' => $employee->salary,
            'head' => Employee::whereId($head->id)->first(),
            'id'   => $id,
            'created_at' => $employee->created_at->format('d.m.y'),
            'updated_at' => $employee->updated_at->format('d.m.y'),
            'admin_created_id' => $employee->admin_created_id,
            'admin_updated_id' => $employee->admin_updated_id,
            'positions' => Position::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
//     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $employeeId, StoreImageService $imageService, CheckHierarchyService $checkHierarchyService, EmployeeSubordinatesService $employeeSubordinatesService, Faker $faker)
    {
        $employee = Employee::whereId($employeeId)->first();
        $oldHead = $employee->employees()->first();

        $newHead = Employee::where('name', $request->head)->first();
        $headLevel = $checkHierarchyService->make($newHead);

        $employeeHeadLevel = $checkHierarchyService->make($employee);

        $employeeLevel = ($employeeHeadLevel) + $employeeSubordinatesService->make($employee);

        $employeeHierarchy = $employeeLevel - $employeeHeadLevel;

        if($headLevel + $employeeHierarchy < 5) {
            $oldHead->heads()->detach($employeeId);
            $newHead->heads()->attach($employeeId);
        } else {
            return back()->with('status', 'Choose another head! Invalid level of subordinates . Max level equals 5 !')->withInput($request->all());
        }

        $employee->update([
            'name' => $request->name,
            'position' => $request->position,
            'date_of_employment' => $request->date_of_employment,
            'phone_number' => $request->phone,
            'email' => $request->email,
            'salary' => $request->salary,
            'admin_updated_id' => $faker->unique()->randomNumber(6)
        ]);

        $imageService->make($employee);

        return redirect()->route('employees.index')->with('status', 'Position updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
//     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //number of heads
        $person = Employee::findOrFail($id);

        $head = $person->employees()->first();

        if(!$head) {
            return redirect()->route('employees.index')->with('errors', "Employee $person->name can't be deleted");
        }

        $children = $person->heads()->get();

        //get id of children
        $children_id = collect([]);
        foreach ($children as $child){
            $children_id->push($child->id);
        }

        //destroy old head and detach from head_employee table
        $person->delete();

        //attach children to new head
        $head->heads()->attach($children_id);

        return redirect()->route('employees.index')->with('status', "Employee $person->name deleted successfully");
    }
}
