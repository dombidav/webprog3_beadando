<?php


namespace App\Helpers;


use App\Task;
use Closure;
use Illuminate\Database\Schema\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class LINQ
{
    private $a;

    public function __construct($enumerable)
    {
        $this->a = $enumerable;
    }

    /**
     * @param Collection $collection
     * @param int $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function paginate(Collection $collection, $per_page = 15){
        if($collection->count() > 0){
            $temp = Task::query();
            for ($i = 0; $i < $collection->count(); $i++){
                $temp = $temp->orWhere('id', '=', $collection->skip($i)->first()->id);
            }
            return $temp->paginate($per_page);
        }
        else{
            return new LengthAwarePaginator([], 0, $per_page);
        }
    }

    public static function from($enumerable){
        return new LINQ($enumerable);
    }
}
