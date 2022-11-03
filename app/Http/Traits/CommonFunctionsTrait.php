<?php
namespace App\Http\Traits;

trait CommonFunctionsTrait
{
    public function p($data,$exit = 0)
    {
		print("<pre>");
		print_r($data);
		print("</pre>");

        if($exit == 1)
        {
            exit();
        }
    }

    public function tech_error($e)
    {
        return $e->getMessage();
    }


    public function pagination_count()
    {
        return 10;
    }
}
