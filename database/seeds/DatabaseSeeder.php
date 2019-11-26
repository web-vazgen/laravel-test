<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $dumps = [
            'load_departments.dump',
            'load_employees.dump',
            'load_dept_emp.dump',
            'load_dept_manager.dump',
            'load_titles.dump',
            'load_salaries1.dump',
            'load_salaries2.dump',
            'load_salaries3.dump'
        ];

        foreach ($dumps as $dump){
            $sql = file_get_contents('dumps/'.$dump,true);
            DB::statement($sql);
            sleep(3);
        }
    }
}
