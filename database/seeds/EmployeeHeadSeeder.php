<?php

use App\Models\Head;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class EmployeeHeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getHeadsId() as $head){
            Head::create([
                'head_id' => $head['head'],
                'employee_id' => $head['employee']
            ]);
        }
    }

    public function getHeadsId(){
        $heads = collect([]);
        $n = 1;
        $thousand = 0;
        $round = 100;

        for ($i = 1; $i <= 5; $i++){

            if($i == 1) {
                for ($j = 2 + $thousand; $j <= $round * $n; $j++) {
                    $heads->push(['head' => $i, 'employee' => $j]); //1 ...1000
                }
            }
            else {
                for ($j = 1 + $thousand; $j <= $round * $n; $j++) {
                    $heads->push(['head' => $j - $round, 'employee' => $j]); //1 ...1000
                }
            }
            $n++;
            $thousand += $round;
        }

        return $heads;
    }
}
