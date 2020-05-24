<?php


namespace App\Helpers;


use App\Task;
use Closure;
use Illuminate\Database\Schema\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use function GuzzleHttp\Psr7\str;

class LINQ
{
    private $a;
    /**
     * @var string
     */
    private $param;

    public function __construct($enumerable)
    {
        $this->a = $enumerable;
    }

    /**
     * @param Collection $collection
     * @param int $per_page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function paginate(Collection $collection, $per_page = 15)
    {
        if ($collection->count() > 0) {
            $temp = Task::query();
            for ($i = 0; $i < $collection->count(); $i++) {
                $temp = $temp->orWhere('id', '=', $collection->skip($i)->first()->id);
            }
            return $temp->paginate($per_page);
        } else {
            return new LengthAwarePaginator([], 0, $per_page);
        }
    }

    public static function from($enumerable)
    {
        return new LINQ($enumerable);
    }

    public function array(){
        return self::asArray($this->a);
    }

    public static function asArray($a)
    {
        if ($a instanceof Collection)
            return $a->toArray();
        else
            return $a;
    }

    public function csv($filename = null)
    {
        $array = self::asArray($this->a);
        $this->param = '';
        $keys = array_keys($array[0]);
        foreach ($keys as $key){
            $this->param .= "\"$key\";";
        }
        $this->param = trim($this->param, "\t\n\r\0\x0B; ") . "\n";
        foreach ($array as $object){
            foreach (array_values($object) as $value){
                $this->param .= '"' . str_replace('"', '""', str_replace("\t", '\\t', str_replace("\n", '\\n', $value))) . '";';
            }
            $this->param = trim($this->param, "\t\n\r\0\x0B; ") . "\n";
        }
        if($filename === null)
            $filename = date("Y-m-d") . '.csv';
        else if(strpos($filename, '{NOW}') != -1){
            $filename = str_replace('{NOW}', date("Y-m-d"), $filename);
        }
        return new Downloadable(Str::finish($filename, '.csv'), $this->param);
    }

    public function is_associative() : bool
    {
        if (array() === $this->a) return false;
        return array_keys($this->a) !== range(0, count($this->a) - 1);
    }

    public static function check_associative($arr) : bool
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    public function values($except = []) : LINQ
    {
        $this->a = $this->array();
        $temp = [];
        foreach ($this->a as $key => $value){
            if(LINQ::from($except)->notContains($key))
                $temp[$key] = $value;
        }
        $this->a = $temp;
        return $this;
    }

    public function notContains($key) : bool
    {
        return !$this->contains($key);
    }

    public function contains($key) : bool
    {
        foreach ($this->a as $item){
            if($key == $item)
                return true;
        }
        return false;
    }

}
